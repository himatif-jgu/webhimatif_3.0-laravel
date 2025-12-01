<?php

use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\LandingPageBlogController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $latestBlogs = \App\Models\Blog::with(['category', 'author'])
        ->published()
        ->latest('published_at')
        ->limit(3)
        ->get();
    
    return view('home', compact('latestBlogs'));
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::prefix('foundation')->group(function () {
    Route::get('/vision', function () {
        return view(view: 'foundation.vision');
    })->name('foundation.vision');

    Route::get('/mission', function () {
        return view('foundation.mission');
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
        return view('apps.spin_wheel.index');
    })->name('spin_wheel');

    Route::get('/split-bill', function () {
        return view('apps.split_bill.index');
    })->name('splitify');
    Route::get('/cek-khodam', function () {
        return view('apps.cek_khodam.index');
    })->name('cek_khodam');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [LandingPageBlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [LandingPageBlogController::class, 'show'])->name('show');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::bind('member', function ($value) {
    try {
        $id = decrypt($value);
    } catch (\Exception $e) {
        abort(404);
    }
    return User::findOrFail($id);
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::patch('members/{member}/toggle-active', [MemberController::class, 'toggleActive'])->name('members.toggle-active');
        Route::resource('members', MemberController::class);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show', 'create']);
        Route::resource('divisions', DivisionController::class)->except(['show']);
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin|bph'])
    ->group(function () {
        Route::resource('blogs', BlogController::class)->except(['show']);
        Route::resource('blog-categories', BlogCategoryController::class)->except(['show']);
    });

require __DIR__.'/auth.php';
