<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'dashboard', 'approval', 'crud_ruangan', 'crud_user',
            'crud_role', 'crud_permission', 'booking', 'lihat_ruangan',
        ];

        foreach ($permissions as $nama) {
            Permission::firstOrCreate(['nama' => $nama]);
        }

        $admin = Role::firstOrCreate(['nama' => 'admin']);
        $prodi = Role::firstOrCreate(['nama' => 'prodi']);

        $admin->permissions()->sync(Permission::pluck('id'));
        $prodi->permissions()->sync(
            Permission::whereIn('nama', ['booking', 'lihat_ruangan'])->pluck('id')
        );
    }
}
