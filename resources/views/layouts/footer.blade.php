<!-- resources/views/layouts/footer.blade.php -->
<footer class="footer mt-auto bg-white border-top">
    <div class="container-fluid py-1">
        <div class="text-center d-flex align-items-center justify-content-center">
            <img src="{{ asset('storage/logo-kemenag.png') }}" alt="Logo" height="20" class="me-2">
            <small class="text-muted">© E-Lapak - Kemenag Konawe Utara</small>
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #ffffff;
        border-top: 1px solid #e5e7eb !important;
        font-size: 12px;
        padding: 0 !important;
    }

    .footer .container-fluid {
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
    }

    .footer img {
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .footer:hover img {
        opacity: 1;
    }

    .footer .text-muted {
        color: #6b7280 !important;
        font-weight: 500;
    }
</style>
