@php
    $user = auth()->user();
    $roles = $user?->roles?->pluck('name')
        ->map(fn (string $role): string => str($role)->replace('_', ' ')->title()->toString())
        ->implode(', ');
    $avatar = $user?->getFilamentAvatarUrl();
@endphp

<x-filament-panels::page>
    <style>
        .himatif-profile-view {
            display: grid;
            gap: 18px;
        }

        .himatif-profile-hero {
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 22px;
            background: #ffffff;
            box-shadow: 0 14px 45px rgba(15, 23, 42, 0.08);
        }

        .dark .himatif-profile-hero {
            border-color: rgba(148, 163, 184, 0.16);
            background: rgb(17, 24, 39);
        }

        .himatif-profile-hero__cover {
            height: 150px;
            background:
                radial-gradient(circle at top right, rgba(245, 158, 11, 0.38), transparent 24rem),
                linear-gradient(135deg, #12351d, #0f172a);
        }

        .himatif-profile-hero__body {
            display: grid;
            gap: 18px;
            padding: 0 24px 24px;
        }

        @media (min-width: 768px) {
            .himatif-profile-hero__body {
                grid-template-columns: auto 1fr auto;
                align-items: end;
            }
        }

        .himatif-profile-hero__avatar {
            display: grid;
            width: 112px;
            height: 112px;
            margin-top: -56px;
            place-items: center;
            overflow: hidden;
            border: 5px solid #ffffff;
            border-radius: 999px;
            background: #0f766e;
            color: #ffffff;
            font-size: 34px;
            font-weight: 900;
        }

        .dark .himatif-profile-hero__avatar {
            border-color: rgb(17, 24, 39);
        }

        .himatif-profile-hero__avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .himatif-profile-hero h2 {
            margin: 0;
            color: rgb(15, 23, 42);
            font-size: 28px;
            font-weight: 900;
        }

        .dark .himatif-profile-hero h2 {
            color: #ffffff;
        }

        .himatif-profile-hero p {
            margin: 4px 0 0;
            color: rgb(100, 116, 139);
        }

        .dark .himatif-profile-hero p {
            color: rgb(203, 213, 225);
        }

        .himatif-profile-grid {
            display: grid;
            gap: 16px;
        }

        @media (min-width: 768px) {
            .himatif-profile-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .himatif-profile-card {
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 18px;
            background: #ffffff;
            padding: 20px;
        }

        .dark .himatif-profile-card {
            border-color: rgba(148, 163, 184, 0.16);
            background: rgb(17, 24, 39);
        }

        .himatif-profile-card h3 {
            margin: 0 0 16px;
            color: rgb(15, 23, 42);
            font-size: 16px;
            font-weight: 900;
        }

        .dark .himatif-profile-card h3 {
            color: #ffffff;
        }

        .himatif-profile-row {
            display: grid;
            gap: 4px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.16);
        }

        .himatif-profile-row:last-child {
            border-bottom: 0;
        }

        .himatif-profile-row span {
            color: rgb(100, 116, 139);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .himatif-profile-row strong {
            color: rgb(15, 23, 42);
            font-weight: 750;
        }

        .dark .himatif-profile-row strong {
            color: #ffffff;
        }
    </style>

    <div class="himatif-profile-view">
        <section class="himatif-profile-hero">
            <div class="himatif-profile-hero__cover"></div>
            <div class="himatif-profile-hero__body">
                <div class="himatif-profile-hero__avatar">
                    @if ($avatar)
                        <img src="{{ $avatar }}" alt="{{ $user?->name }}">
                    @else
                        {{ str($user?->name ?? 'H')->substr(0, 1)->upper() }}
                    @endif
                </div>
                <div>
                    <h2>{{ $user?->name }}</h2>
                    <p>{{ $user?->email }}</p>
                    <p>{{ $roles ?: 'Member' }}</p>
                </div>
                <x-filament::button tag="a" href="{{ \App\Filament\Pages\EditMyProfile::getUrl() }}" icon="heroicon-o-pencil-square">
                    Edit Profile
                </x-filament::button>
            </div>
        </section>

        <div class="himatif-profile-grid">
            <section class="himatif-profile-card">
                <h3>Organization Info</h3>
                <div class="himatif-profile-row"><span>NPM</span><strong>{{ $user?->npm ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>Role</span><strong>{{ $roles ?: '-' }}</strong></div>
                <div class="himatif-profile-row"><span>Division</span><strong>{{ $user?->teamUnit?->name ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>Batch Year</span><strong>{{ $user?->batch_year ?? '-' }}</strong></div>
            </section>

            <section class="himatif-profile-card">
                <h3>Personal Info</h3>
                <div class="himatif-profile-row"><span>Username</span><strong>{{ $user?->username ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>Phone</span><strong>{{ $user?->phone ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>Birth Date</span><strong>{{ $user?->birth_date?->format('d M Y') ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>Gender</span><strong>{{ $user?->gender ? str($user->gender)->title() : '-' }}</strong></div>
            </section>

            <section class="himatif-profile-card">
                <h3>Bio</h3>
                <div class="himatif-profile-row"><span>Address</span><strong>{{ $user?->address ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>About</span><strong>{{ $user?->bio ?? '-' }}</strong></div>
            </section>

            <section class="himatif-profile-card">
                <h3>Social Links</h3>
                <div class="himatif-profile-row"><span>Instagram</span><strong>{{ $user?->instagram_url ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>LinkedIn</span><strong>{{ $user?->linkedin_url ?? '-' }}</strong></div>
                <div class="himatif-profile-row"><span>Website</span><strong>{{ $user?->website_url ?? '-' }}</strong></div>
            </section>
        </div>
    </div>
</x-filament-panels::page>
