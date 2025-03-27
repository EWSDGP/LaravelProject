<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{    
     public function __construct()
    {
        // Corrected syntax
        $this->middleware('permission:department-list|department-create|department-edit|department-delete', ["only" => ["index", "show"]]);
        $this->middleware('permission:department-create', ["only" => ["create", "store"]]);
        $this->middleware('permission:department-edit', ["only" => ["edit", "update"]]);
        $this->middleware('permission:department-delete', ["only" => ["destroy"]]);
    }
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
 
    }

    public function create()
    {
        return view('departments.create');
        
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|unique:departments,name',
        ]);

        Department::create([
            'name' => $request->name,
        ]);
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function edit($id)
    {    $department = Department::findOrFail($id); 
        

        return view('departments.edit', compact('department'));
    }

    public function update(Request $request,$id)
    {   
        $request->validate([
            "name" => "required",
        ]);
        
        $department = Department::findOrFail($id);
        $department->name=$request->name;
        $department->save();
        return redirect()->route('departments.index')->with ("success","Department Updated");
    
    }

    public function destroy( $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index')->with("success","Department Deleted");
    }
}