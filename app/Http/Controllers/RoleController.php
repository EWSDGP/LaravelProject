<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{ 
    public function __construct()
    {
        // Corrected syntax
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ["only" => ["index", "show"]]);
        $this->middleware('permission:role-create', ["only" => ["create", "store"]]);
        $this->middleware('permission:role-edit', ["only" => ["edit", "update"]]);
        $this->middleware('permission:role-delete', ["only" => ["destroy"]]);
    }
    
    
    public function index()
    {   
        $roles = Role::all();
        return view ("roles.index",compact("roles"));
    }

   
    public function create()
    {   
        $permissions = Permission::all();
        return view ("roles.create",compact('permissions'));
    }

   
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name"=>"required|unique:roles,name"
        ]);
        $role = Role::create(["name"=>$request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route("roles.index")->with("success","Role created");
    }

    
    public function show(string $id)
    {  
        $role = Role::find($id);
        return view("roles.show",compact("role"));
    }

   
    public function edit(string $id)
    {    $permissions = Permission::all();
        $role = Role::find($id);
        return view("roles.edit",compact("role","permissions"));
    }

    
    public function update(Request $request, string $id)
    {   
        //  $request->validate([
        // "name"=>"required|unique:roles,name"
        // ]);
        
        $role = Role::find($id);
        $role->name=$request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return redirect()->route("roles.index")->with("success","Role Updated");
    }

   
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
    
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role. There are users assigned to this role.');
        }
    
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
    
    
    
}
