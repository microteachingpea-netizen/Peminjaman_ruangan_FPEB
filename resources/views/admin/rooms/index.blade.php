@extends('layouts.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0 font-weight-bold text-gray-950"><i class="fas fa-door-open mr-2"></i> Data Ruangan</h1>
    <button type="button" class="btn btn-lg shadow-sm font-weight-bold px-4 py-2" data-toggle="modal" data-target="#tambahModal" style="background-color: #FF8C00; color: white; font-size: 1.05rem;">
        <i class="fas fa-plus mr-1"></i> Tambah Ruangan
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="font-size: 1.05rem;">
                <thead class="bg-light text-dark font-weight-bold">
                    <tr>
                        <th class="py-3 text-center">No</th>
                        <th class="py-3">Nama Ruangan</th>
                        <th class="py-3 text-center">Kapasitas</th>
                        <th class="py-3">Fasilitas</th>
                        <th class="py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                    <tr>
                        <td class="text-center align-middle font-weight-bold">{{ $loop->iteration }}</td>
                        <td class="align-middle"><strong class="text-dark" style="font-size: 1.1rem;">{{ $room->name }}</strong></td>
                        <td class="text-center align-middle font-weight-bold">{{ $room->capacity }} Orang</td>
                        <td class="align-middle">
                            @foreach($room->facility_names as $f)
                                <span class="badge p-2 mr-1 mb-1 font-weight-bold" style="background:#FF8C00; color:white; font-size: 0.9rem;">{{ $f }}</span>
                            @endforeach
                        </td>
                        <td class="text-center align-middle">
                            <button class="btn btn-warning text-white font-weight-bold px-3 py-2 mr-1 shadow-sm" style="font-size: 0.95rem;" data-toggle="modal" data-target="#editModal{{ $room->id }}">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus ruangan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger font-weight-bold px-3 py-2 shadow-sm" style="font-size: 0.95rem;"><i class="fas fa-trash mr-1"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-5 font-weight-bold" style="font-size: 1.1rem;">Belum ada data ruangan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header bg-light"><h6 class="m-0 font-weight-bold text-dark" style="font-size: 1.1rem;">Kelola Fasilitas</h6></div>
    <div class="card-body">
        <form action="{{ route('admin.facilities.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" style="font-size: 1.05rem; padding: 12px; height: auto;" placeholder="Nama fasilitas baru..." required>
                <div class="input-group-append">
                    <button class="btn font-weight-bold px-4" style="background:#FF8C00; color:white; font-size: 1.05rem;">Tambah Fasilitas</button>
                </div>
            </div>
        </form>
        <div class="d-flex flex-wrap gap-2">
            @foreach($facilities as $f)
            <span class="badge badge-secondary p-2 mr-2 mb-2 font-weight-bold d-inline-flex align-items-center" style="font-size: 1rem;">
                {{ $f->name }}
                <form action="{{ route('admin.facilities.destroy', $f) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-link btn-sm text-white p-0 ml-2 font-weight-bold" style="font-size: 1.1rem;">&times;</button>
                </form>
            </span>
            @endforeach
        </div>
    </div>
</div>

@foreach($rooms as $room)
<div class="modal fade" id="editModal{{ $room->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header text-white" style="background:#FF8C00;">
                    <h5 class="modal-title font-weight-bold">Edit Ruangan: {{ $room->name }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('admin.rooms._form', ['room' => $room, 'facilities' => $facilities])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn font-weight-bold px-4 py-2" style="background:#FF8C00; color:white;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header text-white" style="background:#FF8C00;">
                    <h5 class="modal-title font-weight-bold">Tambah Ruangan Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('admin.rooms._form', ['room' => null, 'facilities' => $facilities])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn font-weight-bold px-4 py-2" style="background:#FF8C00; color:white;">Tambah Ruangan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection