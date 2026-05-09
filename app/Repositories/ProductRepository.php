<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        return Product::with('category')->latest()->get();
    }

    public function getPaginated($perPage = 10)
    {
        return Product::with('category')->latest()->paginate($perPage);
    }

    public function getLatest($count = 4)
    {
        return Product::with('category')->latest()->take($count)->get();
    }

    public function findById($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) return false;
        $product->delete();
        return true;
    }
}