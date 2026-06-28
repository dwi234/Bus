<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pendapatan</h1>
        <a href="<?= base_url('report/print?start_date='.$start_date.'&end_date='.$end_date.'&status='.$status) ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50"></i> Cetak PDF / Print
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('report') ?>" method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label>Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label>Status Booking</label>
                        <select name="status" class="form-control">
                            <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>Semua Status</option>
                            <option value="selesai" <?= $status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="sedang_berlangsung" <?= $status == 'sedang_berlangsung' ? 'selected' : '' ?>>Sedang Berlangsung</option>
                            <option value="uang_muka_dibayarkan" <?= $status == 'uang_muka_dibayarkan' ? 'selected' : '' ?>>Uang Muka Dibayar</option>
                            <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="dibatalkan" <?= $status == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="<?= base_url('report') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kode Booking</th>
                            <th>Customer</th>
                            <th>Bus</th>
                            <th>Status</th>
                            <th>Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $total_pendapatan = 0;
                        foreach ($reports as $r) : 
                            $total_pendapatan += $r['total_harga'];
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d M Y', strtotime($r['tanggal_keberangkatan'])); ?></td>
                            <td>#<?= $r['booking_id']; ?></td>
                            <td><?= $r['customer_nama']; ?></td>
                            <td><?= $r['bus_nama']; ?></td>
                            <td>
                                <?php
                                $badge = 'info';
                                if($r['booking_status'] == 'selesai') $badge = 'success';
                                if($r['booking_status'] == 'pending') $badge = 'warning';
                                if($r['booking_status'] == 'dibatalkan') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= ucwords(str_replace('_', ' ', $r['booking_status'])); ?></span>
                            </td>
                            <td class="text-right"><?= number_format($r['total_harga'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-right">Total Pendapatan:</th>
                            <th class="text-right text-success">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
