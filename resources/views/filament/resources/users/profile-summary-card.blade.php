@php
    use Illuminate\Support\Facades\Storage;

    $avatarUrl = $record?->avatar
        ? Storage::disk('public')->url($record->avatar)
        : null;
    $roles = $record?->roles?->pluck('name')
        ->map(fn (string $role): string => str($role)->replace('_', ' ')->title()->toString())
        ->implode(', ');
@endphp

<style>
    .himatif-profile-card {
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.22);
        border-radius: 16px;
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06);
    }

    .dark .himatif-profile-card {
        background: rgb(17, 24, 39);
        color: rgb(248, 250, 252);
    }

    .himatif-profile-card__cover {
        height: 150px;
        background:
            radial-gradient(circle at 25% 15%, rgba(245, 158, 11, 0.34), transparent 26%),
            radial-gradient(circle at 75% 35%, rgba(34, 197, 94, 0.26), transparent 30%),
            linear-gradient(135deg, #14532d 0%, #f59e0b 100%);
    }

    .himatif-profile-card__body {
        padding: 0 22px 24px;
    }

    .himatif-profile-card__avatar {
        display: grid;
        place-items: center;
        width: 138px;
        height: 138px;
        margin: -72px auto 16px;
        overflow: hidden;
        border: 5px solid #ffffff;
        border-radius: 999px;
        background: #e5e7eb;
        color: #64748b;
        font-size: 38px;
        font-weight: 800;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.18);
    }

    .dark .himatif-profile-card__avatar {
        border-color: rgb(17, 24, 39);
        background: rgb(30, 41, 59);
        color: rgb(203, 213, 225);
    }

    .himatif-profile-card__avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .himatif-profile-card__identity {
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        text-align: center;
    }

    .himatif-profile-card__identity h2 {
        margin: 0;
        color: inherit;
        font-size: 22px;
        font-weight: 850;
        line-height: 1.25;
    }

    .himatif-profile-card__identity p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .dark .himatif-profile-card__identity p {
        color: rgb(203, 213, 225);
    }

    .himatif-profile-card__section-title {
        margin: 22px 0 14px;
        font-size: 18px;
        font-weight: 850;
    }

    .himatif-profile-card__info {
        display: grid;
        gap: 13px;
    }

    .himatif-profile-card__row {
        display: grid;
        grid-template-columns: 130px 1fr;
        gap: 10px;
        font-size: 14px;
        line-height: 1.5;
    }

    .himatif-profile-card__row strong {
        color: #0f172a;
        font-weight: 800;
    }

    .dark .himatif-profile-card__row strong {
        color: rgb(248, 250, 252);
    }

    .himatif-profile-card__row span {
        color: #334155;
        word-break: break-word;
    }

    .dark .himatif-profile-card__row span {
        color: rgb(203, 213, 225);
    }

    @media (max-width: 640px) {
        .himatif-profile-card__row {
            grid-template-columns: 1fr;
            gap: 2px;
        }
    }
</style>

<aside class="himatif-profile-card">
    <div class="himatif-profile-card__cover"></div>

    <div class="himatif-profile-card__body">
        <div class="himatif-profile-card__avatar">
            @if($avatarUrl)
                <img src="{{ $avatarUrl }}" alt="{{ $record?->name }}">
            @else
                {{ str($record?->name ?? 'User')->explode(' ')->map(fn ($part) => str($part)->substr(0, 1))->take(2)->implode('') }}
            @endif
        </div>

        <div class="himatif-profile-card__identity">
            <h2>{{ $record?->name ?? '-' }}</h2>
            <p>{{ $record?->email ?? '-' }}</p>
        </div>

        <h3 class="himatif-profile-card__section-title">Personal Info</h3>

        <div class="himatif-profile-card__info">
            <div class="himatif-profile-card__row">
                <strong>Full Name</strong>
                <span>: {{ $record?->name ?? '-' }}</span>
            </div>
            <div class="himatif-profile-card__row">
                <strong>Email</strong>
                <span>: {{ $record?->email ?? '-' }}</span>
            </div>
            <div class="himatif-profile-card__row">
                <strong>Phone</strong>
                <span>: {{ $record?->phone ?: '-' }}</span>
            </div>
            <div class="himatif-profile-card__row">
                <strong>NPM</strong>
                <span>: {{ $record?->npm ?: '-' }}</span>
            </div>
            <div class="himatif-profile-card__row">
                <strong>Division</strong>
                <span>: {{ $record?->teamUnit?->name ?: '-' }}</span>
            </div>
            <div class="himatif-profile-card__row">
                <strong>Designation</strong>
                <span>: {{ $roles ?: '-' }}</span>
            </div>
            <div class="himatif-profile-card__row">
                <strong>Batch</strong>
                <span>: {{ $record?->batch_year ?: '-' }}</span>
            </div>
            <div class="himatif-profile-card__row">
                <strong>Bio</strong>
                <span>: {{ $record?->bio ?: '-' }}</span>
            </div>
        </div>
    </div>
</aside>
