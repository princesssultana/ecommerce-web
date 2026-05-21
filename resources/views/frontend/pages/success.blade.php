@extends('frontend.master')

@section('title', 'Payment Successful')

@section('content')
<section style="padding: 80px 0;">
    <div class="container">
        <div class="card p-5 text-center" style="max-width: 500px; margin: 0 auto;">

            {{-- Success Icon --}}
            <div style="font-size: 70px; color: #22c55e;">✓</div>

            {{-- Title --}}
            <h2 style="margin: 16px 0 8px;">Payment Successful!</h2>
            <p style="color: #64748b;">Thank you for your order.</p>

            <hr>

            {{-- Order Info --}}
            <div style="text-align: left; margin: 20px 0;">
                <table class="table table-borderless">
                    <tr>
                        <th>Order ID</th>
                        <td><strong>#{{ $order->id }}</strong></td>
                    </tr>
                    <tr>
                        <th>Order Number</th>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td><strong style="color: #22c55e;">{{ number_format($order->total, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td><span class="badge bg-success">Paid</span></td>
                    </tr>
                </table>
            </div>

            <hr>

            {{-- Button --}}
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-lg mt-3">
                View Order Details
            </a>

        </div>
    </div>
</section>
@endsection