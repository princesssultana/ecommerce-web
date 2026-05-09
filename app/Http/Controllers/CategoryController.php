<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // সব category দেখাও
    public function index()
    {
        $categories = Category::paginate(10);
        return view('pages.category.index', compact('categories'));
    }

    // নতুন category form
    public function create()
    {
        return view('pages.category.create');
    }

    // নতুন category save করো
    public function store(Request $request)
    {
        $request->validate([
            'c_name'        => 'required|string|max:255|unique:categories,name',
            'c_description' => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name'        => $request->c_name,
            'slug'        => Str::slug($request->c_name),
            'description' => $request->c_description,
            'status'      => $request->status ?? 1,
            'image'       => $imagePath,
        ]);

        return redirect()->route('category.index')
                         ->with('success', 'Category created successfully!');
    }

    // Single category দেখাও
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.category.view', compact('category'));
    }

    // Edit form
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
    }

    // Update করো
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'c_name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'c_description' => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $category->image; // আগের image রাখো

        // নতুন image দিলে replace করো
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name'        => $request->c_name,
            'slug'        => Str::slug($request->c_name),
            'description' => $request->c_description,
            'status'      => $request->status ?? 1,
            'image'       => $imagePath,
        ]);

        return redirect()->route('category.index')
                         ->with('success', 'Category updated successfully!');
    }

    // Delete করো
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')
                         ->with('success', 'Category deleted successfully!');
    }
}