<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

class WebProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->getLatestProducts(4);
        return view('frontend.pages.index', compact('products'));
    }

    public function show($id)
    {
        $product = $this->service->getProductById($id);
        return response()->json($product);
    }
}