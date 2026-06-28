<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Pelanggan</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahModal">
                        <i class="fas fa-plus fa-sm"></i> Tambah Pelanggan
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Customer</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($customer as $c) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $c['nama']; ?></td>
                                    <td><?= $c['email']; ?></td>
                                    <td><?= $c['tlp']; ?></td>
                                    <td><?= $c['alamat']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editModal<?= $c['customer_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                                        <?php if ($c['booking_count'] == 0): ?>
                                            <a href="<?= base_url('customer/hapus/'.$c['customer_id']); ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus akun kosong ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary mb-1" disabled title="Pelanggan ini memiliki riwayat pesanan aktif" style="opacity: 0.6; cursor: not-allowed;"><i class="fas fa-trash"></i> Hapus</button>
                                        <?php endif; ?>
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Pelanggan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('customer/tambah') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="tlp" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
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
<?php foreach ($customer as $c) : ?>
<div class="modal fade" id="editModal<?= $c['customer_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Pelanggan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('customer/edit') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" name="customer_id" value="<?= $c['customer_id']; ?>">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= $c['nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $c['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="tlp" class="form-control" value="<?= $c['tlp']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?= $c['alamat']; ?></textarea>
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
