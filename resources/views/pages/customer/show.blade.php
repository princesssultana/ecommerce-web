@extends('master')

@section('content')

<h1>Customer Details</h1>

<a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">← Back to List</a>

<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h5>{{ $customer->name }}</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $customer->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $customer->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{ $customer->city ?? 'N/A' }}</td>
            </tr>
           
            <tr>
                <th>Status</th>
                <td>
                    @if($customer->status == 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $customer->created_at->format('d M Y h:i A') }}</td>
            </tr>
        </table>

        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>

        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">Delete</button>
        </form>

    </div>
</div>

@endsection