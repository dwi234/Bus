<?php $this->load->view('public/layout/header'); ?>

<!-- ===================== HERO SECTION — FULL-BLEED 3D BACKGROUND ===================== -->
<section class="hero-3d-section" id="section_1">

    <!-- Full-bleed 3D Canvas (entire hero background) -->
    <canvas id="hero3dCanvas"></canvas>

    <!-- Gradient overlay for text readability -->
    <div class="hero-gradient-overlay"></div>

    <!-- Loading Overlay -->
    <div id="heroLoading">
        <div class="hero-loading-inner">
            <div class="hero-spinner"></div>
            <p>Memuat 3D Environment...</p>
        </div>
    </div>

    <!-- ── Content Container (overlaid on 3D background) ── -->
    <div class="container hero-content-container">
        <div class="row align-items-center justify-content-center" style="min-height: 100vh; padding: 100px 0 80px;">

            <!-- LEFT COLUMN: Text + Badges -->
            <div class="col-lg-6 col-md-10 col-12 mb-5 mb-lg-0">
                <h1 class="hero-title-1">Travel as friends</h1>
                <h1 class="hero-title-2">
                    return as <span class="hero-accent">family</span>
                </h1>

                <p class="hero-description">
                    Pengalaman perjalanan premium dengan armada modern, mengutamakan kenyamanan, keamanan, dan pelayanan terbaik untuk Anda dan keluarga.
                </p>

                <!-- Premium Badges -->
                <div class="hero-badges">
                    <span class="hero-badge">
                        <i class="fas fa-star"></i> Premium Vehicles
                    </span>
                    <span class="hero-badge">
                        <i class="fas fa-headset"></i> 24/7 Concierge
                    </span>
                    <span class="hero-badge">
                        <i class="fas fa-shield-alt"></i> Fully Insured
                    </span>
                </div>

                <!-- Stats Row -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-number">50+</span>
                        <span class="hero-stat-label">Armada</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">10K+</span>
                        <span class="hero-stat-label">Pelanggan</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">4.9</span>
                        <span class="hero-stat-label">Rating</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Glassmorphic Booking Card -->
            <div class="col-lg-5 col-md-8 col-12 offset-lg-1">
                <div class="hero-booking-card">
                    <h4 class="booking-card-title">Reserve Your Journey</h4>
                    <p class="booking-card-subtitle">Temukan armada premium untuk perjalanan Anda</p>

                    <form id="heroSearchForm" method="GET" action="<?= base_url('home/booking_page') ?>">
                        <!-- Pickup Location -->
                        <div class="hero-input-group">
                            <div class="hero-input-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <input type="text" name="pickup" id="hero_pickup" placeholder="Lokasi Penjemputan" autocomplete="off" class="hero-input">
                        </div>

                        <!-- Destination -->
                        <div class="hero-input-group">
                            <div class="hero-input-icon"><i class="fas fa-flag-checkered"></i></div>
                            <input type="text" name="destination" id="hero_destination" placeholder="Tempat Tujuan" autocomplete="off" class="hero-input">
                        </div>

                        <!-- Date -->
                        <div class="hero-input-group">
                            <div class="hero-input-icon"><i class="fas fa-calendar-alt"></i></div>
                            <input type="date" name="date" id="hero_date" min="<?= date('Y-m-d') ?>" class="hero-input" style="color-scheme: dark;">
                        </div>

                        <!-- Capacity -->
                        <div class="hero-input-group">
                            <div class="hero-input-icon"><i class="fas fa-users"></i></div>
                            <select name="capacity" id="hero_capacity" class="hero-input hero-select">
                                <option value="" style="background: #1a2a3a; color: #ccc;">Kapasitas Penumpang</option>
                                <option value="15" style="background: #1a2a3a; color: #fff;">15 Kursi (Mini Bus)</option>
                                <option value="25" style="background: #1a2a3a; color: #fff;">25 Kursi (Medium Bus)</option>
                                <option value="30" style="background: #1a2a3a; color: #fff;">30 Kursi (Big Bus)</option>
                                <option value="50" style="background: #1a2a3a; color: #fff;">50 Kursi (Executive Bus)</option>
                                <option value="60" style="background: #1a2a3a; color: #fff;">60 Kursi (Super Big Bus)</option>
                            </select>
                            <div class="hero-select-arrow"><i class="fas fa-chevron-down"></i></div>
                        </div>

                        <!-- CTA Button -->
                        <button type="submit" id="heroCheckBtn" class="hero-cta-btn">
                            Check Availability &nbsp;→
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>



    <!-- Clean bottom fade transition -->
    <div class="hero-bottom-fade"></div>

    <!-- ===================== HERO STYLES ===================== -->
    <style>
        /* ── Section ── */
        .hero-3d-section {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: #060a10;
        }

        /* ── Full-Bleed 3D Canvas ── */
        #hero3dCanvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            display: block;
        }

        /* ── Gradient Overlay (ensures text readability) ── */
        .hero-gradient-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            background:
                linear-gradient(90deg, rgba(6,10,16,0.75) 0%, rgba(6,10,16,0.3) 40%, rgba(6,10,16,0.45) 70%, rgba(6,10,16,0.7) 100%),
                linear-gradient(180deg, rgba(6,10,16,0.5) 0%, transparent 30%, transparent 70%, rgba(6,10,16,0.6) 100%);
        }

        /* ── Loading Overlay ── */
        #heroLoading {
            position: absolute;
            inset: 0;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #060a10;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }
        #heroLoading.loaded {
            opacity: 0;
            visibility: hidden;
        }
        .hero-loading-inner { text-align: center; }
        .hero-spinner {
            width: 48px; height: 48px;
            border: 3px solid rgba(224,169,109,0.15);
            border-top-color: #E0A96D;
            border-radius: 50%;
            animation: heroSpin 0.8s linear infinite;
            margin: 0 auto 16px;
        }
        #heroLoading p {
            color: rgba(255,255,255,0.45);
            font-size: 0.88rem;
            letter-spacing: 0.5px;
            margin: 0;
        }
        @keyframes heroSpin { to { transform: rotate(360deg); } }

        /* ── Content Container ── */
        .hero-content-container {
            position: relative;
            z-index: 5;
        }

        /* ── Titles ── */
        .hero-title-1 {
            font-size: 3.4rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.08;
            margin-bottom: 6px;
            text-shadow: 0 2px 30px rgba(0,0,0,0.6), 0 0 80px rgba(0,0,0,0.3);
        }
        .hero-title-2 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 24px;
            text-shadow: 0 2px 30px rgba(0,0,0,0.6), 0 0 80px rgba(0,0,0,0.3);
        }
        .hero-accent {
            color: #E0A96D;
            border-bottom: 3px solid #E0A96D;
            padding-bottom: 4px;
        }

        /* ── Description ── */
        .hero-description {
            color: rgba(255,255,255,0.7);
            font-size: 1.05rem;
            max-width: 480px;
            line-height: 1.8;
            margin-bottom: 28px;
            text-shadow: 0 1px 10px rgba(0,0,0,0.5);
        }

        /* ── Badges ── */
        .hero-badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            background: rgba(224,169,109,0.1);
            border: 1px solid rgba(224,169,109,0.25);
            color: #E0A96D;
            font-size: 0.82rem;
            font-weight: 600;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }
        .hero-badge:hover {
            background: rgba(224,169,109,0.2);
            border-color: rgba(224,169,109,0.45);
            transform: translateY(-2px);
        }

        /* ── Stats ── */
        .hero-stats {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 18px 24px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            max-width: 380px;
        }
        .hero-stat { text-align: center; }
        .hero-stat-number {
            display: block;
            font-size: 1.5rem;
            font-weight: 800;
            color: #E0A96D;
            line-height: 1.2;
        }
        .hero-stat-label {
            display: block;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
            margin-top: 2px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .hero-stat-divider {
            width: 1px;
            height: 32px;
            background: rgba(255,255,255,0.1);
        }

        /* ── Booking Card ── */
        .hero-booking-card {
            background: rgba(16, 24, 40, 0.78);
            backdrop-filter: blur(28px) saturate(1.3);
            -webkit-backdrop-filter: blur(28px) saturate(1.3);
            border-radius: 24px;
            padding: 38px 32px;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 24px 80px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.03) inset;
        }
        .booking-card-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.35rem;
            margin-bottom: 6px;
        }
        .booking-card-subtitle {
            color: rgba(255,255,255,0.42);
            font-size: 0.85rem;
            margin-bottom: 28px;
        }

        /* ── Form Inputs ── */
        .hero-input-group {
            position: relative;
            margin-bottom: 16px;
        }
        .hero-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #E0A96D;
            font-size: 0.9rem;
            z-index: 2;
            pointer-events: none;
        }
        .hero-input {
            width: 100%;
            padding: 15px 16px 15px 42px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.06);
            color: #ffffff;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        }
        .hero-input:focus {
            border-color: rgba(224,169,109,0.5);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 3px rgba(224,169,109,0.08);
        }
        .hero-input::placeholder { color: rgba(255,255,255,0.35); }
        .hero-select {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            color: rgba(255,255,255,0.65);
        }
        .hero-select-arrow {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 0.75rem;
            pointer-events: none;
        }
        .hero-input-group:last-of-type { margin-bottom: 28px; }

        /* ── CTA Button ── */
        .hero-cta-btn {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #E0A96D 0%, #C8894A 100%);
            color: #0f1923;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 24px rgba(224,169,109,0.3);
        }
        .hero-cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 36px rgba(224,169,109,0.5);
        }

        /* ── 3D Controls (bottom-left) ── */
        #hero3dControls {
            position: absolute;
            bottom: 100px;
            left: 24px;
            z-index: 8;
            display: flex;
            gap: 8px;
        }
        .ctrl-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(10,15,24,0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: rgba(255,255,255,0.5);
            font-size: 0.78rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
        }
        .ctrl-btn:hover {
            background: rgba(224,169,109,0.12);
            border-color: rgba(224,169,109,0.3);
            color: #E0A96D;
        }
        .ctrl-btn-active {
            color: #E0A96D;
            border-color: rgba(224,169,109,0.3);
        }
        .ctrl-btn i { font-size: 0.85rem; }

        /* ── Bottom Fade Transition ── */
        .hero-bottom-fade {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            z-index: 3;
            pointer-events: none;
            background: linear-gradient(to bottom, transparent 0%, #ffffff 100%);
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .hero-title-1 { font-size: 2.6rem; }
            .hero-title-2 { font-size: 2.2rem; }
            .hero-stats { max-width: 100%; }
            #hero3dControls { bottom: 80px; left: 16px; }
        }
        @media (max-width: 575px) {
            .hero-title-1 { font-size: 2rem; }
            .hero-title-2 { font-size: 1.7rem; }
            .hero-booking-card { padding: 28px 20px; }
            .hero-stats { gap: 16px; padding: 14px 16px; }
            #hero3dControls { bottom: 70px; }
            .ctrl-btn span { display: none; }
        }
    </style>
</section>

<!-- TENTANG KAMI SECTION -->
<section id="tentang_kami" class="about-section py-5" style="background-color: #ffffff;">
    <div class="container py-4">
        <div class="row mb-5">
            <div class="col-lg-12 col-12 text-center">
                <h2 class="mb-4 fw-bold" style="color: #1e293b;">Tentang Dheemobilindo</h2>
            </div>
        </div>

        <div class="row align-items-center justify-content-center mb-5 pb-5">
            <div class="col-lg-6 col-md-10 col-12 mb-5 mb-lg-0">
                <img src="<?= base_url('assets/img/bus_hero.png') ?>" class="img-fluid d-block" alt="Armada Dheemobilindo" style="width: 100%; aspect-ratio: 16/10; object-fit: cover; border-radius: 16px; box-shadow: 0 12px 35px rgba(0,0,0,0.15);">
            </div>

            <div class="col-lg-5 col-md-10 col-12 offset-lg-1 d-flex flex-column justify-content-center">
                <h5 style="color: #475467; font-weight: 600; font-size: 1.15rem; margin-bottom: 24px;">Mengenal Dheemobilindo Lebih Dekat</h5>
                <p style="color: #667085; font-size: 0.95rem; line-height: 1.7; text-align: justify; margin-bottom: 24px;">
                    Kami adalah penyedia layanan penyewaan armada bus premium yang berdedikasi untuk memberikan pengalaman perjalanan yang aman, nyaman, dan tak terlupakan. Dengan pilihan armada terlengkap yang selalu dalam kondisi prima serta didukung oleh pengemudi profesional, Dheemobilindo siap melayani segala kebutuhan perjalanan Anda mulai dari wisata keluarga, kunjungan industri, hingga acara perusahaan di seluruh Indonesia.
                </p>
                
                <div style="background-color: #f5f8ff; border-left: 4px solid #1a3bb5; padding: 24px; border-radius: 0 12px 12px 0; margin-top: 8px;">
                    <p style="color: #1a3bb5; font-style: italic; font-weight: 600; font-size: 0.95rem; margin: 0; line-height: 1.6;">
                        "Melayani dengan komitmen penuh pada kualitas, kenyamanan, dan ketepatan waktu."
                    </p>
                </div>
            </div>
        </div>

        <!-- Mengapa Memilih Kami Section -->
        <div class="row mt-5 pt-4">
            <div class="col-12 text-center mb-5">
                <h6 style="color: #475467; font-weight: 600; margin-bottom: 12px; font-size: 1.05rem;">Mengapa Memilih Kami?</h6>
                <p style="color: #667085; font-size: 0.95rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">Komitmen kami untuk memberikan pengalaman perjalanan yang tak terlupakan dengan standar layanan tertinggi.</p>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-shield-alt" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Keamanan Terjamin</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Armada terawat secara berkala dengan standar keamanan operasional yang ketat.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-bus" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Armada Mewah</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Fasilitas premium dalam kabin untuk kenyamanan maksimal sepanjang perjalanan.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-id-badge" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Driver Profesional</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Pengemudi berpengalaman dan bersertifikat yang memahami rute dengan baik.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-tag" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Harga Terbaik</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Penawaran harga transparan dan kompetitif tanpa biaya tersembunyi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== GALLERY SECTION ===================== -->
<section id="galeri" class="gallery-section py-5" style="background-color: #f8fafc; border-top: 1px solid #eaecf0;">
    <div class="container py-4">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h6 style="color: #1a3bb5; font-weight: 700; margin-bottom: 12px; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px;">Galeri Kami</h6>
                <h2 class="mb-4 fw-bold" style="color: #1e293b;">Momen Tak Terlupakan Bersama Dheemobilindo</h2>
                <p style="color: #64748b; font-size: 1.05rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                    Intip kemewahan armada kami dan keceriaan wisatawan yang telah mempercayakan perjalanannya kepada kami.
                </p>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
                <button class="gallery-filter-btn active" data-filter="all">Semua</button>
                <button class="gallery-filter-btn" data-filter="armada">Armada Bus</button>
                <button class="gallery-filter-btn" data-filter="wisatawan">Keseruan Wisatawan</button>
            </div>
        </div>

        <!-- Swipe indicator helper for mobile -->
        <div class="d-md-none text-center mb-3 text-muted small" style="letter-spacing: 0.5px;">
            <i class="fas fa-arrows-alt-h me-1"></i> Geser kiri/kanan untuk melihat momen
        </div>
    </div> <!-- Close standard container to allow full-width collage -->

    <!-- Full Width Fluid Container for Gallery Collage -->
    <div class="container-fluid px-3">
        <!-- Bento Grid Gallery -->
        <div class="gallery-bento-grid">
            <!-- Item 1 (Large - Armada) -->
            <div class="bento-item item-large" data-category="armada" onclick="openLightbox(this)">
                <img src="<?= base_url('assets/img/bus_dru.jpg') ?>" alt="Executive Bus">
                <div class="bento-overlay">
                    <div class="bento-content">
                        <div class="bento-icon"><i class="fas fa-bus"></i></div>
                        <h5>Armada Premium</h5>
                        <p>Kenyamanan Eksekutif 50 Kursi</p>
                    </div>
                </div>
            </div>

            <!-- Item 2 (Wisatawan) -->
            <div class="bento-item" data-category="wisatawan" onclick="openLightbox(this)">
                <img src="<?= base_url('assets/img/bus_hero.png') ?>" alt="Keseruan Wisatawan">
                <div class="bento-overlay">
                    <div class="bento-content">
                        <div class="bento-icon"><i class="fas fa-camera-retro"></i></div>
                        <h5>Momen Wisata</h5>
                        <p>Perjalanan Menyenangkan</p>
                    </div>
                </div>
            </div>

            <!-- Item 3 (Armada) -->
            <div class="bento-item" data-category="armada" onclick="openLightbox(this)">
                <img src="<?= base_url('assets/img/bus/0116c23f3745207151cf5efa0647a900.jpeg') ?>" alt="Interior Bus">
                <div class="bento-overlay">
                    <div class="bento-content">
                        <div class="bento-icon"><i class="fas fa-couch"></i></div>
                        <h5>Interior Mewah</h5>
                        <p>Fasilitas Lengkap</p>
                    </div>
                </div>
            </div>

            <!-- Item 4 (Tall - Wisatawan) -->
            <div class="bento-item item-tall" data-category="wisatawan" onclick="openLightbox(this)">
                <img src="<?= base_url('assets/img/bus/1b3d1e20b415c2d50ca62d8579d9086b.jpeg') ?>" alt="Trip Keluarga">
                <div class="bento-overlay">
                    <div class="bento-content">
                        <div class="bento-icon"><i class="fas fa-users"></i></div>
                        <h5>Gathering Keluarga</h5>
                        <p>Aman dan Nyaman</p>
                    </div>
                </div>
            </div>

            <!-- Item 5 (Armada) -->
            <div class="bento-item" data-category="armada" onclick="openLightbox(this)">
                <img src="<?= base_url('assets/img/bus/3473fb8ea2fe44e83aec89a65399e184.jpeg') ?>" alt="Eksterior Bus">
                <div class="bento-overlay">
                    <div class="bento-content">
                        <div class="bento-icon"><i class="fas fa-road"></i></div>
                        <h5>Siap Meluncur</h5>
                        <p>Mesin Prima Terawat</p>
                    </div>
                </div>
            </div>

            <!-- Item 6 (Wide - Armada) -->
            <div class="bento-item item-wide" data-category="armada" onclick="openLightbox(this)">
                <img src="<?= base_url('assets/img/bus/d1d622d18464c3c4baa76414b9be9def.jpeg') ?>" alt="Armada Berjejer">
                <div class="bento-overlay">
                    <div class="bento-content">
                        <div class="bento-icon"><i class="fas fa-star"></i></div>
                        <h5>Pilihan Lengkap</h5>
                        <p>Tersedia Berbagai Kapasitas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div id="galleryLightbox" class="lightbox-modal">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img class="lightbox-content" id="lightboxImg">
        <div id="lightboxCaption" class="lightbox-caption"></div>
    </div>

    <style>
        /* Filter Buttons */
        .gallery-filter-btn {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 8px 20px;
            border-radius: 30px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .gallery-filter-btn:hover {
            background: #f1f5f9;
            color: #1e293b;
            transform: translateY(-2px);
        }
        .gallery-filter-btn.active {
            background: #1a3bb5;
            color: #ffffff;
            border-color: #1a3bb5;
            box-shadow: 0 4px 12px rgba(26, 59, 181, 0.3);
        }

        /* Masonry Grid Layout (True Collage) */
        .gallery-bento-grid {
            column-count: 3;
            column-gap: 16px;
            width: 100%;
        }

        .bento-item {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            display: inline-block;
            width: 100%;
            margin-bottom: 16px;
            break-inside: avoid;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s ease;
        }

        .bento-item img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @media (max-width: 991px) {
            .gallery-bento-grid {
                column-count: 2;
            }
        }

        @media (max-width: 768px) {
            .gallery-bento-grid {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                gap: 16px;
                padding: 10px 4px 20px 4px;
                column-count: unset;
                column-gap: unset;
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
            .gallery-bento-grid::-webkit-scrollbar {
                display: none;
            }
            .bento-item {
                flex: 0 0 85%;
                width: 85%;
                height: 280px;
                scroll-snap-align: start;
                display: block;
                margin-bottom: 0;
            }
            .bento-item img {
                height: 100%;
                object-fit: cover;
            }
            .bento-overlay {
                opacity: 1;
                background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.2) 60%, transparent 100%);
            }
            .bento-content {
                transform: translateY(0);
            }
        }

        .bento-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .bento-item:hover img {
            transform: scale(1.08);
        }

        /* Glassmorphic Overlay */
        .bento-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.2) 50%, transparent 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            display: flex;
            align-items: flex-end;
            padding: 24px;
        }

        .bento-item:hover .bento-overlay {
            opacity: 1;
        }

        .bento-content {
            transform: translateY(20px);
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            color: #ffffff;
            width: 100%;
        }

        .bento-item:hover .bento-content {
            transform: translateY(0);
        }

        .bento-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 1.1rem;
            color: #ffffff;
        }

        .bento-content h5 {
            margin: 0 0 4px 0;
            font-weight: 700;
            font-size: 1.15rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .bento-content p {
            margin: 0;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        /* Filtering Animation */
        .bento-item.hide {
            display: none;
        }

        /* Lightbox CSS */
        .lightbox-modal {
            display: none; 
            position: fixed; 
            z-index: 9999; 
            padding-top: 60px; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            overflow: hidden; 
            background-color: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lightbox-modal.show {
            display: block;
            opacity: 1;
        }

        .lightbox-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 80vh;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .lightbox-modal.show .lightbox-content {
            transform: scale(1);
        }

        .lightbox-caption {
            margin: 20px auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #e2e8f0;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .lightbox-close {
            position: absolute;
            top: 25px;
            right: 45px;
            color: #f1f5f9;
            font-size: 40px;
            font-weight: 100;
            cursor: pointer;
            transition: 0.3s;
        }

        .lightbox-close:hover,
        .lightbox-close:focus {
            color: #1a3bb5;
            text-decoration: none;
            cursor: pointer;
            transform: scale(1.1);
        }
    </style>

    <script>
        // Filtering Logic
        document.addEventListener("DOMContentLoaded", function() {
            const filterBtns = document.querySelectorAll('.gallery-filter-btn');
            const bentoItems = document.querySelectorAll('.bento-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    btn.classList.add('active');

                    const filterValue = btn.getAttribute('data-filter');

                    bentoItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.classList.remove('hide');
                            // Add a slight animation effect when showing
                            item.style.animation = 'none';
                            item.offsetHeight; /* trigger reflow */
                            item.style.animation = 'fadeInUp 0.4s ease forwards';
                        } else {
                            item.classList.add('hide');
                        }
                    });
                });
            });
        });

        // Keyframe for filter animation
        const styleSheet = document.createElement("style");
        styleSheet.type = "text/css";
        styleSheet.innerText = `@keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }`;
        document.head.appendChild(styleSheet);

        // Lightbox Logic
        const lightbox = document.getElementById('galleryLightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const lightboxCaption = document.getElementById('lightboxCaption');

        function openLightbox(element) {
            const img = element.querySelector('img');
            const title = element.querySelector('h5').innerText;
            const subtitle = element.querySelector('p').innerText;
            
            lightbox.classList.add('show');
            lightboxImg.src = img.src;
            lightboxCaption.innerHTML = `<strong>${title}</strong> - ${subtitle}`;
            
            // Prevent scrolling on body
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('show');
            // Restore scrolling
            document.body.style.overflow = 'auto';
        }

        // Close when clicking outside image
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Escape key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape" && lightbox.classList.contains('show')) {
                closeLightbox();
            }
        });
    </script>
