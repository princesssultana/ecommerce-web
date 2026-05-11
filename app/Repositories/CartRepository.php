<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
    public function getByUser($userId)
    {
        return Cart::with('product')->where('user_id', $userId)->get();
    }

    public function findItem($userId, $productId)
    {
        return Cart::where('user_id', $userId)
        ->where('product_id', $productId)
        ->first();
    }


    public function add($userId, $productId, $qty = 1)
{
    $item = $this->findItem($userId, $productId);

    if ($item) {
        $item->increment('quantity', $qty);
        return $item;
    }

    return Cart::create([
        'user_id'    => $userId,
        'product_id' => $productId,
        'quantity'   => $qty,
    ]);
}

    public function remove($id, $userId)
    {
        return Cart::where('id', $id)
                   ->where('user_id', $userId)
                   ->delete();
    }

    public function clear($userId)
    {
        return Cart::where('user_id', $userId)->delete();
    }
}