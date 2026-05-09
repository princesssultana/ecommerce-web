@extends('master')

@section('content')
<h1>Orders List</h1>

<div class="table-responsive mt-3">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Order Number</th>
        <th>Customer</th>
        <th>Shipping Name</th>
        <th>Total</th>
        <th>Delivery Type</th>
        <th>Status</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>

      @foreach($allOrders as $order)
      <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->order_number }}</td>
        <td>{{ $order->user->name ?? 'N/A' }}</td>
        <td>{{ $order->shipping_name }}</td>
        <td>{{ $order->total }} ৳</td>
        <td>
          @if($order->delivery_type == 'express')
            <span class="badge bg-warning text-dark">Express</span>
          @else
            <span class="badge bg-info text-dark">Standard</span>
          @endif
        </td>
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
        <td>{{ $order->created_at->format('d M Y') }}</td>
        <td>
          <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
          <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
          <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach

      @if($allOrders->isEmpty())
      <tr>
        <td colspan="9" class="text-center">There are no orders to display.</td>
      </tr>
      @endif

    </tbody>
  </table>
</div>

@endsection