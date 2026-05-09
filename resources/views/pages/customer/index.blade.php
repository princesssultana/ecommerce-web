@extends('master')

@section('content')
<h1>Customers List</h1>

<a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add new Customer</a>

<div class="table-responsive mt-3">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>City</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>

      @foreach($allCustomers as $customer)
      <tr>
        <td>{{ $customer->id }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->email }}</td>
        <td>{{ $customer->phone ?? 'N/A' }}</td>
        <td>{{ $customer->city ?? 'N/A' }}</td>
        <td>
          @if($customer->status == 'active')
            <span class="badge bg-success">Active</span>
          @else
            <span class="badge bg-danger">Inactive</span>
          @endif
        </td>
        <td>{{ $customer->created_at->format('d M Y') }}</td>
        <td>
          <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-primary btn-sm">View</a>
          <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
          <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach

      @if($allCustomers->isEmpty())
      <tr>
        <td colspan="8" class="text-center">There are no customers to display.</td>
      </tr>
      @endif

    </tbody>
  </table>
</div>

@endsection