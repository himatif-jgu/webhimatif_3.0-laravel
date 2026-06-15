<?php

use App\Http\Controllers\AttendanceCheckInController;
use App\Http\Controllers\AttendanceEventPdfExportController;
use App\Http\Controllers\LandingPageBlogController;
use App\Http\Controllers\QrCodeSvgController;
use App\Http\Controllers\ShortUrlRedirectController;
use App\Models\ContactInformation;
use App\Models\Announcement;
use App\Models\FoundationContent;
use App\Models\HistoryEntry;
use App\Models\LandingContent;
use App\Models\LeadershipMember;
use App\Models\TeamUnit;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $latestBlogs = \App\Models\Blog::with(['category', 'author'])
        ->published()
        ->latest('published_at')
        ->limit(3)
        ->get();
    $landingAnnouncements = Announcement::query()
        ->published()
        ->visibleOnLanding()
        ->orderedForDisplay()
        ->limit(6)
        ->get();

    $landingContents = LandingContent::active()
        ->orderBy('section')
        ->orderBy('sort_order')
        ->get()
        ->keyBy('key');
    $historyEntries = HistoryEntry::active()->get()->groupBy('type');
    $foundationContents = FoundationContent::active()->get();
    $teamUnits = TeamUnit::active()->get();
    $leadershipMembers = LeadershipMember::active()->get();
    $contactInformation = ContactInformation::active()->get();
    
    return view('landingpage.pages.home', compact(
        'latestBlogs',
        'landingAnnouncements',
        'landingContents',
        'historyEntries',
        'foundationContents',
        'teamUnits',
        'leadershipMembers',
        'contactInformation',
    ));
})->name('home');

Route::get('/announcements', function () {
    $announcements = Announcement::query()
        ->published()
        ->visibleOnLanding()
        ->orderedForDisplay()
        ->paginate(9);

    return view('landingpage.pages.announcements.index', compact('announcements'));
})->name('announcements.index');

Route::get('/announcements/{announcement:slug}', function (Announcement $announcement) {
    abort_unless(
        $announcement->is_published
            && $announcement->published_at
            && $announcement->published_at->lte(now())
            && (! $announcement->expires_at || $announcement->expires_at->gte(now()))
            && in_array($announcement->visibility, ['public', 'landing_only'], true),
        404,
    );

    return view('landingpage.pages.announcements.show', compact('announcement'));
})->name('announcements.show');

Route::get('/team/{teamUnit:slug}', function (TeamUnit $teamUnit) {
    abort_unless($teamUnit->is_active, 404);

    $members = $teamUnit->users()
        ->with('roles')
        ->where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('landingpage.pages.team.show', compact('teamUnit', 'members'));
})->name('team.show');

Route::get('/attendance/{token}', [AttendanceCheckInController::class, 'show'])
    ->name('attendance.check-in');
Route::get('/attendance/{token}/qr.svg', [AttendanceCheckInController::class, 'qr'])
    ->name('attendance.qr');
Route::post('/attendance/{token}', [AttendanceCheckInController::class, 'store'])
    ->name('attendance.check-in.store');
Route::get('/attendance-events/{attendanceEvent}/export.pdf', AttendanceEventPdfExportController::class)
    ->middleware('auth')
    ->name('attendance-events.export-pdf');

Route::get('/s/{code}', ShortUrlRedirectController::class)
    ->where('code', '[A-Za-z0-9-]+')
    ->name('short-urls.redirect');

Route::get('/qr/{token}', QrCodeSvgController::class)
    ->where('token', '[A-Za-z0-9]+')
    ->name('qr-codes.show');

Route::get('/qr/{token}.svg', QrCodeSvgController::class)
    ->where('token', '[A-Za-z0-9]+')
    ->name('qr-codes.svg');

Route::prefix('foundation')->group(function () {
    Route::get('/vision', function () {
        return view('landingpage.pages.foundation.vision');
    })->name('foundation.vision');

    Route::get('/mission', function () {
        return view('landingpage.pages.foundation.mission');
    })->name('foundation.mission');
});

// Route for handling errors
Route::prefix('error')->group(function () {
    Route::get('/401', function () {
        abort(401);
    })->name('error.401');
    Route::get('/402', function () {
        abort(402);
    })->name('error.402');
    Route::get('/403', function () {
        abort(403);
    })->name('error.403');
    Route::get('/404', function () {
        abort(404);
    })->name('error.404');
    Route::get('/405', function () {
        abort(405);
    })->name('error.405');
    Route::get('/500', function () {
        abort(500);
    })->name('error.500');
    // Tambahkan route error lain di sini jika diperlukan
});

Route::get('/comingsoon', function () {
    return view('comingsoon.index');
})->name('comingsoon');


// Mini App

Route::prefix('apps')->group(function () {
    Route::get('/spin-wheel', function () {
        return view('landingpage.pages.apps.spin_wheel.index');
    })->name('spin_wheel');

    Route::get('/split-bill', function () {
        return view('landingpage.pages.apps.split_bill.index');
    })->name('splitify');
    Route::get('/cek-khodam', function () {
        return view('landingpage.pages.apps.cek_khodam.index');
    })->name('cek_khodam');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [LandingPageBlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [LandingPageBlogController::class, 'show'])->name('show');
});


require __DIR__.'/auth.php';
