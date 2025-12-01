@extends('admin.layout.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.members.index') }}">Anggota</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Anggota</li>
  </ol>
</nav>

<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h6 class="card-title mb-0">Form Tambah Anggota</h6>
      <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    @if($errors->any())
      <div class="alert alert-danger">
        <strong>Periksa kembali inputan:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Student Number</label>
          <input type="text" name="student_number" class="form-control" value="{{ old('student_number') }}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Angkatan</label>
          <input type="number" name="batch_year" class="form-control" value="{{ old('batch_year') }}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">No. HP</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="col-md-3">
          <label class="form-label">Membership Role</label>
          <select name="role" class="form-select" required>
            @foreach($membershipRoles as $roleName)
              <option value="{{ $roleName }}" @selected(old('role', 'member') === $roleName)>{{ Str::headline($roleName) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Jenis Kelamin</label>
          <select name="gender" class="form-select">
            <option value="">Pilih</option>
            <option value="laki-laki" @selected(old('gender') === 'laki-laki')>Laki-laki</option>
            <option value="perempuan" @selected(old('gender') === 'perempuan')>Perempuan</option>
            <option value="lainnya" @selected(old('gender') === 'lainnya')>Lainnya</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
        </div>
        <div class="col-md-3">
          <label class="form-label">Avatar (max 2MB)</label>
          <input type="file" name="avatar" class="form-control" accept="image/*">
        </div>
        <div class="col-md-3 d-flex align-items-center">
          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Aktif</label>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label">Divisi</label>
          <select name="division_id" class="form-select">
            <option value="">Pilih Divisi</option>
            @foreach($divisions as $id => $name)
              <option value="{{ $id }}" @selected(old('division_id') == $id)>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Instagram</label>
          <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url') }}" placeholder="https://instagram.com/username">
        </div>
        <div class="col-md-3">
          <label class="form-label">LinkedIn</label>
          <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/...">
        </div>
        <div class="col-md-3">
          <label class="form-label">Website</label>
          <input type="url" name="website_url" class="form-control" value="{{ old('website_url') }}" placeholder="https://">
        </div>
        <div class="col-md-6">
          <label class="form-label">Alamat</label>
          <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">Bio</label>
          <textarea name="bio" class="form-control" rows="2">{{ old('bio') }}</textarea>
        </div>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i data-lucide="save" class="me-1"></i> Simpan</button>
        <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
