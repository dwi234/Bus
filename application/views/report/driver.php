<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Aktivitas Supir</h1>
        <a href="<?= base_url('report/print_driver?start_date='.$start_date.'&end_date='.$end_date) ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50"></i> Cetak PDF / Print
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Rentang Waktu</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('report/driver') ?>" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="<?= base_url('report/driver') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Driver Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-id-card mr-1"></i> Daftar Seluruh Driver & Armada</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
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
                                    <?= htmlspecialchars($r['bus_nama']) ?> <small class="text-muted">(<?= htmlspecialchars($r['tipe_bus']) ?>)</small>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
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
                            <td class="text-center">
                                <span class="badge badge-<?= $r['total_trip'] > 0 ? 'success' : 'secondary' ?> pt-1 pb-1 px-3">
                                    <?= $r['total_trip']; ?> Trip
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (!$has_data): ?>
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada data driver</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
