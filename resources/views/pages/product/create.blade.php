@extends('master')

@section('content')
<h1>Create Product</h1>

<!-- name ,status, image, description -->

<form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">

@csrf

<div class="form-group">
    <label for="name">Enter Product Name</label>
    <input name="product_name" placeholder="Enter Product Name here.." type="text" class="form-control" id="name" aria-describedby="emailHelp">
    
  </div>
  <label for="name">Select Category</label>

  <select class="form-select" aria-label="Default select example" name="category_id">
  <option selected value="">Select Category</option>
    @foreach($categories as $cat)

    <option value="{{$cat->id}}">{{$cat->name}}</option>

    @endforeach
</select>



  <div class="form-group">
    <label for="name">Enter Product Price</label>
    <input name="product_price" placeholder="Enter Product Price here.." type="number" class="form-control" id="name" aria-describedby="emailHelp">
    
  </div>

   <div class="form-group">
    <label for="name">Enter Product Stock</label>
    <input name="product_stock" placeholder="Enter Product Stock here.." type="number" class="form-control" id="name" aria-describedby="emailHelp">
    
  </div>
  <div class="form-group">
    <label for="desc">Enter description</label>
    <input name="product_description" type="text" class="form-control" id="desc">
  </div>

    <div class="form-group">
    <label for="image">Upload Image</label>
    <input name="image" type="file" class="form-control" id="image">
  </div>

   <div class="form-group">
    <label for="status">Select Status</label>
    <select name="status" id="status" class="form-control">
      <option value="active">Active</option>
      <option value="inactive">In Active</option>
    </select>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


@endsection





