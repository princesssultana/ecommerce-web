@extends('frontend.master')

@section('title', 'My Cart')

@section('content')
<section class="section">
    <div class="container">
        <h2>My Cart</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($cartItems->isEmpty())
            <p>Your cart is empty. <a href="/products">Shop now</a></p>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}"
                             width="60" height="60" style="object-fit:cover;">
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->product->price * $item->quantity }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Total:</td>
                    <td colspan="2">${{ $total }}</td>
                </tr>
            </tfoot>
        </table>

        <form action="{{ route('cart.clear') }}" method="POST" style="display:inline;">
            @csrf
            <button class="btn btn-warning">Clear Cart</button>
        </form>

        <a href="/products" class="btn btn-primary">Continue Shopping</a>
        @endif
    </div>
</section>
@endsection