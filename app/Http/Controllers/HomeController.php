<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller  // ← extends Controller যোগ করো
{
    public function home()
    {
        $categories = Category::where('status', 'active')->get();
        $products   = Product::where('status', 'active')
                              ->latest()
                              ->take(8)
                              ->get();

        return view('home', compact('categories', 'products'));
    }
}