<?php

namespace App\Http\Controllers;

use App\Models\AttendanceEvent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class AttendanceEventPdfExportController extends Controller
{
    public function __invoke(AttendanceEvent $attendanceEvent): Response
    {
        $user = auth()->user();

        abort_unless(
            $user
                && (
                    $user->isAdmin()
                    || (int) $attendanceEvent->created_by === (int) $user->id
                    || (int) $attendanceEvent->assigned_to === (int) $user->id
                ),
            403,
        );

        $attendanceEvent->load(['creator', 'assignee']);

        $records = $attendanceEvent->records()
            ->with(['user.teamUnit', 'user.roles', 'checkedInBy'])
            ->orderBy('checked_in_at')
            ->orderBy('attendee_name')
            ->get();

        $logoPath = public_path('assets/landing/images/logo-himatif.png');
        $logoDataUri = is_file($logoPath)
            ? 'data:image/png;base64,' . base64_encode((string) file_get_contents($logoPath))
            : null;

        $pdf = Pdf::loadView('pdf.attendance-event', [
            'event' => $attendanceEvent,
            'records' => $records,
            'logoDataUri' => $logoDataUri,
            'generatedBy' => $user,
            'generatedAt' => now(),
        ])->setPaper('a4');

        $filename = 'attendance-' . str($attendanceEvent->title)->slug()->limit(60, '') . '.pdf';

        return $pdf->download($filename);
    }
}
