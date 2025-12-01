@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>
</nav>

<div class="card">
  <div class="card-body">
    <h6 class="card-title">Edit Permission</h6>
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
      </div>
    @endif
    <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Nama Permission</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
