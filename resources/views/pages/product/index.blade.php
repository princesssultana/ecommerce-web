@extends('master')

@section('content')
<h1>Products list</h1>

<a href="{{ route('products.create') }}" class="btn btn-primary">Add new Product</a>

<div class="table-responsive mt-3">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Product Name</th>
        <th scope="col">Image</th>
        <th scope="col">Category Name</th>
        <th scope="col">Description</th>
        <th scope="col">Price</th>
        <th scope="col">Stock</th>
        <th scope="col">Status</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>

      @foreach($allProducts as $singleProduct)
      <tr>
        <th scope="row">{{ $singleProduct->id }}</th>
        <td>{{ $singleProduct->name }}</td>
        <td>
          <img width="100px" src="{{ url('/products/' . $singleProduct->thumbnail) }}" alt="{{ $singleProduct->name }}">
        </td>
        <td>{{ $singleProduct->category_id }}</td>
        <td>{{ $singleProduct->description }}</td>
        <td>{{ $singleProduct->price }} BDT</td>
        <td>{{ $singleProduct->stock }}</td>
        <td>
          @if($singleProduct->status == 'active')
            <span class="badge bg-success">Active</span>
          @else
            <span class="badge bg-danger">Inactive</span>
          @endif
        </td>
        <td>
          <a href="{{ route('products.show', $singleProduct->id) }}" class="btn btn-primary btn-sm">View</a>
          <a href="{{ route('products.edit', $singleProduct->id) }}" class="btn btn-warning btn-sm">Edit</a>
          <form action="{{ route('products.destroy', $singleProduct->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('আপনি কি নিশ্চিত?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
</div>

@endsection