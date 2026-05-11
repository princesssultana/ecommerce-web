<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $cartItems = $this->service->getCart(Auth::id());
        $total     = $this->service->getTotal(Auth::id());
        return view('frontend.pages.cart', compact('cartItems', 'total'));
    }

   public function add(Request $request, $id)
{
    $qty = $request->query('qty', 1);
    $this->service->addToCart(Auth::id(), $id, $qty);
    return redirect()->back()->with('success', 'Product added to cart!');
}

    public function remove($id)
    {
        $this->service->removeFromCart($id, Auth::id());
        return redirect()->back()->with('success', 'Item removed!');
    }

    public function clear()
    {
        $this->service->clearCart(Auth::id());
        return redirect()->back()->with('success', 'Cart cleared!');
    }
}
