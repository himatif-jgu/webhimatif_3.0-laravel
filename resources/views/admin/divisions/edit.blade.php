@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.divisions.index') }}">Divisi</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>
</nav>

<div class="card">
  <div class="card-body">
    <h6 class="card-title mb-3">Edit Divisi</h6>
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
      </div>
    @endif
    <form method="POST" action="{{ route('admin.divisions.update', $division) }}">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Nama Divisi</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $division->name) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" class="form-control" name="slug" value="{{ old('slug', $division->slug) }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description', $division->description) }}</textarea>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.divisions.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
