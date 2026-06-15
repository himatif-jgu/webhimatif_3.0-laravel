@extends('landingpage.templates.landing')

@section('content')
    <section class="page-title centred pt_110 pb_90">
        <div class="auto-container">
            <div class="content-box">
                <span class="sub-title">Announcement</span>
                <h1>Pengumuman HIMATIF</h1>
            </div>
        </div>
    </section>

    <section class="news-section pt_90 pb_90">
        <div class="auto-container">
            <div class="row clearfix">
                @forelse($announcements as $announcement)
                    @php
                        $announcementImage = $announcement->image
                            ? asset('storage/' . $announcement->image)
                            : asset('assets/landing/images/logo-himatif.png');
                    @endphp
                    <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                        <div class="himatif-announcement-card {{ $announcement->image ? '' : 'is-placeholder' }}">
                            <a href="{{ route('announcements.show', $announcement) }}" class="himatif-announcement-image">
                                <img src="{{ $announcementImage }}" alt="{{ $announcement->title }}">
                            </a>
                            <div class="himatif-announcement-content">
                                <ul class="himatif-announcement-meta">
                                    <li>{{ ucfirst(str_replace('_', ' ', $announcement->category)) }}</li>
                                    <li>{{ $announcement->published_at?->format('d M Y') }}</li>
                                </ul>
                                <h3><a href="{{ route('announcements.show', $announcement) }}">{{ $announcement->title }}</a></h3>
                                <p>{{ $announcement->summary ?: str(strip_tags($announcement->content))->limit(120) }}</p>
                                <div class="link">
                                    <a href="{{ route('announcements.show', $announcement) }}"><span>Read More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 centred">
                        <p>Belum ada pengumuman yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt_30">
                {{ $announcements->links() }}
            </div>
        </div>
    </section>
@endsection
