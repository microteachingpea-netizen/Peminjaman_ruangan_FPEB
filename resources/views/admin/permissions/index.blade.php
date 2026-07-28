@extends('layouts.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0 font-weight-bold text-gray-950"><i class="fas fa-key mr-2"></i> Permission</h1>
    <button type="button" class="btn px-4 py-2 font-weight-bold shadow-sm" data-toggle="modal" data-target="#addPermModal" style="background:#FF8C00;color:white;font-size: 1rem;">
        <i class="fas fa-plus mr-1"></i> Tambah Permission
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="font-size: 1.05rem;">
                <thead class="bg-light text-dark font-weight-bold">
                    <tr>
                        <th class="py-3">Kode</th>
                        <th class="py-3">Nama Permission</th>
                        <th class="py-3">Tanggal Dibuat</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $perm)
                    <tr>
                        <td class="align-middle font-weight-bold">#{{ $perm->id }}</td>
                        <td class="align-middle"><strong class="text-dark" style="font-size: 1.1rem;">{{ $perm->nama }}</strong></td>
                        <td class="align-middle text-secondary" style="font-size: 0.95rem;">{{ $perm->created_at->format('d M Y') }}</td>
                        <td class="align-middle">
                            <form action="{{ route('admin.permissions.destroy', $perm) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus permission?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger font-weight-bold px-3 py-2" style="font-size: 0.95rem;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-5 font-weight-bold" style="font-size: 1.1rem;">Belum ada permission.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addPermModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background:#FF8C00;color:white;">
                    <h5 class="modal-title font-weight-bold">Tambah Permission</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label class="font-weight-bold text-dark">Nama Permission:</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama permission..." style="font-size: 1rem; padding: 10px;" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn px-4 py-2 font-weight-bold text-white" style="background:#FF8C00;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection