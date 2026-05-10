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


    public function add($userId, $productId)
    {
        $item = $this->findItem($userId, $productId);

        if ($item) {
            // আগে থেকে cart এ থাকলে quantity বাড়াও
            $item->increment('quantity');
            return $item;
        }

        // নতুন item add করো
        return Cart::create([
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => 1,
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