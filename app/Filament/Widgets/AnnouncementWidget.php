<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use Filament\Widgets\Widget;

class AnnouncementWidget extends Widget
{
    protected string $view = 'filament.widgets.announcement-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -3;

    protected function getViewData(): array
    {
        $baseQuery = Announcement::query()
            ->published()
            ->visibleOnDashboard();

        $pinnedAnnouncements = (clone $baseQuery)
            ->where('is_pinned', true)
            ->orderedForDisplay()
            ->limit(2)
            ->get();

        $latestAnnouncements = (clone $baseQuery)
            ->when(
                $pinnedAnnouncements->isNotEmpty(),
                fn ($query) => $query->whereNotIn('id', $pinnedAnnouncements->pluck('id')),
            )
            ->orderedForDisplay()
            ->limit(5)
            ->get();

        return [
            'pinnedAnnouncements' => $pinnedAnnouncements,
            'latestAnnouncements' => $latestAnnouncements,
            'activeAnnouncementsCount' => (clone $baseQuery)->count(),
            'pinnedAnnouncementsCount' => (clone $baseQuery)->where('is_pinned', true)->count(),
        ];
    }
}
