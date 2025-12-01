@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Role & Permission</li>
  </ol>
</nav>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Roles</h4>
  <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">Tambah Role</a>
 </div>

<div class="card mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Permissions</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $role)
            <tr>
              <td>{{ $role->name }}</td>
              <td>{{ $role->permissions->pluck('name')->implode(', ') ?: '-' }}</td>
              <td class="d-flex gap-1">
                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                @if($role->name !== 'admin')
                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Hapus role ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                </form>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h6 class="card-title">Permissions</h6>
    <div class="table-responsive">
      <table class="table">
        <thead><tr><th>Nama</th></tr></thead>
        <tbody>
          @foreach($permissions as $permission)
            <tr>
              <td>{{ $permission->name }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
