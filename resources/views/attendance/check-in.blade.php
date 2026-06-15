<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/landing/images/logo-himatif.png') }}">
    <title>{{ $event->title }} - HIMATIF Attendance</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #172235;
            --panel-soft: #202c40;
            --text: #f8fafc;
            --muted: #cbd5e1;
            --subtle: #94a3b8;
            --line: rgba(255, 255, 255, 0.1);
            --accent: #f59e0b;
            --green: #22c55e;
            --red: #ef4444;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(245, 158, 11, 0.18), transparent 22rem),
                linear-gradient(180deg, #111827 0%, var(--bg) 100%);
            color: var(--text);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .attendance-page {
            width: min(100%, 980px);
            margin: 0 auto;
            padding: clamp(22px, 5vw, 48px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .brand img {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #fff;
            padding: 5px;
            object-fit: contain;
        }

        .brand strong,
        .brand span {
            display: block;
        }

        .brand strong {
            font-size: 15px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .brand span {
            color: var(--subtle);
            font-size: 13px;
        }

        .hero {
            display: grid;
            gap: 18px;
            margin-bottom: 22px;
        }

        .badge {
            width: fit-content;
            border: 1px solid rgba(245, 158, 11, 0.28);
            border-radius: 999px;
            background: rgba(245, 158, 11, 0.12);
            padding: 7px 12px;
            color: #fde68a;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            max-width: 760px;
            font-size: clamp(32px, 7vw, 60px);
            line-height: 1.04;
            font-weight: 900;
            letter-spacing: 0;
        }

        .hero-copy {
            margin: 0;
            max-width: 640px;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.7;
        }

        .countdown-card {
            display: grid;
            gap: 10px;
            border: 1px solid var(--line);
            border-radius: 22px;
            background: rgba(23, 34, 53, 0.82);
            padding: 18px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.22);
        }

        .countdown-label {
            color: var(--subtle);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .countdown-box {
            border-radius: 16px;
            background: var(--panel-soft);
            padding: 14px 10px;
            text-align: center;
        }

        .countdown-box strong {
            display: block;
            font-size: clamp(22px, 8vw, 36px);
            line-height: 1;
        }

        .countdown-box span {
            display: block;
            margin-top: 7px;
            color: var(--subtle);
            font-size: 12px;
            font-weight: 700;
        }

        .main-card {
            margin-top: 18px;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: var(--panel);
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.25);
        }

        .card-section {
            padding: clamp(18px, 4vw, 28px);
        }

        .card-section + .card-section {
            border-top: 1px solid var(--line);
        }

        .section-title {
            margin: 0 0 16px;
            font-size: 18px;
            font-weight: 850;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .info-item {
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.04);
            padding: 14px;
        }

        .info-item span {
            display: block;
            color: var(--subtle);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .info-item strong,
        .info-item div {
            display: block;
            margin-top: 7px;
            color: var(--text);
            font-size: 15px;
            line-height: 1.5;
            word-break: break-word;
        }

        .status {
            margin-bottom: 16px;
            border-radius: 16px;
            padding: 14px;
            background: rgba(245, 158, 11, 0.13);
            color: #fde68a;
            line-height: 1.55;
        }

        .status.success {
            background: rgba(34, 197, 94, 0.14);
            color: #bbf7d0;
        }

        .status.error {
            background: rgba(239, 68, 68, 0.14);
            color: #fecaca;
        }

        .checkin-button {
            width: 100%;
            border: 0;
            border-radius: 16px;
            background: var(--accent);
            padding: 15px 18px;
            color: #111827;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
        }

        .checkin-button:disabled {
            cursor: not-allowed;
            background: #475569;
            color: #cbd5e1;
        }

        .checkin-actions {
            display: grid;
            gap: 10px;
            margin-top: 18px;
        }

        .record-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border: 1px solid rgba(245, 158, 11, 0.35);
            border-radius: 16px;
            background: rgba(245, 158, 11, 0.12);
            padding: 14px 18px;
            color: #fde68a;
            font-size: 15px;
            font-weight: 900;
            text-align: center;
            text-decoration: none;
        }

        .record-link:hover {
            background: rgba(245, 158, 11, 0.2);
        }

        .back-link {
            display: inline-flex;
            margin-top: 16px;
            color: #fde68a;
            font-weight: 800;
            text-decoration: none;
        }

        @media (max-width: 680px) {
            .attendance-page {
                padding: 20px 16px 34px;
            }

            .countdown-grid,
            .info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 420px) {
            .countdown-grid,
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $deadline = $event->check_in_closes_at ?? $event->ends_at;
        $opensAt = $event->check_in_opens_at;
        $roles = $user->roles->pluck('name')->map(fn (string $role): string => str($role)->replace('_', ' ')->title()->toString())->implode(', ');
        $isOpen = $event->isCheckInOpen();
        $alreadyCheckedIn = filled($attendanceRecord);
    @endphp

    <main class="attendance-page" data-deadline="{{ optional($deadline)->toIso8601String() }}">
        <div class="brand">
            <img src="{{ asset('assets/landing/images/logo-himatif.png') }}" alt="Logo HIMATIF">
            <div>
                <strong>HIMATIF Attendance</strong>
                <span>Jakarta Global University</span>
            </div>
        </div>

        <section class="hero">
            <div class="badge">{{ ucfirst(str_replace('_', ' ', $event->activity_type)) }}</div>
            <h1>{{ $event->title }}</h1>
            <p class="hero-copy">
                Pastikan detail kegiatan dan identitas kamu sudah benar sebelum melakukan check-in.
            </p>
        </section>

        <section class="countdown-card">
            <div class="countdown-label">
                {{ $deadline ? 'Tenggat absensi' : 'Absensi tanpa tenggat waktu' }}
                @if ($deadline)
                    - {{ $deadline->format('d M Y H:i') }}
                @endif
            </div>

            <div class="countdown-grid">
                <div class="countdown-box">
                    <strong data-countdown-days>0</strong>
                    <span>Hari</span>
                </div>
                <div class="countdown-box">
                    <strong data-countdown-hours>0</strong>
                    <span>Jam</span>
                </div>
                <div class="countdown-box">
                    <strong data-countdown-minutes>0</strong>
                    <span>Menit</span>
                </div>
                <div class="countdown-box">
                    <strong data-countdown-seconds>0</strong>
                    <span>Detik</span>
                </div>
            </div>
        </section>

        <section class="main-card">
            <div class="card-section">
                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                @if ($alreadyCheckedIn)
                    <div class="status success">
                        Kamu sudah tercatat hadir pada {{ $attendanceRecord->checked_in_at?->format('d M Y H:i') }}.
                    </div>
                @elseif (! $isOpen)
                    <div class="status error">
                        Absensi belum dibuka atau sudah ditutup.
                    </div>
                @endif

                <h2 class="section-title">Detail Kegiatan</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span>Jenis kegiatan</span>
                        <strong>{{ ucfirst(str_replace('_', ' ', $event->activity_type)) }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Lokasi</span>
                        <strong>{{ $event->location ?: '-' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Mulai</span>
                        <strong>{{ $event->starts_at?->format('d M Y H:i') ?: '-' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Selesai</span>
                        <strong>{{ $event->ends_at?->format('d M Y H:i') ?: '-' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Absensi dibuka</span>
                        <strong>{{ $opensAt?->format('d M Y H:i') ?: 'Langsung dibuka' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Tenggat absensi</span>
                        <strong>{{ $deadline?->format('d M Y H:i') ?: 'Tidak ada tenggat' }}</strong>
                    </div>
                    @if ($event->description)
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <span>Deskripsi</span>
                            <div>{!! $event->description !!}</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-section">
                <h2 class="section-title">Identitas Kamu</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span>Nama login</span>
                        <strong>{{ $user->name }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Jabatan / role</span>
                        <strong>{{ $roles ?: '-' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>NPM</span>
                        <strong>{{ $user->npm ?: '-' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Divisi</span>
                        <strong>{{ $user->teamUnit?->name ?: '-' }}</strong>
                    </div>
                </div>

                <div class="checkin-actions">
                    <form method="POST" action="{{ route('attendance.check-in.store', $event->qr_token) }}">
                        @csrf
                        <button
                            type="submit"
                            class="checkin-button"
                            @disabled(! $isOpen || $alreadyCheckedIn || blank($user->npm))
                        >
                            @if ($alreadyCheckedIn)
                                Sudah check-in
                            @elseif (blank($user->npm))
                                NPM belum tersedia
                            @else
                                Check in sekarang
                            @endif
                        </button>
                    </form>

                    @if ($alreadyCheckedIn)
                        <a class="record-link" href="{{ route('filament.app.resources.attendance-records.index') }}">
                            Lihat Histori Absensi
                        </a>
                    @endif
                </div>

                <a class="back-link" href="{{ route('filament.app.pages.dashboard') }}">Kembali ke HIMATIF App</a>
            </div>
        </section>
    </main>

    <script>
        (() => {
            const page = document.querySelector('[data-deadline]');
            const deadline = page?.dataset.deadline;

            const targets = {
                days: document.querySelector('[data-countdown-days]'),
                hours: document.querySelector('[data-countdown-hours]'),
                minutes: document.querySelector('[data-countdown-minutes]'),
                seconds: document.querySelector('[data-countdown-seconds]'),
            };

            const render = () => {
                if (!deadline) {
                    return;
                }

                const distance = Math.max(0, new Date(deadline).getTime() - Date.now());
                targets.days.textContent = Math.floor(distance / (1000 * 60 * 60 * 24));
                targets.hours.textContent = Math.floor((distance / (1000 * 60 * 60)) % 24);
                targets.minutes.textContent = Math.floor((distance / (1000 * 60)) % 60);
                targets.seconds.textContent = Math.floor((distance / 1000) % 60);
            };

            render();
            setInterval(render, 1000);
        })();
    </script>
</body>
</html>
