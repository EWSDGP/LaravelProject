<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;






use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // Corrected syntax
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ["only" => ["index", "show"]]);
        $this->middleware('permission:user-create', ["only" => ["create", "store"]]);
        $this->middleware('permission:user-edit', ["only" => ["edit", "update"]]);
        $this->middleware('permission:user-delete', ["only" => ["destroy"]]);
    }
    public function index()
    {
        // dd("users");
        $users = User::all(); //get
        return view ("users.index",compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $roles = Role::all();
        return view ("users.create",compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name"=>"required",
            "email"=>"required|email",
            "password"=>"required"
        ]);
       $user= User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password)
        ]);
        $user->syncRoles($request->roles);
        return redirect()->route("users.index")->with("success","Users created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view("users.show",compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles=Role::all();
        return view("users.edit",compact("user","roles"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        // dd($request->all());
        $request->validate([
        "name"=>"required",
        "email"=>"required|email",
        "password"=>"required"
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        $user->syncRoles($request->roles);
        return redirect()->route("users.index")->with ("success","User Updated");
        


    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route("users.index")->with("success","User Deleted");
    }
}
