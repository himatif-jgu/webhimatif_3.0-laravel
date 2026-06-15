<?php

namespace App\Http\Controllers;

use App\Models\AttendanceEvent;
use App\Models\AttendanceRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AttendanceCheckInController extends Controller
{
    public function show(string $token): View|RedirectResponse
    {
        $event = AttendanceEvent::where('qr_token', $token)->firstOrFail();

        if (! Auth::check()) {
            return redirect()->guest(route('filament.app.auth.login'));
        }

        $user = Auth::user();
        $attendanceRecord = blank($user->npm)
            ? null
            : AttendanceRecord::query()
                ->where('attendance_event_id', $event->id)
                ->where('npm', $user->npm)
                ->first();

        return view('attendance.check-in', compact('event', 'user', 'attendanceRecord'));
    }

    public function qr(string $token): Response
    {
        $event = AttendanceEvent::where('qr_token', $token)->firstOrFail();

        return response($event->qrCodeSvg(), 200, [
            'Content-Type' => 'image/svg+xml',
        ]);
    }

    public function store(Request $request, string $token): RedirectResponse
    {
        $event = AttendanceEvent::where('qr_token', $token)->firstOrFail();
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('filament.app.auth.login'));
        }

        if (! $event->isCheckInOpen()) {
            return back()->with('status', 'Absensi belum dibuka atau sudah ditutup.');
        }

        if (blank($user->npm)) {
            return back()->with('status', 'NPM belum tersedia di profil kamu. Hubungi pengurus untuk memperbarui data.');
        }

        AttendanceRecord::updateOrCreate(
            [
                'attendance_event_id' => $event->id,
                'npm' => $user->npm,
            ],
            [
                'user_id' => $user->id,
                'attendee_name' => $user->name,
                'status' => 'present',
                'source' => 'self_qr',
                'checked_in_at' => now(),
                'checked_in_by' => $user->id,
            ],
        );

        return back()->with('status', 'Absensi berhasil dicatat.');
    }
}