</section>

<!-- KONTAK SECTION -->
<section id="kontak" class="contact-section py-5" style="background-color: #f9fafb;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 col-12 mb-5">
                <h2 class="mb-4 pb-2 fw-bold" style="color: #1e293b;">Hubungi Kami</h2>
                <p style="color: #64748b; line-height: 1.7; font-size: 1.05rem; max-width: 90%;">
                    Armada bus premium kami siap mengantarkan Anda ke mana saja. Pesan sekarang dan nikmati pengalaman perjalanan terbaik bersama Dheemobilindo.
                </p>
                
                <div class="mt-5 mb-5 p-4 rounded-3" style="background-color: #ffffff; border: 1px solid #e2e8f0;">
                    <h5 class="mb-3 fw-bold" style="color: #0f172a;">Informasi Kontak</h5>
                    <p class="mb-3 d-flex align-items-center" style="color: #475569; font-size: 1.05rem;">
                        <i class="fas fa-phone-alt me-3" style="color: #1a3bb5; width: 20px; text-align: center;"></i> 
                        <a href="tel:+6281234567890" style="text-decoration:none; color:inherit; font-weight: 500;">+62 812-3456-7890</a>
                    </p>
                    <p class="mb-2 d-flex align-items-center" style="color: #475569; font-size: 1.05rem;">
                        <i class="fas fa-envelope me-3" style="color: #1a3bb5; width: 20px; text-align: center;"></i> 
                        <a href="mailto:info@dheemobilindo.com" style="text-decoration:none; color:inherit; font-weight: 500;">info@dheemobilindo.com</a>
                    </p>
                </div>
                
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Dheemobilindo%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20sewa%20bus." target="_blank" class="btn" style="background: #25D366; color: white; border-radius: 8px; padding: 14px 28px; font-weight: 600; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(37, 211, 102, 0.4)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(37, 211, 102, 0.3)';">
                    <i class="bi bi-whatsapp me-2" style="font-size: 1.1rem;"></i> Hubungi via WhatsApp
                </a>
            </div>

            <div class="col-lg-6 col-md-10 col-12">
                <div class="h-100">
                    <!-- Google Maps Embed -->
                    <iframe src="https://maps.google.com/maps?q=Dheemobilindo&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="min-height: 400px; border:0; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="text-end mt-3">
                        <a href="https://maps.app.goo.gl/2USqzXK78n1Z3rRg6" target="_blank" style="font-size: 0.9rem; color: #1a3bb5; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-external-link-alt me-1"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===================== REVIEWS SECTION ===================== -->
