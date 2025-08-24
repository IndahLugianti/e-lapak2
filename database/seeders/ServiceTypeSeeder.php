<?php
// database/seeders/ServiceTypeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceType;

class ServiceTypeSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama dengan cara yang aman
        ServiceType::query()->delete();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $serviceTypes = [
            [
                'name' => 'Perbaikan Hardware',
                'description' => 'Perbaikan perangkat keras komputer, printer, dan peralatan IT lainnya',
                'requires_file' => false,
                'file_requirements' => null,
                'is_active' => true,
                'estimated_days' => 2,
            ],
            [
                'name' => 'Instalasi Software',
                'description' => 'Instalasi aplikasi, sistem operasi, dan software pendukung kerja',
                'requires_file' => false,
                'file_requirements' => null,
                'is_active' => true,
                'estimated_days' => 1,
            ],
            [
                'name' => 'Pembuatan Email Baru',
                'description' => 'Pembuatan akun email perusahaan untuk karyawan baru atau tambahan',
                'requires_file' => true,
                'file_requirements' => 'Scan KTP, Surat Pengangkatan Kerja, Form Permohonan',
                'is_active' => true,
                'estimated_days' => 1,
            ],
            [
                'name' => 'Reset Password',
                'description' => 'Reset password untuk akun sistem, email, atau aplikasi perusahaan',
                'requires_file' => true,
                'file_requirements' => 'Scan KTP, Surat Keterangan dari Atasan Langsung',
                'is_active' => true,
                'estimated_days' => 1,
            ],
            [
                'name' => 'Akses Jaringan',
                'description' => 'Pemberian akses jaringan, VPN, atau sistem khusus perusahaan',
                'requires_file' => true,
                'file_requirements' => 'Surat Permohonan dari Atasan, Form Persetujuan Akses',
                'is_active' => true,
                'estimated_days' => 3,
            ],
            [
                'name' => 'Backup & Restore Data',
                'description' => 'Permintaan backup atau restore data penting dan file kerja',
                'requires_file' => false,
                'file_requirements' => null,
                'is_active' => true,
                'estimated_days' => 2,
            ],
            [
                'name' => 'Maintenance Rutin',
                'description' => 'Perawatan rutin perangkat komputer dan sistem IT',
                'requires_file' => false,
                'file_requirements' => null,
                'is_active' => true,
                'estimated_days' => 1,
            ],
            [
                'name' => 'Pengadaan Perangkat',
                'description' => 'Permintaan pengadaan perangkat IT baru (laptop, PC, printer, dll)',
                'requires_file' => true,
                'file_requirements' => 'Surat Permohonan, Spesifikasi Perangkat, Persetujuan Budget',
                'is_active' => true,
                'estimated_days' => 7,
            ],
            [
                'name' => 'Troubleshooting Jaringan',
                'description' => 'Penyelesaian masalah koneksi internet dan jaringan internal',
                'requires_file' => false,
                'file_requirements' => null,
                'is_active' => true,
                'estimated_days' => 1,
            ],
            [
                'name' => 'Training Software',
                'description' => 'Pelatihan penggunaan software atau sistem baru',
                'requires_file' => false,
                'file_requirements' => null,
                'is_active' => true,
                'estimated_days' => 3,
            ],
        ];

        foreach ($serviceTypes as $type) {
            ServiceType::create($type);
        }
    }
}
