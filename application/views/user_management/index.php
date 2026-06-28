<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users-cog mr-2"></i>Manajemen Pengguna</h1>
    </div>

    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-1"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Superadmin</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_superadmin ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-shield fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Admin Operasional</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_operasional ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-cogs fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Admin Reservasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_reservasi ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Admin</h6>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahModal">
                <i class="fas fa-user-plus fa-sm"></i> Tambah Admin
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($admins as $a) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?= $a['nama_lengkap'] ? $a['nama_lengkap'] : '-'; ?>
                                <?php if($a['admin_id'] == $this->session->userdata('admin_id')): ?>
                                    <span class="badge badge-light border ml-1">Anda</span>
                                <?php endif; ?>
                            </td>
                            <td><code><?= $a['username']; ?></code></td>
                            <td>
                                <?php if($a['role'] == 'superadmin'): ?>
                                    <span class="badge badge-danger px-2 py-1"><i class="fas fa-user-shield mr-1"></i>Superadmin</span>
                                <?php elseif($a['role'] == 'operasional'): ?>
                                    <span class="badge badge-warning px-2 py-1"><i class="fas fa-cogs mr-1"></i>Operasional</span>
                                <?php else: ?>
                                    <span class="badge badge-info px-2 py-1"><i class="fas fa-clipboard-list mr-1"></i>Reservasi</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $a['created_at'] ? date('d M Y H:i', strtotime($a['created_at'])) : '-'; ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editModal<?= $a['admin_id']; ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="<?= base_url('usermanagement/reset_password/'.$a['admin_id']); ?>" 
                                   class="btn btn-sm btn-secondary mb-1" 
                                   onclick="return confirm('Reset password <?= $a['username'] ?> ke default (username+123)?')">
                                    <i class="fas fa-key"></i> Reset
                                </a>
                                <?php if($a['admin_id'] != $this->session->userdata('admin_id')): ?>
                                <a href="<?= base_url('usermanagement/hapus/'.$a['admin_id']); ?>" 
                                   class="btn btn-sm btn-danger mb-1" 
                                   onclick="return confirm('Yakin ingin menghapus akun <?= $a['username'] ?>?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
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

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus mr-2"></i>Tambah Admin Baru</h5>
                <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="<?= base_url('usermanagement/tambah') ?>" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username untuk login" required>
                    <small class="form-text text-muted">Username harus unik, tidak boleh sama dengan yang sudah ada.</small>
                </div>
                <div class="form-group">
                    <label>Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 4 karakter" minlength="4" required>
                </div>
                <div class="form-group">
                    <label>Role / Jabatan <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="superadmin">🛡️ Superadmin — Akses penuh semua fitur</option>
                        <option value="operasional">⚙️ Operasional — Bus, Driver, Jadwal</option>
                        <option value="reservasi">📋 Reservasi — Customer, Booking, Payment</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i>Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($admins as $a) : ?>
<div class="modal fade" id="editModal<?= $a['admin_id']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Edit Admin: <?= $a['username'] ?></h5>
                <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="<?= base_url('usermanagement/edit') ?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="admin_id" value="<?= $a['admin_id']; ?>">
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= $a['nama_lengkap']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= $a['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah" minlength="4">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                </div>
                <div class="form-group">
                    <label>Role / Jabatan <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="superadmin" <?= $a['role'] == 'superadmin' ? 'selected' : ''; ?>>🛡️ Superadmin</option>
                        <option value="operasional" <?= $a['role'] == 'operasional' ? 'selected' : ''; ?>>⚙️ Operasional</option>
                        <option value="reservasi" <?= $a['role'] == 'reservasi' ? 'selected' : ''; ?>>📋 Reservasi</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-warning" type="submit"><i class="fas fa-save mr-1"></i>Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
