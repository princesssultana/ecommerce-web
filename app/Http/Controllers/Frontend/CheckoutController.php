<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCart(Auth::id());
        $total     = $this->cartService->getTotal(Auth::id());

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty!');
        }

        return view('frontend.pages.checkout', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string',
            'last_name'       => 'required|string',
            'email'           => 'required|email',
            'phone'           => 'required|string',
            'city'            => 'required|string',
            'address'         => 'required|string',
            'shipping_method' => 'required|in:free,express',
            'payment_method'  => 'required|in:cod,sslcommerz',
        ]);

        $cartItems    = $this->cartService->getCart(Auth::id());
        $subtotal     = $this->cartService->getTotal(Auth::id());
        $shippingCost = $request->shipping_method === 'express' ? 9 : 0;
        $total        = $subtotal + $shippingCost;
        $tran_id      = uniqid('TXN_');

        $order = Order::create([
            'user_id'          => Auth::id(),
            'order_number'     => 'ORD-' . strtoupper(uniqid()),
            'subtotal'         => $subtotal,
            'shipping_charge'  => $shippingCost,
            'discount'         => 0,
            'total'            => $total,
            'shipping_name'    => $request->first_name . ' ' . $request->last_name,
            'shipping_phone'   => $request->phone,
            'shipping_address' => $request->address,
            'shipping_city'    => $request->city,
            'shipping_zip'     => $request->zip_code,
            'delivery_type'    => $request->shipping_method === 'express' ? 'express' : 'standard',
            'order_notes'      => null,
            'status'           => 'pending',
            'payment_method'   => $request->payment_method,
            'payment_status'   => 'pending',
            'transaction_id'   => $tran_id,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        if ($request->payment_method === 'cod') {
            $this->cartService->clearCart(Auth::id());
            return redirect()->route('order.confirmation', $order->id)
                             ->with('success', 'Order placed successfully!');
        }

        $post_data = [
            'total_amount'     => $total,
            'currency'         => 'BDT',
            'tran_id'          => $tran_id,
             'success_url' => url('/checkout/payment/success'),
'fail_url'    => url('/checkout/payment/fail'),
'cancel_url'  => url('/checkout/payment/cancel'), 
            'cus_name'         => $request->first_name . ' ' . $request->last_name,
            'cus_email'        => $request->email,
            'cus_add1'         => $request->address,
            'cus_add2'         => '',
            'cus_city'         => $request->city,
            'cus_state'        => $request->state ?? 'Dhaka',
            'cus_postcode'     => $request->zip_code ?? '1000',
            'cus_country'      => 'Bangladesh',
            'cus_phone'        => $request->phone,
            'cus_fax'          => '',
            'ship_name'        => $request->first_name . ' ' . $request->last_name,
            'ship_add1'        => $request->address,
            'ship_add2'        => '',
            'ship_city'        => $request->city,
            'ship_state'       => $request->state ?? 'Dhaka',
            'ship_postcode'    => $request->zip_code ?? '1000',
            'ship_phone'       => $request->phone,
            'ship_country'     => 'Bangladesh',
            'shipping_method'  => 'NO',
            'product_name'     => 'Order #' . $order->id,
            'product_category' => 'Goods',
            'product_profile'  => 'physical-goods',
            'value_a'          => $order->id,
        ];

        $sslc = new SslCommerzNotification();
        $sslc->makePayment($post_data, 'hosted');
    }

    // SSLCommerz Success
    public function paymentSuccess(Request $request)
    {
        $tran_id  = $request->tran_id;
        $order_id = $request->value_a;

        $sslc = new SslCommerzNotification();
        $validation = $sslc->orderValidate(
            $request->all(),
            $tran_id,
            $request->amount,
            $request->currency
        );

        if ($validation) {
            $order = Order::findOrFail($order_id);
            $order->update([
                'payment_status' => 'paid',
                'status'         => 'processing', 
            ]);

            $this->cartService->clearCart($order->user_id);

          return redirect()->route('order.confirmation', $order->id)
                 ->with('success', 'Payment successful!');
        }

        return redirect()->route('checkout.index')
                         ->with('error', 'Payment validation failed!');
    }

    // SSLCommerz Fail
    public function paymentFail(Request $request)
    {
        $order_id = $request->value_a;
        Order::where('id', $order_id)->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('checkout.index')
                         ->with('error', 'Payment failed. Please try again.');
    }

    // SSLCommerz Cancel
    public function paymentCancel(Request $request)
    {
        $order_id = $request->value_a;
        Order::where('id', $order_id)->update([
            'status' => 'cancelled' 
        ]);

        return redirect()->route('checkout.index')
                         ->with('error', 'Payment cancelled.');
    }

    public function confirmation($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('frontend.pages.order_confirmation', compact('order'));
    }
}