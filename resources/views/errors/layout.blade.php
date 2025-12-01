@extends('landingpage.layout.master_error')

@section('css')
<link href="{{ asset('assets/landing/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/error.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/subscribe.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/responsive.css') }}" rel="stylesheet">
@endsection
@section('style')

@endsection


@section('content')
    <section class="error-section centred pt_200 pb_120">
        <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-25.png);"></div>
        <div class="auto-container">
            <div class="content-box">
                <h1>@yield('code')</h1>
                <h3>Page Not Found</h3>
                <p>This page doesn’t exist or was removed! We suggest you <br />go back to home.</p>
                <a href="{{ route('home') }}" class="theme-btn btn-one">Back to Homepage</a>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Initialize Feather Icons
        feather.replace();
    </script>
@endsection
