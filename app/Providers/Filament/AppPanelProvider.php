<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\AppLogin;
use App\Filament\Pages\EditMyProfile;
use App\Filament\Pages\MyProfile;
use App\Filament\Resources\AnnouncementResource;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\AnnouncementWidget;
use App\Filament\Widgets\WelcomeWidget;
use Filament\Enums\UserMenuPosition;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->brandName('HIMATIF App')
            ->brandLogo(asset('assets/landing/images/logo-himatif.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('assets/landing/images/logo-himatif.png'))
            ->login(AppLogin::class)
            ->profile(isSimple: false)
            ->userMenu(position: UserMenuPosition::Topbar)
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('View Profile')
                    ->icon('heroicon-o-user-circle')
                    ->url(fn (): string => MyProfile::getUrl())
                    ->sort(-2),
                'edit-profile' => MenuItem::make()
                    ->label('Edit Profile')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (): string => EditMyProfile::getUrl())
                    ->sort(-1),
                'manage-announcements' => MenuItem::make()
                    ->label('Manage Announcements')
                    ->icon('heroicon-o-megaphone')
                    ->url(fn (): string => AnnouncementResource::getUrl('index'))
                    ->visible(fn (): bool => (bool) auth()->user()?->can('manage_announcements'))
                    ->sort(10),
            ])
            ->renderHook(
                PanelsRenderHook::TOPBAR_END,
                fn (): string => view('filament.partials.topbar-theme-switcher')->render(),
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_LOGO_AFTER,
                fn (): string => view('filament.partials.brand-title')->render(),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_LOGO_AFTER,
                fn (): string => view('filament.partials.brand-title')->render(),
            )
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                WelcomeWidget::class,
                AnnouncementWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