<section id="ulasan" class="reviews-section py-5" style="background-color: #ffffff; border-top: 1px solid #eaecf0;">
    <div class="container py-4">
        <div class="row align-items-center">
            
            <!-- Left Side: Summary -->
            <div class="col-lg-3 col-md-4 mb-5 mb-md-0 text-center">
                <div class="d-inline-block mb-3" style="width: 70px; height: 70px; border-radius: 50%; overflow: hidden; border: 2px solid #eaecf0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    <img src="<?= base_url('assets/img/bus_dru.jpg') ?>" alt="Dheemobilindo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h4 class="font-weight-bold" style="color: #1e293b; font-size: 1.25rem; margin-bottom: 5px;">Dheemobilindo</h4>
                
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                    <span style="color: #f59e0b; font-weight: 700; font-size: 1.2rem;"><?= isset($avg_rating) ? $avg_rating : '5.0' ?></span>
                    <div style="color: #f59e0b; font-size: 1.1rem;">
                        <?php 
                        $avg = isset($avg_rating) ? round($avg_rating) : 5;
                        for($i=1; $i<=5; $i++) {
                            echo '<i class="fas fa-star" '.($i > $avg ? 'style="color: #e2e8f0;"' : '').'></i>';
                        }
                        ?>
                    </div>
                </div>
                
                <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 10px;">
                    Berdasarkan <?= isset($total_reviews) ? $total_reviews : 0 ?> ulasan
                </p>
                
                <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 15px;">
                    didukung oleh 
                    <span style="font-weight: 600; letter-spacing: -0.3px;">
                        <span style="color: #4285F4;">G</span><span style="color: #EA4335;">o</span><span style="color: #FBBC05;">o</span><span style="color: #4285F4;">g</span><span style="color: #34A853;">l</span><span style="color: #EA4335;">e</span>
                    </span>
                </div>
                
                <a href="https://www.google.com/search?sca_esv=f309c00a8710a5de&hl=en-ID&gl=id&sxsrf=ANbL-n6SVlNJqWujlr7pO5Dd3SodLDws3w:1780347958318&si=AL3DRZEsmMGCryMMFSHJ3StBhOdZ2-6yYkXd_doETEE1OR-qOczLCpMq1tcuVRaknNmo0WPh3gft5xk5FkSX4iBuOSAM3MEiEptdlRmoVFSxJmO-tCQ42rf0cXCxe4n9Ne2k0NX5gzFEvtjl07oUKVVAgJG-p-bT6BX1_kYkUX5wsg4aM1NiDvc%3D&q=Pool+bus+pariwisata+dheemobilindo+Reviews&sa=X&ved=2ahUKEwiHh4f9-OaUAxWpyzgGHUQ9J1UQ0bkNegQIJBAF&biw=1280&bih=585&dpr=1.5#lrd=0x2e68ef3487a0b151:0x72e2de868605dabb,3,,,," target="_blank" class="btn btn-primary" style="background-color: #4285F4; border: none; border-radius: 20px; padding: 8px 20px; font-size: 0.85rem; font-weight: 600; box-shadow: 0 2px 5px rgba(66, 133, 244, 0.3);">
                    ulas kami di <i class="fab fa-google ml-1" style="background: #fff; color: #4285F4; border-radius: 50%; padding: 3px; font-size: 0.7rem;"></i>
                </a>
            </div>
            
            <!-- Right Side: Review Cards Slider -->
            <div class="col-lg-9 col-md-8 relative">
                <div class="review-slider-container">
                    <button class="review-btn review-prev" onclick="scrollReviews(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="review-track" id="reviewTrack">
                        <?php if(!empty($reviews)): ?>
                            <?php 
                            $colors = ['#EA4335', '#FBBC05', '#34A853', '#4285F4', '#8E44AD', '#E67E22'];
                            foreach($reviews as $index => $r): 
                                $initial = strtoupper(substr($r['customer_name'] ?? 'U', 0, 1));
                                $bgColor = $colors[$index % count($colors)];
                                
                                // Calculate time ago
                                $time_ago = '';
                                $diff = time() - strtotime($r['created_at']);
                                if($diff < 86400) $time_ago = 'Hari ini';
                                elseif($diff < 2592000) $time_ago = floor($diff/86400) . ' hari yang lalu';
                                elseif($diff < 31536000) $time_ago = floor($diff/2592000) . ' bulan yang lalu';
                                else $time_ago = floor($diff/31536000) . ' tahun yang lalu';
                            ?>
                            <div class="review-card">
                                <div class="review-card-header">
                                    <div class="d-flex align-items-center">
                                        <div class="review-avatar" style="background-color: <?= $bgColor ?>;">
                                            <?= $initial ?>
                                        </div>
                                        <div>
                                            <div class="review-name"><?= htmlspecialchars($r['customer_name'] ?? 'User') ?></div>
                                            <div class="review-time"><?= $time_ago ?></div>
                                        </div>
                                    </div>
                                    <div class="review-g-icon">
                                        <span style="color: #4285F4;">G</span>
                                    </div>
                                </div>
                                <div class="review-stars">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="fas fa-star" <?= $i > $r['rating'] ? 'style="color: #e2e8f0;"' : '' ?>></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="review-text">
                                    <?= nl2br(htmlspecialchars($r['review_text'] ?? '')) ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-4 text-center w-100" style="color: #64748b;">Belum ada ulasan.</div>
                        <?php endif; ?>
                    </div>
                    
                    <button class="review-btn review-next" onclick="scrollReviews(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</section>

