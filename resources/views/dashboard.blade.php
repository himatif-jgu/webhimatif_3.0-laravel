@extends('admin.layout.master')

@section('content')
@php
  $hour = now()->format('H');
  $greeting = match(true) {
    $hour >= 4 && $hour < 11 => 'Selamat Pagi',
    $hour >= 11 && $hour < 15 => 'Selamat Siang',
    $hour >= 15 && $hour < 18 => 'Selamat Sore',
    default => 'Selamat Malam',
  };
@endphp

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
</nav>

<div class="card mb-3">
  <div class="card-body d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-1">{{ $greeting }}, {{ auth()->user()->name ?? 'Admin' }}!</h5>
      <p class="text-secondary mb-0">Kelola keanggotaan HIMATIF dengan cepat.</p>
    </div>
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">Tambah Anggota</a>
  </div>
</div>

<div class="row">
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="card-title mb-0">Anggota Aktif</h6>
          <i data-lucide="users"></i>
        </div>
        <h3 class="fw-bold mb-1">{{ \App\Models\User::where('is_active', true)->count() }}</h3>
        <small class="text-secondary">Total anggota HIMATIF aktif</small>
      </div>
    </div>
  </div>
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="card-title mb-0">Pengurus</h6>
          <i data-lucide="shield"></i>
        </div>
        <h3 class="fw-bold mb-1">{{ \App\Models\User::role('bph')->count() }}</h3>
        <small class="text-secondary">Jumlah pengurus terdaftar</small>
      </div>
    </div>
  </div>
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="card-title mb-0">Alumni</h6>
          <i data-lucide="award"></i>
        </div>
        <h3 class="fw-bold mb-1">{{ \App\Models\User::role('alumni')->count() }}</h3>
        <small class="text-secondary">Alumni terdata</small>
      </div>
    </div>
  </div>
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="card-title mb-0">Non-aktif</h6>
          <i data-lucide="slash"></i>
        </div>
        <h3 class="fw-bold mb-1">{{ \App\Models\User::where('is_active', false)->count() }}</h3>
        <small class="text-secondary">Anggota non-aktif</small>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h6 class="card-title mb-1">Selamat datang di Admin HIMATIF</h6>
        <p class="text-secondary mb-0">Gunakan menu di sidebar untuk mengelola keanggotaan.</p>
      </div>
      <a href="{{ route('admin.members.index') }}" class="btn btn-primary">Kelola Anggota</a>
    </div>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="d-flex align-items-center">
          <span class="me-2 text-primary"><i data-lucide="user-plus"></i></span>
          <div>
            <div class="fw-semibold">Tambah Anggota</div>
            <small class="text-secondary">Masukkan anggota baru atau pengurus.</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="d-flex align-items-center">
          <span class="me-2 text-success"><i data-lucide="file-text"></i></span>
          <div>
            <div class="fw-semibold">Lihat Data</div>
            <small class="text-secondary">Pantau status keaktifan & keanggotaan.</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="d-flex align-items-center">
          <span class="me-2 text-warning"><i data-lucide="shield-check"></i></span>
          <div>
            <div class="fw-semibold">Peran & Akses</div>
            <small class="text-secondary">Role admin, pengurus, anggota.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
