{{-- Gunakan layout landing page atau simple layout --}}
@extends('landingpage.layout.master') 

@section('content')
<div class="container pt_120 pb_120">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body text-center p-5">
                    <h3 class="mb-3">Konfirmasi Kehadiran</h3>
                    <h5 class="text-primary">{{ $meeting->title }}</h5>
                    <p class="text-muted mb-4">{{ $meeting->meeting_date->format('d M Y, H:i') }}</p>

                    <div class="alert alert-info">
                        Anda login sebagai: <strong>{{ auth()->user()->name }}</strong>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                        <div class="mt-4">
                            <h1>✅</h1>
                            <p>Data kehadiran Anda telah tercatat.</p>
                        </div>
                    @else
                        @if($attendance)
                            <div class="alert alert-warning">
                                Anda sudah tercatat <strong>{{ strtoupper($attendance->status) }}</strong> pada {{ $attendance->updated_at->diffForHumans() }}.
                            </div>
                        @else
                            <form action="{{ route('attendance.checkin.store', $meeting->qr_code_token) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-lg btn-success w-100">
                                    SAYA HADIR SEKARANG
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
