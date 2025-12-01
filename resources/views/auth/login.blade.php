@extends('admin.layout.master2')

@section('content')
<div class="row w-100 mx-0 auth-page">
  <div class="col-md-8 col-xl-6 mx-auto">
    <div class="card">
      <div class="row">
        <div class="col-md-4 pe-md-0">
          <div class="auth-side-wrapper" style="background-image: url({{ url('https://placehold.co/220x450') }})"></div>
        </div>
        <div class="col-md-8 ps-md-0">
          <div class="auth-form-wrapper px-4 py-5">
            <a href="{{ url('/') }}" class="nobleui-logo d-block mb-2">HIMATIF<span> Admin</span></a>
            <h5 class="text-secondary fw-normal mb-4">Masuk ke dashboard HIMATIF.</h5>

            @if (session('status'))
              <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form class="forms-sample" method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus autocomplete="username">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="Password" required>
              </div>
              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember me</label>
              </div>
              <div class="d-flex align-items-center gap-2 mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
                @if (Route::has('password.request'))
                  <a class="text-decoration-none" href="{{ route('password.request') }}">Lupa password?</a>
                @endif
              </div>
              <p class="mt-3 text-secondary">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
