<!-- resources/views/layouts/sidebar.blade.php -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">

        <ul class="nav flex-column">
            <?php if(Auth::user()->isAdmin()): ?>
                <!-- Admin Menu -->
                <li class="nav-item mb-2">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">MAIN</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="fas fa-tachometer-alt me-3"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('tickets.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('tickets.index')); ?>">
                        <i class="fas fa-ticket-alt me-3"></i>
                        Kelola Tiket
                    </a>
                </li>

                <li class="nav-item mb-2 mt-4">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">MANAGEMENT</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.users.index')); ?>">
                        <i class="fas fa-users me-3"></i>
                        Kelola User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.service-types.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.service-types.index')); ?>">
                        <i class="fas fa-cogs me-3"></i>
                        Jenis Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.departments.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.departments.index')); ?>">
                        <i class="fas fa-building me-3"></i>
                         Unit Kerja
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('approval.riwayat') ? 'active' : ''); ?>"
                    href="<?php echo e(route('approval.riwayat')); ?>">
                        <i class="fas fa-history me-2"></i>
                        Riwayat Approval
                    </a>
                </li>

                <li class="nav-item mb-2 mt-4">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">ACCOUNT</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>"
                    href="<?php echo e(route('profile.edit')); ?>">
                        <i class="fas fa-user-cog me-3"></i>
                        Pengaturan
                    </a>
                </li>



            <?php elseif(Auth::user()->isApproval()): ?>
                <!-- Approval Menu -->
                <li class="nav-item mb-2">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">MAIN</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('approval.dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('approval.dashboard')); ?>">
                        <i class="fas fa-tachometer-alt me-3"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('tickets.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('tickets.index')); ?>">
                        <i class="fas fa-ticket-alt me-3"></i>
                        Kelola Tiket
                    </a>
                </li>

                <li class="nav-item mb-2 mt-4">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">HISTORY</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('approval.riwayat') ? 'active' : ''); ?>"
                    href="<?php echo e(route('approval.riwayat')); ?>">
                        <i class="fas fa-history me-2"></i>
                        Riwayat Approval
                    </a>
                </li>

                <li class="nav-item mb-2 mt-4">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">ACCOUNT</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>"
                    href="<?php echo e(route('profile.edit')); ?>">
                        <i class="fas fa-user-cog me-3"></i>
                        Pengaturan
                    </a>
                </li>

            <?php else: ?>
                <!-- Pegawai Menu -->
                <li class="nav-item mb-2">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">MAIN</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('pegawai.dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('pegawai.dashboard')); ?>">
                        <i class="fas fa-tachometer-alt me-3"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('tickets.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('tickets.index')); ?>">
                        <i class="fas fa-ticket-alt me-3"></i>
                        Tiket Saya
                    </a>
                </li>

                <li class="nav-item mb-2 mt-4">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">ACTIONS</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('tickets.create') ? 'active' : ''); ?>"
                       href="<?php echo e(route('tickets.create')); ?>">
                        <i class="fas fa-plus-circle me-3"></i>
                        Buat Tiket Baru
                    </a>
                </li>

                <li class="nav-item mb-2 mt-4">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">SUPPORT</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('bantuan') ? 'active' : ''); ?>"
                        href="<?php echo e(route('bantuan')); ?>">
                        <i class="fas fa-question-circle me-3"></i>
                        Bantuan
                    </a>
                </li>

                <li class="nav-item mb-2 mt-4">
                    <div class="px-3 py-1">
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">ACCOUNT</small>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>"
                    href="<?php echo e(route('profile.edit')); ?>">
                        <i class="fas fa-user-cog me-3"></i>
                        Pengaturan
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <div class="mt-auto">
            <!-- Development Info -->
            <div class="px-3 py-3 mx-2 rounded-3" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="text-center text-light small">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div style="font-weight: 600; font-size: 0.85rem; color: rgba(255,255,255,0.9);">
                            Kemenag Konawe Utara
                        </div>
                    </div>
                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6);">
                        <i class="far fa-copyright me-1"></i>2025 • E-Lapak System
                    </div>
                </div>
            </div>
        </div>

    </div>
</nav>


<?php /**PATH C:\laragon\www\e-lapak\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>