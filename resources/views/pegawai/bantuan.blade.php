@extends('layouts.app')

@section('title', 'Bantuan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">
       <i class="fas fa-question-circle me-2"></i>
       Pusat Bantuan
   </h1>
</div>

<div class="row">
   <!-- FAQ Section -->
   <div class="col-lg-8">
       <div class="card shadow mb-4">
           <div class="card-header">
               <h5 class="mb-0">
                   <i class="fas fa-comments me-2"></i>
                   Pertanyaan yang Sering Diajukan (FAQ)
               </h5>
           </div>
           <div class="card-body">
               <div class="accordion" id="faqAccordion">
                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                               Bagaimana cara membuat tiket baru?
                           </button>
                       </h2>
                       <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                           <div class="accordion-body">
                               1. Klik menu "Buat Tiket Baru" di sidebar<br>
                               2. Pilih jenis layanan yang dibutuhkan<br>
                               3. Isi judul dan deskripsi dengan jelas<br>
                               4. Upload file pendukung jika diperlukan<br>
                               5. Klik tombol "Ajukan Tiket"
                           </div>
                       </div>
                   </div>

                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                               Berapa lama proses penyelesaian tiket?
                           </button>
                       </h2>
                       <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                           <div class="accordion-body">
                               Estimasi waktu tergantung jenis layanan:<br>
                               • Layanan umum: 1-2 hari kerja<br>
                               • Permintaan data: 3-5 hari kerja<br>
                               • Layanan kompleks: 5-7 hari kerja
                           </div>
                       </div>
                   </div>

                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                               Format file apa yang diterima?
                           </button>
                       </h2>
                       <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                           <div class="accordion-body">
                               Format yang diterima:<br>
                               • Dokumen: PDF, DOC, DOCX<br>
                               • Gambar: JPG, JPEG, PNG<br>
                               • Ukuran maksimal: 5MB per file
                           </div>
                       </div>
                   </div>

                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                               Bagaimana cara membatalkan tiket?
                           </button>
                       </h2>
                       <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                           <div class="accordion-body">
                               Tiket hanya dapat dibatalkan jika masih berstatus "Pengajuan".<br>
                               Klik tombol "Batalkan" pada halaman detail tiket atau daftar tiket.
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <!-- Status Guide -->
       <div class="card shadow">
           <div class="card-header">
               <h5 class="mb-0">
                   <i class="fas fa-info-circle me-2"></i>
                   Panduan Status Tiket
               </h5>
           </div>
           <div class="card-body">
               <div class="table-responsive">
                   <table class="table">
                       <thead>
                           <tr>
                               <th>Status</th>
                               <th>Keterangan</th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td><span class="badge bg-warning">Pengajuan</span></td>
                               <td>Tiket baru dibuat dan menunggu ditindaklanjuti</td>
                           </tr>
                           <tr>
                               <td><span class="badge bg-info">Proses</span></td>
                               <td>Tiket sedang dikerjakan oleh admin</td>
                           </tr>
                           <tr>
                               <td><span class="badge bg-success">Selesai</span></td>
                               <td>Tiket sudah selesai diproses</td>
                           </tr>
                           <tr>
                               <td><span class="badge bg-danger">Dibatalkan</span></td>
                               <td>Tiket dibatalkan oleh pegawai</td>
                           </tr>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>

   <!-- Contact & Downloads -->
   <div class="col-lg-4">
       <!-- Contact Info -->
       <div class="card shadow mb-4">
           <div class="card-header bg-primary text-white">
               <h5 class="mb-0">
                   <i class="fas fa-phone me-2"></i>
                   Hubungi Admin
               </h5>
           </div>
           <div class="card-body">
               <div class="mb-3">
                   <i class="fab fa-whatsapp text-success me-2"></i>
                   <strong>WhatsApp:</strong><br>
                  @if($admin_phone)
                        <a href="https://wa.me/62{{ substr($admin_phone, 1) }}" target="_blank">
                            {{ $admin_phone }}
                        </a>
                    @else
                        <span class="text-muted">Kontak admin belum tersedia</span>
                    @endif

               </div>
               <div class="mb-3">
                   <i class="fas fa-envelope text-primary me-2"></i>
                   <strong>Email:</strong><br>

                    @if($admin_email)
                        <a href="mailto:{{ $admin_email }}">
                            {{ $admin_email }}
                        </a>
                    @else
                        <span class="text-muted">Tidak tersedia</span>
                    @endif
               </div>
               <div class="mb-3">
                   <i class="fas fa-clock text-warning me-2"></i>
                   <strong>Jam Operasional:</strong><br>
                   Senin - Jumat<br>
                   08:00 - 16:00 WITA
               </div>
           </div>
       </div>

       <!-- Download Templates -->
       <div class="card shadow">
           <div class="card-header">
               <h5 class="mb-0">
                   <i class="fas fa-download me-2"></i>
                   Download Template
               </h5>
           </div>
           <div class="card-body">
               <div class="list-group">
                   <a href="#" class="list-group-item list-group-item-action">
                       <i class="fas fa-file-word text-primary me-2"></i>
                       Template Surat Permohonan
                   </a>
                   <a href="#" class="list-group-item list-group-item-action">
                       <i class="fas fa-file-excel text-success me-2"></i>
                       Format Pengajuan Cuti
                   </a>
                   <a href="#" class="list-group-item list-group-item-action">
                       <i class="fas fa-file-pdf text-danger me-2"></i>
                       Form Permintaan Data
                   </a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
