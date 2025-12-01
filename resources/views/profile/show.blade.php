@extends('admin.layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
  </ol>
</nav>

@if(session('status') === 'profile-updated')
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your profile has been updated successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row">
  <div class="col-md-4">
    <!-- Profile Card -->
    <div class="card">
      <div class="card-body text-center">
        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200&background=6366f1&color=fff' }}" 
             alt="{{ $user->name }}" 
             class="rounded-circle mb-3" 
             style="width: 160px; height: 160px; object-fit: cover;">
        
        <h4 class="mb-1">{{ $user->name }}</h4>
        <p class="text-muted mb-1">{{ $user->email }}</p>
        @if($user->username)
          <p class="text-muted small mb-2">@<span>{{ $user->username }}</span></p>
        @endif

        <!-- Role Badge -->
        @if($user->roles->isNotEmpty())
          <div class="mb-3">
            @foreach($user->roles as $role)
              <span class="badge bg-primary">{{ ucwords(str_replace('_', ' ', $role->name)) }}</span>
            @endforeach
          </div>
        @endif

        <!-- Online Status -->
        <div class="mb-3">
          <x-user-online-status :user="$user" />
        </div>

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
          <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i data-lucide="edit-3" class="me-1"></i> Edit Profile
          </a>
        </div>

        <!-- Social Links -->
        @if($user->socialMedia->isNotEmpty())
          <hr class="my-4">
          <div class="d-flex justify-content-center gap-3 flex-wrap">
            @foreach($user->socialMedia as $social)
              <a href="{{ $social->url }}" target="_blank" class="text-decoration-none" title="{{ ucfirst($social->platform) }}">
                @if($social->platform === 'instagram')
                  <div class="d-flex align-items-center justify-content-center rounded-circle bg-danger text-white" style="width: 40px; height: 40px;">
                    <i data-lucide="instagram" style="width: 20px; height: 20px;"></i>
                  </div>
                @elseif($social->platform === 'linkedin')
                  <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width: 40px; height: 40px;">
                    <i data-lucide="linkedin" style="width: 20px; height: 20px;"></i>
                  </div>
                @elseif($social->platform === 'twitter')
                  <div class="d-flex align-items-center justify-content-center rounded-circle bg-info text-white" style="width: 40px; height: 40px;">
                    <i data-lucide="twitter" style="width: 20px; height: 20px;"></i>
                  </div>
                @elseif($social->platform === 'facebook')
                  <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background-color: #1877f2;">
                    <i data-lucide="facebook" class="text-white" style="width: 20px; height: 20px;"></i>
                  </div>
                @elseif($social->platform === 'github')
                  <div class="d-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width: 40px; height: 40px;">
                    <i data-lucide="github" style="width: 20px; height: 20px;"></i>
                  </div>
                @else
                  <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white" style="width: 40px; height: 40px;">
                    <i data-lucide="globe" style="width: 20px; height: 20px;"></i>
                  </div>
                @endif
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    <!-- Stats Card -->
    <div class="card mt-3">
      <div class="card-body">
        <h6 class="card-title mb-3">Quick Info</h6>
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="text-muted small">Status</span>
          <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
            {{ $user->is_active ? 'Active' : 'Inactive' }}
          </span>
        </div>
        @if($user->division)
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted small">Division</span>
            <span class="fw-medium">{{ $user->division->name }}</span>
          </div>
        @endif
        @if($user->batch_year)
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted small">Batch</span>
            <span class="fw-medium">{{ $user->batch_year }}</span>
          </div>
        @endif
        @if($user->last_seen_at)
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Last Seen</span>
            <span class="small">{{ $user->lastSeenText() }}</span>
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <!-- Personal Information -->
    <div class="card">
      <div class="card-body">
        <h6 class="card-title mb-4">Personal Information</h6>
        
        <div class="row mb-3">
          <div class="col-sm-4">
            <h6 class="mb-0 small text-muted">Full Name</h6>
          </div>
          <div class="col-sm-8">
            <p class="mb-0">{{ $user->name }}</p>
          </div>
        </div>

        @if($user->username)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Username</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->username }}</p>
            </div>
          </div>
        @endif

        <div class="row mb-3">
          <div class="col-sm-4">
            <h6 class="mb-0 small text-muted">Email</h6>
          </div>
          <div class="col-sm-8">
            <p class="mb-0">{{ $user->email }}</p>
          </div>
        </div>

        @if($user->phone)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Phone</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->phone }}</p>
            </div>
          </div>
        @endif

        @if($user->student_number)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Student Number</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->student_number }}</p>
            </div>
          </div>
        @endif

        @if($user->batch_year)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Batch Year</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->batch_year }}</p>
            </div>
          </div>
        @endif

        @if($user->gender)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Gender</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ ucfirst($user->gender) }}</p>
            </div>
          </div>
        @endif

        @if($user->birth_date)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Birth Date</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->birth_date->format('d F Y') }}</p>
            </div>
          </div>
        @endif

        @if($user->address)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Address</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->address }}</p>
            </div>
          </div>
        @endif

        @if($user->division)
          <div class="row mb-3">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Division</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->division->name }}</p>
            </div>
          </div>
        @endif

        @if($user->bio)
          <hr class="my-3">
          <div class="row">
            <div class="col-sm-4">
              <h6 class="mb-0 small text-muted">Bio</h6>
            </div>
            <div class="col-sm-8">
              <p class="mb-0">{{ $user->bio }}</p>
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- Security Settings -->
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-3"><i data-lucide="lock" class="me-2"></i> Security</h6>
            <p class="text-muted small mb-3">Update your password regularly to keep your account secure.</p>
            <a href="{{ route('profile.edit') }}#security-tab" class="btn btn-sm btn-outline-primary" onclick="event.preventDefault(); window.location.href='{{ route('profile.edit') }}'; setTimeout(() => { document.getElementById('security-tab').click(); }, 100);">
              <i data-lucide="key" class="me-1"></i> Change Password
            </a>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card border-danger">
          <div class="card-body">
            <h6 class="card-title mb-3 text-danger"><i data-lucide="alert-triangle" class="me-2"></i> Danger Zone</h6>
            <p class="text-muted small mb-3">Once you delete your account, there is no going back.</p>
            <a href="{{ route('profile.edit') }}#security-tab" class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); window.location.href='{{ route('profile.edit') }}'; setTimeout(() => { document.getElementById('security-tab').click(); }, 100);">
              <i data-lucide="trash-2" class="me-1"></i> Delete Account
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('custom-scripts')
<script>
  @if(session('status') === 'profile-updated')
    Swal.fire({
      icon: 'success',
      title: 'Profile Updated!',
      text: 'Your profile has been updated successfully',
      confirmButtonColor: '#6571ff',
      timer: 3000,
      showConfirmButton: false
    });
  @endif

  lucide.createIcons();
</script>
@endpush
