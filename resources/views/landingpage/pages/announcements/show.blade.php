@extends('landingpage.templates.landing')

@section('content')
    @php
        $announcementImage = $announcement->image
            ? asset('storage/' . $announcement->image)
            : null;
    @endphp

    <section class="page-title centred pt_110 pb_90">
        <div class="auto-container">
            <div class="content-box">
                <span class="sub-title">{{ ucfirst(str_replace('_', ' ', $announcement->category)) }}</span>
                <h1>{{ $announcement->title }}</h1>
                <p>{{ $announcement->published_at?->format('d M Y H:i') }}</p>
            </div>
        </div>
    </section>

    <section class="sidebar-page-container pt_90 pb_90">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                    <div class="blog-details-content">
                        @if($announcementImage)
                            <figure class="himatif-announcement-detail-image mb_40">
                                <img src="{{ $announcementImage }}" alt="{{ $announcement->title }}">
                            </figure>
                        @endif

                        @if($announcement->summary)
                            <div class="text-box mb_30">
                                <h3>{{ $announcement->summary }}</h3>
                            </div>
                        @endif

                        <div class="text-box">
                            {!! $announcement->content !!}
                        </div>

                        <div class="mt_40">
                            <a href="{{ route('announcements.index') }}" class="theme-btn btn-one"><span>Kembali ke Pengumuman</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
