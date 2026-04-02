<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function showCheckinForm($token)
    {
        $meeting = Meeting::where('qr_code_token', $token)->firstOrFail();

        if (!$meeting->isOpen()) {
            return redirect()->route('home')->with('error', 'Presensi untuk kegiatan ini sudah ditutup.');
        }

        // Cek apakah user sudah presensi
        $attendance = MeetingAttendance::where('meeting_id', $meeting->id)
                        ->where('user_id', auth()->id())
                        ->first();

        return view('attendance.checkin', compact('meeting', 'attendance'));
    }

    public function submitCheckin($token)
    {
        $meeting = Meeting::where('qr_code_token', $token)->firstOrFail();

        if (!$meeting->isOpen()) {
            return redirect()->back()->with('error', 'Presensi ditutup.');
        }

        MeetingAttendance::updateOrInsert(
            ['meeting_id' => $meeting->id, 'user_id' => auth()->id()],
            [
                'status' => 'hadir',
                'checkin_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect()->route('attendance.checkin.show', $token)
            ->with('success', 'Berhasil check-in! Terima kasih.');
    }
}
