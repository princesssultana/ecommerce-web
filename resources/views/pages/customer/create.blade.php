@extends('master')

@section('content')
<h1>Create Customer</h1>

<a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">← Back to List</a>

<form action="{{ route('customers.store') }}" method="POST">
    @csrf

    <div class="form-group mb-3">
        <label>Name</label>
        <input name="name" type="text" class="form-control" placeholder="Enter customer name">
    </div>

    <div class="form-group mb-3">
        <label>Email</label>
        <input name="email" type="email" class="form-control" placeholder="Enter customer email">
    </div>

    <div class="form-group mb-3">
        <label>Phone</label>
        <input name="phone" type="text" class="form-control" placeholder="Enter customer phone">
    </div>

    <div class="form-group mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control" placeholder="Enter customer address"></textarea>
    </div>

    <div class="form-group mb-3">
        <label>City</label>
        <input name="city" type="text" class="form-control" placeholder="Enter customer city">
    </div>

    

    <div class="form-group mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Save Customer</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>

</form>

@endsection