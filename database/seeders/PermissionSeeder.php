<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['id' => Str::ulid(), 'label' => 'View Dashboard', 'name' => 'view-dashboard'],

            ['id' => Str::ulid(), 'label' => 'Create User', 'name' => 'create-user'],
            ['id' => Str::ulid(), 'label' => 'Update User', 'name' => 'update-user'],
            ['id' => Str::ulid(), 'label' => 'View User', 'name' => 'view-user'],
            ['id' => Str::ulid(), 'label' => 'Delete User', 'name' => 'delete-user'],

            ['id' => Str::ulid(), 'label' => 'Create Role', 'name' => 'create-role'],
            ['id' => Str::ulid(), 'label' => 'Update Role', 'name' => 'update-role'],
            ['id' => Str::ulid(), 'label' => 'View Role', 'name' => 'view-role'],
            ['id' => Str::ulid(), 'label' => 'Delete Role', 'name' => 'delete-role'],

            
            ['id' => Str::ulid(), 'label' => 'Tambah Divisi ', 'name' => 'create-division'],
            ['id' => Str::ulid(), 'label' => 'Ubah Divisi', 'name' => 'update-division'],
            ['id' => Str::ulid(), 'label' => 'Lihat Divisi', 'name' => 'view-division'],
            ['id' => Str::ulid(), 'label' => 'Hapus Divisi', 'name' => 'delete-division'],

            ['id' => Str::ulid(), 'label' => 'Tambah Jabatan ', 'name' => 'create-position'],
            ['id' => Str::ulid(), 'label' => 'Ubah Jabatan', 'name' => 'update-position'],
            ['id' => Str::ulid(), 'label' => 'Lihat Jabatan', 'name' => 'view-position'],
            ['id' => Str::ulid(), 'label' => 'Hapus Jabatan', 'name' => 'delete-position'],

            ['id' => Str::ulid(), 'label' => 'Tambah Jadwal ', 'name' => 'create-schedule'],
            ['id' => Str::ulid(), 'label' => 'Ubah Jadwal', 'name' => 'update-schedule'],
            ['id' => Str::ulid(), 'label' => 'Lihat Jadwal', 'name' => 'view-schedule'],
            ['id' => Str::ulid(), 'label' => 'Hapus Jadwal', 'name' => 'delete-schedule'],

            ['id' => Str::ulid(), 'label' => 'Ubah Setting', 'name' => 'update-setting'],
            ['id' => Str::ulid(), 'label' => 'Lihat Setting', 'name' => 'view-setting'],

            ['id' => Str::ulid(), 'label' => 'Tambah Pegawai ', 'name' => 'create-employee'],
            ['id' => Str::ulid(), 'label' => 'Ubah Pegawai', 'name' => 'update-employee'],
            ['id' => Str::ulid(), 'label' => 'Lihat Pegawai', 'name' => 'view-employee'],
            ['id' => Str::ulid(), 'label' => 'Hapus Pegawai', 'name' => 'delete-employee'],

            
            ['id' => Str::ulid(), 'label' => 'Tambah Absensi ', 'name' => 'create-attendance'],
            ['id' => Str::ulid(), 'label' => 'Ubah Absensi', 'name' => 'update-attendance'],
            ['id' => Str::ulid(), 'label' => 'Lihat Absensi', 'name' => 'view-attendance'],
            ['id' => Str::ulid(), 'label' => 'Hapus Absensi', 'name' => 'delete-attendance'],
        ];

        foreach ($permissions as $permission) {
            Permission::insert($permission);
        }

        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role->rolePermissions()->create(['permission_id' => $permission->id]);
        }

        User::create([
            'name' => 'Super Administrator',
            'email' => 'root@admin.com',
            'password' => bcrypt('password'),
        ]);

        $admin = User::create([
            'name' => 'Administator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $setting = [];

        Setting::insert($setting);
    }
}
