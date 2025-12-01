@extends('admin.layout.master')
@php use Illuminate\Support\Str; @endphp

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.members.index') }}">Anggota</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Anggota</li>
  </ol>
</nav>

<form action="{{ route('admin.members.update', $member) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="row">
    <!-- Left Column - Avatar & Basic Info -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title mb-4">Profile Picture</h6>
          
          <div class="text-center">
            <div class="position-relative d-inline-block">
              <img id="avatarPreview" 
                   src="{{ $member->avatar ? asset('storage/' . $member->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&size=200&background=6366f1&color=fff' }}" 
                   alt="Avatar" 
                   class="rounded-circle mb-3"
                   style="width: 160px; height: 160px; object-fit: cover; cursor: pointer;"
                   onclick="document.getElementById('avatarInput').click()">
              <button type="button" class="btn btn-sm btn-primary rounded-circle position-absolute" 
                      style="bottom: 10px; right: 10px; width: 35px; height: 35px; padding: 0;"
                      onclick="document.getElementById('avatarInput').click()">
                <i data-lucide="camera" style="width: 18px; height: 18px;"></i>
              </button>
            </div>

            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
            <input type="hidden" id="avatarBase64" name="avatar_base64">
            
            <p class="text-muted small mb-2">JPG, PNG or GIF (Max. 2MB)</p>
            @if($member->avatar)
              <button type="button" id="removeAvatar" class="btn btn-sm btn-outline-danger">
                <i data-lucide="trash-2" class="me-1"></i> Remove Photo
              </button>
            @endif
          </div>

          <hr class="my-4">

          <!-- Quick Info -->
          <div class="mb-3">
            <label class="form-label">Status Aktif</label>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">Anggota Aktif</label>
            </div>
          </div>

          <!-- Online Status -->
          <div class="p-3 bg-light rounded">
            <x-user-online-status :user="$member" />
            @if($member->last_seen_at)
              <p class="text-muted small mb-0 mt-2">
                Last seen: {{ $member->last_seen_at->format('d M Y, H:i') }}
              </p>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column - Form -->
    <div class="col-md-8">
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Periksa kembali inputan:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <!-- Personal Information -->
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="card-title mb-4">Personal Information</h6>

          @php $currentRole = $member->roles->first()->name ?? null; @endphp

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                     value="{{ old('name', $member->name) }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                     value="{{ old('username', $member->username) }}" required>
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                     value="{{ old('email', $member->email) }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">No. HP</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                     value="{{ old('phone', $member->phone) }}" placeholder="+62 812-3456-7890">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Student Number <span class="text-danger">*</span></label>
              <input type="text" name="student_number" class="form-control @error('student_number') is-invalid @enderror" 
                     value="{{ old('student_number', $member->student_number) }}" required>
              @error('student_number')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Angkatan <span class="text-danger">*</span></label>
              <input type="number" name="batch_year" class="form-control @error('batch_year') is-invalid @enderror" 
                     value="{{ old('batch_year', $member->batch_year) }}" required min="2000" max="{{ date('Y') + 5 }}">
              @error('batch_year')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Jenis Kelamin</label>
              <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                <option value="">Pilih</option>
                <option value="male" @selected(old('gender', $member->gender) === 'male')>Laki-laki</option>
                <option value="female" @selected(old('gender', $member->gender) === 'female')>Perempuan</option>
              </select>
              @error('gender')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" 
                     value="{{ old('birth_date', optional($member->birth_date)->format('Y-m-d')) }}">
              @error('birth_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Membership Role</label>
              <select name="role" class="form-select @error('role') is-invalid @enderror">
                @foreach($membershipRoles as $roleName)
                  <option value="{{ $roleName }}" @selected(old('role', $currentRole) === $roleName)>{{ Str::headline($roleName) }}</option>
                @endforeach
              </select>
              @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Divisi</label>
              <select name="division_id" class="form-select @error('division_id') is-invalid @enderror">
                <option value="">Pilih Divisi</option>
                @foreach($divisions as $id => $name)
                  <option value="{{ $id }}" @selected(old('division_id', $member->division_id) == $id)>{{ $name }}</option>
                @endforeach
              </select>
              @error('division_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-12">
              <label class="form-label">Alamat</label>
              <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $member->address) }}</textarea>
              @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-12">
              <label class="form-label">Bio</label>
              <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="2">{{ old('bio', $member->bio) }}</textarea>
              @error('bio')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media -->
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="card-title mb-4">Social Media</h6>

          @php
            $socialMediaUrls = $member->socialMedia->pluck('url', 'platform')->toArray();
          @endphp

          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label">Instagram</label>
              <div class="input-group">
                <span class="input-group-text"><i data-lucide="instagram"></i></span>
                <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" 
                       value="{{ old('instagram_url', $socialMediaUrls['instagram'] ?? '') }}" 
                       placeholder="https://instagram.com/username">
                @error('instagram_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-12">
              <label class="form-label">LinkedIn</label>
              <div class="input-group">
                <span class="input-group-text"><i data-lucide="linkedin"></i></span>
                <input type="url" name="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                       value="{{ old('linkedin_url', $socialMediaUrls['linkedin'] ?? '') }}" 
                       placeholder="https://linkedin.com/in/...">
                @error('linkedin_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-12">
              <label class="form-label">Twitter</label>
              <div class="input-group">
                <span class="input-group-text"><i data-lucide="twitter"></i></span>
                <input type="url" name="twitter_url" class="form-control @error('twitter_url') is-invalid @enderror" 
                       value="{{ old('twitter_url', $socialMediaUrls['twitter'] ?? '') }}" 
                       placeholder="https://twitter.com/username">
                @error('twitter_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-12">
              <label class="form-label">Facebook</label>
              <div class="input-group">
                <span class="input-group-text"><i data-lucide="facebook"></i></span>
                <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" 
                       value="{{ old('facebook_url', $socialMediaUrls['facebook'] ?? '') }}" 
                       placeholder="https://facebook.com/username">
                @error('facebook_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-12">
              <label class="form-label">GitHub</label>
              <div class="input-group">
                <span class="input-group-text"><i data-lucide="github"></i></span>
                <input type="url" name="github_url" class="form-control @error('github_url') is-invalid @enderror" 
                       value="{{ old('github_url', $socialMediaUrls['github'] ?? '') }}" 
                       placeholder="https://github.com/username">
                @error('github_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-12">
              <label class="form-label">Website</label>
              <div class="input-group">
                <span class="input-group-text"><i data-lucide="globe"></i></span>
                <input type="url" name="website_url" class="form-control @error('website_url') is-invalid @enderror" 
                       value="{{ old('website_url', $socialMediaUrls['website'] ?? '') }}" 
                       placeholder="https://">
                @error('website_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
              <i data-lucide="arrow-left" class="me-1"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-lucide="save" class="me-1"></i> Simpan Perubahan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Crop Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crop Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="cropImage" src="" alt="Crop" style="max-width: 100%;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelCrop">Cancel</button>
        <button type="button" class="btn btn-primary" id="applyCrop">Apply</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endpush

@push('plugin-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('custom-scripts')
<script>
  let cropper = null;
  let cropModalBootstrap = null;
  const avatarInput = document.getElementById('avatarInput');
  const cropModalEl = document.getElementById('cropModal');
  const cropImage = document.getElementById('cropImage');
  const avatarPreview = document.getElementById('avatarPreview');
  const avatarBase64Input = document.getElementById('avatarBase64');
  const removeAvatarBtn = document.getElementById('removeAvatar');

  // Initialize Bootstrap modal
  cropModalBootstrap = new bootstrap.Modal(cropModalEl);

  avatarInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      if (file.size > 2048000) {
        Swal.fire({
          icon: 'error',
          title: 'File Too Large',
          text: 'Please select an image smaller than 2MB',
          confirmButtonColor: '#6571ff'
        });
        avatarInput.value = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = function(event) {
        cropImage.src = event.target.result;
        cropModalBootstrap.show();
        
        if (cropper) {
          cropper.destroy();
        }
        
        cropper = new Cropper(cropImage, {
          aspectRatio: 1,
          viewMode: 1,
          minCropBoxWidth: 200,
          minCropBoxHeight: 200,
          autoCropArea: 1,
          responsive: true,
          guides: true,
          center: true,
          highlight: true,
          cropBoxMovable: true,
          cropBoxResizable: true,
          toggleDragModeOnDblclick: false,
        });
      };
      reader.readAsDataURL(file);
    }
  });

  document.getElementById('cancelCrop').addEventListener('click', function() {
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
    avatarInput.value = '';
  });

  document.getElementById('applyCrop').addEventListener('click', function() {
    if (cropper) {
      const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
      });

      canvas.toBlob(function(blob) {
        const reader = new FileReader();
        reader.onloadend = function() {
          avatarPreview.src = reader.result;
          avatarBase64Input.value = reader.result;
          cropModalBootstrap.hide();
          cropper.destroy();
          cropper = null;
          
          Swal.fire({
            icon: 'success',
            title: 'Photo Updated',
            text: 'Click "Simpan Perubahan" to apply',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
          });
        };
        reader.readAsDataURL(blob);
      });
    }
  });

  if (removeAvatarBtn) {
    removeAvatarBtn.addEventListener('click', function() {
      Swal.fire({
        title: 'Remove Profile Picture?',
        text: "Member akan menggunakan default avatar",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, remove it'
      }).then((result) => {
        if (result.isConfirmed) {
          avatarPreview.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent('{{ $member->name }}') + '&size=200&background=6366f1&color=fff';
          avatarBase64Input.value = 'remove';
          avatarInput.value = '';
          
          Swal.fire({
            icon: 'success',
            title: 'Photo Removed',
            text: 'Click "Simpan Perubahan" to apply',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
          });
        }
      });
    });
  }

  // Re-initialize Lucide icons
  lucide.createIcons();
</script>
@endpush
