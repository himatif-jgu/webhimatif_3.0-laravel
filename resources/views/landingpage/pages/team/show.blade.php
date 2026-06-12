@extends('landingpage.templates.landing')

@section('content')
    <section class="page-title centred pt_110">
        <div class="auto-container">
            <div class="content-box">
                <h1>{{ $teamUnit->name }}</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>-</li>
                    <li>{{ $teamUnit->name }}</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="about-section pt_120 pb_120">
        <div class="auto-container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <figure class="image-box">
                        <img src="{{ $teamUnit->image_path ? asset('storage/' . $teamUnit->image_path) : asset('assets/landing/images/resource/about-us.png') }}"
                            alt="{{ $teamUnit->name }}">
                    </figure>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <div class="content_block_one">
                        <div class="content-box ml_80">
                            <div class="sec-title pb_20">
                                <span class="sub-title mb_10">{{ $teamUnit->subtitle ?? 'HIMATIF Team Unit' }}</span>
                                <h2>{{ $teamUnit->name }}</h2>
                            </div>
                            <div class="text-box">
                                {!! $teamUnit->description ?: '<p>Detail konten tim belum tersedia.</p>' !!}
                            </div>
                            <div class="btn-box mt_30">
                                <a href="{{ route('home') }}#team" class="theme-btn btn-one">Back to Team</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
