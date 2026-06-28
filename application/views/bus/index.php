<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Bus</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Bus</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahModal">
                        <i class="fas fa-plus fa-sm"></i> Tambah Bus
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bus</th>
                                    <th>Kapasitas</th>
                                    <th>Tipe Bus</th>
                                    <th>Harga Sewa (Dalam / Luar)</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($bus as $b) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $b['bus_nama']; ?></td>
                                    <td><?= $b['kapasitas']; ?></td>
                                    <td><?= htmlspecialchars($b['tipe_bus']); ?></td>
                                    <td>Rp <?= number_format($b['harga_dalam_kota'], 0, ',', '.'); ?> / Rp <?= number_format($b['harga_luar_kota'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if($b['status'] == 'available'): ?>
                                            <span class="badge badge-success">Tersedia</span>
                                        <?php elseif($b['status'] == 'booked'): ?>
                                            <span class="badge badge-warning">Telah Dipesan</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Perawatan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editModal<?= $b['bus_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                                        <a href="<?= base_url('bus/hapus/'.$b['bus_id']); ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i> Hapus</a>
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Bus</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('bus/tambah') ?>" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Bus</label>
                    <input type="text" name="bus_nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tipe Bus</label>
                    <select name="tipe_bus" class="form-control" required>
                        <option value="">Pilih Tipe Bus</option>
                        <option value="Big Bus">Big Bus</option>
                        <option value="Medium Bus">Medium Bus</option>
                        <option value="Mini Bus">Mini Bus</option>
                        <option value="Hiace / Elf">Hiace / Elf</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi Bus</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Fasilitas tambahan, interior, dll"></textarea>
                </div>
                <div class="form-group">
                    <label>Fasilitas Bus</label><br>
                    <?php 
                    $fas_options = ['AC', 'WiFi', 'Toilet', 'TV/Audio', 'USB Charger', 'Kursi Rebah', 'Bagasi'];
                    foreach($fas_options as $opt): 
                    ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="fasilitas[]" value="<?= $opt ?>">
                        <label class="form-check-label"><?= $opt ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label>Foto Bus (Opsional)</label>
                    <input type="file" name="foto" class="form-control-file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Harga Sewa Dalam Kota (Rp)</label>
                    <input type="number" name="harga_dalam_kota" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Harga Sewa Luar Kota (Rp)</label>
                    <input type="number" name="harga_luar_kota" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="available">Tersedia</option>
                        <option value="booked">Telah Dipesan</option>
                        <option value="maintenance">Perawatan</option>
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
<?php foreach ($bus as $b) : ?>
<div class="modal fade" id="editModal<?= $b['bus_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Bus</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('bus/edit') ?>" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="bus_id" value="<?= $b['bus_id']; ?>">
                <div class="form-group">
                    <label>Nama Bus</label>
                    <input type="text" name="bus_nama" class="form-control" value="<?= $b['bus_nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" class="form-control" value="<?= $b['kapasitas']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tipe Bus</label>
                    <select name="tipe_bus" class="form-control" required>
                        <option value="Big Bus" <?= ($b['tipe_bus'] == 'Big Bus') ? 'selected' : ''; ?>>Big Bus</option>
                        <option value="Medium Bus" <?= ($b['tipe_bus'] == 'Medium Bus') ? 'selected' : ''; ?>>Medium Bus</option>
                        <option value="Mini Bus" <?= ($b['tipe_bus'] == 'Mini Bus') ? 'selected' : ''; ?>>Mini Bus</option>
                        <option value="Hiace / Elf" <?= ($b['tipe_bus'] == 'Hiace / Elf') ? 'selected' : ''; ?>>Hiace / Elf</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi Bus</label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($b['deskripsi'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Fasilitas Bus</label><br>
                    <?php 
                    $fas_options = ['AC', 'WiFi', 'Toilet', 'TV/Audio', 'USB Charger', 'Kursi Rebah', 'Bagasi'];
                    $fas_selected = explode(', ', $b['fasilitas'] ?? '');
                    foreach($fas_options as $opt): 
                    ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="fasilitas[]" value="<?= $opt ?>" <?= in_array($opt, $fas_selected) ? 'checked' : '' ?>>
                        <label class="form-check-label"><?= $opt ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label>Foto Bus (Biarkan kosong jika tidak diubah)</label>
                    <br>
                    <?php if(!empty($b['foto'])): ?>
                        <img src="<?= base_url('assets/img/bus/' . $b['foto']) ?>" width="100" class="mb-2 rounded">
                    <?php endif; ?>
                    <input type="file" name="foto" class="form-control-file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Harga Sewa Dalam Kota (Rp)</label>
                    <input type="number" name="harga_dalam_kota" class="form-control" value="<?= $b['harga_dalam_kota']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga Sewa Luar Kota (Rp)</label>
                    <input type="number" name="harga_luar_kota" class="form-control" value="<?= $b['harga_luar_kota']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="available" <?= $b['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                        <option value="booked" <?= $b['status'] == 'booked' ? 'selected' : ''; ?>>Booked</option>
                        <option value="maintenance" <?= $b['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
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