<style>
    .review-slider-container {
        position: relative;
        padding: 0 40px;
    }
    .review-track {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 20px;
        padding: 10px 0 20px 0;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE/Edge */
        scroll-snap-type: x mandatory;
    }
    .review-track::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
    }
    .review-card {
        flex: 0 0 300px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        scroll-snap-align: start;
    }
    .review-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .review-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
        margin-right: 12px;
    }
    .review-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
        line-height: 1.2;
    }
    .review-time {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-top: 2px;
    }
    .review-g-icon {
        font-weight: 800;
        font-size: 1.1rem;
    }
    .review-stars {
        color: #f59e0b;
        font-size: 0.9rem;
        margin-bottom: 12px;
    }
    .review-text {
        color: #475569;
        font-size: 0.9rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .review-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #64748b;
        z-index: 5;
        transition: all 0.2s;
    }
    .review-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .review-prev { left: 0; }
    .review-next { right: 0; }
    
    @media (max-width: 767px) {
        .review-slider-container { padding: 0 20px; }
        .review-prev { left: -10px; }
        .review-next { right: -10px; }
        .review-card { flex: 0 0 260px; padding: 20px; scroll-snap-align: start; }
    }
</style>

<script>
function scrollReviews(direction) {
    const track = document.getElementById('reviewTrack');
    const scrollAmount = 320; // width of card + gap
    track.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
}
</script>

