<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::all();  // Fetch all categories
        return view('categories.index', compact('categories'));
    }

    // Show form to create a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store a new category
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

    // Show form to edit a category
    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);  // or use $category_id as it is
        return view('categories.edit', compact('category'));
    }

    // Update an existing category
    public function update(Request $request, $category_id)
{
    $category = Category::findOrFail($category_id);
    $category->update($request->all());
    return redirect()->route('categories.index');
}

public function destroy($category_id)
{
    $category = Category::findOrFail($category_id);
    $category->delete();
    return redirect()->route('categories.index');
}
}

