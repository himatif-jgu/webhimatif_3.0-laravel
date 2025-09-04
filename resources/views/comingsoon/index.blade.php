@extends('layout_landingpage.comingsoon')

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
                <h1>Coming Soon</h1>
                     <br>
                <br>
                <h3>This page is currently under development. Stay tuned for its launch!</h3>

                {{-- <p>This page is currently under development. Stay tuned for its launch!</p> --}}
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
