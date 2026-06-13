<x-filament-panels::page.simple :heading="null" :subheading="null">
    <style>
        .fi-simple-page {
            width: 100%;
        }

        .fi-simple-page-content {
            width: 100%;
        }

        .himatif-login-page {
            min-height: calc(100vh - 3rem);
            display: grid;
            grid-template-columns: minmax(340px, 0.9fr) minmax(0, 1.1fr);
            max-width: 1180px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 24px 80px rgba(15, 23, 42, 0.1);
            color: #111827;
        }

        .himatif-login-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: clamp(2rem, 5vw, 4.5rem);
            background: #fff;
        }

        .himatif-login-hero {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 700px;
            padding: clamp(2rem, 5vw, 4.2rem);
            background:
                radial-gradient(circle at 78% 24%, rgba(245, 158, 11, 0.42), transparent 28rem),
                linear-gradient(145deg, #0f172a 0%, #17324f 48%, #92400e 100%);
            color: #fff;
        }

        .himatif-login-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url("{{ asset('assets/landing/images/logo-himatif.png') }}") right 3rem top 3rem / 170px no-repeat;
            opacity: 0.12;
            pointer-events: none;
        }

        .himatif-login-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 4rem;
        }

        .himatif-login-logo {
            width: 42px;
            height: 42px;
            object-fit: contain;
            border-radius: 12px;
            background: #fffbeb;
            padding: 0.35rem;
        }

        .himatif-login-brand strong {
            display: block;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 850;
        }

        .himatif-login-brand span {
            display: block;
            margin-top: 0.1rem;
            color: #64748b;
            font-size: 0.84rem;
        }

        .himatif-login-card h2 {
            margin: 0;
            color: #0f172a;
            font-size: clamp(1.8rem, 4vw, 2.35rem);
            font-weight: 850;
            letter-spacing: 0;
        }

        .himatif-login-subheading {
            max-width: 28rem;
            margin: 0.75rem 0 2rem;
            color: #64748b;
            line-height: 1.7;
        }

        .himatif-login-form :is(.fi-input-wrp, .fi-select-input) {
            border-radius: 12px;
        }

        .himatif-login-form :is(label, .fi-fo-field-wrp-label, .fi-fo-field-wrp-label span) {
            color: #0f172a;
        }

        .himatif-login-form :is(.fi-input, input, textarea, select) {
            color: #0f172a;
            caret-color: #f59e0b;
        }

        .himatif-login-form :is(.fi-input::placeholder, input::placeholder, textarea::placeholder) {
            color: #94a3b8;
            opacity: 1;
        }

        .himatif-login-form :is(.fi-checkbox-input, input[type="checkbox"]) {
            border-color: #cbd5e1;
            background-color: #fff;
        }

        .himatif-login-form :is(.fi-fo-field-wrp-helper-text, .fi-fo-field-wrp-hint, .fi-link) {
            color: #475569;
        }

        .himatif-login-form .fi-btn {
            border-radius: 12px;
        }

        .himatif-login-form .fi-ac-btn-action {
            background: #0f172a;
            color: #fff;
        }

        .himatif-login-hero h1 {
            position: relative;
            z-index: 1;
            max-width: 580px;
            margin: 0 0 1.25rem;
            font-size: clamp(2.3rem, 5vw, 4.5rem);
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: 0;
        }

        .himatif-login-hero p {
            position: relative;
            z-index: 1;
            max-width: 520px;
            color: rgba(255, 255, 255, 0.78);
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .himatif-login-google {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            background: #fff;
            padding: 0.78rem 1rem;
            color: #111827;
            font-weight: 750;
            text-decoration: none;
            transition: border-color 150ms ease, box-shadow 150ms ease, transform 150ms ease;
        }

        .himatif-login-google:hover {
            border-color: #f59e0b;
            box-shadow: 0 12px 28px rgba(245, 158, 11, 0.16);
            transform: translateY(-1px);
        }

        .himatif-login-google svg {
            width: 20px;
            height: 20px;
            flex: none;
        }

        .himatif-login-divider {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 0.75rem;
            align-items: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.82rem;
            font-weight: 650;
        }

        .himatif-login-divider::before,
        .himatif-login-divider::after {
            content: "";
            height: 1px;
            background: #e5e7eb;
        }

        .himatif-login-alert {
            margin-bottom: 1rem;
            border-radius: 12px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            padding: 0.85rem 1rem;
            color: #991b1b;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .himatif-login-help {
            margin-top: 1.25rem;
            color: #6b7280;
            font-size: 0.86rem;
            line-height: 1.55;
            text-align: center;
        }

        .himatif-login-quote {
            position: relative;
            z-index: 1;
            max-width: 580px;
            margin-top: 3rem;
            padding-left: 1.25rem;
            border-left: 4px solid #f59e0b;
            color: rgba(255, 255, 255, 0.82);
            font-size: 1rem;
            line-height: 1.8;
        }

        .himatif-login-footnote {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.18);
            padding-top: 1.25rem;
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.85rem;
            font-weight: 650;
        }

        .himatif-login-badge {
            border-radius: 999px;
            background: rgba(245, 158, 11, 0.18);
            padding: 0.45rem 0.85rem;
            color: #fde68a;
        }

        @media (max-width: 1024px) {
            .himatif-login-page {
                grid-template-columns: 1fr;
                max-width: 720px;
            }

            .himatif-login-hero {
                min-height: 360px;
                order: 2;
            }
        }

        @media (max-width: 640px) {
            .himatif-login-page {
                min-height: auto;
                border-radius: 18px;
            }

            .himatif-login-hero {
                min-height: 300px;
                padding: 1.5rem;
            }

            .himatif-login-hero h1 {
                font-size: 2rem;
            }

            .himatif-login-card {
                padding: 1.4rem;
            }

            .himatif-login-brand {
                margin-bottom: 2.4rem;
            }

            .himatif-login-footnote {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="himatif-login-page">
        <section class="himatif-login-card" aria-label="Form login">
            @if (session('google_login_error'))
                <div class="himatif-login-alert">
                    {{ session('google_login_error') }}
                </div>
            @endif

            <div class="himatif-login-brand">
                <img
                    class="himatif-login-logo"
                    src="{{ asset('assets/landing/images/logo-himatif.png') }}"
                    alt="Logo HIMATIF"
                >

                <div>
                    <strong>HIMATIF App</strong>
                    <span>Portal internal organisasi</span>
                </div>
            </div>

            <h2>{{ $this->getHeading() }}</h2>

            @if ($subheading = $this->getSubheading())
                <p class="himatif-login-subheading">{{ $subheading }}</p>
            @endif

            <div class="himatif-login-form">
                {{ $this->content }}
            </div>

            @if (blank($this->userUndertakingMultiFactorAuthentication))
                <div class="himatif-login-divider">atau</div>

                <a class="himatif-login-google" href="{{ route('auth.google.redirect') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Masuk dengan Google
                </a>
            @endif

            <p class="himatif-login-help">
                Gunakan email yang sudah terdaftar oleh admin. Jika akses ditolak, cek status akun dan role user.
            </p>
        </section>

        <section class="himatif-login-hero" aria-label="HIMATIF App overview">
            <div>
                <h1>Kelola HIMATIF dalam satu portal.</h1>

                <p>
                    Portal internal Himpunan Mahasiswa Teknik Informatika Jakarta Global University.
                </p>

                <div class="himatif-login-quote">
                    Akses terpusat untuk pengurus, dosen, dan anggota yang sudah terdaftar.
                </div>
            </div>

            <div class="himatif-login-footnote">
                <span>HIMATIF JGU</span>
                <span class="himatif-login-badge">Secure member access</span>
            </div>
        </section>
    </div>
</x-filament-panels::page.simple>
