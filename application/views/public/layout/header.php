<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dheemobilindo - Premium Fleet</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS Frameworks -->
    <link href="<?= base_url('assets/tiya/') ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/tiya/') ?>css/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- Note: If you want to use the animated text on hero, uncomment the next line, but it might conflict so we'll see later -->
    <!-- <link href="<?= base_url('assets/tiya/') ?>css/templatemo-tiya-golf-club.css" rel="stylesheet"> -->

    <style>
        /* CSS Reset & Global Style override to merge Bootstrap with our clean design */
        body { font-family: 'Inter', sans-serif; color: #1a1a2e; background: #f9fafb; margin: 0; padding: 0; }
        a { text-decoration: none; color: inherit; }
        a:hover { text-decoration: none; color: inherit; }
        
        /* Navbar Custom Styles */
        .custom-navbar {
            position: sticky; top: 0; z-index: 1050; padding: 16px 0;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid #eaecf0;
            transition: all 0.3s ease;
        }
        .custom-navbar .container { display: flex; align-items: center; justify-content: space-between; }
        .custom-navbar-brand { display: flex; align-items: center; gap: 10px; }
        .custom-navbar-brand img { height: 32px; }
        .custom-navbar-brand span { font-weight: 800; font-size: 1.1rem; color: #1a3bb5; margin-bottom: 0; }
        
        .nav-links { display: flex; align-items: center; gap: 28px; list-style: none; margin: 0; padding: 0; }
        .nav-links li { margin: 0; }
        .nav-links a { font-weight: 500; font-size: 0.95rem; color: #344054; transition: color 0.2s; display: block; }
        .nav-links a:hover { color: #1a3bb5; }
        .nav-links a.active { color: #1a3bb5; font-weight: 700; border-bottom: 2px solid #1a3bb5; padding-bottom: 4px; }
        
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .nav-btn-primary { 
            padding: 8px 20px; background: #1a3bb5; color: #fff !important; 
            border-radius: 8px; font-weight: 600; font-size: 0.9rem; 
            transition: all 0.3s; border: none; text-align: center;
        }
        .nav-btn-primary:hover { background: #1530a0; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(26,59,181,0.2); }
        
        /* Dropdown Profile */
        .profile-dropdown .dropdown-toggle {
            display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 0.9rem;
            color: #344054; background: none; border: none; padding: 6px 12px;
            border-radius: 8px; transition: background 0.2s;
        }
        .profile-dropdown .dropdown-toggle:hover { background: #f1f5f9; }
        .profile-dropdown .dropdown-toggle::after { display: none; } /* Hide default caret */
        .profile-avatar {
            width: 32px; height: 32px; border-radius: 50%; background: #e0f2fe; color: #0284c7;
            display: flex; align-items: center; justify-content: center; font-weight: 700;
        }
        .profile-dropdown .dropdown-menu {
            border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            padding: 8px; min-width: 200px;
        }
        .profile-dropdown .dropdown-item {
            border-radius: 6px; padding: 10px 16px; font-size: 0.9rem; font-weight: 500; color: #475467;
            display: flex; align-items: center; gap: 10px; transition: all 0.2s;
        }
        .profile-dropdown .dropdown-item:hover { background: #f8fafc; color: #1a3bb5; }
        .profile-dropdown .dropdown-item-danger { color: #b42318; }
        .profile-dropdown .dropdown-item-danger:hover { background: #fef2f2; color: #b42318; }

        .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #344054; padding: 0; }
        
        /* Form & Alerts Reset (from old landing page) */
        .alert-landing { padding: 14px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500; }
        .alert-landing-danger { background: #fef3f2; color: #b42318; border: 1px solid #fecdca; }
        .alert-landing-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }

        @media (max-width: 992px) {
            .nav-links { 
                display: none; position: absolute; top: 100%; left: 0; right: 0; 
                background: #fff; flex-direction: column; gap: 0;
                padding: 16px; border-bottom: 1px solid #eaecf0; box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            }
            .nav-links.show { display: flex; }
            .nav-links li { width: 100%; }
            .nav-links a { padding: 12px 16px; border-radius: 8px; }
            .nav-links a:hover, .nav-links a.active { background: #f8fafc; border: none; }
            .mobile-toggle { display: block; }
            .nav-right-desktop { display: none; }
        }
        @media (min-width: 993px) {
            .custom-navbar-brand { flex: 1; }
            .nav-right.nav-right-desktop { flex: 1; justify-content: flex-end; }
            .nav-right-mobile { display: none; }
        }
    </style>
</head>
<body>
    <?php
        $segment1 = $this->uri->segment(1);
        $segment2 = $this->uri->segment(2);
        
        $is_home = ($segment1 == 'home' && ($segment2 == '' || $segment2 == 'index')) || $segment1 == '';
        $is_about = ($segment2 == 'tentang_kami');
        $is_catalog = ($segment2 == 'bus_catalog');
        $is_booking = ($segment2 == 'booking_page' || $segment2 == 'voucher');
        $is_contact = ($segment2 == 'kontak');
        $is_my_bookings = ($segment2 == 'my_bookings' || $segment2 == 'booking_detail' || $segment2 == 'kwitansi');
    ?>

    <nav class="custom-navbar">
        <div class="container">
            <a href="<?= base_url('home') ?>" class="custom-navbar-brand">
                <!-- <img src="<?= base_url('assets/img/logo_dru.png') ?>" alt="Logo"> -->
                <span>Dheemobilindo</span>
            </a>
            
            <ul class="nav-links" id="navbarLinks">
                <li><a href="<?= base_url('home') ?>" class="<?= $is_home ? 'active' : '' ?>">Beranda</a></li>
                <li><a href="<?= base_url('home/bus_catalog') ?>" class="<?= $is_catalog ? 'active' : '' ?>">Katalog Bus</a></li>
                <li><a href="<?= base_url('home/booking_page') ?>" class="<?= $is_booking ? 'active' : '' ?>">Pemesanan</a></li>
                
                <!-- Mobile Only Menu Items -->
                <div class="nav-right-mobile mt-3 pt-3 border-top w-100">
                    <?php if($this->session->userdata('guest_email')): ?>
                        <li><a href="<?= base_url('home/my_bookings') ?>" class="<?= $is_my_bookings ? 'active' : '' ?>"><i class="fas fa-list-ul me-2"></i> Pesanan Saya</a></li>
                        <li><a href="<?= base_url('home/guest_logout') ?>" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
                    <?php else: ?>
                        <li><a href="<?= base_url('home/guest_login') ?>" class="nav-btn-primary w-100 d-block mt-2">Masuk</a></li>
                    <?php endif; ?>
                </div>
            </ul>
            
            <div class="nav-right nav-right-desktop">
                <?php if($this->session->userdata('guest_email')): ?>
                    <?php 
                        $nama = htmlspecialchars($this->session->userdata('guest_name'));
                        $inisial = substr($nama, 0, 1);
                    ?>
                    <div class="dropdown profile-dropdown">
                        <button class="dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-avatar"><?= strtoupper($inisial) ?></div>
                            <span><?= $nama ?></span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem; color: #98a2b3;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item <?= $is_my_bookings ? 'active bg-light text-primary' : '' ?>" href="<?= base_url('home/my_bookings') ?>"><i class="fas fa-list-ul"></i> Pesanan Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item dropdown-item-danger" href="<?= base_url('home/guest_logout') ?>"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('home/guest_login') ?>" class="nav-btn-primary"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk</a>
                <?php endif; ?>
            </div>
            
            <button class="mobile-toggle" onclick="document.getElementById('navbarLinks').classList.toggle('show')">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
    <main>
