<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        
        $categories = Category::take(3)->get(); 
        $products = Product::latest()->take(4)->get(); 
        return view ('frontend.pages.home', compact('categories', 'products'));
    }
}
