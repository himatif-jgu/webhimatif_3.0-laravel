@props([
    'position' => null,
])

@php
    $user = filament()->auth()->user();
    $items = collect($this->getUserMenuItems());
    $logoutItem = $items->pull('logout');
    $position ??= filament()->getUserMenuPosition();

    $roles = $user?->roles?->pluck('name')
        ->map(fn (string $role): string => str($role)->replace('_', ' ')->title()->toString())
        ->implode(', ');

    $initials = str($user?->name ?? 'HIMATIF')
        ->explode(' ')
        ->filter()
        ->take(2)
        ->map(fn (string $part): string => str($part)->substr(0, 1)->upper()->toString())
        ->implode('');
@endphp

{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_BEFORE) }}

<style>
    .himatif-user-menu .fi-dropdown-panel {
        width: 320px;
        overflow: hidden;
        border-radius: 18px;
    }

    .himatif-user-menu__header {
        display: flex;
        gap: 12px;
        padding: 18px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(21, 52, 30, 0.08));
    }

    .dark .himatif-user-menu__header {
        border-bottom-color: rgba(148, 163, 184, 0.16);
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.16), rgba(15, 23, 42, 0.96));
    }

    .himatif-user-menu__avatar {
        display: grid;
        flex: 0 0 auto;
        width: 46px;
        height: 46px;
        place-items: center;
        border-radius: 999px;
        background: #0f766e;
        color: #ffffff;
        font-size: 15px;
        font-weight: 800;
    }

    .himatif-user-menu__identity {
        min-width: 0;
    }

    .himatif-user-menu__name {
        display: flex;
        align-items: center;
        gap: 5px;
        color: rgb(17, 24, 39);
        font-size: 15px;
        font-weight: 800;
        line-height: 1.3;
    }

    .dark .himatif-user-menu__name {
        color: rgb(248, 250, 252);
    }

    .himatif-user-menu__email,
    .himatif-user-menu__role {
        overflow: hidden;
        color: rgb(100, 116, 139);
        font-size: 13px;
        line-height: 1.4;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dark .himatif-user-menu__email,
    .dark .himatif-user-menu__role {
        color: rgb(203, 213, 225);
    }

    .himatif-user-menu__section-label {
        padding: 12px 18px 4px;
        color: rgb(148, 163, 184);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.02em;
    }
</style>

<x-filament::dropdown
    :placement="($position === \Filament\Enums\UserMenuPosition::Topbar) ? 'bottom-end' : 'top-end'"
    :teleport="$position === \Filament\Enums\UserMenuPosition::Topbar"
    :attributes="\Filament\Support\prepare_inherited_attributes($attributes)->class(['fi-user-menu', 'himatif-user-menu'])"
>
    <x-slot name="trigger">
        <button
            aria-label="{{ __('filament-panels::layout.actions.open_user_menu.label') }}"
            type="button"
            class="fi-user-menu-trigger"
        >
            <x-filament-panels::avatar.user :user="$user" loading="lazy" />
        </button>
    </x-slot>

    <div class="himatif-user-menu__header">
        <div class="himatif-user-menu__avatar">{{ $initials ?: 'HA' }}</div>
        <div class="himatif-user-menu__identity">
            <div class="himatif-user-menu__name">
                <span>{{ $user?->name ?? 'HIMATIF User' }}</span>
                {{
                    \Filament\Support\generate_icon_html(
                        \Filament\Support\Icons\Heroicon::ChevronDown,
                        attributes: new \Illuminate\View\ComponentAttributeBag(['style' => 'width: 14px; height: 14px;'])
                    )
                }}
            </div>
            <div class="himatif-user-menu__email">{{ $user?->email }}</div>
            <div class="himatif-user-menu__role">{{ $roles ?: 'Member' }}</div>
        </div>
    </div>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            :href="route('filament.app.pages.dashboard')"
            :icon="\Filament\Support\Icons\Heroicon::Squares2x2"
            tag="a"
        >
            Dashboard
        </x-filament::dropdown.list.item>

        @foreach ($items->filter(fn ($item, $key): bool => in_array($key, ['profile', 'edit-profile'], true)) as $item)
            {{ $item }}
        @endforeach
    </x-filament::dropdown.list>

    <div class="himatif-user-menu__section-label">Manage Account</div>

    <x-filament::dropdown.list>
        @if (auth()->user()?->isAdmin())
            <x-filament::dropdown.list.item
                :href="\App\Filament\Resources\UserResource::getUrl('index')"
                :icon="\Filament\Support\Icons\Heroicon::Users"
                tag="a"
            >
                Access Control
            </x-filament::dropdown.list.item>
        @endif

        @foreach ($items->filter(fn ($item, $key): bool => ! in_array($key, ['profile', 'edit-profile'], true)) as $item)
            {{ $item }}
        @endforeach
    </x-filament::dropdown.list>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            href="mailto:himatif.19@jgu.ac.id"
            :icon="\Filament\Support\Icons\Heroicon::QuestionMarkCircle"
            tag="a"
        >
            Help & Support
        </x-filament::dropdown.list.item>

        @if ($logoutItem)
            {{ $logoutItem }}
        @endif
    </x-filament::dropdown.list>
</x-filament::dropdown>

{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_AFTER) }}
