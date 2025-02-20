<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        $categories = Category::all(); 
        return view('categories.index', compact('categories'));
    }

    
    public function create()
    {
        return view('categories.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

   
    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id); 
        return view('categories.edit', compact('category'));
    }

    
    public function update(Request $request, $category_id)
{   
    $request->validate([
        "category_name" => "required|string|max:255"
    ]);
    
    $category = Category::findOrFail($category_id);
    $category->category_name=$request->category_name;
    $category->save();
    return redirect()->route('categories.index')->with ("success","Categoried Updated");
}

public function destroy($category_id)
{
    $category = Category::findOrFail($category_id);
    $category->delete();
    return redirect()->route('categories.index')->with("success","Categories Deleted");
}
}

