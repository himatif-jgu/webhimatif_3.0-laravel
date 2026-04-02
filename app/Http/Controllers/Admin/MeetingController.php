<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\User;
use App\Models\MeetingAttendance;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::latest('meeting_date')->withCount('attendances')->paginate(10);
        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('admin.meetings.create');
    }

    public function store(StoreMeetingRequest $request)
    {
        $data = $request->validated();
        $data['qr_code_token'] = Str::random(32);
        $data['created_by'] = auth()->id();

        Meeting::create($data);

        return redirect()->route('admin.meetings.index')->with('success', 'Agenda berhasil dibuat.');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['attendances.user', 'creator']);
        
        // Statistik singkat
        $stats = [
            'hadir' => $meeting->attendances->where('status', 'hadir')->count(),
            'izin'  => $meeting->attendances->where('status', 'izin')->count(),
            'absen' => $meeting->attendances->where('status', 'absen')->count(),
        ];

        // Generate check-in URL for QR code (will be generated via JS in view)
        $checkinUrl = route('attendance.checkin.show', $meeting->qr_code_token);

        return view('admin.meetings.show', compact('meeting', 'stats', 'checkinUrl'));
    }

    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        $data = $request->validated();
        // Handle checkbox boolean (kadang tidak terkirim jika unchecked)
        $data['is_active'] = $request->has('is_active');
        
        $meeting->update($data);

        return redirect()->route('admin.meetings.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('admin.meetings.index')->with('success', 'Agenda berhasil dihapus.');
    }

    // --- Manual Attendance Logic ---

    public function attendanceForm(Meeting $meeting)
    {
        // Ambil semua member aktif untuk dilist
        // Sesuaikan role/scope dengan kebutuhan (misal hanya member aktif)
        $users = User::orderBy('name')->get(); 
        
        // Ambil data presensi yang sudah ada untuk meeting ini
        $attendances = $meeting->attendances->keyBy('user_id');

        return view('admin.meetings.attendance', compact('meeting', 'users', 'attendances'));
    }

    public function storeAttendance(Request $request, Meeting $meeting)
    {
        $inputData = $request->input('attendance', []); // Array [user_id => status]
        $notes = $request->input('note', []); // Array [user_id => note]

        foreach ($inputData as $userId => $status) {
            MeetingAttendance::updateOrInsert(
                ['meeting_id' => $meeting->id, 'user_id' => $userId],
                [
                    'status' => $status,
                    'note' => $notes[$userId] ?? null,
                    'created_by' => auth()->id(), // Admin yang input
                    'updated_at' => now(),
                    // Hanya set checkin_at jika hadir dan belum ada
                    'checkin_at' => ($status == 'hadir') ? now() : null 
                ]
            );
        }

        return redirect()->route('admin.meetings.attendance', $meeting->id)
            ->with('success', 'Presensi berhasil disimpan.');
    }
}
