<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Pemesanan</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Booking</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahModal">
                        <i class="fas fa-plus fa-sm"></i> Tambah Booking
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Bus</th>
                                    <th>Berangkat</th>
                                    <th>Pulang</th>
                                    <th>Penjemputan</th>
                                    <th>Tujuan</th>
                                    <th>Total (Rp)</th>
                                    <th>Bukti</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($booking as $b) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $b['customer_nama']; ?></td>
                                    <td><?= $b['bus_nama']; ?></td>
                                    <td><?= $b['tanggal_keberangkatan']; ?></td>
                                    <td><?= $b['tanggal_pulang']; ?></td>
                                    <td><?= $b['lokasi_penjemputan']; ?></td>
                                    <td><?= $b['tempat_tujuan']; ?></td>
                                    <td><?= number_format($b['total_harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if(!empty($b['bukti_pembayaran'])): ?>
                                            <button class="btn btn-sm btn-info mb-1" data-toggle="modal" data-target="#buktiModal<?= $b['booking_id'] ?>"><i class="fas fa-eye"></i> DP</button>
                                        <?php endif; ?>
                                        <?php if(!empty($b['bukti_pelunasan'])): ?>
                                            <button class="btn btn-sm btn-primary mb-1" data-toggle="modal" data-target="#buktiModal<?= $b['booking_id'] ?>"><i class="fas fa-eye"></i> Pelunasan</button>
                                        <?php endif; ?>
                                        <?php if(empty($b['bukti_pembayaran']) && empty($b['bukti_pelunasan'])): ?>
                                            <span class="text-muted small">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-info"><?= str_replace('_', ' ', $b['booking_status']); ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editModal<?= $b['booking_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                                        <a href="<?= base_url('booking/hapus/'.$b['booking_id']); ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Booking</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('booking/tambah') ?>" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label>Customer</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">-- Pilih Customer --</option>
                        <?php foreach($customer as $c): ?>
                            <option value="<?= $c['customer_id'] ?>"><?= $c['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bus</label>
                    <select name="bus_id" class="form-control" required>
                        <option value="">-- Pilih Bus --</option>
                        <?php foreach($bus as $bs): ?>
                            <option value="<?= $bs['bus_id'] ?>"><?= $bs['bus_nama'] ?> (Rp <?= number_format($bs['harga_rental'],0,',','.') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Berangkat</label>
                    <input type="date" name="tanggal_keberangkatan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Pulang</label>
                    <input type="date" name="tanggal_pulang" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Lokasi Penjemputan</label>
                    <input type="text" name="lokasi_penjemputan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tempat Tujuan</label>
                    <input type="text" name="tempat_tujuan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Total Harga (Rp)</label>
                    <input type="number" name="total_harga" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status Booking</label>
                    <select name="booking_status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                        <option value="uang_muka_dibayarkan">Uang Muka Dibayarkan</option>
                        <option value="menunggu_pelunasan">Menunggu Pelunasan</option>
                        <option value="siap_berangkat">Siap Berangkat</option>
                        <option value="sedang_berlangsung">Sedang Berlangsung</option>
                        <option value="selesai">Selesai</option>
                        <option value="batal">Batal</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($booking as $b) : ?>
<div class="modal fade" id="editModal<?= $b['booking_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Booking</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('booking/edit') ?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="booking_id" value="<?= $b['booking_id']; ?>">
                <div class="form-group">
                    <label>Customer</label>
                    <select name="customer_id" class="form-control" required>
                        <?php foreach($customer as $c): ?>
                            <option value="<?= $c['customer_id'] ?>" <?= $b['customer_id'] == $c['customer_id'] ? 'selected' : '' ?>><?= $c['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bus</label>
                    <select name="bus_id" class="form-control" required>
                        <?php foreach($bus as $bs): ?>
                            <option value="<?= $bs['bus_id'] ?>" <?= $b['bus_id'] == $bs['bus_id'] ? 'selected' : '' ?>><?= $bs['bus_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Berangkat</label>
                    <input type="date" name="tanggal_keberangkatan" class="form-control" value="<?= $b['tanggal_keberangkatan'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Pulang</label>
                    <input type="date" name="tanggal_pulang" class="form-control" value="<?= $b['tanggal_pulang'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Lokasi Penjemputan</label>
                    <input type="text" name="lokasi_penjemputan" class="form-control" value="<?= $b['lokasi_penjemputan'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Tempat Tujuan</label>
                    <input type="text" name="tempat_tujuan" class="form-control" value="<?= $b['tempat_tujuan'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Total Harga (Rp)</label>
                    <input type="number" name="total_harga" class="form-control" value="<?= $b['total_harga'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Status Booking</label>
                    <select name="booking_status" class="form-control" required>
                        <option value="pending" <?= $b['booking_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="menunggu_verifikasi" <?= $b['booking_status'] == 'menunggu_verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                        <option value="uang_muka_dibayarkan" <?= $b['booking_status'] == 'uang_muka_dibayarkan' ? 'selected' : '' ?>>Uang Muka Dibayarkan</option>
                        <option value="menunggu_pelunasan" <?= $b['booking_status'] == 'menunggu_pelunasan' ? 'selected' : '' ?>>Menunggu Pelunasan</option>
                        <option value="siap_berangkat" <?= $b['booking_status'] == 'siap_berangkat' ? 'selected' : '' ?>>Siap Berangkat</option>
                        <option value="sedang_berlangsung" <?= $b['booking_status'] == 'sedang_berlangsung' ? 'selected' : '' ?>>Sedang Berlangsung</option>
                        <option value="selesai" <?= $b['booking_status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="batal" <?= $b['booking_status'] == 'batal' ? 'selected' : '' ?>>Batal</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Bukti & Verifikasi -->
<?php foreach ($booking as $b) : ?>
<?php if(!empty($b['bukti_pembayaran']) || !empty($b['bukti_pelunasan'])): ?>
<div class="modal fade" id="buktiModal<?= $b['booking_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Transfer #BK-<?= str_pad($b['booking_id'], 4, '0', STR_PAD_LEFT) ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <?php if($b['booking_status'] == 'menunggu_verifikasi' || !empty($b['bukti_pembayaran'])): ?>
                    <h6>Bukti DP (Uang Muka)</h6>
                    <img src="<?= base_url('assets/img/bukti_transfer/'.$b['bukti_pembayaran']) ?>" alt="Bukti Transfer DP" class="img-fluid mb-3" style="max-height: 400px; border-radius: 8px; border: 1px solid #ddd;">
                <?php endif; ?>

                <?php if(!empty($b['bukti_pelunasan'])): ?>
                    <hr>
                    <h6>Bukti Pelunasan</h6>
                    <img src="<?= base_url('assets/img/bukti_transfer/'.$b['bukti_pelunasan']) ?>" alt="Bukti Transfer Pelunasan" class="img-fluid mb-3" style="max-height: 400px; border-radius: 8px; border: 1px solid #ddd;">
                <?php endif; ?>
                
                <?php if($b['booking_status'] == 'menunggu_verifikasi' || $b['booking_status'] == 'menunggu_pelunasan'): ?>
                <form action="<?= base_url('booking/verifikasi_pembayaran') ?>" method="POST">
                    <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                    <div class="form-group text-left">
                        <label class="font-weight-bold text-danger">Alasan Penolakan (Opsional, hanya jika ditolak):</label>
                        <textarea name="alasan_penolakan" class="form-control" rows="2" placeholder="Misal: Bukti transfer buram, mohon upload ulang..."></textarea>
                    </div>
                    <hr>
                    <button type="submit" name="action" value="tolak" class="btn btn-danger mr-2"><i class="fas fa-times"></i> Tolak Bukti</button>
                    <button type="submit" name="action" value="terima" class="btn btn-success"><i class="fas fa-check"></i> Terima Pembayaran</button>
                </form>
                <?php else: ?>
                    <div class="alert alert-success mt-3"><i class="fas fa-check-circle"></i> Pembayaran ini sudah diproses.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
