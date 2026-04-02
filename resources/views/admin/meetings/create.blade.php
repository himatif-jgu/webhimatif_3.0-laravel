@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">Buat Agenda Baru</div>
    <div class="card-body">
        <form action="{{ route('admin.meetings.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Judul Kegiatan</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tipe</label>
                    <select name="type" class="form-select">
                        <option value="Rapat Rutin">Rapat Rutin</option>
                        <option value="Rapat Besar">Rapat Besar</option>
                        <option value="Kegiatan">Kegiatan / Event</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Waktu</label>
                    <input type="datetime-local" name="meeting_date" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="location" class="form-control">
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" id="activeCheck" checked>
                <label class="form-check-label" for="activeCheck">Buka Presensi Sekarang?</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
