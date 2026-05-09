@extends('master')

@section('content')

<h1>Edit Customer</h1>

<a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">← Back to List</a>

<form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <label>Name</label>
        <input name="name" type="text" class="form-control" value="{{ $customer->name }}">
    </div>

    <div class="form-group mb-3">
        <label>Email</label>
        <input name="email" type="email" class="form-control" value="{{ $customer->email }}">
    </div>

    <div class="form-group mb-3">
        <label>Phone</label>
        <input name="phone" type="text" class="form-control" value="{{ $customer->phone }}">
    </div>

    <div class="form-group mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
    </div>

    <div class="form-group mb-3">
        <label>City</label>
        <input name="city" type="text" class="form-control" value="{{ $customer->city }}">
    </div>


    <div class="form-group mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active"   {{ $customer->status == 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-warning">Update Customer</button>
    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary">Cancel</a>

</form>

@endsection