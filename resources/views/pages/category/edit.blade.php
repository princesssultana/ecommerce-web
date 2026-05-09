<form action="{{ route('category.update', $category->id) }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name *</label>
        <input type="text" name="c_name" class="form-control"
               value="{{ old('c_name', $category->name) }}" required>
    </div>

    <div class="mb-3">
        <label>Description *</label>
        <textarea name="c_description" class="form-control" rows="3" required>
            {{ old('c_description', $category->description) }}
        </textarea>
    </div>

    <div class="mb-3">
        <label>Image</label>
        @if($category->image)
            <div class="mb-2">
                <img src="{{ url('/categories/' . $category->image) }}" 
                     width="80" height="80" 
                     style="object-fit:cover;border-radius:8px">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>

</form>