<!-- ===================== THREE.JS — FULL-BLEED 3D BUS BACKGROUND ===================== -->
<script>
    var APP_BASE_URL = '<?= base_url() ?>';
</script>

<script type="importmap">
{
    "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three@0.163.0/build/three.module.js"
    }
}
</script>

<script type="module">
import * as THREE from 'three';

// ── DOM Elements ──
const canvas = document.getElementById('hero3dCanvas');
const section = document.querySelector('.hero-3d-section');
if (!canvas || !section) throw new Error('Hero 3D canvas not found');

// ── Scene ──
const scene = new THREE.Scene();
scene.background = new THREE.Color(0x060a10);
scene.fog = new THREE.FogExp2(0x060a10, 0.028);

// ── Camera ──
const camera = new THREE.PerspectiveCamera(48, section.clientWidth / section.clientHeight, 0.1, 200);
camera.position.set(0, 2.4, 8.5);
camera.lookAt(0, 1.6, 0);

// ── Renderer ──
const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: false });
renderer.setSize(section.clientWidth, section.clientHeight);
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.15;

// ── Ambient Lighting ──
scene.add(new THREE.AmbientLight(0x223344, 0.4));
scene.add(new THREE.HemisphereLight(0x1a2a4a, 0x0a0a0a, 0.25));

