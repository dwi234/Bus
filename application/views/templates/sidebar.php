<?php 
$seg1 = $this->uri->segment(1); 
$role = $this->session->userdata('role');
?>
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center mt-3 mb-2" href="<?= base_url('dashboard') ?>" style="padding: 1.5rem 1rem;">
                <div class="sidebar-brand-icon">
                    <img src="<?= base_url('assets/img/logo_dru.png') ?>" alt="Logo" style="height: 40px; width: auto;">
                </div>
                <div class="sidebar-brand-text mx-2 text-left" style="line-height: 1.2;">
                    <div class="text-white font-weight-bold" style="font-size: 0.95rem;">DHEEMOBILINDO</div>
                    <div class="text-white-50 font-weight-bold" style="font-size: 0.6rem; letter-spacing: 0.1em;">SYSTEM CONTROL</div>
                </div>
            </a>
            <hr class="sidebar-divider my-0">

            <style>
                /* Sidebar sticky + flex layout */
                #accordionSidebar {
                    position: sticky !important;
                    top: 0;
                    height: 100vh;
                    overflow: visible !important; /* biarkan submenu meluber */
                    display: flex;
                    flex-direction: column;
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                }
                /* Inner scroll wrapper */
                #accordionSidebar .sidebar-scroll-wrapper {
                    flex: 1;
                    overflow-y: auto;
                    overflow-x: hidden;
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                }
                #accordionSidebar .sidebar-scroll-wrapper::-webkit-scrollbar {
                    display: none;
                }

                .sidebar.toggled .role-text { display: none; }
                .sidebar.toggled .role-badge { padding: 0.5em 0.6em !important; }

                /* Saat di-minimize: fixed position bypass overflow scroll wrapper */
                @media (min-width: 768px) {
                    #accordionSidebar.toggled {
                        overflow: visible !important;
                        z-index: 999 !important;
                    }
                    .sidebar.toggled .nav-item .collapse {
                        position: fixed !important;
                        left: calc(6.5rem + 0.75rem) !important;
                        z-index: 1000 !important;
                        width: 14rem !important;
                        -webkit-animation-name: growIn;
                        animation-name: growIn;
                        -webkit-animation-duration: 200ms;
                        animation-duration: 200ms;
                        -webkit-animation-timing-function: transform cubic-bezier(0.18, 1.25, 0.4, 1), opacity cubic-bezier(0, 1, 0.4, 1);
                        animation-timing-function: transform cubic-bezier(0.18, 1.25, 0.4, 1), opacity cubic-bezier(0, 1, 0.4, 1);
                    }
                    .sidebar.toggled .nav-item .collapse .collapse-inner {
                        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                        border-radius: 0.35rem;
                        background-color: #fff;
                    }
                    /* Nonaktifkan animasi collapsing, jangan sembunyikan display */
                    .sidebar.toggled .nav-item .collapsing {
                        transition: none !important;
                    }
                    .sidebar.toggled .nav-item .collapse.show {
                        display: block !important;
                    }
                }
            </style>
            <div class="sidebar-scroll-wrapper">
            <!-- Role Badge -->
            <div class="text-center my-2">
                <?php if($role == 'superadmin'): ?>
                    <span class="badge badge-danger px-3 py-1 role-badge" title="Superadmin">
                        <i class="fas fa-user-shield"></i> <span class="role-text ml-1">Superadmin</span>
                    </span>
                <?php elseif($role == 'operasional'): ?>
                    <span class="badge badge-warning px-3 py-1 role-badge" title="Operasional">
                        <i class="fas fa-cogs"></i> <span class="role-text ml-1">Operasional</span>
                    </span>
                <?php else: ?>
                    <span class="badge badge-info px-3 py-1 role-badge" title="Reservasi">
                        <i class="fas fa-clipboard-list"></i> <span class="role-text ml-1">Reservasi</span>
                    </span>
                <?php endif; ?>
            </div>
            <hr class="sidebar-divider my-0">

            <!-- Dashboard - semua role -->
            <li class="nav-item <?= ($seg1 == 'dashboard' || $seg1 == '') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-th-large"></i>
                    <span>Dashboard</span></a>
            </li>

            <?php if($role == 'superadmin'): ?>
            <!-- ========== MENU SUPERADMIN (SEMUA MENU) ========== -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Armada & Sumber Daya</div>

            <li class="nav-item <?= ($seg1 == 'bus') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('bus') ?>">
                    <i class="fas fa-fw fa-bus"></i>
                    <span>Manajemen Bus</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'driver') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('driver') ?>">
                    <i class="fas fa-fw fa-id-card"></i>
                    <span>Supir</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'jadwal') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('jadwal') ?>">
                    <i class="far fa-fw fa-calendar-alt"></i>
                    <span>Jadwal</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Pelanggan & Transaksi</div>

            <li class="nav-item <?= ($seg1 == 'customer') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('customer') ?>">
                    <i class="fas fa-fw fa-user-friends"></i>
                    <span>Pelanggan</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'booking' && $this->uri->segment(2) != 'persetujuan') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('booking') ?>">
                    <i class="fas fa-fw fa-ticket-alt"></i>
                    <span>Pemesanan</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'booking' && $this->uri->segment(2) == 'persetujuan') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('booking/persetujuan') ?>">
                    <i class="fas fa-fw fa-check-double"></i>
                    <span>Persetujuan Pemb.</span></a>
            </li>

            <!-- Semua Reports -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Laporan</div>
            <li class="nav-item <?= ($seg1 == 'report') ? 'active' : '' ?>">
                <a class="nav-link <?= ($seg1 == 'report') ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="<?= ($seg1 == 'report') ? 'true' : 'false' ?>" aria-controls="collapseReports">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseReports" class="collapse <?= ($seg1 == 'report') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Semua Laporan:</h6>
                        <?php $seg2 = $this->uri->segment(2); ?>
                        <a class="collapse-item <?= ($seg1 == 'report' && ($seg2 == '' || $seg2 == 'index')) ? 'active' : '' ?>" href="<?= base_url('report') ?>">Laporan Pendapatan</a>
                        <a class="collapse-item <?= ($seg1 == 'report' && $seg2 == 'bus') ? 'active' : '' ?>" href="<?= base_url('report/bus') ?>">Utilisasi Bus</a>
                        <a class="collapse-item <?= ($seg1 == 'report' && $seg2 == 'driver') ? 'active' : '' ?>" href="<?= base_url('report/driver') ?>">Aktivitas Supir</a>
                        <a class="collapse-item <?= ($seg1 == 'report' && $seg2 == 'customer') ? 'active' : '' ?>" href="<?= base_url('report/customer') ?>">Transaksi Pelanggan</a>
                    </div>
                </div>
            </li>

            <!-- User Management - Superadmin Only -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Pengaturan</div>
            <li class="nav-item <?= ($seg1 == 'usermanagement') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('usermanagement') ?>">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Manajemen Pengguna</span></a>
            </li>

            <?php elseif($role == 'operasional'): ?>
            <!-- ========== MENU ADMIN OPERASIONAL ========== -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Armada & Sumber Daya</div>

            <li class="nav-item <?= ($seg1 == 'bus') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('bus') ?>">
                    <i class="fas fa-fw fa-bus"></i>
                    <span>Manajemen Bus</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'driver') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('driver') ?>">
                    <i class="fas fa-fw fa-id-card"></i>
                    <span>Supir</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'jadwal') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('jadwal') ?>">
                    <i class="far fa-fw fa-calendar-alt"></i>
                    <span>Jadwal</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Laporan</div>
            <li class="nav-item <?= ($seg1 == 'report') ? 'active' : '' ?>">
                <a class="nav-link <?= ($seg1 == 'report') ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="<?= ($seg1 == 'report') ? 'true' : 'false' ?>" aria-controls="collapseReports">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseReports" class="collapse <?= ($seg1 == 'report') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Laporan Operasional:</h6>
                        <?php $seg2 = $this->uri->segment(2); ?>
                        <a class="collapse-item <?= ($seg1 == 'report' && $seg2 == 'bus') ? 'active' : '' ?>" href="<?= base_url('report/bus') ?>">Utilisasi Bus</a>
                        <a class="collapse-item <?= ($seg1 == 'report' && $seg2 == 'driver') ? 'active' : '' ?>" href="<?= base_url('report/driver') ?>">Aktivitas Supir</a>
                    </div>
                </div>
            </li>

            <?php elseif($role == 'reservasi'): ?>
            <!-- ========== MENU ADMIN RESERVASI ========== -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Pelanggan & Transaksi</div>

            <li class="nav-item <?= ($seg1 == 'customer') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('customer') ?>">
                    <i class="fas fa-fw fa-user-friends"></i>
                    <span>Pelanggan</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'booking' && $this->uri->segment(2) != 'persetujuan') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('booking') ?>">
                    <i class="fas fa-fw fa-ticket-alt"></i>
                    <span>Pemesanan</span></a>
            </li>
            <li class="nav-item <?= ($seg1 == 'booking' && $this->uri->segment(2) == 'persetujuan') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('booking/persetujuan') ?>">
                    <i class="fas fa-fw fa-check-double"></i>
                    <span>Persetujuan Pemb.</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Laporan</div>
            <li class="nav-item <?= ($seg1 == 'report') ? 'active' : '' ?>">
                <a class="nav-link <?= ($seg1 == 'report') ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="<?= ($seg1 == 'report') ? 'true' : 'false' ?>" aria-controls="collapseReports">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseReports" class="collapse <?= ($seg1 == 'report') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Laporan Reservasi:</h6>
                        <?php $seg2 = $this->uri->segment(2); ?>
                        <a class="collapse-item <?= ($seg1 == 'report' && $seg2 == 'customer') ? 'active' : '' ?>" href="<?= base_url('report/customer') ?>">Transaksi Pelanggan</a>
                    </div>
                </div>
            </li>
            <?php endif; ?>
            </div><!-- end sidebar-scroll-wrapper -->

            <hr class="sidebar-divider d-none d-md-block mt-3">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <script>
            (function() {
                // 1. Restore state seawal mungkin untuk mencegah flicker
                var isDesktop = window.innerWidth >= 768;
                var sidebarToggled = localStorage.getItem('sb-sidebar-toggled') === 'true';
                
                var sidebarEl = document.getElementById('accordionSidebar');
                
                if (isDesktop && sidebarToggled) {
                    if (sidebarEl) sidebarEl.classList.add('toggled');
                    document.body.classList.add('sidebar-toggled');
                }

                // Restore Submenu state (Reports)
                var reportsState = localStorage.getItem('sb-submenu-collapseReports');
                var collapseReports = document.getElementById('collapseReports');
                var anchorReports = document.querySelector('a[data-target="#collapseReports"]');

                if (isDesktop && !sidebarToggled) {
                    if (reportsState === 'show') {
                        if (collapseReports) collapseReports.classList.add('show');
                        if (anchorReports) {
                            anchorReports.classList.remove('collapsed');
                            anchorReports.setAttribute('aria-expanded', 'true');
                        }
                    } else if (reportsState === 'hide') {
                        if (collapseReports) collapseReports.classList.remove('show');
                        if (anchorReports) {
                            anchorReports.classList.add('collapsed');
                            anchorReports.setAttribute('aria-expanded', 'false');
                        }
                    }
                } else {
                    // Mobile atau Minimized: Submenu harus tertutup
                    if (collapseReports) collapseReports.classList.remove('show');
                    if (anchorReports) {
                        anchorReports.classList.add('collapsed');
                        anchorReports.setAttribute('aria-expanded', 'false');
                    }
                }

                // 2. Event Listeners untuk Update Storage
                document.addEventListener('DOMContentLoaded', function() {
                    function updateSidebarStorage() {
                        if (window.innerWidth >= 768) {
                            // Tunggu sb-admin-2.js selesai melakukan toggle class
                            setTimeout(function() {
                                var isNowToggled = document.body.classList.contains('sidebar-toggled');
                                localStorage.setItem('sb-sidebar-toggled', isNowToggled);
                                
                                // Jika di-expand, pulihkan submenu yang tadinya terbuka
                                if (!isNowToggled && typeof jQuery !== 'undefined') {
                                    // Bersihkan inline top dari semua collapse
                                    jQuery('#accordionSidebar .collapse').css('top', '');
                                    var rState = localStorage.getItem('sb-submenu-collapseReports');
                                    if (rState === 'show') {
                                        jQuery('#collapseReports').collapse('show');
                                    }
                                }
                            }, 50);
                        }
                    }

                    var toggleBtn = document.getElementById('sidebarToggle');
                    var toggleBtnTop = document.getElementById('sidebarToggleTop');
                    if (toggleBtn) toggleBtn.addEventListener('click', updateSidebarStorage);
                    if (toggleBtnTop) toggleBtnTop.addEventListener('click', updateSidebarStorage);

                    // 3. Event Listeners untuk Submenu Storage & Positioning
                    if (typeof jQuery !== 'undefined') {
                        // Position submenu correctly when sidebar is toggled (position:fixed)
                        jQuery('#accordionSidebar').on('show.bs.collapse', '.collapse', function() {
                            if (document.body.classList.contains('sidebar-toggled')) {
                                var navItem = jQuery(this).closest('.nav-item');
                                if (navItem.length) {
                                    var rect = navItem[0].getBoundingClientRect();
                                    this.style.top = rect.top + 'px';
                                }
                            }
                        });
                        // Cleanup inline top style on hide
                        jQuery('#accordionSidebar').on('hidden.bs.collapse', '.collapse', function() {
                            this.style.top = '';
                            if (!document.body.classList.contains('sidebar-toggled')) {
                                localStorage.setItem('sb-submenu-' + this.id, 'hide');
                            }
                        });
                        // Save show state
                        jQuery('#accordionSidebar').on('shown.bs.collapse', '.collapse', function() {
                            localStorage.setItem('sb-submenu-' + this.id, 'show');
                        });
                    }
                });
            })();
        </script>
        <!-- End of Sidebar -->