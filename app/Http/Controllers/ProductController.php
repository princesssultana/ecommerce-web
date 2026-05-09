<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $allProducts = $this->service->getAllProducts();
        return view('pages.product.index', compact('allProducts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->service->createProduct($request);
        return redirect()->route('products.index')
                         ->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product    = $this->service->getProductById($id);
        $categories = Category::all();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->service->updateProduct($request, $id);
        return redirect()->route('products.index')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteProduct($id);
        if (!$deleted) {
            return redirect()->back()->with('error', 'Product not found!');
        }
        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully!');
    }

    public function show($id)
    {
        $product = $this->service->getProductById($id);
        return view('pages.product.view', compact('product'));
    }
}