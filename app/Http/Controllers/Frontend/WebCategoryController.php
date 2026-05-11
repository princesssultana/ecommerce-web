<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class WebCategoryController extends Controller
{
    // All Categories list
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('frontend.pages.category.categorylist', compact('categories'));
    }

    // Category অনুযায়ী Products
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->latest()->get();
        return view('frontend.pages.product.bycategory', compact('products', 'category'));
    }
}