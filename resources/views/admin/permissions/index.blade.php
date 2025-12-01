@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Permissions</li>
  </ol>
</nav>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
  </div>
@endif

<div class="card mb-3">
  <div class="card-body">
    <h6 class="card-title">Tambah Permission</h6>
    <form method="POST" action="{{ route('admin.permissions.store') }}" class="row g-2 align-items-end">
      @csrf
      <div class="col-md-6">
        <label class="form-label">Nama Permission</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead><tr><th>Nama</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach($permissions as $permission)
            <tr>
              <td>{{ $permission->name }}</td>
              <td class="d-flex gap-2">
                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Hapus permission ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
