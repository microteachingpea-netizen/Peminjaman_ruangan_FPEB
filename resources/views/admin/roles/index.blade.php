@extends('layouts.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0 font-weight-bold text-gray-950"><i class="fas fa-user-tag mr-2"></i> Data Role</h1>
    <button type="button" class="btn font-weight-bold px-4 py-2 shadow-sm" data-toggle="modal" data-target="#addRoleModal" style="background:#FF8C00;color:white;font-size: 1.05rem;">
        <i class="fas fa-plus mr-1"></i> Tambah Role
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="font-size: 1.05rem;">
                <thead class="bg-light text-dark font-weight-bold">
                    <tr>
                        <th class="py-3">Kode</th>
                        <th class="py-3">Nama Role</th>
                        <th class="py-3">Tanggal Dibuat</th>
                        <th class="py-3">Status Permission</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td class="align-middle font-weight-bold">#{{ $role->id }}</td>
                        <td class="align-middle"><strong class="text-dark" style="font-size: 1.1rem;">{{ $role->nama }}</strong></td>
                        <td class="align-middle text-secondary" style="font-size: 0.95rem;">{{ $role->created_at->format('d M Y') }}</td>
                        <td class="align-middle">
                            @php $total = $permissions->count(); $assigned = $role->permissions_count; @endphp
                            <div class="progress shadow-sm" style="height:24px; font-size: 0.9rem; font-weight: bold;">
                                <div class="progress-bar bg-success" style="width:{{ $total ? ($assigned/$total*100) : 0 }}%">
                                    {{ $assigned }}/{{ $total }}
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-primary font-weight-bold px-3 py-2 mr-1 shadow-sm" style="font-size: 0.95rem;" data-toggle="modal" data-target="#permModal{{ $role->id }}">Kelola Permission</button>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus role?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger font-weight-bold px-3 py-2 shadow-sm" style="font-size: 0.95rem;">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="permModal{{ $role->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('admin.roles.permissions', $role) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title font-weight-bold">Kelola Permission Untuk Role {{ $role->nama }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                        @php $rolePermIds = $role->permissions->pluck('id')->all(); @endphp
                                        @foreach($permissions as $perm)
                                        <div class="custom-control custom-checkbox mb-3" style="font-size: 1.05rem;">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="custom-control-input"
                                                   id="perm_{{ $role->id }}_{{ $perm->id }}"
                                                   {{ in_array($perm->id, $rolePermIds) ? 'checked' : '' }}>
                                            <label class="custom-control-label text-dark font-weight-medium" for="perm_{{ $role->id }}_{{ $perm->id }}">{{ $perm->nama }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background:#FF8C00;">
                    <h5 class="modal-title font-weight-bold">Tambah Role Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label class="font-weight-bold text-dark">Nama Role:</label>
                    <input type="text" name="nama" class="form-control" style="font-size: 1.05rem; padding: 10px;" placeholder="Nama Role Baru" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="background:#FF8C00; border-color:#FF8C00;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection