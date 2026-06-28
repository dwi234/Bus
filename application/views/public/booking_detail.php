<?php $this->load->view('public/layout/header'); ?>
<style>

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #1a1a2e; background: #f9fafb; }
        a { text-decoration: none; color: inherit; }

        /* Navbar */
        .navbar {
            position: sticky; top: 0; z-index: 1000; padding: 16px 0;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid #eaecf0;
        }
        .navbar .container { display: flex; align-items: center; justify-content: space-between; }
        .navbar-brand { display: flex; align-items: center; gap: 10px; }
        .navbar-brand img { height: 32px; }
        .navbar-brand span { font-weight: 800; font-size: 1.1rem; color: #1a3bb5; }
        .nav-links { display: flex; align-items: center; gap: 28px; list-style: none; }
        .nav-links a { font-weight: 500; font-size: 0.9rem; color: #344054; transition: color 0.2s; }
        .nav-links a:hover { color: #1a3bb5; }
        .nav-links a.active { color: #1a3bb5; font-weight: 700; border-bottom: 2px solid #1a3bb5; padding-bottom: 4px; }
        .nav-right { display: flex; align-items: center; gap: 12px; }

        .container { max-width: 1100px; margin: 0 auto; padding: 0 24px; }

        /* Page Header */
        .page-header { padding: 48px 0 12px; }
        .page-header h1 { font-size: 2.2rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 8px; }
        .page-header p { color: #667085; font-size: 1rem; line-height: 1.6; max-width: 600px; }

        /* Stepper */
        .stepper { display: flex; align-items: center; margin: 32px 0 40px; }
        .step { display: flex; flex-direction: column; align-items: center; flex: 1; position: relative; }
        .step-icon {
            width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; z-index: 2;
        }
        .step-icon.done { background: #1a3bb5; color: #fff; }
        .step-icon.current { background: #1a3bb5; color: #fff; }
        .step-icon.pending { background: #eaecf0; color: #98a2b3; }
        .step-label { margin-top: 8px; font-size: 0.78rem; font-weight: 600; color: #667085; }
        .step-label.active-label { color: #1a3bb5; }
        .step-line { position: absolute; top: 22px; left: 50%; width: 100%; height: 2px; background: #eaecf0; z-index: 1; }
        .step-line.done-line { background: #1a3bb5; }
        .step:last-child .step-line { display: none; }

        /* Main Grid */
        .detail-grid { display: grid; grid-template-columns: 1fr 380px; gap: 32px; margin-bottom: 60px; align-items: start; }

        /* Left Column */
        .detail-card {
            background: #fff; border-radius: 16px; border: 1px solid #eaecf0;
            padding: 28px 32px; margin-bottom: 24px;
        }
        .detail-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .detail-card-header h2 { font-size: 1.25rem; font-weight: 800; }
        .availability-badge {
            display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 50px;
            font-size: 0.75rem; font-weight: 700;
        }
        .badge-validated { background: #ecfdf5; color: #065f46; }
        .badge-pending { background: #fffbeb; color: #b45309; }
        .badge-confirmed { background: #e0f2fe; color: #0369a1; }
        .badge-active { background: #eef2ff; color: #3730a3; }
        .badge-done { background: #f0fdf4; color: #166534; }
        .badge-cancelled { background: #fef2f2; color: #991b1b; }
        .edit-link { font-size: 0.85rem; font-weight: 600; color: #1a3bb5; cursor: pointer; }
        .edit-link:hover { text-decoration: underline; }

        .info-boxes { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 8px; }
        .info-box {
            padding: 16px 20px; border-radius: 10px; border: 1px solid #eaecf0;
            background: #fff;
        }
        .info-box-label {
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;
            color: #98a2b3; margin-bottom: 8px;
        }
        .info-box-value { font-size: 0.95rem; font-weight: 600; color: #1a1a2e; display: flex; align-items: center; gap: 8px; }
        .info-box-value i { color: #1a3bb5; }

        /* Passenger Info Card */
        .passenger-field { margin-bottom: 16px; }
        .passenger-field label { display: block; font-weight: 600; font-size: 0.85rem; color: #344054; margin-bottom: 6px; }
        .passenger-value {
            width: 100%; padding: 12px 16px; border: 1px solid #eaecf0; border-radius: 8px;
            font-size: 0.92rem; color: #667085; background: #f9fafb;
        }
        .passenger-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        /* Right Sidebar */
        .summary-card {
            background: #fff; border-radius: 16px; border: 1px solid #eaecf0;
            padding: 28px; position: sticky; top: 90px;
        }
        .summary-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; }
        .summary-bus-img {
            width: 100%; height: 160px; border-radius: 12px; margin-bottom: 20px;
            background: linear-gradient(135deg, #1a3bb5 0%, #4e73df 100%);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.3); font-size: 4rem; overflow: hidden;
        }
        .summary-bus-img img { width: 100%; height: 100%; object-fit: cover; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .summary-row .s-label { font-size: 0.88rem; color: #667085; }
        .summary-row .s-value { font-size: 0.88rem; font-weight: 600; color: #1a1a2e; }
        .summary-divider { border: none; height: 1px; background: #eaecf0; margin: 16px 0; }
        .summary-total { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
        .summary-total .t-label { font-size: 1rem; font-weight: 700; }
        .summary-total .t-value { font-size: 1.4rem; font-weight: 800; color: #e74a3b; }
        .summary-tax { text-align: right; font-size: 0.72rem; color: #98a2b3; text-transform: uppercase; margin-bottom: 20px; }

        .btn-confirm {
            display: block; width: 100%; padding: 16px; border: none; border-radius: 10px;
            background: #1a3bb5; color: #fff; font-weight: 700; font-size: 1rem; text-align: center;
            cursor: pointer; transition: all 0.3s; font-family: 'Inter', sans-serif;
        }
        .btn-confirm:hover { background: #1530a0; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,59,181,0.3); }
        .btn-wa-detail {
            display: flex; width: 100%; padding: 14px; border: none; border-radius: 10px; margin-top: 10px;
            background: #25D366; color: #fff; font-weight: 700; font-size: 0.95rem;
            align-items: center; justify-content: center; gap: 8px;
            cursor: pointer; transition: all 0.3s; font-family: 'Inter', sans-serif;
        }
        .btn-wa-detail:hover { background: #1ebe5d; color: #fff; }
        .confirm-note { text-align: center; font-size: 0.75rem; color: #98a2b3; margin-top: 12px; line-height: 1.5; }

        .secure-badge {
            display: flex; align-items: center; gap: 12px; padding: 16px; border-radius: 12px;
            background: #f0f4ff; margin-top: 20px; border: 1px solid rgba(26,59,181,0.08);
        }
        .secure-icon {
            width: 40px; height: 40px; border-radius: 50%; background: #1a3bb5; color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;
        }
        .secure-text h4 { font-size: 0.85rem; font-weight: 700; color: #1a3bb5; }
        .secure-text p { font-size: 0.75rem; color: #667085; }

        .footer-mini {
            text-align: center; padding: 24px 0; color: #98a2b3; font-size: 0.8rem;
            border-top: 1px solid #eaecf0; margin-top: 40px;
        }

        @media (max-width: 900px) {
            .detail-grid { grid-template-columns: 1fr; }
            .summary-card { position: static; }
            .nav-links { display: none; }
        }
        @media (max-width: 640px) {
            .info-boxes, .passenger-row { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 1.6rem; }
        }
    </style>
<div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Complete Your Reservation</h1>
            <p>Follow the three simple steps below to secure your executive fleet transport. Our concierge team is standing by to assist with any special requirements.</p>
        </div>

        <!-- Order Status Tracker -->
        <?php
            $status = $booking['booking_status'];
            
            // Logic Tracker
            $is_cancelled = in_array($status, ['batal', 'ditolak', 'expired']);
            $step1_done = true; // Selalu aktif karena invoice sudah dibuat
            $step1_current = ($status == 'pending');
            
            $step2_done = in_array($status, ['uang_muka_dibayarkan','menunggu_pelunasan','lunas','siap_berangkat','sedang_berlangsung','selesai']);
            $step2_current = ($status == 'menunggu_verifikasi');
            
            $step3_done = in_array($status, ['uang_muka_dibayarkan','lunas','siap_berangkat','sedang_berlangsung','selesai']);
        ?>

        <?php if($is_cancelled): ?>
            <!-- Status Dibatalkan -->
            <div class="alert-landing alert-landing-danger" style="text-align: center; margin-bottom: 40px; padding: 20px;">
                <i class="fas fa-times-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <h4 style="margin-bottom: 5px;">Pemesanan Dibatalkan</h4>
                <p style="margin: 0;">Pemesanan ini sudah hangus atau dibatalkan oleh sistem/admin.</p>
            </div>
        <?php else: ?>
            <div class="stepper">
                <!-- Step 1: Menunggu Pembayaran -->
                <div class="step" style="cursor: default;">
                    <div class="step-icon <?= ($step1_done && !$step1_current) ? 'done' : 'current' ?>">
                        <?= ($step1_done && !$step1_current) ? '<i class="fas fa-check"></i>' : '<i class="fas fa-wallet"></i>' ?>
                    </div>
                    <span class="step-label <?= ($step1_current || $step1_done) ? 'active-label' : '' ?>">Menunggu Pembayaran</span>
                    <div class="step-line <?= ($step2_current || $step2_done) ? 'done-line' : '' ?>"></div>
                </div>
                
                <!-- Step 2: Sedang Diverifikasi -->
                <div class="step" style="cursor: default;">
                    <div class="step-icon <?= $step2_done ? 'done' : ($step2_current ? 'current' : 'pending') ?>">
                        <?= $step2_done ? '<i class="fas fa-check"></i>' : '<i class="fas fa-user-clock"></i>' ?>
                    </div>
                    <span class="step-label <?= ($step2_current || $step2_done) ? 'active-label' : '' ?>">Verifikasi Admin</span>
                    <div class="step-line <?= $step3_done ? 'done-line' : '' ?>"></div>
                </div>
                
                <!-- Step 3: Lunas / Siap Berangkat -->
                <div class="step" style="cursor: default;">
                    <div class="step-icon <?= $step3_done ? 'done' : 'pending' ?>">
                        <?= $step3_done ? '<i class="fas fa-check"></i>' : '<i class="fas fa-ticket-alt"></i>' ?>
                    </div>
                    <span class="step-label <?= $step3_done ? 'active-label' : '' ?>">Lunas & E-Ticket</span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Grid -->
        <div class="detail-grid">
            <!-- LEFT COLUMN -->
            <div>
                <!-- Route & Schedule Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <div>
                            <h2>Route & Schedule</h2>
                            <?php
                                $badge_class = 'badge-pending';
                                if ($step3_done) $badge_class = 'badge-done';
                                elseif ($step2_done) $badge_class = 'badge-confirmed';
                                elseif ($status == 'pending') $badge_class = 'badge-pending';
                                if ($status == 'batal') $badge_class = 'badge-cancelled';
                            ?>
                            <span class="availability-badge <?= $badge_class ?>">
                                <i class="fas fa-<?= $step2_done ? 'check-circle' : 'clock' ?>" style="font-size: 0.7rem;"></i>
                                <?= $step3_done ? 'Fully Confirmed' : ($step2_done ? 'DP Validated' : ($status == 'batal' ? 'Cancelled' : 'Awaiting Payment')) ?>
                            </span>
                        </div>
                        <a href="<?= base_url('home/my_bookings') ?>" class="edit-link"><i class="fas fa-arrow-left" style="margin-right: 4px;"></i> Back</a>
                    </div>
                    <div class="info-boxes">
                        <div class="info-box">
                            <div class="info-box-label">Pickup Location</div>
                            <div class="info-box-value"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($booking['lokasi_penjemputan']) ?></div>
                        </div>
                        <div class="info-box">
                            <div class="info-box-label">Destination</div>
                            <div class="info-box-value"><i class="fas fa-location-arrow"></i> <?= htmlspecialchars($booking['tempat_tujuan']) ?></div>
                        </div>
                        <div class="info-box">
                            <div class="info-box-label">Travel Dates</div>
                            <div class="info-box-value"><i class="far fa-calendar-alt"></i> <?= date('M d', strtotime($booking['tanggal_keberangkatan'])) ?> - <?= date('M d, Y', strtotime($booking['tanggal_pulang'])) ?></div>
                        </div>
                        <div class="info-box">
                            <div class="info-box-label">Selected Fleet</div>
                            <div class="info-box-value"><i class="fas fa-bus"></i> <?= htmlspecialchars($booking['bus_nama']) ?> (<?= $booking['kapasitas'] ?? '-' ?> Seater)</div>
                        </div>
                    </div>
                </div>

                <!-- Passenger Information Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2>Passenger Information</h2>
                    </div>
                    <div class="passenger-row">
                        <div class="passenger-field">
                            <label>Full Name</label>
                            <div class="passenger-value"><?= htmlspecialchars($booking['customer_nama']) ?></div>
                        </div>
                        <div class="passenger-field">
                            <label>Phone Number</label>
                            <div class="passenger-value"><?= htmlspecialchars($booking['no_telp']) ?></div>
                        </div>
                    </div>
                    <div class="passenger-field">
                        <label>Address</label>
                        <div class="passenger-value"><?= htmlspecialchars($booking['alamat'] ?? '-') ?></div>
                    </div>
                    <div class="passenger-field">
                        <label>Booking Status</label>
                        <div class="passenger-value" style="font-weight: 700; color: #1a3bb5;"><?= ucwords(str_replace('_', ' ', $booking['booking_status'])) ?></div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR -->
            <div>
                <div class="summary-card">
                    <h3>Booking Summary</h3>

                    <div class="summary-bus-img">
                        <i class="fas fa-bus-alt"></i>
                    </div>

                    <div class="summary-row">
                        <span class="s-label">Base Rate (<?= $jumlah_hari ?> Day<?= $jumlah_hari > 1 ? 's' : '' ?>)</span>
                        <span class="s-value">Rp <?= number_format($booking['total_harga'], 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="s-label">Per Day Rate</span>
                        <span class="s-value">Rp <?= number_format($booking['tipe_perjalanan'] == 'dalam_kota' ? $booking['harga_dalam_kota'] : $booking['harga_luar_kota'], 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="s-label">Duration</span>
                        <span class="s-value"><?= $jumlah_hari ?> Day<?= $jumlah_hari > 1 ? 's' : '' ?></span>
                    </div>

                    <hr class="summary-divider">

                    <div class="summary-total">
                        <span class="t-label">Total Price</span>
                        <span class="t-value">Rp <?= number_format($booking['total_harga'], 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-tax">Down Payment (DP): <strong style="color: #e74a3b;">Rp <?= number_format($dp_amount, 0, ',', '.') ?></strong></div>

                    <?php if($booking['booking_status'] == 'pending'): ?>
                        <?php if(!empty($booking['alasan_penolakan'])): ?>
                            <div style="background: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; border: 1px solid #fecaca;">
                                <strong>⚠️ Pembayaran Ditolak:</strong><br><?= htmlspecialchars($booking['alasan_penolakan']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($booking['batas_waktu_bayar'])): ?>
                            <div style="background: #fffbeb; color: #b45309; padding: 12px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; border: 1px solid #fef3c7; text-align: center;">
                                <strong>⏳ Batas Waktu Pembayaran:</strong><br>
                                <span style="font-size: 1.1rem; font-weight: 700;" id="countdown-timer"></span>
                            </div>
                            <script>
                                var countDownDate = new Date("<?= date('M d, Y H:i:s', strtotime($booking['batas_waktu_bayar'])) ?>").getTime();
                                var x = setInterval(function() {
                                    var now = new Date().getTime();
                                    var distance = countDownDate - now;
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("countdown-timer").innerHTML = "KEDALUWARSA";
                                    } else {
                                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                        document.getElementById("countdown-timer").innerHTML = hours + "j " + minutes + "m " + seconds + "s";
                                    }
                                }, 1000);
                            </script>
                        <?php endif; ?>

                        <!-- Form Upload Bukti -->
                        <form action="<?= base_url('home/upload_bukti') ?>" method="post" enctype="multipart/form-data" style="margin-bottom: 16px;">
                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: #344054;">Upload Bukti Transfer (JPG/PNG)</label>
                            <input type="file" name="bukti_pembayaran" accept="image/*" required style="width: 100%; padding: 10px; border: 1px dashed #1a3bb5; border-radius: 8px; background: #f0f4ff; margin-bottom: 12px; font-size: 0.85rem;">
                            <button type="submit" class="btn-confirm">
                                <i class="fas fa-upload" style="margin-right: 6px;"></i> Upload Bukti
                            </button>
                        </form>
                        

                    <?php elseif($booking['booking_status'] == 'menunggu_verifikasi'): ?>
                        <button class="btn-confirm" disabled style="background: #f59e0b; opacity: 1; cursor: default;">
                            <i class="fas fa-clock" style="margin-right: 6px;"></i> Menunggu Verifikasi Admin
                        </button>
                        <p class="confirm-note">Bukti pembayaran Anda sedang dicek. Harap bersabar.</p>
                    <?php elseif($booking['booking_status'] == 'uang_muka_dibayarkan'): ?>
                        <a href="<?= base_url('home/cetak_kwitansi/'.$booking['booking_id']) ?>" target="_blank" class="btn-confirm" style="background: #10b981; margin-bottom: 16px;">
                            <i class="fas fa-file-invoice-dollar" style="margin-right: 6px;"></i> Cetak Kwitansi DP
                        </a>
                        <div style="background: #e0f2fe; color: #0369a1; padding: 12px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; border: 1px solid #bae6fd;">
                            <strong>ℹ️ Info Pelunasan:</strong><br>Sisa pembayaran sebesar Rp <?= number_format($booking['sisa_pembayaran'], 0, ',', '.') ?> wajib dilunasi maksimal H-3 keberangkatan.
                        </div>
                        
                        <form action="<?= base_url('home/upload_pelunasan') ?>" method="post" enctype="multipart/form-data" style="margin-bottom: 16px;">
                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: #344054;">Upload Bukti Pelunasan (JPG/PNG)</label>
                            <input type="file" name="bukti_pelunasan" accept="image/*" required style="width: 100%; padding: 10px; border: 1px dashed #1a3bb5; border-radius: 8px; background: #f0f4ff; margin-bottom: 12px; font-size: 0.85rem;">
                            <button type="submit" class="btn-confirm">
                                <i class="fas fa-upload" style="margin-right: 6px;"></i> Upload Pelunasan
                            </button>
                        </form>
                    <?php elseif($booking['booking_status'] == 'menunggu_pelunasan'): ?>
                        <button class="btn-confirm" disabled style="background: #f59e0b; opacity: 1; cursor: default;">
                            <i class="fas fa-clock" style="margin-right: 6px;"></i> Verifikasi Pelunasan
                        </button>
                        <p class="confirm-note">Bukti pelunasan Anda sedang dicek admin.</p>
                    <?php elseif(in_array($booking['booking_status'], ['lunas', 'siap_berangkat', 'sedang_berlangsung', 'selesai'])): ?>
                        <a href="<?= base_url('home/cetak_kwitansi/'.$booking['booking_id']) ?>" target="_blank" class="btn-confirm" style="background: #10b981;">
                            <i class="fas fa-file-invoice-dollar" style="margin-right: 6px;"></i> Cetak Kwitansi Lunas
                        </a>
                        <p class="confirm-note">Pembayaran telah LUNAS.</p>
                    <?php else: ?>
                        <button class="btn-confirm" disabled style="background: #ef4444; opacity: 1; cursor: default;">
                            <i class="fas fa-times-circle" style="margin-right: 6px;"></i> Dibatalkan / Expired
                        </button>
                        <p class="confirm-note">Pemesanan ini sudah hangus atau dibatalkan.</p>
                    <?php endif; ?>

                    <div class="secure-badge">
                        <div class="secure-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="secure-text">
                            <h4>Secure Reservation</h4>
                            <p>256-bit encrypted checkout process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<?php $this->load->view('public/layout/footer'); ?>
