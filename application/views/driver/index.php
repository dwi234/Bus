<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Supir</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Driver</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahModal">
                        <i class="fas fa-plus fa-sm"></i> Tambah Driver
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Driver</th>
                                    <th>Telepon</th>
                                    <th>Bus yang Ditugaskan</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($driver as $d) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $d['nama']; ?></td>
                                    <td><?= $d['tlp']; ?></td>
                                    <td><?= htmlspecialchars($d['bus_nama'] ?? '-'); ?></td>
                                    <td>
                                        <?php if($d['status'] == 'bisa bertugas'): ?>
                                            <span class="badge badge-success">Bisa Bertugas</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Tidak Bisa Bertugas</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($d['keterangan'] ?? '-'); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editModal<?= $d['driver_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                                        <a href="<?= base_url('driver/hapus/'.$d['driver_id']); ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i> Hapus</a>
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Driver</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('driver/tambah') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Driver</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="tlp" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Bus yang Ditugaskan</label>
                    <select name="bus_id" class="form-control" required>
                        <option value="">-- Pilih Bus --</option>
                        <?php foreach($buses as $bus): ?>
                            <option value="<?= $bus['bus_id'] ?>"><?= htmlspecialchars($bus['bus_nama']) ?> (<?= htmlspecialchars($bus['tipe_bus']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="statusTambah" class="form-control" required>
                        <option value="bisa bertugas">Bisa Bertugas</option>
                        <option value="tidak bisa bertugas">Tidak Bisa Bertugas</option>
                    </select>
                </div>
                <div class="form-group" id="keteranganGroupTambah" style="display: none;">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" placeholder="Tulis alasan tidak bisa bertugas..."></textarea>
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
<?php foreach ($driver as $d) : ?>
<div class="modal fade" id="editModal<?= $d['driver_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Driver</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('driver/edit') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" name="driver_id" value="<?= $d['driver_id']; ?>">
                <div class="form-group">
                    <label>Nama Driver</label>
                    <input type="text" name="nama" class="form-control" value="<?= $d['nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="tlp" class="form-control" value="<?= $d['tlp']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Bus yang Ditugaskan</label>
                    <select name="bus_id" class="form-control" required>
                        <option value="">-- Pilih Bus --</option>
                        <?php foreach($buses as $bus): ?>
                            <option value="<?= $bus['bus_id'] ?>" <?= (isset($d['bus_id']) && $d['bus_id'] == $bus['bus_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($bus['bus_nama']) ?> (<?= htmlspecialchars($bus['tipe_bus']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control statusEdit" data-id="<?= $d['driver_id']; ?>" required>
                        <option value="bisa bertugas" <?= $d['status'] == 'bisa bertugas' ? 'selected' : ''; ?>>Bisa Bertugas</option>
                        <option value="tidak bisa bertugas" <?= $d['status'] == 'tidak bisa bertugas' ? 'selected' : ''; ?>>Tidak Bisa Bertugas</option>
                    </select>
                </div>
                <div class="form-group keteranganGroupEdit" id="keteranganGroupEdit<?= $d['driver_id']; ?>" style="<?= $d['status'] == 'tidak bisa bertugas' ? '' : 'display: none;'; ?>">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" placeholder="Tulis alasan tidak bisa bertugas..."><?= htmlspecialchars($d['keterangan'] ?? ''); ?></textarea>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handling status change in Tambah Modal
    const statusTambah = document.getElementById('statusTambah');
    const keteranganGroupTambah = document.getElementById('keteranganGroupTambah');
    if (statusTambah && keteranganGroupTambah) {
        statusTambah.addEventListener('change', function() {
            if (this.value === 'tidak bisa bertugas') {
                keteranganGroupTambah.style.display = 'block';
                keteranganGroupTambah.querySelector('textarea').setAttribute('required', 'required');
            } else {
                keteranganGroupTambah.style.display = 'none';
                keteranganGroupTambah.querySelector('textarea').removeAttribute('required');
                keteranganGroupTambah.querySelector('textarea').value = '';
            }
        });
    }

    // Handling status change in Edit Modals
    const statusEdits = document.querySelectorAll('.statusEdit');
    statusEdits.forEach(function(select) {
        select.addEventListener('change', function() {
            const driverId = this.getAttribute('data-id');
            const keteranganGroup = document.getElementById('keteranganGroupEdit' + driverId);
            if (keteranganGroup) {
                if (this.value === 'tidak bisa bertugas') {
                    keteranganGroup.style.display = 'block';
                    keteranganGroup.querySelector('textarea').setAttribute('required', 'required');
                } else {
                    keteranganGroup.style.display = 'none';
                    keteranganGroup.querySelector('textarea').removeAttribute('required');
                    keteranganGroup.querySelector('textarea').value = '';
                }
            }
        });
    });
});
</script>
