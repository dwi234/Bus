<?php $this->load->view('public/layout/header'); ?>
<style>
/* Hero Header */
        .page-header { padding: 48px 0 32px; }
        .page-header h1 { font-size: 2.2rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 8px; }
        .page-header p { color: #667085; font-size: 1rem; line-height: 1.6; }

        /* Search Card */
        .search-card {
            background: #fff; border-radius: 16px; padding: 32px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04); border: 1px solid #eaecf0;
            margin-bottom: 32px;
        }
        .search-form { display: flex; gap: 12px; align-items: flex-end; }
        .search-form .fg { flex: 1; }
        .search-form label { display: block; font-weight: 600; font-size: 0.85rem; color: #344054; margin-bottom: 6px; }
        .search-form input {
            width: 100%; padding: 12px 16px; border: 1px solid #d0d5dd; border-radius: 8px;
            font-size: 0.95rem; font-family: 'Inter', sans-serif; transition: border-color 0.2s;
        }
        .search-form input:focus { outline: none; border-color: #1a3bb5; box-shadow: 0 0 0 3px rgba(26,59,181,0.1); }
        .search-btn {
            padding: 12px 28px; background: #1a3bb5; color: #fff; border: none; border-radius: 8px;
            font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;
            font-family: 'Inter', sans-serif; white-space: nowrap;
        }
        .search-btn:hover { background: #1530a0; }

        /* Stepper */
        .stepper { display: flex; align-items: center; margin-bottom: 40px; }
        .step { display: flex; flex-direction: column; align-items: center; flex: 1; position: relative; }
        .step-icon {
            width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; z-index: 2; transition: all 0.3s;
        }
        .step-icon.done { background: #1a3bb5; color: #fff; }
        .step-icon.current { background: #1a3bb5; color: #fff; }
        .step-icon.pending { background: #eaecf0; color: #98a2b3; }
        .step-label { margin-top: 8px; font-size: 0.78rem; font-weight: 600; color: #667085; }
        .step-label.active-label { color: #1a3bb5; }
        .step-line {
            position: absolute; top: 22px; left: 50%; width: 100%; height: 2px;
            background: #eaecf0; z-index: 1;
        }
        .step-line.done-line { background: #1a3bb5; }
        .step:last-child .step-line { display: none; }

        /* Booking Cards List */
        .booking-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 60px; }
        .booking-card {
            background: #fff; border-radius: 14px; border: 1px solid #eaecf0;
            padding: 24px 28px; display: flex; align-items: center; gap: 24px;
            transition: all 0.3s; cursor: pointer;
        }
        .booking-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.06); transform: translateY(-2px); border-color: #1a3bb5; }

        .bc-icon {
            width: 56px; height: 56px; border-radius: 12px;
            background: linear-gradient(135deg, #1a3bb5 0%, #4e73df 100%);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.4rem; flex-shrink: 0;
        }
        .bc-info { flex: 1; }
        .bc-info h3 { font-size: 1rem; font-weight: 700; margin-bottom: 4px; }
        .bc-info .bc-meta { font-size: 0.83rem; color: #667085; display: flex; gap: 16px; flex-wrap: wrap; }
        .bc-info .bc-meta span { display: flex; align-items: center; gap: 4px; }
        .bc-right { text-align: right; flex-shrink: 0; }
        .bc-price { font-size: 1.1rem; font-weight: 800; color: #1a3bb5; margin-bottom: 6px; }
        .bc-status {
            display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;
        }
        .status-pending { background: #fffbeb; color: #b45309; }
        .status-uang_muka_dibayarkan { background: #e0f2fe; color: #0369a1; }
        .status-menunggu_pelunasan { background: #fef3f2; color: #b42318; }
        .status-siap_berangkat { background: #ecfdf5; color: #065f46; }
        .status-sedang_berlangsung { background: #eef2ff; color: #3730a3; }
        .status-selesai { background: #f0fdf4; color: #166534; }
        .status-batal { background: #fef2f2; color: #991b1b; }

        /* Empty State */
        .empty-state {
            text-align: center; padding: 60px 24px; background: #fff;
            border-radius: 16px; border: 1px solid #eaecf0;
        }
        .empty-icon { font-size: 3rem; color: #d0d5dd; margin-bottom: 16px; }
        .empty-state h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 6px; }
        .empty-state p { font-size: 0.9rem; color: #667085; }

        /* Footer */
        .footer-mini {
            text-align: center; padding: 24px 0; color: #98a2b3; font-size: 0.8rem;
            border-top: 1px solid #eaecf0; margin-top: 40px;
        }

        /* Alert */
        .alert-landing { padding: 14px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500; }
        .alert-landing-danger { background: #fef3f2; color: #b42318; border: 1px solid #fecdca; }

        @media (max-width: 768px) {
            .search-form { flex-direction: column; }
            .booking-card { flex-direction: column; text-align: center; }
            .bc-right { text-align: center; }
            .nav-links { display: none; }
        }
    </style>
<div class="container">
        <!-- Page Header -->
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>My Bookings</h1>
                <p>Track the status of your reservations, <strong><?= htmlspecialchars($this->session->userdata('guest_name')) ?></strong>.</p>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert-landing alert-landing-danger">
                <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($bookings)): ?>
            <div class="booking-list">
                <?php foreach($bookings as $b): ?>
                    <a href="<?= base_url('home/booking_detail/' . $b['booking_id']) ?>" style="text-decoration: none; color: inherit;">
                        <div class="booking-card">
                            <div class="bc-icon"><i class="fas fa-bus-alt"></i></div>
                            <div class="bc-info">
                                <h3>#BK-<?= str_pad($b['booking_id'], 4, '0', STR_PAD_LEFT) ?> — <?= htmlspecialchars($b['bus_nama']) ?></h3>
                                <div class="bc-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($b['lokasi_penjemputan']) ?> → <?= htmlspecialchars($b['tempat_tujuan']) ?></span>
                                    <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($b['tanggal_keberangkatan'])) ?> - <?= date('d M Y', strtotime($b['tanggal_pulang'])) ?></span>
                                </div>
                            </div>
                            <div class="bc-right">
                                <div class="bc-price">Rp <?= number_format($b['total_harga'], 0, ',', '.') ?></div>
                                <?php
                                    $status_raw = $b['booking_status'];
                                    $status_label = ucwords(str_replace('_', ' ', $status_raw));
                                    $status_class = 'status-' . $status_raw;
                                ?>
                                <span class="bc-status <?= $status_class ?>"><i class="fas fa-circle" style="font-size: 6px;"></i> <?= $status_label ?></span>
                                <?php if($status_raw === 'selesai' && !empty($b['review_token'])): ?>
                                    <div style="margin-top: 10px;">
                                        <button onclick="window.location.href='<?= base_url('review/form/' . $b['review_token']) ?>'; event.preventDefault();" style="font-size: 0.8rem; font-weight: 600; padding: 4px 10px; border-radius: 6px; border: 1px solid #1a3bb5; background: transparent; color: #1a3bb5; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#1a3bb5'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='#1a3bb5';">
                                            <i class="fas fa-star"></i> Tulis Ulasan
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                <h3>Belum Ada Booking</h3>
                <p>Anda belum memiliki riwayat pemesanan. <a href="<?= base_url('home#booking') ?>" style="color:#1a3bb5; font-weight:600;">Pesan bus sekarang!</a></p>
            </div>
        <?php endif; ?>
    </div>

    
<?php $this->load->view('public/layout/footer'); ?>
