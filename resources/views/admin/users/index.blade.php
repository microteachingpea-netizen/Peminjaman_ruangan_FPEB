@extends('layouts.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0 font-weight-bold text-gray-950"><i class="fas fa-users mr-2"></i> Data User</h1>
    <button type="button" class="btn font-weight-bold px-4 py-2 shadow-sm" data-toggle="modal" data-target="#addUserModal" style="background:#FF8C00; color:white; font-size: 1.05rem;">
        <i class="fas fa-plus mr-1"></i> Tambah Prodi/Admin
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="font-size: 1.05rem;">
                <thead class="bg-light text-dark font-weight-bold">
                    <tr>
                        <th class="py-3">Kode</th>
                        <th class="py-3">Nama & Prodi</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Role</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="align-middle font-weight-bold">#{{ $user->id }}</td>
                        <td class="align-middle">
                            <strong class="text-dark" style="font-size: 1.1rem;">{{ $user->name }}</strong><br>
                            <span class="text-muted" style="font-size: 0.95rem;">{{ $user->prodi ?? '-' }}</span>
                        </td>
                        <td class="align-middle text-secondary" style="font-size: 1rem;">{{ $user->email }}</td>
                        <td class="align-middle">
    @foreach($user->roles as $role)
        @php
            // Menentukan warna badge yang berbeda berdasarkan nama role
            $badgeColor = 'secondary';
            $roleName = strtolower($role->nama);
            
            if (str_contains($roleName, 'super admin')) {
                $badgeColor = 'danger'; // Merah untuk Super Admin
            } elseif (str_contains($roleName, 'admin')) {
                $badgeColor = 'warning text-dark'; // Kuning/Oranye untuk Admin
            } elseif (str_contains($roleName, 'prodi') || str_contains($roleName, 'dosen')) {
                $badgeColor = 'success'; // Hijau untuk Prodi/Dosen
            } else {
                $badgeColor = 'primary'; // Biru untuk role lainnya
            }
        @endphp
        
        <span class="badge badge-{{ $badgeColor }} p-2 font-weight-bold mr-1 shadow-sm" style="font-size: 0.9rem;">
            {{ $role->nama }}
        </span>
    @endforeach

    @if($user->roles->isEmpty())
        <span class="badge badge-light text-muted border p-2 font-weight-bold" style="font-size: 0.9rem;">No Role</span>
    @endif
</td>
                        <td class="align-middle">
                            <span class="badge badge-success p-2 font-weight-bold" style="font-size: 0.9rem;">Verify</span>
                        </td>
                        <td class="align-middle">
    <button class="btn btn-info text-white font-weight-bold px-3 py-2 mr-1 shadow-sm" style="font-size: 0.95rem;" data-toggle="modal" data-target="#roleModal{{ $user->id }}">Atur Role</button>
    
    @if($user->id !== auth()->id())
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger font-weight-bold px-3 py-2 shadow-sm" style="font-size: 0.95rem;">Hapus</button>
    </form>
    @endif
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Atur Role (Diletakkan di luar tabel agar rapi) -->
@foreach($users as $user)
<div class="modal fade" id="roleModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.users.update-roles', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold">Atur Role Untuk {{ $user->name }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label class="font-weight-bold mb-2">Pilih Role:</label>
                    <div class="row">
                        @foreach($allRoles as $role)
<div class="col-md-6 mb-2">
    <div class="custom-control custom-checkbox">
        <!-- Ganti $role->name menjadi $role->nama -->
        <input type="checkbox" name="roles[]" value="{{ $role->nama }}" 
               class="custom-control-input" id="role_{{ $user->id }}_{{ $role->id }}"
               {{ $user->hasRole($role->nama) ? 'checked' : '' }}>
        <label class="custom-control-label font-weight-bold" for="role_{{ $user->id }}_{{ $role->id }}">
            {{ $role->nama }}
        </label>
    </div>
</div>
@endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background:#FF8C00;">
                    <h5 class="modal-title font-weight-bold">Tambah Prodi/Admin</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="font-size: 1.05rem;">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" style="font-size: 1.05rem; padding: 12px;" required placeholder="Masukkan nama lengkap...">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Email</label>
                        <input type="email" name="email" class="form-control" style="font-size: 1.05rem; padding: 12px;" required placeholder="nama@email.com">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Password</label>
                        <input type="password" name="password" class="form-control" style="font-size: 1.05rem; padding: 12px;" required minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Prodi</label>
                        <input type="text" name="prodi" class="form-control" style="font-size: 1.05rem; padding: 12px;" placeholder="Nama Program Studi...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn px-4 py-2 font-weight-bold text-white" style="background:#FF8C00; border-color:#FF8C00;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection