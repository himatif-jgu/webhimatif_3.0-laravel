@extends('admin.layout.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Manajemen Anggota</li>
  </ol>
</nav>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row mb-3">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-grow-1">
            <h6 class="text-secondary mb-1">Total Anggota</h6>
            <h3 class="mb-0">{{ $stats['total'] }}</h3>
          </div>
          <div class="ms-3">
            <i data-lucide="users" class="text-primary" style="width: 32px; height: 32px;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-grow-1">
            <h6 class="text-secondary mb-1">Sedang Online</h6>
            <h3 class="mb-0 text-success">{{ $stats['online'] }}</h3>
          </div>
          <div class="ms-3">
            <div class="bg-success rounded-circle d-inline-block" style="width: 32px; height: 32px; position: relative;">
              <div class="bg-white rounded-circle position-absolute top-50 start-50 translate-middle animate-pulse" style="width: 16px; height: 16px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-grow-1">
            <h6 class="text-secondary mb-1">Anggota Aktif</h6>
            <h3 class="mb-0 text-info">{{ $stats['active'] }}</h3>
          </div>
          <div class="ms-3">
            <i data-lucide="check-circle" class="text-info" style="width: 32px; height: 32px;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-3">
  <div class="card-body">
    <form class="row g-2 align-items-end" method="GET" action="{{ route('admin.members.index') }}">
      <div class="col-md-4">
        <label class="form-label" for="search">Cari</label>
        <div class="input-group">
          <span class="input-group-text"><i data-lucide="search"></i></span>
          <input type="text" name="search" id="search" class="form-control" placeholder="Nama, username, NIM, email" value="{{ $filters['search'] }}">
        </div>
      </div>
      <div class="col-md-2">
        <label class="form-label" for="role">Role</label>
        <select name="role" id="role" class="form-select">
          <option value="">Semua</option>
          @foreach($membershipRoles as $role)
            <option value="{{ $role }}" @selected($filters['role'] === $role)>{{ Str::headline($role) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label" for="batch_year">Angkatan</label>
        <select name="batch_year" id="batch_year" class="form-select">
          <option value="">Semua</option>
          @foreach($batchOptions as $batch)
            <option value="{{ $batch }}" @selected((string) $filters['batch_year'] === (string) $batch)>{{ $batch }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label" for="online_status">Status</label>
        <select name="online_status" id="online_status" class="form-select">
          <option value="">Semua</option>
          <option value="online" @selected($filters['online_status'] ?? '' === 'online')>Online</option>
          <option value="offline" @selected($filters['online_status'] ?? '' === 'offline')>Offline</option>
        </select>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-grow-1"><i data-lucide="filter"></i></button>
        <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary" title="Reset"><i data-lucide="x"></i></a>
      </div>
    </form>
  </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Daftar Keanggotaan HIMATIF</h4>
  <a href="{{ route('admin.members.create') }}" class="btn btn-primary"><i data-lucide="plus" class="me-1"></i> Tambah Anggota</a>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Student Number</th>
            <th>Angkatan</th>
            <th>Divisi</th>
            <th>Role</th>
            <th>Aktif</th>
            <th>Status Online</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($members as $index => $member)
            <tr>
              <td>{{ $members->firstItem() + $index }}</td>
              <td>
                <div class="fw-semibold">{{ $member->name }}</div>
                <div class="text-secondary small">{{ $member->email }}</div>
                <div class="text-secondary small">Username: {{ $member->username ?? '-' }}</div>
              </td>
              <td>{{ $member->student_number ?? '-' }}</td>
              <td>{{ $member->batch_year ?? '-' }}</td>
              <td>{{ $member->division?->name ?? '-' }}</td>
              <td>{{ $member->roles->pluck('name')->implode(', ') ?: '-' }}</td>
              <td>
                @if($member->is_active)
                  <span class="text-success d-inline-flex align-items-center gap-1"><i data-lucide="check-circle"></i> Aktif</span>
                @else
                  <span class="text-danger d-inline-flex align-items-center gap-1"><i data-lucide="x-circle"></i> Nonaktif</span>
                @endif
              </td>
              <td>
                <x-user-online-status :user="$member" />
              </td>
              <td class="d-flex flex-wrap gap-1">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.members.show', $member) }}" title="Detail"><i data-lucide="eye"></i></a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.members.edit', $member) }}" title="Edit"><i data-lucide="pencil"></i></a>
                <form action="{{ route('admin.members.toggle-active', $member) }}" method="POST" onsubmit="return confirm('Ubah status aktif anggota ini?');">
                  @csrf
                  @method('PATCH')
                  <button class="btn btn-sm btn-outline-warning" type="submit" title="Toggle Aktif"><i data-lucide="toggle-right"></i></button>
                </form>
                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus (soft delete) anggota ini?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit" title="Hapus"><i data-lucide="trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center text-secondary py-4">Belum ada data anggota.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $members->links() }}
    </div>
  </div>
</div>
@endsection
