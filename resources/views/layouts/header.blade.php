<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--primary-transparent) 0%, var(--primary-color) 40%, var(--primary-dark) 100%) !important;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center text-white" href="#">
            <img src="{{ asset('storage/logo-kemenag.png') }}"
                 alt="Logo Kemenag"
                 height="40"
                 class="me-3"
                 style="background-color: white; padding: 5px; border-radius: 4px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-ticket-alt me-2 text-white"></i>
                <div>
                    <span class="fw-bold text-white" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">E-Lapak Kemenag Konut</span>
                    <small class="d-block text-white-50" style="font-size: 0.75rem; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">Kementerian Agama Kabupaten Konawe Utara</small>
                </div>
            </div>
        </a>

        @auth
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown" style="position: static;">
                <a class="nav-link dropdown-toggle user-dropdown-toggle d-flex align-items-center text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar-enhanced me-3">
                        {{ substr(Auth::user()->name, 0, 1) }}
                        <div class="status-indicator"></div>
                    </div>
                    <div class="user-info d-none d-md-block">
                        <div class="user-name">{{ Str::limit(Auth::user()->name, 15) }}</div>
                        <small class="user-role">{{ ucfirst(Auth::user()->role) }}</small>
                    </div>
                    <i class="fas fa-chevron-down ms-2 dropdown-arrow"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end modern-dropdown shadow-lg">
                    <!-- User Profile Header -->
                    <div class="dropdown-header-modern">
                        <div class="d-flex align-items-center p-3">
                            <div class="user-avatar-large me-3">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="user-name-large">{{ Auth::user()->name }}</div>
                                <div class="user-email-small">{{ Auth::user()->email ?? 'No email' }}</div>
                            </div>
                        </div>
                        <div class="user-stats-row">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-number">{{ Auth::user()->createdTickets()->count() }}</div>
                                    <div class="stat-label">Tiket</div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-number">{{ ucfirst(Auth::user()->role) }}</div>
                                    <div class="stat-label">Role</div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-number">
                                        <span class="badge bg-success">Aktif</span>
                                    </div>
                                    <div class="stat-label">Status</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-divider-modern"></div>

                    <!-- User Details -->
                    <div class="dropdown-body">
                        <div class="user-detail-item">
                            <i class="fas fa-id-badge detail-icon"></i>
                            <div class="detail-content">
                                <div class="detail-label">NIP</div>
                                <div class="detail-value">{{ Auth::user()->nip }}</div>
                            </div>
                        </div>
                        <div class="user-detail-item">
                            <i class="fas fa-building detail-icon"></i>
                            <div class="detail-content">
                                <div class="detail-label">Unit Kerja</div>
                                <div class="detail-value">{{ Str::limit(Auth::user()->department, 25) }}</div>
                            </div>
                        </div>
                        <div class="user-detail-item">
                            <i class="fas fa-calendar detail-icon"></i>
                            <div class="detail-content">
                                <div class="detail-label">Bergabung</div>
                                <div class="detail-value">{{ Auth::user()->created_at->format('M Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-divider-modern"></div>

                    <!-- Quick Actions -->
                    <div class="dropdown-actions">
                        <a href="{{ route('tickets.index') }}" class="dropdown-item-modern">
                            <i class="fas fa-ticket-alt"></i>
                            <span>Tiket Saya</span>
                        </a>
                        @if(!Auth::user()->isAdmin())
                        <a href="{{ route('tickets.create') }}" class="dropdown-item-modern">
                            <i class="fas fa-plus-circle"></i>
                            <span>Buat Tiket</span>
                        </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="dropdown-item-modern">
                            <i class="fas fa-user-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                    </div>

                    <div class="dropdown-divider-modern"></div>

                    <!-- Logout -->
                    <div class="dropdown-footer">
                        <form action="{{ route('logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="dropdown-item-logout">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </div>
</nav>

<style>
.navbar {
    box-shadow: 0 4px 15px rgba(6, 95, 70, 0.15);
    backdrop-filter: blur(15px);
    z-index: 1030;
    position: relative;
}

.navbar-brand {
    text-decoration: none !important;
}

.navbar-brand:hover {
    opacity: 0.9;
}

.navbar-brand img {
    object-fit: contain;
}

.navbar-brand:hover img {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

/* Enhanced User Avatar */
.user-avatar-enhanced {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
    color: #064e3b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 16px;
    text-transform: uppercase;
    position: relative;
    border: 3px solid rgba(255,255,255,0.5);
    transition: all 0.3s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
}

.user-avatar-enhanced:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(255,255,255,0.3);
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    background: #28a745;
    border: 2px solid white;
    border-radius: 50%;
}

.user-avatar-large {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-transparent) 0%, var(--primary-color) 50%, var(--primary-dark) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    text-transform: uppercase;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.user-info {
    text-align: left;
}

.user-name {
    font-weight: 600;
    font-size: 14px;
    line-height: 1.2;
}

.user-role {
    font-size: 11px;
    opacity: 0.8;
    font-weight: 500;
}

.dropdown-arrow {
    font-size: 10px;
    transition: transform 0.3s ease;
}

.user-dropdown-toggle[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(180deg);
}

/* Modern Dropdown */
.modern-dropdown {
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(10px);
    padding: 0;
    min-width: 320px;
    overflow: hidden;
    animation: dropdownSlide 0.3s ease;
    z-index: 9999 !important;
    position: absolute !important;
}

@keyframes dropdownSlide {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-header-modern {
    background: linear-gradient(135deg, var(--primary-transparent) 0%, var(--primary-color) 50%, var(--primary-dark) 100%);
    color: white;
    padding: 0;
}

.user-name-large {
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 2px;
}

.user-email-small {
    font-size: 12px;
    opacity: 0.8;
}

.user-stats-row {
    background: rgba(255,255,255,0.1);
    padding: 12px 20px;
    margin-top: 10px;
}

.stat-number {
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 2px;
}

.stat-label {
    font-size: 10px;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dropdown-divider-modern {
    margin: 0;
    border-color: #e9ecef;
    opacity: 0.3;
}

.dropdown-body {
    padding: 16px 20px;
}

.user-detail-item {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.user-detail-item:last-child {
    margin-bottom: 0;
}

.detail-icon {
    width: 16px;
    color: var(--primary-color);
    font-size: 14px;
    margin-right: 12px;
}

.detail-content {
    flex: 1;
}

.detail-label {
    font-size: 11px;
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.detail-value {
    font-size: 13px;
    font-weight: 600;
    color: #212529;
}

.dropdown-actions {
    padding: 8px 12px;
}

.dropdown-item-modern {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    color: #495057;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 4px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.dropdown-item-modern:hover {
    background: linear-gradient(135deg, var(--primary-transparent) 0%, var(--primary-color) 50%, var(--primary-dark) 100%);
    color: white;
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(6, 95, 70, 0.3);
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}

.dropdown-item-modern i {
    width: 18px;
    margin-right: 12px;
    font-size: 14px;
}

.dropdown-footer {
    padding: 12px 20px;
    background: #f8f9fa;
}

.dropdown-item-logout {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.dropdown-item-logout:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
}

/* Text visibility */
.text-white {
    color: #ffffff !important;
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.7) !important;
}

/* Additional fixes for dropdown positioning */
.dropdown-menu.show {
    z-index: 9999 !important;
}

.navbar-nav .dropdown {
    position: static !important;
}

.navbar-nav .dropdown-menu {
    position: absolute !important;
    transform: none !important;
    will-change: auto !important;
}

/* Responsive */
@media (max-width: 768px) {
    .modern-dropdown {
        min-width: 280px;
    }

    .user-stats-row .col-4 {
        padding: 0 8px;
    }

    .stat-number {
        font-size: 12px;
    }
}

@media (max-width: 576px) {
    .navbar-brand img {
        height: 35px;
    }

    .navbar-brand small {
        display: none !important;
    }

    .user-avatar-enhanced {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }

    .modern-dropdown {
        min-width: 260px;
    }
}
</style>
