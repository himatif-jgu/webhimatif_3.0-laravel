@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.blog-categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Edit Category</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.blog-categories.update', $blogCategory) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="name" class="form-label">Name *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $blogCategory->name) }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $blogCategory->slug) }}">
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $blogCategory->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $blogCategory->is_active) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">
                Active
              </label>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted">
              <strong>Blog Posts:</strong> {{ $blogCategory->blogs()->count() }}<br>
              <strong>Created:</strong> {{ $blogCategory->created_at->format('d M Y H:i') }}<br>
              <strong>Updated:</strong> {{ $blogCategory->updated_at->format('d M Y H:i') }}
            </small>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
