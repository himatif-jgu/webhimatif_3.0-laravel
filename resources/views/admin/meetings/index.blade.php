@extends('admin.layout.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Manajemen Kegiatan & Rapat</h4>
    <a href="{{ route('admin.meetings.create') }}" class="btn btn-primary">
        <i data-lucide="plus"></i> Tambah Agenda
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $m)
                <tr>
                    <td>
                        <strong>{{ $m->title }}</strong><br>
                        <small class="text-muted">{{ $m->location }}</small>
                    </td>
                    <td><span class="badge bg-info">{{ $m->type }}</span></td>
                    <td>{{ $m->meeting_date->format('d M Y H:i') }}</td>
                    <td>
                        @if($m->is_active)
                            <span class="badge bg-success">Buka</span>
                        @else
                            <span class="badge bg-secondary">Tutup</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.meetings.show', $m->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                <i data-lucide="eye"></i>
                            </a>
                            <a href="{{ route('admin.meetings.attendance', $m->id) }}" class="btn btn-sm btn-outline-warning" title="Presensi Manual">
                                <i data-lucide="clipboard-list"></i>
                            </a>
                            <a href="{{ route('admin.meetings.edit', $m->id) }}" class="btn btn-sm btn-outline-primary">
                                <i data-lucide="edit"></i>
                            </a>
                            <!-- Form Delete -->
                            <button class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('admin.meetings.destroy', $m->id) }}" title="Hapus">
                                <i data-lucide="trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $meetings->links() }}
    </div>
</div>

<!-- Form for delete action (hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('plugin-scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('custom-scripts')
    <script>
        $(function() {
            // Handle Delete Button Click with SweetAlert
            $(document).on('click', '.btn-delete', function() {
                var url = $(this).data('url');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('#delete-form');
                        form.attr('action', url);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
@endsection
