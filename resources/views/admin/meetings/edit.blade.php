@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">Edit Agenda</div>
    <div class="card-body">
        <form action="{{ route('admin.meetings.update', $meeting->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Judul Kegiatan</label>
                <input type="text" name="title" class="form-control" value="{{ $meeting->title }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tipe</label>
                    <select name="type" class="form-select">
                        <option value="Rapat Rutin" {{ $meeting->type == 'Rapat Rutin' ? 'selected' : '' }}>Rapat Rutin</option>
                        <option value="Rapat Besar" {{ $meeting->type == 'Rapat Besar' ? 'selected' : '' }}>Rapat Besar</option>
                        <option value="Kegiatan" {{ $meeting->type == 'Kegiatan' ? 'selected' : '' }}>Kegiatan / Event</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Waktu</label>
                    <input type="datetime-local" name="meeting_date" class="form-control" value="{{ $meeting->meeting_date->format('Y-m-d\TH:i') }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="location" class="form-control" value="{{ $meeting->location }}">
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ $meeting->description }}</textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" id="activeCheck" {{ $meeting->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="activeCheck">Buka Presensi?</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
