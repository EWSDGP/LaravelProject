<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function __construct()
    {

        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ["only" => ["index", "show"]]);
        $this->middleware('permission:user-create', ["only" => ["create", "store"]]);
        $this->middleware('permission:user-edit', ["only" => ["edit", "update"]]);
        $this->middleware('permission:user-delete', ["only" => ["destroy"]]);
    }
    public function index()
    {
        // dd("users");
        $users = User::all();
        return view("users.index", compact("users"));
    }


    public function create()
    {
        $roles = Role::where('name', '!=', 'Admin')->get();
        $departments = Department::all();
        return view("users.create", compact("roles", "departments"));
    }


    public function store(Request $request)
    {

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required",
            "department_id" => "nullable|exists:departments,id",
            "photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);

        $profilePhotoPath = null;


        if ($request->hasFile('photo')) {

            $profilePhotoPath = $request->file('photo')->store('profile_photos', 'public');
        }


        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "department_id" => $request->department_id ?? null,
            "profile_photo" => $profilePhotoPath,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route("users.index")->with("success", "User created");
    }



    public function show(string $id)
    {
        $user = User::find($id);
        return view("users.show", compact("user"));
    }


    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::where('name', '!=', 'Admin')->get();
        $departments = Department::all();
        if ($user->hasRole('Admin')) {
            $roles = Role::where('name', 'Admin')->get();
        }

        return view('users.edit', compact('user', 'roles', 'departments'));
    }



    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route("users.index")->with("error", "User not found.");
        }

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email," . $id,
            "department_id" => "nullable|exists:departments,id",
            "photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);


        if ($request->hasFile('photo')) {

            if ($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo))) {
                unlink(public_path('storage/' . $user->profile_photo));
            }


            $user->profile_photo = $request->file('photo')->store('profile_photos', 'public');
        }



        $user->name = $request->name;
        $user->email = $request->email;
        $user->department_id = $request->department_id;
        $user->save();


        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route("users.index")->with("success", "User updated successfully.");
    }


    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route("users.index")->with("success", "User Deleted");
    }

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('statistics.index')->with('success', 'Password changed successfully');
    }

    public function changeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo))) {
                unlink(public_path('storage/' . $user->profile_photo));
            }
            $user->profile_photo = $request->file('profile_picture')->store('profile_photos', 'public');
        }

        $user->name = $request->name;   
        $user->save();

        return redirect()->route('statistics.index')->with('success', 'Profile updated successfully'); 
    }


    public function showSettings($section = null)
    {
        $loginHistory = [];
        if ($section === 'login-history') {
            $loginHistory = Auth::user()->logins()->orderBy('created_at', 'desc')->get();
        }

        return view('settings.index', compact('section', 'loginHistory'));
    }
}
