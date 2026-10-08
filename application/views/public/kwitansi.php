<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= $is_lunas ? 'Kwitansi Pelunasan' : 'Invoice DP' ?> #BK-<?= str_pad($booking['booking_id'], 4, '0', STR_PAD_LEFT) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; color: #333; line-height: 1.6; background: #f9fafb; padding: 40px 20px; }
        .invoice-box { 
            max-width: 800px; margin: auto; padding: 40px; 
            background: #fff; border: 1px solid #eaecf0; 
            border-radius: 12px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); 
            font-size: 15px; position: relative; overflow: hidden;
        }
        
        /* Stamp Lunas */
        .stamp-lunas {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 120px;
            font-weight: 800;
            color: rgba(16, 185, 129, 0.15); /* Translucent Green */
            border: 10px solid rgba(16, 185, 129, 0.15);
            padding: 20px 40px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            pointer-events: none;
            z-index: 0;
        }

        .content-wrapper { position: relative; z-index: 1; }

        .invoice-box table { width: 100%; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 8px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        
        /* Header */
        .header-table td { padding-bottom: 30px; }
        .logo-text { font-size: 32px; color: #1a3bb5; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 4px; }
        .doc-title { font-size: 14px; font-weight: 700; color: #98a2b3; text-transform: uppercase; letter-spacing: 0.1em; }
        
        .inv-details strong { color: #1a1a2e; }
        .status-badge { 
            display: inline-block; padding: 4px 12px; border-radius: 50px; 
            font-size: 12px; font-weight: 700; text-transform: uppercase; 
            background: <?= $is_lunas ? '#d1fae5' : '#fef3c7' ?>; 
            color: <?= $is_lunas ? '#065f46' : '#b45309' ?>; 
            margin-top: 8px;
        }

        /* Addresses */
        .address-table td { padding-bottom: 40px; line-height: 1.5; color: #667085; }
        .address-title { font-size: 12px; font-weight: 700; text-transform: uppercase; color: #98a2b3; margin-bottom: 8px; }
        .address-name { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }

        /* Items Table */
        .items-table { margin-bottom: 30px; }
        .items-table th { 
            background: #f0f4ff; color: #1a3bb5; 
            padding: 12px; font-size: 13px; font-weight: 700; 
            text-transform: uppercase; border-bottom: 2px solid #c7d2fe; 
        }
        .items-table td { padding: 16px 12px; border-bottom: 1px solid #eaecf0; color: #344054; }
        .items-table tr:last-child td { border-bottom: 2px solid #eaecf0; }

        /* Totals */
        .total-table { width: 400px; margin-left: auto; }
        .total-table td { padding: 10px 12px; border-bottom: 1px solid #eaecf0; color: #667085; }
        .total-table td.value { font-weight: 600; color: #1a1a2e; }
        
        .total-table tr.grand-total td { 
            border-top: 2px solid #1a3bb5; border-bottom: none; 
            padding-top: 16px; font-size: 18px; font-weight: 800; color: #1a1a2e; 
        }
        .total-table tr.grand-total td.value { color: #1a3bb5; }
        
        .total-table tr.amount-paid td { font-size: 16px; font-weight: 700; background: #f8fafc; }
        .total-table tr.amount-paid td.value { color: #10b981; }

        /* Footer */
        .footer-note { margin-top: 50px; text-align: center; color: #98a2b3; font-size: 13px; }
        
        .btn-print { 
            padding: 12px 24px; background: #1a3bb5; color: white; border: none; 
            cursor: pointer; border-radius: 8px; font-weight: 600; font-family: 'Inter', sans-serif;
            transition: 0.2s; box-shadow: 0 4px 12px rgba(26,59,181,0.2);
        }
        .btn-print:hover { background: #1530a0; transform: translateY(-1px); }
        .btn-thermal { background: #10b981; box-shadow: 0 4px 12px rgba(16,185,129,0.2); margin-left: 10px; }
        .btn-thermal:hover { background: #059669; }

        @media print { 
            body { background: white; padding: 0; }
            .btn-print, .print-wrapper { display: none; } 
            .invoice-box { box-shadow: none; border: none; padding: 0; max-width: 100%; }
            .stamp-lunas { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="print-wrapper" style="text-align: right; margin-bottom: 24px; max-width: 800px; margin-left: auto; margin-right: auto;">
        <button class="btn-print" onclick="window.print()">Cetak PDF / Print</button>
        <button class="btn-print btn-thermal" onclick="cetakThermal(<?= $booking['booking_id'] ?>)">Cetak Struk Kasir (Thermal)</button>
    </div>
    
    <div class="invoice-box">
        <?php if($is_lunas): ?>
            <div class="stamp-lunas">LUNAS</div>
        <?php endif; ?>

        <div class="content-wrapper">
            <table class="header-table">
                <tr>
                    <td>
                        <div class="logo-text">DHEEMOBILINDO</div>
                        <div class="doc-title"><?= $is_lunas ? 'Kwitansi Pelunasan' : 'Invoice Penagihan DP' ?></div>
                    </td>
                    <td class="inv-details">
                        Invoice #: <strong>BK-<?= str_pad($booking['booking_id'], 4, '0', STR_PAD_LEFT) ?></strong><br>
                        Tanggal Terbit: <?= date('d M Y') ?><br>
                        <div class="status-badge"><?= $is_lunas ? 'PAID IN FULL' : 'DOWN PAYMENT PAID' ?></div>
                    </td>
                </tr>
            </table>

            <table class="address-table">
                <tr>
                    <td>
                        <div class="address-title">Ditagihkan Oleh</div>
                        <div class="address-name">PT Dheemobilindo</div>
                        Jl. Bojong Koneng, RT.01/RW.08, Cingcin, Kec. Soreang,<br>
                        Kabupaten Bandung, Jawa Barat 40921, Indonesia<br>
                        CS: +62 812-3456-7890
                    </td>
                    <td>
                        <div class="address-title">Ditagihkan Kepada</div>
                        <div class="address-name"><?= htmlspecialchars($booking['customer_nama']) ?></div>
                        <?= htmlspecialchars($booking['no_telp']) ?><br>
                        <?= htmlspecialchars($booking['alamat'] ?? '-') ?>
                    </td>
                </tr>
            </table>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Deskripsi Layanan</th>
                        <th style="text-align: center;">Durasi</th>
                        <th style="text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: left;">
                            <strong>Sewa Armada: <?= htmlspecialchars($booking['bus_nama']) ?> (<?= $booking['kapasitas'] ?> Seat)</strong><br>
                            <span style="font-size: 13px; color: #667085;">
                                Rute: <?= htmlspecialchars($booking['lokasi_penjemputan']) ?> → <?= htmlspecialchars($booking['tempat_tujuan']) ?><br>
                                Tanggal: <?= date('d M Y', strtotime($booking['tanggal_keberangkatan'])) ?> s/d <?= date('d M Y', strtotime($booking['tanggal_pulang'])) ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <?= $jumlah_hari ?> Hari<br>
                            <span style="font-size: 12px; color: #98a2b3;">@ Rp <?= number_format($booking['tipe_perjalanan'] == 'dalam_kota' ? $booking['harga_dalam_kota'] : $booking['harga_luar_kota'], 0, ',', '.') ?>/hari</span>
                        </td>
                        <td style="text-align: right;">
                            <strong>Rp <?= number_format($booking['total_harga'], 0, ',', '.') ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="total-table">
                <tr>
                    <td>Total Harga Sewa</td>
                    <td class="value">Rp <?= number_format($booking['total_harga'], 0, ',', '.') ?></td>
                </tr>
                
                <?php if(!$is_lunas): ?>
                    <!-- INVOICE DP -->
                    <tr>
                        <td>Down Payment (30%)</td>
                        <td class="value">Rp <?= number_format($booking['total_harga'] * 0.3, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Kode Unik Verifikasi</td>
                        <td class="value" style="color: #f59e0b;">+ Rp <?= number_format($booking['kode_unik'], 0, ',', '.') ?></td>
                    </tr>
                    <tr class="amount-paid">
                        <td>DP Telah Dibayar</td>
                        <td class="value">Rp <?= number_format($dp_amount, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="grand-total">
                        <td>Sisa Tagihan (Pelunasan)</td>
                        <td class="value" style="color: #e74a3b;">Rp <?= number_format($booking['total_harga'] - $dp_amount, 0, ',', '.') ?></td>
                    </tr>
                <?php else: ?>
                    <!-- KWITANSI LUNAS -->
                    <tr>
                        <td>Down Payment (DP)</td>
                        <td class="value">Rp <?= number_format($dp_amount, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Pelunasan</td>
                        <td class="value">Rp <?= number_format($booking['total_harga'] - $dp_amount, 0, ',', '.') ?></td>
                    </tr>
                    <?php if($booking['denda'] > 0): ?>
                    <tr>
                        <td style="color: #e74a3b;">Denda Keterlambatan / Pinalti</td>
                        <td class="value" style="color: #e74a3b;">Rp <?= number_format($booking['denda'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="grand-total">
                        <td>Total Dibayarkan</td>
                        <td class="value" style="color: #10b981;">Rp <?= number_format($booking['total_harga'] + $booking['denda'], 0, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>
            </table>
            
            <div class="footer-note">
                <p>Terima kasih atas kepercayaan Anda menggunakan layanan Dheemobilindo.<br>
                Syarat & Ketentuan berlaku. DP yang telah disetorkan tidak dapat dikembalikan (Non-Refundable) apabila terjadi pembatalan sepihak dari pihak penyewa.</p>
                <p style="margin-top: 10px; font-weight: 600; color: #eaecf0;"> Dokumen Sah Diterbitkan Otomatis Secara Elektronik </p>
            </div>
        </div>
    </div>

    <script>
    function cetakThermal(bookingId) {
        const btn = document.querySelector('.btn-thermal');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Menghubungkan Printer...';
        
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
