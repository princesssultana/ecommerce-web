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
        $products = $this->service->getPaginatedProducts(12);
        return view('frontend.pages.product.productlist', compact('products'));
    }

    // Single Product Details page
public function details($id)
{
    $product = $this->service->getProductById($id);
    return view('frontend.pages.product.details', compact('product'));
}



}