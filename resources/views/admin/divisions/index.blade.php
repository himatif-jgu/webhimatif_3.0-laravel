@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Divisi</li>
  </ol>
</nav>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Daftar Divisi</h4>
  <a href="{{ route('admin.divisions.create') }}" class="btn btn-primary btn-sm">Tambah Divisi</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead><tr><th>Nama</th><th>Slug</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach($divisions as $division)
            <tr>
              <td>{{ $division->name }}</td>
              <td>{{ $division->slug }}</td>
              <td>{{ $division->description ?? '-' }}</td>
              <td class="d-flex gap-1">
                <a href="{{ route('admin.divisions.edit', $division) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form method="POST" action="{{ route('admin.divisions.destroy', $division) }}" onsubmit="return confirm('Hapus divisi ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $divisions->links() }}
    </div>
  </div>
</div>
@endsection
