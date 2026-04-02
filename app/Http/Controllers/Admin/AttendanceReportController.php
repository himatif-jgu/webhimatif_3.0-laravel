<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $users = User::withCount([
            'attendances as hadir_count' => function ($q) use ($startDate, $endDate) {
                $q->where('status', 'hadir');
                if($startDate) $q->whereHas('meeting', fn($m) => $m->whereDate('meeting_date', '>=', $startDate));
                if($endDate) $q->whereHas('meeting', fn($m) => $m->whereDate('meeting_date', '<=', $endDate));
            },
            'attendances as izin_count' => function ($q) use ($startDate, $endDate) {
                $q->where('status', 'izin');
                // Filter date logic sama seperti di atas...
                if($startDate) $q->whereHas('meeting', fn($m) => $m->whereDate('meeting_date', '>=', $startDate));
                if($endDate) $q->whereHas('meeting', fn($m) => $m->whereDate('meeting_date', '<=', $endDate));
            },
            'attendances as absen_count' => function ($q) use ($startDate, $endDate) {
                $q->where('status', 'absen');
                // Filter date logic sama seperti di atas...
                if($startDate) $q->whereHas('meeting', fn($m) => $m->whereDate('meeting_date', '>=', $startDate));
                if($endDate) $q->whereHas('meeting', fn($m) => $m->whereDate('meeting_date', '<=', $endDate));
            }
        ])
        ->paginate(20);

        return view('admin.meetings.report', compact('users', 'startDate', 'endDate'));
    }
}
