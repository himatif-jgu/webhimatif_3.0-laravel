<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected string $view = 'filament.widgets.welcome-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -10;

    protected function getViewData(): array
    {
        $user = auth()->user();
        $now = now();
        $birthDate = $user?->birth_date;

        return [
            'user' => $user,
            'greeting' => match (true) {
                $now->hour < 11 => 'Selamat pagi',
                $now->hour < 15 => 'Selamat siang',
                $now->hour < 18 => 'Selamat sore',
                default => 'Selamat malam',
            },
            'isBirthday' => $birthDate
                && (int) $birthDate->format('m') === (int) $now->format('m')
                && (int) $birthDate->format('d') === (int) $now->format('d'),
            'roles' => $user?->roles?->pluck('name')
                ->map(fn (string $role): string => str($role)->replace('_', ' ')->title()->toString())
                ->implode(', '),
        ];
    }
}
