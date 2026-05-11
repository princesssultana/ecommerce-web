@extends('master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Categories</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Category
    </button>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Category Table --}}
<table class="table table-bordered table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td>

            {{-- Image --}}
            <td>
                @if($category->image)
                <img src="{{ asset('categories/' . $category->image) }}"
     width="50" height="50"
     style="object-fit:cover; border-radius:6px;">
                @else
                    <span class="text-muted">No image</span>
                @endif
            </td>

            {{-- Name --}}
            <td>{{ $category->name }}</td>

            {{-- Description --}}
            <td>{{ Str::limit($category->description, 50) }}</td>

            {{-- Status --}}
            <td>
                <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($category->status) }}
                </span>
            </td>

            {{-- Actions --}}
            <td>
                {{-- Edit Button --}}
                <button class="btn btn-sm btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal{{ $category->id }}">
                    ✏️ Edit
                </button>

                {{-- Delete Button --}}
                <form action="{{ route('category.destroy', $category->id) }}"
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this category?')">
                        🗑️ Delete
                    </button>
                </form>
            </td>
        </tr>

        {{-- Edit Modal --}}
        <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit — {{ $category->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('category.update', $category->id) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Name *</label>
                                <input type="text" name="c_name" class="form-control"
                                       value="{{ $category->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Description *</label>
                                <textarea name="c_description" class="form-control"
                                          rows="3" required>{{ $category->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Image</label>
                                @if($category->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('categories/' . $category->image) }}"
     width="50" height="50"
     style="object-fit:cover; border-radius:6px;">
                                        <small class="text-muted ms-2">Current image</small>
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Leave blank to keep current image</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active"
                                        {{ $category->status === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive"
                                        {{ $category->status === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Edit Modal --}}

        @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">No categories found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
{{ $categories->links() }}


{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('category.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Name *</label>
                        <input type="text" name="c_name" class="form-control"
                               placeholder="e.g. Electronics" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description *</label>
                        <textarea name="c_description" class="form-control"
                                  rows="3" placeholder="Short description..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Create Modal --}}

@endsection