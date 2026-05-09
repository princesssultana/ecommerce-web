@extends('master')

@section('content')

<h1>Order Details</h1>

<a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3">← Back to List</a>

{{-- Order Summary --}}
<div class="card mb-4">
    <div class="card-header">
        <h5>Order Info — {{ $order->order_number }}</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Customer</th>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Order Date</th>
                <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
            </tr>
            <tr>
                <th>Delivery Type</th>
                <td>
                    @if($order->delivery_type == 'express')
                        <span class="badge bg-warning text-dark">Express</span>
                    @else
                        <span class="badge bg-info text-dark">Standard</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($order->status == 'pending')
                        <span class="badge bg-secondary">Pending</span>
                    @elseif($order->status == 'confirmed')
                        <span class="badge bg-primary">Confirmed</span>
                    @elseif($order->status == 'processing')
                        <span class="badge bg-warning text-dark">Processing</span>
                    @elseif($order->status == 'shipped')
                        <span class="badge bg-info text-dark">Shipped</span>
                    @elseif($order->status == 'delivered')
                        <span class="badge bg-success">Delivered</span>
                    @elseif($order->status == 'cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Order Notes</th>
                <td>{{ $order->order_notes ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
</div>

{{-- Shipping Info --}}
<div class="card mb-4">
    <div class="card-header">
        <h5>Shipping Info</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $order->shipping_name }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $order->shipping_phone }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $order->shipping_address }}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{ $order->shipping_city }}</td>
            </tr>
            <tr>
                <th>ZIP</th>
                <td>{{ $order->shipping_zip ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
</div>

{{-- Order Items --}}
<div class="card mb-4">
    <div class="card-header">
        <h5>Order Items</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->unit_price }} BDT</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->subtotal }} BDT</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Price Summary --}}
<div class="card mb-4" style="max-width: 400px;">
    <div class="card-header">
        <h5>Price Summary</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Subtotal</th>
                <td>{{ $order->subtotal }} BDT</td>
            </tr>
            <tr>
                <th>Shipping Charge</th>
                <td>{{ $order->shipping_charge }} BDT</td>
            </tr>
            <tr>
                <th>Discount</th>
                <td>{{ $order->discount }} BDT</td>
            </tr>
            <tr class="table-success">
                <th>Total</th>
                <td><strong>{{ $order->total }} BDT</strong></td>
            </tr>
        </table>
    </div>
</div>

{{-- Action Buttons --}}
<a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Update Status</a>

<form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete Order</button>
</form>

@endsection