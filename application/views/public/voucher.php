<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Booking Voucher — Dheemobilindo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif; color: #1a1a2e;
            background: linear-gradient(160deg, #f0f4ff 0%, #e8eeff 50%, #f9fafb 100%);
            min-height: 100vh; display: flex; flex-direction: column; align-items: center;
            padding: 40px 20px;
        }

        .voucher-container { max-width: 640px; width: 100%; }

        /* Success Header */
        .success-header { text-align: center; margin-bottom: 32px; }
        .success-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: linear-gradient(135deg, #1cc88a, #17a673);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; color: #fff; font-size: 2.2rem;
            box-shadow: 0 12px 32px rgba(28, 200, 138, 0.3);
            animation: bounceIn 0.6s ease;
        }
        @keyframes bounceIn {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-header h1 { font-size: 1.8rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.02em; }
        .success-header p { color: #667085; font-size: 0.95rem; line-height: 1.6; }

        /* Voucher Card */
        .voucher-card {
            background: #fff; border-radius: 16px; overflow: hidden;
            box-shadow: 0 8px 40px rgba(0,0,0,0.08); border: 1px solid #eaecf0;
        }
        .voucher-top {
            background: linear-gradient(135deg, #1a3bb5 0%, #2a5298 100%);
            color: #fff; padding: 28px 32px; position: relative; overflow: hidden;
        }
        .voucher-top::after {
            content: ''; position: absolute; right: -40px; top: -40px;
            width: 180px; height: 180px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .voucher-top-row { display: flex; justify-content: space-between; align-items: flex-start; position: relative; z-index: 1; }
        .voucher-brand { display: flex; align-items: center; gap: 10px; }
        .voucher-brand img { height: 32px; width: auto; }
        .voucher-brand span { font-weight: 800; font-size: 1.05rem; }
        .voucher-id-box { text-align: right; }
        .voucher-id-label { font-size: 0.72rem; opacity: 0.7; text-transform: uppercase; letter-spacing: 0.08em; }
        .voucher-id-value { font-size: 1.3rem; font-weight: 800; letter-spacing: 0.02em; }
        .voucher-status {
            display: inline-flex; align-items: center; gap: 6px; margin-top: 16px;
            padding: 6px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;
            background: rgba(255,255,255,0.15); text-transform: uppercase; letter-spacing: 0.05em;
            position: relative; z-index: 1;
        }
        .voucher-status .dot { width: 8px; height: 8px; border-radius: 50%; background: #f6c23e; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

        /* Voucher Body */
        .voucher-body { padding: 32px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }
        .info-item {}
        .info-label { font-size: 0.72rem; color: #98a2b3; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; margin-bottom: 4px; }
        .info-value { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; }
        .info-full { grid-column: 1 / -1; }

        .divider {
            border: none; height: 1px; background: #eaecf0; margin: 0 0 28px;
            background-image: repeating-linear-gradient(90deg, #eaecf0 0, #eaecf0 8px, transparent 8px, transparent 16px);
        }

        /* Price Summary */
        .price-summary { background: #f9fafb; border-radius: 12px; padding: 24px; margin-bottom: 28px; }
        .price-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .price-row:last-child { margin-bottom: 0; }
        .price-row .label { font-size: 0.9rem; color: #667085; }
        .price-row .value { font-size: 0.95rem; font-weight: 600; color: #1a1a2e; }
        .price-row.total { border-top: 2px solid #eaecf0; padding-top: 12px; margin-top: 12px; }
        .price-row.total .label { font-weight: 700; color: #1a1a2e; font-size: 1rem; }
        .price-row.total .value { font-weight: 800; color: #1a3bb5; font-size: 1.2rem; }
        .price-row.dp { background: #fff5f5; padding: 12px; border-radius: 8px; margin-top: 12px; border: 1px solid #fecdca; }
        .price-row.dp .label { font-weight: 700; color: #b42318; font-size: 0.9rem; }
        .price-row.dp .value { font-weight: 800; color: #e74a3b; font-size: 1.15rem; }

        /* Bank Info */
        .bank-info {
            background: #f0f4ff; border-radius: 12px; padding: 20px; margin-bottom: 28px;
            border: 1px solid rgba(26,59,181,0.1);
        }
        .bank-info h4 { font-size: 0.9rem; font-weight: 700; color: #1a3bb5; margin-bottom: 12px; }
        .bank-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .bank-row:last-child { margin-bottom: 0; }
        .bank-row .bank-label { font-size: 0.85rem; color: #667085; }
        .bank-row .bank-value { font-size: 0.85rem; font-weight: 700; color: #1a1a2e; }

        /* Kode Unik Info */
        .unique-code-info {
            background: #fffbeb; border-radius: 12px; padding: 16px 20px; margin-bottom: 28px;
            border: 1px solid #fde68a; display: flex; align-items: flex-start; gap: 12px;
        }
        .unique-code-info i { color: #f59e0b; font-size: 1.2rem; margin-top: 2px; }
        .unique-code-info .text { font-size: 0.85rem; color: #92400e; line-height: 1.6; }
        .unique-code-info .text strong { color: #78350f; }

        /* Buttons */
        .voucher-actions { display: flex; flex-direction: column; gap: 12px; }
        .btn-wa {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            padding: 16px; border: none; border-radius: 10px; font-size: 1rem; font-weight: 700;
            cursor: pointer; transition: all 0.3s; text-decoration: none;
            background: #25D366; color: #fff; font-family: 'Inter', sans-serif;
        }
        .btn-wa:hover { background: #1ebe5d; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,211,102,0.3); color: #fff; }
        .btn-secondary-v {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            padding: 14px; border: 2px solid #d0d5dd; border-radius: 10px; font-size: 0.92rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s; text-decoration: none; color: #344054;
            background: #fff; font-family: 'Inter', sans-serif;
        }
        .btn-secondary-v:hover { border-color: #1a3bb5; color: #1a3bb5; }
        .btn-thermal-v:hover { background: #059669 !important; border-color: #059669 !important; color: white !important; }

        /* Countdown */
        .countdown-bar {
            text-align: center; margin-top: 28px; padding: 16px; border-radius: 12px;
            background: #fff5f5; border: 1px solid #fecdca;
        }
        .countdown-bar .timer-label { font-size: 0.8rem; color: #b42318; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .countdown-bar .timer-value { font-size: 1.5rem; font-weight: 800; color: #e74a3b; font-variant-numeric: tabular-nums; }

        /* Back Link */
        .back-link {
            display: block; text-align: center; margin-top: 24px;
            font-size: 0.9rem; color: #667085; text-decoration: none;
        }
        .back-link:hover { color: #1a3bb5; }

        @media (max-width: 640px) {
            body { padding: 20px 12px; }
            .info-grid { grid-template-columns: 1fr; }
            .voucher-top, .voucher-body { padding: 20px; }
            .success-header h1 { font-size: 1.4rem; }
        }

        @media print {
            body { background: white !important; padding: 0 !important; }
            .success-header, .back-link, .btn-wa, .btn-secondary-v, .btn-thermal-v, form, .unique-code-info, .bank-info { display: none !important; }
            .voucher-card { box-shadow: none !important; border: none !important; }
            .voucher-top { background: #1a3bb5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="voucher-container">
        <!-- Success Header -->
        <div class="success-header">
            <div class="success-icon"><i class="fas fa-check"></i></div>
            <h1>Booking Berhasil!</h1>
            <p>Voucher booking Anda sudah dibuat. Silakan lakukan pembayaran DP dan unggah bukti pembayaran di bawah ini.</p>
        </div>
        
        <?php if($this->session->flashdata('success')): ?>
            <div style="background: #ecfdf5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #a7f3d0; text-align: center;">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div style="background: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca; text-align: center;">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Voucher Card -->
        <div class="voucher-card">
            <!-- Top (Blue Header) -->
            <div class="voucher-top">
                <div class="voucher-top-row">
                    <div class="voucher-brand">
                        <img src="<?= base_url('assets/img/logo_dru.png') ?>" alt="Logo">
                        <span>Dheemobilindo</span>
                    </div>
                    <div class="voucher-id-box">
                        <div class="voucher-id-label">Invoice No.</div>
                        <div class="voucher-id-value">#BK-<?= str_pad($booking['booking_id'], 4, '0', STR_PAD_LEFT) ?></div>
                    </div>
                </div>
                <div class="voucher-status">
                    <?php if($booking['booking_status'] == 'pending'): ?>
                        <span class="dot"></span> Waiting for Payment
                    <?php elseif($booking['booking_status'] == 'menunggu_verifikasi'): ?>
                        <i class="fas fa-clock" style="margin-right:4px;"></i> Menunggu Verifikasi
                    <?php else: ?>
                        <i class="fas fa-check" style="margin-right:4px;"></i> <?= ucwords(str_replace('_', ' ', $booking['booking_status'])) ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Body -->
            <div class="voucher-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Pemesan</div>
                        <div class="info-value"><?= htmlspecialchars($booking['nama']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">No. WhatsApp</div>
                        <div class="info-value"><?= htmlspecialchars($booking['no_telp']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Bus / Armada</div>
                        <div class="info-value"><?= htmlspecialchars($booking['bus_nama']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Durasi</div>
                        <div class="info-value"><?= $booking['jumlah_hari'] ?> Hari</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Berangkat</div>
                        <div class="info-value"><?= date('d M Y', strtotime($booking['tgl_berangkat'])) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Pulang</div>
                        <div class="info-value"><?= date('d M Y', strtotime($booking['tgl_pulang'])) ?></div>
                    </div>
                    <div class="info-item info-full">
                        <div class="info-label">Rute Perjalanan</div>
                        <div class="info-value"><?= htmlspecialchars($booking['penjemputan']) ?> → <?= htmlspecialchars($booking['tujuan']) ?></div>
                    </div>
                </div>

                <hr class="divider">

                <!-- Price Summary -->
                <div class="price-summary">
                    <div class="price-row">
                        <span class="label">Harga Sewa (<?= $booking['jumlah_hari'] ?> hari)</span>
                        <span class="value">Rp <?= number_format($booking['total_harga'], 0, ',', '.') ?></span>
                    </div>
                    <div class="price-row">
                        <span class="label">Kode Unik Verifikasi</span>
                        <span class="value" style="color: #f59e0b;">+ Rp <?= number_format($booking['kode_unik'], 0, ',', '.') ?></span>
                    </div>
                    <div class="price-row total">
                        <span class="label">Total Pembayaran</span>
                        <span class="value">Rp <?= number_format($booking['total_harga'] + $booking['kode_unik'], 0, ',', '.') ?></span>
                    </div>
                    <div class="price-row dp">
                        <span class="label"><i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i> Down Payment (DP)</span>
                        <span class="value">Rp <?= number_format($booking['dp_amount'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <!-- Bank Info -->
                <div class="bank-info">
                    <h4><i class="fas fa-university" style="margin-right: 6px;"></i> Transfer ke Rekening</h4>
                    <div class="bank-row">
                        <span class="bank-label">Bank</span>
                        <span class="bank-value">BCA (Bank Central Asia)</span>
                    </div>
                    <div class="bank-row">
                        <span class="bank-label">No. Rekening</span>
                        <span class="bank-value">1234-5678-9012</span>
                    </div>
                    <div class="bank-row">
                        <span class="bank-label">Atas Nama</span>
                        <span class="bank-value">PT. Dheemobilindo</span>
                    </div>
                </div>

                <!-- Kode Unik Alert -->
                <div class="unique-code-info">
                    <i class="fas fa-info-circle"></i>
                    <div class="text">
                        <strong>Penting:</strong> Transfer sesuai nominal <strong>Rp <?= number_format($booking['dp_amount'], 0, ',', '.') ?></strong> (termasuk 3 digit kode unik). Kode unik digunakan untuk mempercepat proses verifikasi pembayaran Anda.
                    </div>
                </div>

                <!-- Action Buttons & Upload -->
                <div class="voucher-actions">
                    <?php if($booking['booking_status'] == 'pending'): ?>
                        
                        <?php if(!empty($booking['alasan_penolakan'])): ?>
                            <div style="background: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; border: 1px solid #fecaca;">
                                <strong>⚠️ Pembayaran Ditolak:</strong><br><?= htmlspecialchars($booking['alasan_penolakan']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($booking['batas_waktu_bayar'])): ?>
                        <div class="countdown-bar">
                            <div class="timer-label"><i class="fas fa-clock" style="margin-right: 4px;"></i> Batas Waktu Pembayaran</div>
                            <div class="timer-value" id="countdown">Memuat...</div>
                        </div>
                        <?php endif; ?>

                        <form action="<?= base_url('home/upload_bukti') ?>" method="post" enctype="multipart/form-data" style="margin-top: 16px;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: #344054;">Upload Bukti Transfer (JPG/PNG)</label>
                            <input type="file" name="bukti_pembayaran" accept="image/*" required style="width: 100%; padding: 12px; border: 1px dashed #1a3bb5; border-radius: 10px; background: #f0f4ff; margin-bottom: 12px; font-size: 0.85rem;">
                            
                            <button type="submit" class="btn-wa" style="width: 100%; background: #1a3bb5;">
                                <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                            </button>
                        </form>
                    <?php elseif($booking['booking_status'] == 'menunggu_verifikasi'): ?>
                        <div style="background: #fffbeb; color: #b45309; padding: 16px; border-radius: 10px; text-align: center; border: 1px solid #fef3c7; font-weight: 600;">
                            <i class="fas fa-hourglass-half" style="margin-bottom: 8px; font-size: 1.5rem; display: block;"></i>
                            Bukti pembayaran Anda sedang diverifikasi oleh admin. Harap bersabar.
                        </div>
                    <?php elseif(in_array($booking['booking_status'], ['uang_muka_dibayarkan', 'menunggu_pelunasan'])): ?>
                        <div style="background: #e0f2fe; color: #0369a1; padding: 16px; border-radius: 10px; text-align: center; border: 1px solid #bae6fd; font-weight: 600;">
                            <i class="fas fa-info-circle" style="margin-bottom: 8px; font-size: 1.5rem; display: block;"></i>
                            DP Terverifikasi. Silakan cek Halaman Detail Pesanan untuk melakukan pelunasan sisa tagihan.
                        </div>
                        <a href="<?= base_url('home/booking_detail/'.$booking['booking_id']) ?>" class="btn-wa" style="width: 100%; background: #0284c7; margin-top: 10px;">
                            <i class="fas fa-file-invoice-dollar"></i> Buka Detail Pesanan
                        </a>
                    <?php elseif(in_array($booking['booking_status'], ['lunas', 'selesai', 'siap_berangkat', 'sedang_berlangsung'])): ?>
                        <div style="background: #ecfdf5; color: #065f46; padding: 16px; border-radius: 10px; text-align: center; border: 1px solid #a7f3d0; font-weight: 600;">
                            <i class="fas fa-check-circle" style="margin-bottom: 8px; font-size: 1.5rem; display: block;"></i>
                            Pembayaran Lunas Terverifikasi
                        </div>
                    <?php else: ?>
                        <div style="background: #fef2f2; color: #991b1b; padding: 16px; border-radius: 10px; text-align: center; border: 1px solid #fecaca; font-weight: 600;">
                            <i class="fas fa-times-circle" style="margin-bottom: 8px; font-size: 1.5rem; display: block;"></i>
                            Booking Dibatalkan / Kedaluwarsa
                        </div>
                    <?php endif; ?>
                    
                    <button onclick="window.print()" class="btn-secondary-v" style="margin-top: 12px;">
                        <i class="fas fa-print"></i> Cetak / Simpan Voucher
                    </button>
                    <button onclick="cetakThermal(<?= $booking['booking_id'] ?>)" class="btn-secondary-v btn-thermal-v" style="margin-top: 12px; background: #10b981; color: white; border-color: #10b981;">
                        <i class="fas fa-receipt"></i> Cetak Struk Kasir (Thermal)
                    </button>
                </div>
            </div>
        </div>

        <a href="<?= base_url('home') ?>" class="back-link"><i class="fas fa-arrow-left" style="margin-right: 6px;"></i> Kembali ke Halaman Utama</a>
    </div>

    <script>
        <?php if($booking['booking_status'] == 'pending' && !empty($booking['batas_waktu_bayar'])): ?>
        var countDownDate = new Date("<?= date('M d, Y H:i:s', strtotime($booking['batas_waktu_bayar'])) ?>").getTime();
        var timerEl = document.getElementById('countdown');
        
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            
            if (distance < 0) {
                clearInterval(x);
                timerEl.innerHTML = "KEDALUWARSA";
                timerEl.style.color = "#b42318";
            } else {
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                timerEl.innerHTML = hours + "j " + minutes + "m " + seconds + "s";
            }
        }, 1000);
        <?php endif; ?>
    </script>
    <script>
    function cetakThermal(bookingId) {
        const btn = document.querySelector('.btn-thermal-v');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghubungkan...';
        
        fetch('<?= base_url("home/cetak_thermal/") ?>' + bookingId)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    let info = 'Berhasil! Data cetak terkirim.\n';
                    info += 'Method: ' + (data.method || '?') + '\n';
                    info += 'Hostname: ' + (data.hostname || '?') + '\n';
                    info += 'Device: ' + (data.device_path || '?') + '\n\n';
                    info += 'Jika printer tidak merespon, cek koneksi dan status printer di Windows.';
                    alert(info);
                } else {
                    alert('Gagal mencetak: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan jaringan atau server saat mencoba mencetak.');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    }
    </script>
</body>
</html>
