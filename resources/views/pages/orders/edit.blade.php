@extends('master')

@section('content')

<h1>Update Order Status</h1>

<a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3">← Back to List</a>

<div class="card" style="max-width: 500px;">
    <div class="card-header">
        <h5>Order — {{ $order->order_number }}</h5>
    </div>
    <div class="card-body">

        {{-- Current Status --}}
        <div class="mb-3">
            <strong>Current Status:</strong>
            @php
                $statusColors = [
                    'pending'    => 'bg-secondary',
                    'confirmed'  => 'bg-primary',
                    'processing' => 'bg-warning text-dark',
                    'shipped'    => 'bg-info text-dark',
                    'delivered'  => 'bg-success',
                    'cancelled'  => 'bg-danger',
                ];
            @endphp
            <span class="badge {{ $statusColors[$order->status] }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        {{-- Update Form --}}
        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Select New Status</label>
                <select name="status" class="form-control">
                    @foreach($statusColors as $status => $color)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Update Status</button>
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
</div>

@endsection