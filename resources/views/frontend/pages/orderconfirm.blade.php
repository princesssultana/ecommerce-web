@extends('frontend.master')

@section('title', 'Order Confirmed')

@section('content')
<section style="padding:60px 0;">
    <div class="container">
        <div class="text-center mb-4">
            <i class="lni lni-checkmark-circle"
               style="font-size:60px; color:#22c55e;"></i>
            <h2 style="margin-top:16px;">Order Placed Successfully!</h2>
            <p style="color:#64748b;">Order #{{ $order->id }}</p>
        </div>

        <div class="card p-4" style="max-width:600px; margin:0 auto;">
            <h5 style="margin-bottom:16px;">Order Summary</h5>

            @foreach($order->items as $item)
            <div style="display:flex; justify-content:space-between;
                        padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
            </div>
            @endforeach

            <div style="display:flex; justify-content:space-between;
                        padding:8px 0; color:#64748b;">
                <span>Shipping</span>
                <span>${{ number_format($order->shipping_cost, 2) }}</span>
            </div>

            <div style="display:flex; justify-content:space-between;
                        font-size:16px; font-weight:700;
                        padding-top:12px; border-top:1px solid #e2e8f0;">
                <span>Total</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>

            <div style="margin-top:16px; padding:12px;
                        background:#f8fafc; border-radius:8px; font-size:13px;">
                <div><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</div>
                <div><strong>Phone:</strong> {{ $order->phone }}</div>
                <div><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}</div>
                <div><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</div>
                <div><strong>Status:</strong>
                    <span style="color:#f59e0b;">{{ ucfirst($order->order_status) }}</span>
                </div>
            </div>

            <div style="margin-top:20px; text-align:center;">
                <a href="{{ route('products.list') }}" class="btn btn-primary">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</section>
@endsection