// ── Key Light (upper-right, warm) ──
const keyLight = new THREE.DirectionalLight(0xffeedd, 0.6);
keyLight.position.set(6, 10, 5);
scene.add(keyLight);

// ── Rim Light (behind bus, gold accent) ──
const rimLight = new THREE.DirectionalLight(0xE0A96D, 0.4);
rimLight.position.set(0, 5, -8);
scene.add(rimLight);

// ═══════════════════════════════════════════════════
// ── REFLECTIVE FLOOR ──
// ═══════════════════════════════════════════════════
const floorGeom = new THREE.PlaneGeometry(60, 60);
const floorMat = new THREE.MeshStandardMaterial({
    color: 0x040608,
    metalness: 0.96,
    roughness: 0.12,
    envMapIntensity: 0.5
});
const floor = new THREE.Mesh(floorGeom, floorMat);
floor.rotation.x = -Math.PI / 2;
floor.position.y = -0.05;
floor.receiveShadow = true;
scene.add(floor);

// Floor grid lines (subtle)
const gridHelper = new THREE.GridHelper(50, 60, 0x111822, 0x0c1018);
gridHelper.position.y = 0.01;
gridHelper.material.opacity = 0.3;
gridHelper.material.transparent = true;
scene.add(gridHelper);

// ═══════════════════════════════════════════════════
// ── BUS IMAGE PLANE (bus_dru.jpg as 3D element) ──
// ═══════════════════════════════════════════════════
const busTextureLoader = new THREE.TextureLoader();
const busTexture = busTextureLoader.load(APP_BASE_URL + 'assets/img/bus_dru.jpg', (tex) => {
    // Hide loading overlay once texture is loaded
    setTimeout(() => {
        const ld = document.getElementById('heroLoading');
        if (ld) ld.classList.add('loaded');
    }, 400);
});
busTexture.colorSpace = THREE.SRGBColorSpace;
busTexture.minFilter = THREE.LinearFilter;
busTexture.magFilter = THREE.LinearFilter;

