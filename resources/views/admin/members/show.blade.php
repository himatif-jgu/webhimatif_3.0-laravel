@extends('admin.layout.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.members.index') }}">Anggota</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Anggota</li>
  </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Profil Anggota</h4>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-primary btn-sm"><i data-lucide="pencil" class="me-1"></i> Edit</a>
    <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
  </div>
</div>

<div class="row">
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body text-center">
        <img src="{{ $member->avatar ? asset('storage/'.$member->avatar) : 'https://placehold.co/160x160' }}" alt="avatar" class="rounded-circle mb-3 w-120px h-120px object-fit-cover">
        <h5 class="fw-bold mb-0">{{ $member->name }}</h5>
        <p class="text-secondary mb-2">{{ $member->email }}</p>
        <div class="text-secondary small">
          Role: {{ $member->roles->pluck('name')->implode(', ') ?: '-' }}
        </div>
        <div class="text-secondary small">
          Divisi: {{ $member->division?->name ?? '-' }}
        </div>
        <div class="mt-2">
          @if($member->is_active)
            <span class="text-success d-inline-flex align-items-center gap-1"><i data-lucide="check-circle"></i> Aktif</span>
          @else
            <span class="text-danger d-inline-flex align-items-center gap-1"><i data-lucide="x-circle"></i> Nonaktif</span>
          @endif
        </div>
        <div class="mt-3 d-flex justify-content-center">
          <x-user-online-status :user="$member" />
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="fw-semibold">Username</div>
            <div class="text-secondary">{{ $member->username ?? '-' }}</div>
          </div>
          <div class="col-sm-6">
            <div class="fw-semibold">Student Number</div>
            <div class="text-secondary">{{ $member->student_number ?? '-' }}</div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="fw-semibold">Angkatan</div>
            <div class="text-secondary">{{ $member->batch_year ?? '-' }}</div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="fw-semibold">Telepon</div>
            <div class="text-secondary">{{ $member->phone ?? '-' }}</div>
          </div>
          <div class="col-sm-6">
            <div class="fw-semibold">Jenis Kelamin</div>
            <div class="text-secondary">{{ $member->gender ?? '-' }}</div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="fw-semibold">Tanggal Lahir</div>
            <div class="text-secondary">{{ optional($member->birth_date)->format('d M Y') ?? '-' }}</div>
          </div>
          <div class="col-sm-6">
            <div class="fw-semibold">Status Aktif</div>
            <div class="text-secondary">{{ $member->is_active ? 'Aktif' : 'Nonaktif' }}</div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="fw-semibold">Status Online</div>
            <div class="text-secondary"><x-user-online-status :user="$member" /></div>
          </div>
          <div class="col-sm-6">
            <div class="fw-semibold">Terakhir Online</div>
            <div class="text-secondary">{{ $member->last_seen_at?->format('d M Y H:i') ?? 'Belum pernah' }}</div>
          </div>
        </div>
        <div class="mb-2">
          <div class="fw-semibold">Alamat</div>
          <div class="text-secondary">{{ $member->address ?? '-' }}</div>
        </div>
        <div class="mb-2">
          <div class="fw-semibold">Bio</div>
          <div class="text-secondary">{{ $member->bio ?? '-' }}</div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="fw-semibold">Instagram</div>
            <div class="text-secondary">
              @if($member->instagram_url)
                <a href="{{ $member->instagram_url }}" target="_blank">{{ $member->instagram_url }}</a>
              @else
                -
              @endif
            </div>
          </div>
          <div class="col-sm-6">
            <div class="fw-semibold">LinkedIn</div>
            <div class="text-secondary">
              @if($member->linkedin_url)
                <a href="{{ $member->linkedin_url }}" target="_blank">{{ $member->linkedin_url }}</a>
              @else
                -
              @endif
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="fw-semibold">Website</div>
            <div class="text-secondary">
              @if($member->website_url)
                <a href="{{ $member->website_url }}" target="_blank">{{ $member->website_url }}</a>
              @else
                -
              @endif
            </div>
          </div>
          <div class="col-sm-6">
            <div class="fw-semibold">Divisi</div>
            <div class="text-secondary">{{ $member->division?->name ?? '-' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
