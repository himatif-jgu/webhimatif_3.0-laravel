@extends('landingpage.templates.landing')

@section('content')
    @php
        $members ??= collect();

        $formatRole = fn (string $role): string => str($role)->replace('_', ' ')->title()->toString();
        $avatarUrl = fn ($member): string => $member->avatar
            ? asset('storage/' . $member->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=234f2e&color=ffffff&size=256';
    @endphp

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

    <section class="team-members-section pb_120">
        <div class="auto-container">
            <div class="sec-title centred pb_50 sec-title-animation animation-style2">
                <span class="sub-title mb_10 title-animation">Team Members</span>
                <h2 class="title-animation">People in {{ $teamUnit->name }}</h2>
                <p class="mt_15">Anggota aktif yang terdaftar pada divisi ini di HIMATIF App.</p>
            </div>

            @if ($members->isNotEmpty())
                <div class="row clearfix">
                    @foreach ($members as $member)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb_30">
                            <div class="himatif-member-card">
                                <figure class="member-photo">
                                    <img src="{{ $avatarUrl($member) }}" alt="{{ $member->name }}">
                                </figure>

                                <div class="member-content">
                                    <h3>{{ $member->name }}</h3>

                                    @if ($member->roles->isNotEmpty())
                                        <p>{{ $member->roles->pluck('name')->map($formatRole)->implode(', ') }}</p>
                                    @else
                                        <p>Member</p>
                                    @endif

                                    @if ($member->npm)
                                        <span>NPM {{ $member->npm }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="himatif-empty-members">
                    <h3>Data anggota belum tersedia</h3>
                    <p>Tambahkan user aktif ke divisi ini melalui HIMATIF App agar fotonya tampil di halaman ini.</p>
                </div>
            @endif
        </div>
    </section>

    <style>
        .team-members-section {
            background: #f8faf8;
        }

        .himatif-member-card {
            height: 100%;
            overflow: hidden;
            border: 1px solid #e4e8e3;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(17, 24, 39, 0.06);
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .himatif-member-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 60px rgba(17, 24, 39, 0.1);
        }

        .himatif-member-card .member-photo {
            aspect-ratio: 1 / 1;
            margin: 0;
            background: #eef4ec;
        }

        .himatif-member-card .member-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .himatif-member-card .member-content {
            padding: 22px;
        }

        .himatif-member-card h3 {
            margin-bottom: 6px;
            color: #141414;
            font-size: 20px;
            line-height: 1.3;
            font-weight: 700;
        }

        .himatif-member-card p {
            margin-bottom: 8px;
            color: #234f2e;
            font-weight: 600;
        }

        .himatif-member-card span {
            color: #6b7280;
            font-size: 14px;
        }

        .himatif-empty-members {
            border: 1px dashed #b8c8b4;
            border-radius: 16px;
            background: #fff;
            padding: 36px;
            text-align: center;
        }

        .himatif-empty-members h3 {
            margin-bottom: 8px;
            color: #141414;
            font-size: 24px;
            font-weight: 700;
        }

        .himatif-empty-members p {
            margin: 0;
            color: #6b7280;
        }

        @media (max-width: 991px) {
            .content_block_one .content-box.ml_80 {
                margin-left: 0;
                margin-top: 40px;
            }
        }

        @media (max-width: 575px) {
            .himatif-member-card .member-content {
                padding: 18px;
            }
        }
    </style>
@endsection
