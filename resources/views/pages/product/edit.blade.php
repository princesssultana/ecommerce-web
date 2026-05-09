@extends('master')

@section('content')
<h1>Edit Product</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Product Name</label>
        <input name="product_name" type="text" class="form-control" value="{{ $product->name }}">
    </div>

    <div class="form-group">
        <label>Select Category</label>
        <select class="form-select" name="category_id">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input name="product_price" type="number" class="form-control" value="{{ $product->price }}">
    </div>

    <div class="form-group">
        <label>Stock</label>
        <input name="product_stock" type="number" class="form-control" value="{{ $product->stock }}">
    </div>

    <div class="form-group">
        <label>Description</label>
        <input name="product_description" type="text" class="form-control" value="{{ $product->description }}">
    </div>

    <div class="form-group">
        <label>Current Image</label><br>
        <img src="{{ asset('storage/products/' . $product->thumbnail) }}" width="100px"><br><br>
        <label>Upload New Image (optional)</label>
        <input name="image" type="file" class="form-control">
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active"   {{ $product->status == 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <br>
    <button type="submit" class="btn btn-warning">Update Product</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
</form>

@endsection