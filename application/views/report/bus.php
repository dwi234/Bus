<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Utilisasi Bus</h1>
        <a href="<?= base_url('report/print_bus?start_date='.$start_date.'&end_date='.$end_date) ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50"></i> Cetak PDF / Print
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Rentang Tanggal</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('report/bus') ?>" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Tanggal Awal Transaksi</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Tanggal Akhir Transaksi</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="<?= base_url('report/bus') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </form>
            <small class="text-muted mt-2 d-block">*Sistem hanya menghitung pemakaian bus dari transaksi dengan status <strong>Selesai</strong> dan <strong>Sedang Berlangsung</strong>.</small>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Bus</th>
                            <th>Kapasitas</th>
                            <th width="15%" class="text-center">Total Trip (Disewa)</th>
                            <th width="20%" class="text-right">Pendapatan Bus (Rp)</th>
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
                            <td><?= $no++; ?></td>
                            <td><?= $r['bus_nama']; ?></td>
                            <td><?= $r['kapasitas']; ?> Kursi</td>
                            <td class="text-center">
                                <span class="badge badge-<?= $r['total_trip'] > 0 ? 'success' : 'secondary' ?> pt-1 pb-1 px-3">
                                    <?= $r['total_trip']; ?>x
                                </span>
                            </td>
                            <td class="text-right"><?= number_format($r['pendapatan_bus'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total Seluruh Pendapatan:</th>
                            <th class="text-right text-success">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
