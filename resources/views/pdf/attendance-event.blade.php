<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Attendance Report - {{ $event->title }}</title>
    <style>
        @page {
            margin: 28px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            color: #111827;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.45;
            margin: 0;
        }

        .header {
            border-bottom: 2px solid #f59e0b;
            padding-bottom: 16px;
            width: 100%;
        }

        .logo {
            float: left;
            height: 52px;
            margin-right: 14px;
            width: 52px;
        }

        .kicker {
            color: #166534;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        h1 {
            font-size: 22px;
            line-height: 1.15;
            margin: 4px 0 6px;
        }

        .muted {
            color: #64748b;
        }

        .summary {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin: 18px 0;
            padding: 14px;
        }

        .summary table,
        .records {
            border-collapse: collapse;
            width: 100%;
        }

        .summary td {
            padding: 4px 8px 4px 0;
            vertical-align: top;
            width: 25%;
        }

        .label {
            color: #64748b;
            display: block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .value {
            color: #111827;
            font-weight: 700;
        }

        .records th {
            background: #14532d;
            color: #ffffff;
            font-size: 9px;
            letter-spacing: .04em;
            padding: 8px 7px;
            text-align: left;
            text-transform: uppercase;
        }

        .records td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 7px;
            vertical-align: top;
        }

        .records tr:nth-child(even) td {
            background: #f8fafc;
        }

        .status {
            color: #166534;
            font-weight: 700;
        }

        .empty {
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            color: #64748b;
            padding: 18px;
            text-align: center;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            color: #64748b;
            font-size: 9px;
            margin-top: 18px;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        @if ($logoDataUri)
            <img class="logo" src="{{ $logoDataUri }}" alt="HIMATIF">
        @endif
        <div class="kicker">HIMATIF JGU Attendance Report</div>
        <h1>{{ $event->title }}</h1>
        <div class="muted">Generated {{ $generatedAt->format('d M Y H:i') }} by {{ $generatedBy->name }}</div>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td><span class="label">Jenis Kegiatan</span><span class="value">{{ Str::of($event->activity_type)->replace('_', ' ')->title() }}</span></td>
                <td><span class="label">Lokasi</span><span class="value">{{ $event->location ?: '-' }}</span></td>
                <td><span class="label">Mulai</span><span class="value">{{ $event->starts_at?->format('d M Y H:i') ?: '-' }}</span></td>
                <td><span class="label">Selesai</span><span class="value">{{ $event->ends_at?->format('d M Y H:i') ?: '-' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Pembuat</span><span class="value">{{ $event->creator?->name ?: '-' }}</span></td>
                <td><span class="label">Petugas</span><span class="value">{{ $event->assignee?->name ?: '-' }}</span></td>
                <td><span class="label">Tenggat Absen</span><span class="value">{{ ($event->check_in_closes_at ?? $event->ends_at)?->format('d M Y H:i') ?: '-' }}</span></td>
                <td><span class="label">Total Hadir</span><span class="value">{{ $records->count() }} peserta</span></td>
            </tr>
        </table>
    </div>

    @if ($records->isEmpty())
        <div class="empty">Belum ada peserta yang tercatat hadir untuk event ini.</div>
    @else
        <table class="records">
            <thead>
                <tr>
                    <th style="width: 28px;">No</th>
                    <th>Nama</th>
                    <th style="width: 78px;">NPM</th>
                    <th>Jabatan</th>
                    <th>Divisi</th>
                    <th style="width: 62px;">Status</th>
                    <th style="width: 92px;">Waktu</th>
                    <th>Dicatat oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    @php
                        $roles = $record->user?->roles?->pluck('name')
                            ->map(fn (string $role) => Str::of($role)->replace('_', ' ')->title())
                            ->implode(', ');
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $record->attendee_name ?: $record->user?->name ?: '-' }}</strong></td>
                        <td>{{ $record->npm ?: $record->user?->npm ?: '-' }}</td>
                        <td>{{ $roles ?: '-' }}</td>
                        <td>{{ $record->user?->teamUnit?->name ?: '-' }}</td>
                        <td class="status">{{ Str::of($record->status)->replace('_', ' ')->title() }}</td>
                        <td>{{ $record->checked_in_at?->format('d M Y H:i') ?: '-' }}</td>
                        <td>{{ $record->checkedInBy?->name ?: '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Dokumen ini dibuat otomatis dari HIMATIF App. Gunakan data ini sebagai rekap internal kegiatan.
    </div>
</body>
</html>
