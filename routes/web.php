<?php

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
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
});
