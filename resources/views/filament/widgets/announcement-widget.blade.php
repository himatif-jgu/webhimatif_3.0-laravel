<x-filament-widgets::widget>
    @php
        $hasAnnouncements = $pinnedAnnouncements->isNotEmpty() || $latestAnnouncements->isNotEmpty();
    @endphp

    <style>
        .himatif-announcement-dashboard {
            display: grid;
            gap: 16px;
        }

        .himatif-announcement-dashboard__header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .himatif-announcement-dashboard__title {
            margin: 0;
            color: rgb(17, 24, 39);
            font-size: 20px;
            font-weight: 900;
        }

        .dark .himatif-announcement-dashboard__title {
            color: #ffffff;
        }

        .himatif-announcement-dashboard__meta {
            margin-top: 4px;
            color: rgb(100, 116, 139);
            font-size: 13px;
        }

        .dark .himatif-announcement-dashboard__meta {
            color: rgb(203, 213, 225);
        }

        .himatif-announcement-dashboard__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .himatif-announcement-dashboard__stats {
            display: grid;
            gap: 10px;
        }

        @media (min-width: 640px) {
            .himatif-announcement-dashboard__stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .himatif-announcement-stat {
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(21, 52, 30, 0.05));
            padding: 14px;
        }

        .dark .himatif-announcement-stat {
            border-color: rgba(148, 163, 184, 0.16);
            background: rgba(15, 23, 42, 0.46);
        }

        .himatif-announcement-stat span {
            color: rgb(100, 116, 139);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .himatif-announcement-stat strong {
            display: block;
            margin-top: 4px;
            color: rgb(17, 24, 39);
            font-size: 26px;
            font-weight: 900;
        }

        .dark .himatif-announcement-stat strong {
            color: #ffffff;
        }

        .himatif-announcement-grid {
            display: grid;
            gap: 12px;
        }

        @media (min-width: 1024px) {
            .himatif-announcement-grid {
                grid-template-columns: minmax(0, 1.1fr) minmax(320px, 0.9fr);
            }
        }

        .himatif-announcement-featured,
        .himatif-announcement-list {
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 18px;
            background: #ffffff;
            overflow: hidden;
        }

        .dark .himatif-announcement-featured,
        .dark .himatif-announcement-list {
            border-color: rgba(148, 163, 184, 0.16);
            background: rgb(17, 24, 39);
        }

        .himatif-announcement-featured__image {
            aspect-ratio: 16 / 7;
            background: linear-gradient(135deg, #12351d, #f59e0b);
        }

        .himatif-announcement-featured__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .himatif-announcement-featured__body {
            padding: 18px;
        }

        .himatif-announcement-item {
            display: flex;
            gap: 12px;
            padding: 14px;
            transition: background-color 150ms ease;
        }

        .himatif-announcement-item + .himatif-announcement-item {
            border-top: 1px solid rgba(148, 163, 184, 0.16);
        }

        .himatif-announcement-item:hover {
            background: rgba(245, 158, 11, 0.08);
        }

        .himatif-announcement-item__thumb {
            width: 56px;
            height: 56px;
            flex: 0 0 auto;
            overflow: hidden;
            border-radius: 12px;
            background: #f59e0b;
        }

        .himatif-announcement-item__thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .himatif-announcement-dashboard h3 {
            margin: 0;
            color: rgb(17, 24, 39);
            font-size: 16px;
            font-weight: 900;
            line-height: 1.35;
        }

        .dark .himatif-announcement-dashboard h3 {
            color: #ffffff;
        }

        .himatif-announcement-dashboard p {
            margin: 6px 0 0;
            color: rgb(100, 116, 139);
            font-size: 13px;
            line-height: 1.55;
        }

        .dark .himatif-announcement-dashboard p {
            color: rgb(203, 213, 225);
        }

        .himatif-announcement-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
            color: rgb(180, 83, 9);
            font-size: 11px;
            font-weight: 800;
        }
    </style>

    <x-filament::section>
        <div class="himatif-announcement-dashboard">
            <div class="himatif-announcement-dashboard__header">
                <div>
                    <h2 class="himatif-announcement-dashboard__title">Pengumuman HIMATIF</h2>
                    <p class="himatif-announcement-dashboard__meta">
                        Menampilkan prioritas dan informasi terbaru. Total aktif: {{ $activeAnnouncementsCount }}.
                    </p>
                </div>

                <div class="himatif-announcement-dashboard__actions">
                    <x-filament::button tag="a" href="{{ route('announcements.index') }}" color="gray" size="sm" icon="heroicon-o-arrow-top-right-on-square" target="_blank">
                        Lihat Semua
                    </x-filament::button>

                    @can('manage_announcements')
                        <x-filament::button tag="a" href="{{ \App\Filament\Resources\AnnouncementResource::getUrl('index') }}" size="sm" icon="heroicon-o-megaphone">
                            Kelola
                        </x-filament::button>
                    @endcan
                </div>
            </div>

            <div class="himatif-announcement-dashboard__stats">
                <div class="himatif-announcement-stat">
                    <span>Active announcements</span>
                    <strong>{{ $activeAnnouncementsCount }}</strong>
                </div>
                <div class="himatif-announcement-stat">
                    <span>Pinned priority</span>
                    <strong>{{ $pinnedAnnouncementsCount }}</strong>
                </div>
            </div>

        @if(! $hasAnnouncements)
            <div class="rounded-xl border border-dashed border-gray-300 p-4 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                Belum ada pengumuman aktif.
            </div>
        @else
            <div class="himatif-announcement-grid">
                @php($featured = $pinnedAnnouncements->first() ?? $latestAnnouncements->first())

                <a href="{{ route('announcements.show', $featured) }}" target="_blank" rel="noopener noreferrer" class="himatif-announcement-featured">
                    <div class="himatif-announcement-featured__image">
                        @if($featured->image)
                            <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}">
                        @endif
                    </div>
                    <div class="himatif-announcement-featured__body">
                        <div class="himatif-announcement-badges">
                            @if($featured->is_pinned)
                                <span>Pinned</span>
                            @endif
                            <span>{{ ucfirst(str_replace('_', ' ', $featured->category)) }}</span>
                            <span>{{ $featured->published_at?->format('d M Y H:i') }}</span>
                        </div>
                        <h3>{{ $featured->title }}</h3>
                        <p>{{ $featured->summary ?: str(strip_tags($featured->content))->limit(170) }}</p>
                    </div>
                </a>

                <div class="himatif-announcement-list">
                    @foreach($pinnedAnnouncements->skip($featured->id === $pinnedAnnouncements->first()?->id ? 1 : 0)->concat($latestAnnouncements->where('id', '!=', $featured->id))->take(5) as $announcement)
                        <a href="{{ route('announcements.show', $announcement) }}" target="_blank" rel="noopener noreferrer" class="himatif-announcement-item">
                            <div class="himatif-announcement-item__thumb">
                                @if($announcement->image)
                                    <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}">
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="himatif-announcement-badges">
                                    @if($announcement->is_pinned)
                                        <span>Pinned</span>
                                    @endif
                                    <span>{{ ucfirst(str_replace('_', ' ', $announcement->category)) }}</span>
                                    <span>{{ $announcement->published_at?->format('d M Y') }}</span>
                                </div>
                                <h3>{{ $announcement->title }}</h3>
                                <p>{{ $announcement->summary ?: str(strip_tags($announcement->content))->limit(95) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
