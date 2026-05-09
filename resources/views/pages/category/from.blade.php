@extends('master')

@section('content')
<h1>Create Category</h1>

<!-- name ,status, image, description -->


<form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
@csrf

  <div class="form-group">
    <label for="name">Enter Category Name</label>
    <input required name="c_name" placeholder="Enter Category Name here.." type="text" class="form-control" id="name" aria-describedby="emailHelp">
    
  </div>
  <div class="form-group">
    <label for="desc">Enter description</label>
    <input required name="c_description" type="text" class="form-control" id="desc">
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





