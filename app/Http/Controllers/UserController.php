<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        return view ("users.index",compact("users"));
    }

  
    public function create()
    {   $roles = Role::all();
        $departments = Department::all();
        return view ("users.create",compact("roles","departments"));
    }

    
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name"=>"required",
            "email"=>"required|email",
            "password"=>"required",
            "department_id" => "nullable|exists:departments,id",
            "profile_photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);

        $profilePhotoUrl = null;
        if ($request->hasFile('profile_photo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('profile_photo')->getRealPath())->getSecurePath();
            $profilePhotoUrl = $uploadedFileUrl;
        }

       $user= User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "department_id" => $request->department_id ?? null,
            "profile_photo" => $profilePhotoUrl
        ]);
        $user->syncRoles($request->roles);
        return redirect()->route("users.index")->with("success","Users created");
    }

  
    public function show(string $id)
    {
        $user = User::find($id);
        return view("users.show",compact("user"));
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
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            // "password" => "required",
            "department_id" => "nullable|exists:departments,id",
            "profile_photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);

        $user = User::find($id);

        if ($request->hasFile('profile_photo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('profile_photo')->getRealPath())->getSecurePath();
            $user->profile_photo = $uploadedFileUrl;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        $user->department_id = $request->department_id;
        $user->save();
    
        $user->syncRoles($request->roles);
    
        return redirect()->route("users.index")->with("success", "User updated successfully.");
    }

    
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route("users.index")->with("success","User Deleted");
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

    return redirect()->route('dashboard')->with('success', 'Password changed successfully');
}
}
