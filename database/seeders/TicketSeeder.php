<?php
// database/seeders/TicketSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\User;
use App\Models\ServiceType;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama dengan cara yang aman
        Ticket::query()->delete();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pegawaiUsers = User::where('role', 'pegawai')->get();
        $serviceTypes = ServiceType::all();

        if ($pegawaiUsers->isEmpty() || $serviceTypes->isEmpty()) {
            $this->command->info('Tidak ada data user pegawai atau service types. Jalankan UserSeeder dan ServiceTypeSeeder terlebih dahulu.');
            return;
        }

        $ticketData = [
            [
                'title' => 'Printer Canon di ruang Finance tidak bisa print',
                'description' => 'Printer Canon iP2770 di ruang Finance sudah 2 hari tidak bisa digunakan untuk print. Lampu power menyala tapi tidak ada respon saat print dari komputer. Sudah coba restart printer dan komputer tapi masih sama. Mohon segera diperbaiki karena mengganggu pekerjaan harian.',
                'status' => 'pengajuan',
                'service_type' => 'Perbaikan Hardware',
                'created_days_ago' => 0,
            ],
            [
                'title' => 'Instalasi Microsoft Office di laptop baru',
                'description' => 'Saya baru mendapat laptop baru dari perusahaan tapi belum terinstal Microsoft Office. Mohon dibantu untuk instalasi Office 2021 karena diperlukan untuk pekerjaan sehari-hari seperti membuat laporan dan presentasi.',
                'status' => 'proses',
                'service_type' => 'Instalasi Software',
                'created_days_ago' => 1,
                'processed_days_ago' => 0,
            ],
            [
                'title' => 'Pembuatan email untuk karyawan baru Marketing',
                'description' => 'Mohon dibuatkan email perusahaan untuk karyawan baru di divisi Marketing atas nama Sari Dewi. Email diperlukan untuk komunikasi dengan client dan internal perusahaan. Dokumen pendukung sudah saya lampirkan.',
                'status' => 'selesai',
                'service_type' => 'Pembuatan Email Baru',
                'created_days_ago' => 3,
                'processed_days_ago' => 2,
                'completed_days_ago' => 1,
            ],
            [
                'title' => 'Reset password email perusahaan',
                'description' => 'Saya lupa password email perusahaan dan sudah tidak bisa login sejak kemarin. Email sangat diperlukan untuk komunikasi kerja. Mohon dibantu untuk reset password. KTP dan surat keterangan dari atasan sudah saya siapkan.',
                'status' => 'proses',
                'service_type' => 'Reset Password',
                'created_days_ago' => 1,
                'processed_days_ago' => 0,
            ],
            [
                'title' => 'Komputer sering hang dan lambat',
                'description' => 'Komputer di meja kerja saya sering hang dan sangat lambat saat membuka aplikasi. Terutama saat membuka Excel dengan data banyak. Sudah coba restart berkali-kali tapi masih sama. Mohon dicek apakah perlu upgrade RAM atau ada masalah lain.',
                'status' => 'pengajuan',
                'service_type' => 'Perbaikan Hardware',
                'created_days_ago' => 0,
            ],
            [
                'title' => 'Akses VPN untuk work from home',
                'description' => 'Mohon dibuatkan akses VPN untuk keperluan work from home. Saya perlu mengakses server perusahaan dari rumah untuk menyelesaikan project yang deadline-nya minggu depan. Surat permohonan dari atasan sudah ada.',
                'status' => 'proses',
                'service_type' => 'Akses Jaringan',
                'created_days_ago' => 2,
                'processed_days_ago' => 1,
            ],
            [
                'title' => 'Backup data penting sebelum format ulang',
                'description' => 'Komputer saya perlu diformat ulang karena sering error. Mohon dibantu backup data penting seperti file Excel laporan bulanan, dokumen kontrak, dan foto-foto kegiatan perusahaan. Data tersebut sangat penting dan tidak boleh hilang.',
                'status' => 'selesai',
                'service_type' => 'Backup & Restore Data',
                'created_days_ago' => 5,
                'processed_days_ago' => 4,
                'completed_days_ago' => 3,
            ],
            [
                'title' => 'Internet di ruang HR sangat lambat',
                'description' => 'Koneksi internet di ruang HR sangat lambat sejak 3 hari yang lalu. Loading website membutuhkan waktu sangat lama, download file kecil saja lama sekali. Ini mengganggu pekerjaan terutama saat upload dokumen ke sistem online.',
                'status' => 'pengajuan',
                'service_type' => 'Troubleshooting Jaringan',
                'created_days_ago' => 0,
            ],
            [
                'title' => 'Pengadaan laptop untuk divisi Marketing',
                'description' => 'Divisi Marketing membutuhkan 2 unit laptop baru untuk mendukung kegiatan presentasi ke client. Spesifikasi minimal Core i5, RAM 8GB, SSD 256GB. Budget sudah disetujui oleh direktur. Mohon diproses pengadaannya.',
                'status' => 'proses',
                'service_type' => 'Pengadaan Perangkat',
                'created_days_ago' => 7,
                'processed_days_ago' => 5,
            ],
                        [
                'title' => 'Training penggunaan sistem ERP baru',
                'description' => 'Mohon dijadwalkan training untuk penggunaan sistem ERP yang baru diimplementasi. Tim Finance perlu memahami cara input data, generate report, dan fitur-fitur lainnya. Sebaiknya training dilakukan minggu depan.',
                'status' => 'selesai',
                'service_type' => 'Training Software',
                'created_days_ago' => 10,
                'processed_days_ago' => 8,
                'completed_days_ago' => 5,
            ],
            [
                'title' => 'Instalasi antivirus di semua komputer',
                'description' => 'Beberapa komputer di kantor belum terinstal antivirus atau antivirusnya sudah expired. Mohon dibantu instalasi antivirus yang berlisensi untuk melindungi data perusahaan dari virus dan malware.',
                'status' => 'pengajuan',
                'service_type' => 'Instalasi Software',
                'created_days_ago' => 1,
            ],
            [
                'title' => 'Perbaikan proyektor ruang meeting',
                'description' => 'Proyektor di ruang meeting utama sudah tidak bisa menampilkan gambar dengan jelas. Ada bintik-bintik hitam dan warna merah yang dominan. Proyektor ini sering digunakan untuk presentasi dengan client jadi mohon segera diperbaiki atau diganti.',
                'status' => 'proses',
                'service_type' => 'Perbaikan Hardware',
                'created_days_ago' => 2,
                'processed_days_ago' => 1,
            ],
            [
                'title' => 'Pembuatan akun sistem inventory',
                'description' => 'Saya butuh akses ke sistem inventory untuk melakukan stock opname bulanan. Mohon dibuatkan akun dengan level user biasa untuk departemen Operations. Surat permohonan dari kepala divisi sudah saya lampirkan.',
                'status' => 'selesai',
                'service_type' => 'Akses Jaringan',
                'created_days_ago' => 4,
                'processed_days_ago' => 3,
                'completed_days_ago' => 2,
            ],
            [
                'title' => 'Maintenance rutin komputer accounting',
                'description' => 'Komputer yang digunakan untuk aplikasi accounting perlu maintenance rutin. Sudah 6 bulan tidak pernah dibersihkan dan performanya mulai menurun. Mohon dijadwalkan maintenance untuk cleaning dan optimasi sistem.',
                'status' => 'pengajuan',
                'service_type' => 'Maintenance Rutin',
                'created_days_ago' => 0,
            ],
            [
                'title' => 'Setup email di smartphone untuk mobile access',
                'description' => 'Mohon dibantu setup email perusahaan di smartphone saya agar bisa akses email saat di luar kantor. Perlu setting yang aman dan sesuai dengan kebijakan IT perusahaan.',
                'status' => 'proses',
                'service_type' => 'Instalasi Software',
                'created_days_ago' => 1,
                'processed_days_ago' => 0,
            ],
        ];

        foreach ($ticketData as $index => $data) {
            // Pilih user pegawai secara acak
            $creator = $pegawaiUsers->random();

            // Cari service type berdasarkan nama
            $serviceType = $serviceTypes->where('name', $data['service_type'])->first();
            if (!$serviceType) {
                $serviceType = $serviceTypes->first(); // fallback
            }

            // Generate ticket number
            $ticketNumber = 'TKT-' . now()->subDays($data['created_days_ago'])->format('Ymd') . '-' . strtoupper(Str::random(4));

            // Set timestamps
            $createdAt = now()->subDays($data['created_days_ago']);
            $processedAt = isset($data['processed_days_ago']) ? now()->subDays($data['processed_days_ago']) : null;
            $completedAt = isset($data['completed_days_ago']) ? now()->subDays($data['completed_days_ago']) : null;

            // Admin notes berdasarkan status
            $adminNotes = $this->getAdminNotes($data['status']);

            // Create ticket
            Ticket::create([
                'ticket_number' => $ticketNumber,
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'service_type_id' => $serviceType->id,
                'created_by' => $creator->id,
                'admin_notes' => $adminNotes,
                'processed_at' => $processedAt,
                'completed_at' => $completedAt,
                'created_at' => $createdAt,
                'updated_at' => $completedAt ?? $processedAt ?? $createdAt,
            ]);
        }
    }

    private function getAdminNotes($status)
    {
        $notes = [
            'pengajuan' => null,
            'proses' => [
                'Tiket sedang dalam proses penanganan oleh tim IT.',
                'Sudah dikonfirmasi dan sedang dijadwalkan untuk penyelesaian.',
                'Tim teknis sudah mulai menangani masalah ini.',
                'Sedang dalam tahap troubleshooting dan analisa masalah.',
                'Permintaan sudah diterima dan sedang diproses sesuai prosedur.',
            ],
            'selesai' => [
                'Tiket telah diselesaikan dengan baik. Mohon dicek kembali.',
                'Masalah sudah teratasi. Silakan dicoba dan konfirmasi jika ada kendala.',
                'Penanganan selesai. Sistem sudah kembali normal.',
                'Completed successfully. Please test and confirm if everything works.',
                'Tiket closed. Solusi sudah diimplementasikan dengan sukses.',
                'Hardware sudah diperbaiki dan berfungsi normal kembali.',
                'Software berhasil diinstal dan siap digunakan.',
                'Akses sudah diberikan sesuai permintaan.',
            ]
        ];

        if ($status === 'pengajuan') {
            return null;
        }

        return $notes[$status][array_rand($notes[$status])];
    }
}
