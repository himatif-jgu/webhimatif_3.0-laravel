@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Edit Role</li>
  </ol>
</nav>

<div class="card">
  <div class="card-body">
    <h6 class="card-title mb-3">Edit Role</h6>
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
      </div>
    @endif
    <form method="POST" action="{{ route('admin.roles.update', $role) }}">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Nama Role</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Permissions</label>
        <div class="row">
          @foreach($permissions as $permission)
            <div class="col-md-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm{{ $permission->id }}" @checked($role->permissions->contains('id', $permission->id))>
                <label class="form-check-label" for="perm{{ $permission->id }}">{{ $permission->name }}</label>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
