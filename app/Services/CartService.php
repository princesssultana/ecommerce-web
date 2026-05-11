<?php

namespace App\Services;

use App\Repositories\CartRepository;

class CartService
{
    protected $repo;

    public function __construct(CartRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getCart($userId)
    {
        return $this->repo->getByUser($userId);
    }

   public function addToCart($userId, $productId, $qty = 1)
{
    return $this->repo->add($userId, $productId, $qty);
}

    public function removeFromCart($id, $userId)
    {
        return $this->repo->remove($id, $userId);
    }

    public function clearCart($userId)
    {
        return $this->repo->clear($userId);
    }

    public function getTotal($userId)
    {
        $items = $this->repo->getByUser($userId);
        return $items->sum(fn($item) => $item->product->price * $item->quantity);
    }
}