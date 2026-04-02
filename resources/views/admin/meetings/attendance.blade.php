@extends('admin.layout.master')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Presensi: {{ $meeting->title }}</h4>
    <a href="{{ route('admin.meetings.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.meetings.attendance.store', $meeting->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        @php 
                            $att = $attendances[$user->id] ?? null; 
                            $status = $att ? $att->status : 'absen';
                        @endphp
                        <tr>
                            <td>
                                {{ $user->name }} <br>
                                <small class="text-muted">{{ $user->student_number }}</small>
                            </td>
                            <td>
                                <select name="attendance[{{ $user->id }}]" class="form-select form-select-sm 
                                    {{ $status == 'hadir' ? 'bg-success text-white' : ($status == 'izin' ? 'bg-warning' : '') }}">
                                    <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="absen" {{ $status == 'absen' ? 'selected' : '' }}>Absen</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="note[{{ $user->id }}]" class="form-control form-control-sm" 
                                    value="{{ $att ? $att->note : '' }}" placeholder="Keterangan...">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 sticky-bottom bg-white p-2 border-top">
                <button type="submit" class="btn btn-primary w-100">Simpan Semua Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
