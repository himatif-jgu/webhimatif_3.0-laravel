<x-guest-layout>
    <div>
        <p class="text-sm font-medium text-amber-600">HIMATIF Attendance</p>
        <h1 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $event->title }}</h1>

        <dl class="mt-6 space-y-3 text-sm text-gray-700 dark:text-gray-300">
            <div>
                <dt class="font-medium text-gray-900 dark:text-gray-100">Jenis kegiatan</dt>
                <dd>{{ ucfirst(str_replace('_', ' ', $event->activity_type)) }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-900 dark:text-gray-100">Waktu</dt>
                <dd>{{ $event->starts_at->format('d M Y H:i') }}</dd>
            </div>
            @if($event->location)
                <div>
                    <dt class="font-medium text-gray-900 dark:text-gray-100">Lokasi</dt>
                    <dd>{{ $event->location }}</dd>
                </div>
            @endif
        </dl>

        @if(session('status'))
            <div class="mt-6 rounded-md bg-amber-50 p-4 text-sm text-amber-800">
                {{ session('status') }}
            </div>
        @endif

        @auth
            <form method="POST" action="{{ route('attendance.check-in.store', $event->qr_token) }}" class="mt-6">
                @csrf
                <button type="submit" class="w-full rounded-md bg-amber-500 px-4 py-3 font-semibold text-white hover:bg-amber-600">
                    Check in sekarang
                </button>
            </form>
        @else
            <a href="{{ route('filament.app.auth.login') }}" class="mt-6 block rounded-md bg-amber-500 px-4 py-3 text-center font-semibold text-white hover:bg-amber-600">
                Login untuk absen
            </a>
        @endauth
    </div>
</x-guest-layout>