// Custom ShaderMaterial with soft vignette edges
const busVertexShader = `
    varying vec2 vUv;
    void main() {
        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
    }
`;

const busFragmentShader = `
    uniform sampler2D busMap;
    uniform float uOpacity;
    varying vec2 vUv;
    void main() {
        vec4 texColor = texture2D(busMap, vUv);
        
        // Soft oval vignette — fades edges to transparent
        vec2 centered = (vUv - 0.5) * 2.0;
        float vignetteX = 1.0 - smoothstep(0.6, 1.0, abs(centered.x));
        float vignetteY = 1.0 - smoothstep(0.65, 1.0, abs(centered.y));
        // Stronger fade at bottom to blend with floor
        float bottomFade = smoothstep(-1.0, -0.3, centered.y);
        float alpha = vignetteX * vignetteY * bottomFade * uOpacity;
        
        gl_FragColor = vec4(texColor.rgb, alpha);
    }
`;

const busMaterial = new THREE.ShaderMaterial({
    uniforms: {
        busMap: { value: busTexture },
        uOpacity: { value: 1.0 }
    },
    vertexShader: busVertexShader,
    fragmentShader: busFragmentShader,
    transparent: true,
    depthWrite: false,
    side: THREE.DoubleSide
});

// Bus plane — large, positioned as the hero focal point
const busPlane = new THREE.Mesh(
    new THREE.PlaneGeometry(13, 8.2),
    busMaterial
);
busPlane.position.set(0, 3.8, -3);
scene.add(busPlane);

// ── Bus reflection on floor ──
const reflectionMat = new THREE.ShaderMaterial({
    uniforms: {
        busMap: { value: busTexture },
        uOpacity: { value: 0.18 }
    },
    vertexShader: busVertexShader,
    fragmentShader: busFragmentShader,
    transparent: true,
    depthWrite: false,
    side: THREE.DoubleSide
});

const busReflection = new THREE.Mesh(
    new THREE.PlaneGeometry(13, 8.2),
    reflectionMat
);
busReflection.position.set(0, -3.9, -3);
busReflection.scale.y = -1;
scene.add(busReflection);

// ═══════════════════════════════════════════════════
// ── HEADLIGHT SPOTLIGHTS ──
// ═══════════════════════════════════════════════════
const spot1 = new THREE.SpotLight(0xffffcc, 18, 30, Math.PI / 5.5, 0.55, 1.8);
spot1.position.set(-2.2, 2.2, 0.5);
spot1.target.position.set(-5, 0, 12);
spot1.castShadow = true;
spot1.shadow.mapSize.set(512, 512);
scene.add(spot1);
scene.add(spot1.target);

const spot2 = new THREE.SpotLight(0xffffcc, 18, 30, Math.PI / 5.5, 0.55, 1.8);
spot2.position.set(2.2, 2.2, 0.5);
spot2.target.position.set(5, 0, 12);
spot2.castShadow = true;
spot2.shadow.mapSize.set(512, 512);
scene.add(spot2);
scene.add(spot2.target);

// ── Headlight glow orbs (lens flare effect) ──
const glowMat = new THREE.MeshBasicMaterial({
    color: 0xffffdd,
    transparent: true,
    opacity: 0.7,
    depthWrite: false
});
const glow1 = new THREE.Mesh(new THREE.SphereGeometry(0.15, 12, 12), glowMat);
glow1.position.set(-2.2, 2.2, 0.6);
scene.add(glow1);

const glow2 = new THREE.Mesh(new THREE.SphereGeometry(0.15, 12, 12), glowMat.clone());
glow2.position.set(2.2, 2.2, 0.6);
scene.add(glow2);

// ═══════════════════════════════════════════════════
// ── UNDERGLOW LIGHTS ──
// ═══════════════════════════════════════════════════
const ugLights = [];
const ugPositions = [
    { x: -3, z: -1 }, { x: -1.5, z: -1 }, { x: 0, z: -1 },
    { x: 1.5, z: -1 }, { x: 3, z: -1 }
];
ugPositions.forEach(pos => {
    const pl = new THREE.PointLight(0xff8800, 5, 6, 2);
    pl.position.set(pos.x, 0.15, pos.z);
    scene.add(pl);
    ugLights.push(pl);
});

// ═══════════════════════════════════════════════════
// ── FLOATING PARTICLES ──
// ═══════════════════════════════════════════════════
const PARTICLE_COUNT = 400;
const particleGeom = new THREE.BufferGeometry();
const pPositions = new Float32Array(PARTICLE_COUNT * 3);
const pSizes = new Float32Array(PARTICLE_COUNT);
const pSpeeds = new Float32Array(PARTICLE_COUNT); // drift speed per particle

