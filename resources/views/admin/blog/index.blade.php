@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
    <li class="breadcrumb-item active" aria-current="page">List</li>
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
  <h4 class="mb-0">Blog Posts</h4>
  <div>
    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary btn-sm me-2">Manage Categories</a>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">Create New Post</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Status</th>
            <th>Views</th>
            <th>Published Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($blogs as $blog)
            <tr>
              <td>{{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}</td>
              <td>
                <div class="fw-bold">{{ $blog->title }}</div>
                <small class="text-muted">{{ Str::limit($blog->excerpt, 50) }}</small>
              </td>
              <td>
                @if($blog->category)
                  <span class="badge bg-info">{{ $blog->category->name }}</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>{{ $blog->author->name ?? '-' }}</td>
              <td>
                @if($blog->is_published)
                  <span class="badge bg-success">Published</span>
                @else
                  <span class="badge bg-warning">Draft</span>
                @endif
              </td>
              <td>{{ number_format($blog->views_count) }}</td>
              <td>{{ $blog->published_at ? $blog->published_at->format('d M Y') : '-' }}</td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-sm btn-outline-info" target="_blank" title="View">
                    <i class="link-icon" data-feather="eye"></i>
                  </a>
                  <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="link-icon" data-feather="edit"></i>
                  </a>
                  <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete">
                      <i class="link-icon" data-feather="trash-2"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted py-4">No blog posts found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($blogs->hasPages())
      <div class="mt-3">
        {{ $blogs->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
