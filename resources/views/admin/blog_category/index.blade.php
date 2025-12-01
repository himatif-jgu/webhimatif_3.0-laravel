@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
  </ol>
</nav>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Blog Categories</h4>
  <div>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm me-2">Back to Posts</a>
    <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary btn-sm">Create Category</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Posts Count</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $category)
            <tr>
              <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
              <td><strong>{{ $category->name }}</strong></td>
              <td><code>{{ $category->slug }}</code></td>
              <td>{{ Str::limit($category->description, 50) ?: '-' }}</td>
              <td>
                <span class="badge bg-primary">{{ $category->blogs_count }}</span>
              </td>
              <td>
                @if($category->is_active)
                  <span class="badge bg-success">Active</span>
                @else
                  <span class="badge bg-secondary">Inactive</span>
                @endif
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('admin.blog-categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                    <i class="link-icon" data-feather="edit"></i>
                  </a>
                  <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" type="submit">
                      <i class="link-icon" data-feather="trash-2"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">No categories found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($categories->hasPages())
      <div class="mt-3">
        {{ $categories->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
