@extends('master')

@section('content')

<h1>Product Details</h1>

<a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">← Back to List</a>

<div class="card" style="max-width: 600px;">
    <img src="{{ asset('storage/products/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}">
    
    <div class="card-body">
        <h3 class="card-title">{{ $product->name }}</h3>
        
        <table class="table table-bordered">
            <tr>
                <th>Category</th>
                <td>{{ $product->category_id }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>{{ $product->price }} <BDT></td>
            </tr>
            <tr>
                <th>Stock</th>
                <td>{{ $product->stock }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($product->status == 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>

        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>

    </div>
</div>

@endsection