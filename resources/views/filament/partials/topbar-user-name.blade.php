@php
    $user = auth()->user();
    $roles = $user?->roles?->pluck('name')
        ->map(fn (string $role): string => str($role)->replace('_', ' ')->title()->toString())
        ->implode(', ');
@endphp

@if ($user)
    <style>
        .himatif-topbar-user {
            display: none;
        }

        @media (min-width: 640px) {
            .himatif-topbar-user {
                display: grid;
                gap: 2px;
                max-width: 260px;
                min-width: 0;
                margin-left: 8px;
                padding: 7px 12px;
                border: 1px solid rgba(148, 163, 184, 0.22);
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.82);
                text-align: left;
                line-height: 1.15;
            }
        }

        .dark .himatif-topbar-user {
            background: rgba(15, 23, 42, 0.72);
            border-color: rgba(148, 163, 184, 0.18);
        }

        .himatif-topbar-user__name {
            overflow: hidden;
            color: rgb(17, 24, 39);
            font-size: 13px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dark .himatif-topbar-user__name {
            color: rgb(248, 250, 252);
        }

        .himatif-topbar-user__meta {
            overflow: hidden;
            color: rgb(100, 116, 139);
            font-size: 11px;
            font-weight: 650;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dark .himatif-topbar-user__meta {
            color: rgb(203, 213, 225);
        }
    </style>

    <div class="himatif-topbar-user" title="{{ $user->name }} - {{ $roles ?: $user->email }}">
        <span class="himatif-topbar-user__name">{{ $user->name }}</span>
        <span class="himatif-topbar-user__meta">{{ $roles ?: $user->email }}</span>
    </div>
@endif
