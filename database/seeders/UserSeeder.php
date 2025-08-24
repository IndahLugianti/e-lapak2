<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama dengan cara yang aman
        User::query()->delete();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Admin
        User::create([
            'nip' => '12345678',
            'name' => 'Administrator System',
            'email' => 'admin@company.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department' => 'IT',
            'position' => 'System Administrator',
            'is_active' => true,
        ]);

        // Approval Users
        User::create([
            'nip' => '87654321',
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@company.com',
            'password' => Hash::make('password'),
            'role' => 'approval',
            'department' => 'Management',
            'position' => 'IT Manager',
            'is_active' => true,
        ]);

        User::create([
            'nip' => '13579246',
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@company.com',
            'password' => Hash::make('password'),
            'role' => 'approval',
            'department' => 'Operations',
            'position' => 'Operations Manager',
            'is_active' => true,
        ]);

        // Pegawai Users
        $pegawaiData = [
            ['nip' => '11223344', 'name' => 'Ahmad Wijaya', 'email' => 'ahmad.wijaya@company.com', 'department' => 'Finance', 'position' => 'Finance Staff'],
            ['nip' => '55667788', 'name' => 'Dewi Sartika', 'email' => 'dewi.sartika@company.com', 'department' => 'HR', 'position' => 'HR Staff'],
            ['nip' => '99887766', 'name' => 'Rudi Hermawan', 'email' => 'rudi.hermawan@company.com', 'department' => 'Marketing', 'position' => 'Marketing Executive'],
            ['nip' => '44556677', 'name' => 'Maya Indira', 'email' => 'maya.indira@company.com', 'department' => 'Operations', 'position' => 'Operations Staff'],
            ['nip' => '33445566', 'name' => 'Andi Pratama', 'email' => 'andi.pratama@company.com', 'department' => 'IT', 'position' => 'IT Support'],
            ['nip' => '77889900', 'name' => 'Lisa Permata', 'email' => 'lisa.permata@company.com', 'department' => 'Finance', 'position' => 'Accounting Staff'],
            ['nip' => '66778899', 'name' => 'Joko Susilo', 'email' => 'joko.susilo@company.com', 'department' => 'General Affairs', 'position' => 'GA Staff'],
        ];

        foreach ($pegawaiData as $pegawai) {
            User::create([
                'nip' => $pegawai['nip'],
                'name' => $pegawai['name'],
                'email' => $pegawai['email'],
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'department' => $pegawai['department'],
                'position' => $pegawai['position'],
                'is_active' => true,
            ]);
        }
    }
}
