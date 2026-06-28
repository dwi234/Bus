<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi Pelanggan</h1>
        <a href="<?= base_url('report/print_customer?start_date='.$start_date.'&end_date='.$end_date) ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50"></i> Cetak PDF / Print
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Rentang Waktu Transaksi</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('report/customer') ?>" method="GET" class="row align-items-end">
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
                    <a href="<?= base_url('report/customer') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </form>
            <small class="text-muted mt-2 d-block">*Menampilkan akumulasi transaksi yang berstatus Selesai & Sedang Berlangsung. Pelanggan diurutkan berdasarkan pembelanjaan terbesar (Top Spender).</small>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">Peringkat</th>
                            <th>Nama Pelanggan</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th width="15%" class="text-center">Total Booking</th>
                            <th width="20%" class="text-right">Total Belanja (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $grand_total = 0;
                        foreach ($reports as $r) : 
                            $grand_total += $r['total_belanja'];
                        ?>
                        <tr>
                            <td class="text-center"><strong>#<?= $no++; ?></strong></td>
                            <td><?= $r['nama']; ?></td>
                            <td><?= isset($r['email']) ? $r['email'] : '-'; ?></td>
                            <td><?= isset($r['telepon']) ? $r['telepon'] : '-'; ?></td>
                            <td class="text-center">
                                <span class="badge badge-<?= $r['total_booking'] > 0 ? 'success' : 'secondary' ?> pt-1 pb-1 px-3">
                                    <?= $r['total_booking']; ?>x
                                </span>
                            </td>
                            <td class="text-right font-weight-bold text-primary"><?= number_format($r['total_belanja'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total Keseluruhan Transaksi:</th>
                            <th class="text-right text-success font-weight-bold">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
