<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aktivitas Supir</title>
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { color: black; background: white; margin: 20px; font-family: 'Nunito', sans-serif;}
        .print-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { color: black; }
        .table-bordered th, .table-bordered td { border: 1px solid #000; }
        .section-title { font-size: 14pt; font-weight: bold; margin: 25px 0 10px 0; padding: 5px 10px; background: #f0f0f0; border-left: 4px solid #333; }
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
            <h3 style="margin: 0; color: #333; font-weight: 700; font-size: 16pt; text-transform: uppercase;">Laporan Aktivitas Supir</h3>
            <p style="margin: 5px 0 0 0; font-size: 10pt; color: #667085;">
                Periode: <?= $start_date ? date('d M Y', strtotime($start_date)) : 'Awal' ?> s/d <?= $end_date ? date('d M Y', strtotime($end_date)) : 'Hari Ini' ?>
            </p>
        </div>
    </div>

    <div class="section-title">Daftar Seluruh Driver & Armada</div>
    <table class="table table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama Supir</th>
                <th>No. HP</th>
                <th>Armada Bus (Tipe)</th>
                <th>Status Akun</th>
                <th width="20%" class="text-center">Total Jadwal (Trip)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $has_data = false;
            foreach ($reports as $r) : 
                $has_data = true;
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= isset($r['nama']) ? $r['nama'] : '-'; ?></td>
                <td><?= isset($r['tlp']) ? $r['tlp'] : '-'; ?></td>
                <td>
                    <?php if(!empty($r['bus_nama'])): ?>
                        <?= $r['bus_nama'] ?> <small class="text-muted">(<?= $r['tipe_bus'] ?>)</small>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php 
                    if (isset($r['status'])) {
                        if ($r['status'] == 'tidak bisa bertugas') {
                            echo 'Tidak Bisa Bertugas';
                            if (!empty($r['keterangan'])) {
                                echo ' (' . htmlspecialchars($r['keterangan']) . ')';
                            }
                        } else {
                            echo 'Bisa Bertugas';
                        }
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td class="text-center"><?= $r['total_trip']; ?> Trip</td>
            </tr>
            <?php endforeach; ?>
            <?php if (!$has_data): ?>
            <tr><td colspan="6" class="text-center">-</td></tr>
            <?php endif; ?>
        </tbody>
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