for (let i = 0; i < PARTICLE_COUNT; i++) {
    pPositions[i * 3]     = (Math.random() - 0.5) * 35;      // x
    pPositions[i * 3 + 1] = Math.random() * 16;               // y
    pPositions[i * 3 + 2] = (Math.random() - 0.5) * 25 - 3;  // z
    pSizes[i] = 0.02 + Math.random() * 0.05;
    pSpeeds[i] = 0.002 + Math.random() * 0.006;
}

particleGeom.setAttribute('position', new THREE.BufferAttribute(pPositions, 3));
particleGeom.setAttribute('size', new THREE.BufferAttribute(pSizes, 1));

const particleMat = new THREE.PointsMaterial({
    color: 0xE0A96D,
    size: 0.045,
    transparent: true,
    opacity: 0.5,
    blending: THREE.AdditiveBlending,
    depthWrite: false,
    sizeAttenuation: true
});
const particles = new THREE.Points(particleGeom, particleMat);
scene.add(particles);

// ═══════════════════════════════════════════════════
// ── DECORATIVE: Ambient glow spheres ──
// ═══════════════════════════════════════════════════
const glowSphere1 = new THREE.Mesh(
    new THREE.SphereGeometry(3, 24, 24),
    new THREE.MeshBasicMaterial({ color: 0xE0A96D, transparent: true, opacity: 0.018, depthWrite: false })
);
glowSphere1.position.set(-5, 4, -8);
scene.add(glowSphere1);

const glowSphere2 = new THREE.Mesh(
    new THREE.SphereGeometry(2.5, 24, 24),
    new THREE.MeshBasicMaterial({ color: 0x4488ff, transparent: true, opacity: 0.012, depthWrite: false })
);
glowSphere2.position.set(6, 6, -10);
scene.add(glowSphere2);

// ═══════════════════════════════════════════════════
// ── MOUSE PARALLAX ──
// ═══════════════════════════════════════════════════
let mouseNX = 0, mouseNY = 0; // normalized mouse [-1, 1]
const baseCamPos = { x: 0, y: 2.4, z: 8.5 };
const parallaxStrength = { x: 1.5, y: 0.6 };

section.addEventListener('pointermove', (e) => {
    const rect = section.getBoundingClientRect();
    mouseNX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
    mouseNY = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
});

// Reset parallax when pointer leaves
section.addEventListener('pointerleave', () => {
    mouseNX = 0;
    mouseNY = 0;
});

// ═══════════════════════════════════════════════════
// ── INTERACTIVITY ──
// ═══════════════════════════════════════════════════
let headlightsOn = true;
let underglowOn = true;

window.toggleHeadlights = () => {
    headlightsOn = !headlightsOn;
    spot1.visible = headlightsOn;
    spot2.visible = headlightsOn;
    glow1.visible = headlightsOn;
    glow2.visible = headlightsOn;

    const btn = document.getElementById('btnHeadlights');
    if (headlightsOn) {
        btn.classList.add('ctrl-btn-active');
    } else {
        btn.classList.remove('ctrl-btn-active');
    }
};

window.toggleUnderglow = () => {
    underglowOn = !underglowOn;
    ugLights.forEach(l => l.visible = underglowOn);

    const btn = document.getElementById('btnUnderglow');
    if (underglowOn) {
        btn.classList.add('ctrl-btn-active');
    } else {
        btn.classList.remove('ctrl-btn-active');
    }
};

// ═══════════════════════════════════════════════════
// ── ANIMATION LOOP ──
// ═══════════════════════════════════════════════════
const clock = new THREE.Clock();

function animate() {
    requestAnimationFrame(animate);
    const elapsed = clock.getElapsedTime();

    // ── Smooth camera parallax ──
    const targetX = baseCamPos.x + mouseNX * parallaxStrength.x;
    const targetY = baseCamPos.y - mouseNY * parallaxStrength.y;
    camera.position.x += (targetX - camera.position.x) * 0.035;
    camera.position.y += (targetY - camera.position.y) * 0.035;
    camera.lookAt(0, 1.6, 0);

    // ── Bus gentle float ──
    busPlane.position.y = 3.8 + Math.sin(elapsed * 0.6) * 0.08;
    busReflection.position.y = -3.8 - Math.sin(elapsed * 0.6) * 0.08;

    // ── Underglow pulse ──
    if (underglowOn) {
        const pulse = 4.0 + Math.sin(elapsed * 1.8) * 1.5;
        ugLights.forEach(l => l.intensity = pulse);
    }

    // ── Headlight glow pulse ──
    if (headlightsOn) {
        const glowPulse = 0.55 + Math.sin(elapsed * 2.5) * 0.15;
        glow1.material.opacity = glowPulse;
        glow2.material.opacity = glowPulse;
    }

    // ── Animate particles (drift upward with slight sway) ──
    const posArr = particles.geometry.attributes.position.array;
    for (let i = 0; i < PARTICLE_COUNT; i++) {
        posArr[i * 3 + 1] += pSpeeds[i]; // y drift up
        posArr[i * 3]     += Math.sin(elapsed + i) * 0.001; // x sway

        // Reset particles that drift too high
        if (posArr[i * 3 + 1] > 16) {
            posArr[i * 3 + 1] = -1;
            posArr[i * 3]     = (Math.random() - 0.5) * 35;
            posArr[i * 3 + 2] = (Math.random() - 0.5) * 25 - 3;
        }
    }
    particles.geometry.attributes.position.needsUpdate = true;

    // ── Subtle particle rotation for extra depth ──
    particles.rotation.y = elapsed * 0.008;

    renderer.render(scene, camera);
}
animate();

// ═══════════════════════════════════════════════════
// ── RESPONSIVE RESIZE ──
// ═══════════════════════════════════════════════════
const resizeObserver = new ResizeObserver(() => {
    const w = section.clientWidth;
    const h = section.clientHeight;
    if (w === 0 || h === 0) return;
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
});
resizeObserver.observe(section);

</script>

<?php $this->load->view('public/layout/footer'); ?>
