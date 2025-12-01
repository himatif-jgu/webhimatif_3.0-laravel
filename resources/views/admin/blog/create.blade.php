@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Create New Blog Post</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-8">
              <div class="mb-3">
                <label for="title" class="form-label">Title *</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="slug" class="form-label">Slug <small class="text-muted">(Leave empty for auto-generate)</small></label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                @error('slug')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="excerpt" class="form-label">Excerpt</label>
                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="content" class="form-label">Content *</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                @error('content')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">You can use HTML tags for formatting</small>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="featured_image" class="form-label">Featured Image</label>
                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                @error('featured_image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max 2MB (jpeg, jpg, png, webp)</small>
              </div>

              <div class="mb-3">
                <label for="blog_category_id" class="form-label">Category</label>
                <select class="form-select @error('blog_category_id') is-invalid @enderror" id="blog_category_id" name="blog_category_id">
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('blog_category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="author_id" class="form-label">Author</label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                <small class="text-muted">Current logged in user</small>
              </div>

              <div class="mb-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_published">
                    Publish this post
                  </label>
                </div>
              </div>

              <div class="mb-3">
                <label for="published_at" class="form-label">Publish Date</label>
                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at') }}">
                @error('published_at')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Leave empty for current date/time</small>
              </div>

              <hr>

              <h6>SEO Settings</h6>

              <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                @error('meta_title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
                @error('meta_keywords')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Separated by commas</small>
              </div>
            </div>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Create Post</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
