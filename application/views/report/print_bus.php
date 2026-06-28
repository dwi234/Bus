<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Utilisasi Bus</title>
    <!-- Use basic bootstrap for standard table stylings -->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { color: black; background: white; margin: 20px; font-family: 'Nunito', sans-serif;}
        .print-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { color: black; }
        .table-bordered th, .table-bordered td { border: 1px solid #000; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="print-header" style="text-align: left; border-bottom: 3px solid #1a3bb5; padding-bottom: 20px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="color: #1a3bb5; margin: 0; font-weight: 800; letter-spacing: 1px; font-size: 24pt;">PT. DHEEMOBILINDO</h1>
            <p style="margin: 5px 0 0 0; color: #667085; font-size: 10pt;">
                Jl. Raya Utama No. 123, Jakarta, Indonesia<br>
                Telp: 0812-3456-7890 | Web: www.dheemobilindo.com
            </p>
        </div>
        <div style="text-align: right;">
            <h3 style="margin: 0; color: #333; font-weight: 700; font-size: 16pt; text-transform: uppercase;">Laporan Utilisasi Bus</h3>
            <p style="margin: 5px 0 0 0; font-size: 10pt; color: #667085;">
                Periode: <?= $start_date ? date('d M Y', strtotime($start_date)) : 'Awal' ?> s/d <?= $end_date ? date('d M Y', strtotime($end_date)) : 'Hari Ini' ?><br>
                Filter: <strong>Selesai & Sedang Berlangsung</strong>
            </p>
        </div>
    </div>

    <table class="table table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama Bus</th>
                <th class="text-center">Kapasitas</th>
                <th width="15%" class="text-center">Jumlah Trip</th>
                <th class="text-right">Pendapatan Bersih (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_total = 0;
            foreach ($reports as $r) : 
                $grand_total += $r['pendapatan_bus'];
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $r['bus_nama']; ?></td>
                <td class="text-center"><?= $r['kapasitas']; ?> Kursi</td>
                <td class="text-center"><?= $r['total_trip']; ?>x</td>
                <td class="text-right"><?= number_format($r['pendapatan_bus'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Seluruh Pendapatan:</th>
                <th class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p>Manajer Operasional,</p>
            <br><br><br>
            <p><strong>( ___________________ )</strong></p>
        </div>
    </div>

</body>
</html>
