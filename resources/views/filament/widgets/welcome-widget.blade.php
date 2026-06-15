<x-filament-widgets::widget>
    <style>
        .himatif-dashboard-welcome {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 22px;
            background:
                radial-gradient(circle at top right, rgba(245, 158, 11, 0.28), transparent 28rem),
                linear-gradient(135deg, #12351d 0%, #0f172a 58%, #111827 100%);
            color: #ffffff;
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.18);
        }

        .himatif-dashboard-welcome__inner {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 22px;
            padding: 28px;
        }

        @media (min-width: 768px) {
            .himatif-dashboard-welcome__inner {
                grid-template-columns: minmax(0, 1.6fr) minmax(260px, 0.8fr);
                align-items: center;
                padding: 34px;
            }
        }

        .himatif-dashboard-welcome__badge {
            display: inline-flex;
            width: fit-content;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            padding: 7px 12px;
            color: #fde68a;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .himatif-dashboard-welcome h2 {
            margin: 0;
            color: #ffffff;
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 900;
            line-height: 1.08;
        }

        .himatif-dashboard-welcome__copy {
            max-width: 680px;
            margin-top: 12px;
            color: #dbeafe;
            font-size: 15px;
            line-height: 1.7;
        }

        .himatif-dashboard-welcome__birthday {
            margin-top: 18px;
            border-left: 4px solid #f59e0b;
            border-radius: 14px;
            background: rgba(245, 158, 11, 0.16);
            padding: 14px 16px;
            color: #fff7ed;
            font-weight: 700;
        }

        .himatif-dashboard-welcome__panel {
            display: grid;
            gap: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            background: rgba(15, 23, 42, 0.46);
            padding: 18px;
            backdrop-filter: blur(12px);
        }

        .himatif-dashboard-welcome__row {
            display: grid;
            gap: 3px;
        }

        .himatif-dashboard-welcome__row span {
            color: #93c5fd;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .himatif-dashboard-welcome__row strong {
            color: #ffffff;
            font-size: 14px;
            font-weight: 800;
        }
    </style>

    <section class="himatif-dashboard-welcome">
        <div class="himatif-dashboard-welcome__inner">
            <div>
                <div class="himatif-dashboard-welcome__badge">HIMATIF App</div>
                <h2>{{ $greeting }}, {{ $user?->name ?? 'HIMATIF' }}</h2>
                <p class="himatif-dashboard-welcome__copy">
                    Langkah kecil yang konsisten hari ini bisa jadi dampak besar untuk HIMATIF besok.
                </p>

                @if ($isBirthday)
                    <div class="himatif-dashboard-welcome__birthday">
                        Selamat ulang tahun, {{ $user?->name }}. Semoga sehat, bertumbuh, dan terus memberi dampak baik untuk HIMATIF.
                    </div>
                @endif
            </div>

            <aside class="himatif-dashboard-welcome__panel">
                <div class="himatif-dashboard-welcome__row">
                    <span>Role</span>
                    <strong>{{ $roles ?: 'Member' }}</strong>
                </div>
                <div class="himatif-dashboard-welcome__row">
                    <span>Division</span>
                    <strong>{{ $user?->teamUnit?->name ?? '-' }}</strong>
                </div>
                <div class="himatif-dashboard-welcome__row">
                    <span>NPM</span>
                    <strong>{{ $user?->npm ?? '-' }}</strong>
                </div>
                <div class="himatif-dashboard-welcome__row">
                    <span>Today</span>
                    <strong>{{ now()->translatedFormat('d F Y, H:i') }}</strong>
                </div>
            </aside>
        </div>
    </section>
</x-filament-widgets::widget>
