<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Schedules;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $start = Carbon::now()->startOfMonth();
        // $end=Carbon::now()->lastOfMonth();
       
        // $period = CarbonPeriod::between($start, $end)->filter('isWeekday');
        // foreach ($period as $date) {
        //     $day=$date->format('Y-m-d');
        //     Schedules::create(['date'=>$day,'start_in'=>'09:00:00','end_out'=>'17:00:00']);
        // }

        $permissions = [

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

    }
}
