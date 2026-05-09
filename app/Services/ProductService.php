<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllProducts()
    {
        return $this->repo->getAll();
    }

    public function getPaginatedProducts($perPage = 10)
    {
        return $this->repo->getPaginated($perPage);
    }

    public function getLatestProducts($count = 4)
    {
        return $this->repo->getLatest($count);
    }

    public function getProductById($id)
    {
        return $this->repo->findById($id);
    }

    public function createProduct($request)
    {
        $fileName = $this->uploadImage($request);

        return $this->repo->create([
            'name'        => $request->product_name,
            'category_id' => $request->category_id,
            'description' => $request->product_description,
            'price'       => $request->product_price,
            'stock'       => $request->product_stock,
            'thumbnail'   => $fileName,
        ]);
    }

    public function updateProduct($request, $id)
    {
        $product  = $this->repo->findById($id);
        $filename = $product->thumbnail;

        if ($request->hasFile('image')) {
            $filename = $this->uploadImage($request);
        }

        return $this->repo->update($id, [
            'name'        => $request->product_name,
            'category_id' => $request->category_id,
            'description' => $request->product_description,
            'price'       => $request->product_price,
            'stock'       => $request->product_stock,
            'thumbnail'   => $filename,
            'status'      => $request->status,
        ]);
    }

    public function deleteProduct($id)
    {
        return $this->repo->delete($id);
    }

    // private — শুধু এই class এর ভেতরে কাজ করবে
    private function uploadImage($request)
    {
        if (!$request->hasFile('image')) return '';

        $file     = $request->file('image');
        $fileName = date('Ymdhis') . str_replace(' ', '_', $file->getClientOriginalName());
        $file->storeAs('products', $fileName, 'public');

        return $fileName;
    }
}