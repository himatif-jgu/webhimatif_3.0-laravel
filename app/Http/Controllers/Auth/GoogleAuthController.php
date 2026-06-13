<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (blank(config('services.google.client_id')) || blank(config('services.google.client_secret'))) {
            return redirect()
                ->route('filament.app.auth.login')
                ->with('google_login_error', 'Login Google belum dikonfigurasi. Lengkapi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET.');
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable) {
            return redirect()
                ->route('filament.app.auth.login')
                ->with('google_login_error', 'Login Google gagal diproses. Coba lagi atau masuk dengan email.');
        }

        $email = $googleUser->getEmail();

        if (blank($email)) {
            return redirect()
                ->route('filament.app.auth.login')
                ->with('google_login_error', 'Akun Google tidak mengirimkan email yang valid.');
        }

        $user = User::query()
            ->where('email', $email)
            ->first();

        if (! $user) {
            return redirect()
                ->route('filament.app.auth.login')
                ->with('google_login_error', 'Email Google belum terdaftar di HIMATIF App. Hubungi admin untuk dibuatkan akun.');
        }

        $panel = Filament::getPanel('app');

        if (! $user->canAccessPanel($panel)) {
            return redirect()
                ->route('filament.app.auth.login')
                ->with('google_login_error', 'Akun ditemukan, tetapi belum aktif atau belum punya role akses app.');
        }

        $user->forceFill([
            'google_id' => $googleUser->getId(),
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended($panel->getUrl());
    }
}
