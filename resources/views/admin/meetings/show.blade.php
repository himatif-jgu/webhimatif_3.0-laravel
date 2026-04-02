@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <h3>{{ $meeting->title }}</h3>
                <p class="text-muted">{{ $meeting->meeting_date->format('l, d F Y H:i') }} | {{ $meeting->location }}</p>
                <hr>
                <p>{{ $meeting->description }}</p>
                
                <div class="row text-center mt-4">
                    <div class="col-4">
                        <h2 class="text-success">{{ $stats['hadir'] }}</h2>
                        <span>Hadir</span>
                    </div>
                    <div class="col-4">
                        <h2 class="text-warning">{{ $stats['izin'] }}</h2>
                        <span>Izin</span>
                    </div>
                    <div class="col-4">
                        <h2 class="text-danger">{{ $stats['absen'] }}</h2>
                        <span>Absen</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-header">QR Code Presensi</div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-center">
                    <div id="qrcode"></div>
                </div>
                <p>Scan untuk presensi mandiri</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{ $checkinUrl }}" readonly id="urlInput">
                    <button class="btn btn-outline-secondary" type="button" onclick="copyUrl()">Copy</button>
                </div>
                @if($meeting->is_active)
                    <span class="badge bg-success">Presensi Dibuka</span>
                @else
                    <span class="badge bg-danger">Presensi Ditutup</span>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
// Generate QR Code
new QRCode(document.getElementById("qrcode"), {
    text: "{{ $checkinUrl }}",
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});

function copyUrl() {
  var copyText = document.getElementById("urlInput");
  copyText.select();
  document.execCommand("copy");
  alert("URL disalin: " + copyText.value);
}
</script>
@endsection
