<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-check-double text-primary mr-2"></i> Persetujuan Pembayaran</h1>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if(empty($verifications)): ?>
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center p-5">
                        <i class="fas fa-inbox text-gray-300 mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-gray-500">Tidak ada pembayaran yang perlu diverifikasi saat ini.</h5>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($verifications as $v): ?>
                <?php 
                    $is_dp = ($v['booking_status'] == 'menunggu_verifikasi');
                    $badge_class = $is_dp ? 'badge-primary' : 'badge-success';
                    $tipe_text = $is_dp ? 'Down Payment (DP)' : 'Pelunasan';
                    $nominal_harus_dibayar = $is_dp ? $v['dp_nominal'] : $v['sisa_pembayaran'];
                    $bukti_img = $is_dp ? $v['bukti_pembayaran'] : $v['bukti_pelunasan'];
                ?>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card shadow h-100 border-left-<?= $is_dp ? 'primary' : 'success' ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge <?= $badge_class ?> px-2 py-1"><?= $tipe_text ?></span>
                                <span class="text-xs font-weight-bold text-gray-500">#BK-<?= str_pad($v['booking_id'], 4, '0', STR_PAD_LEFT) ?></span>
                            </div>
                            
                            <h5 class="font-weight-bold text-dark mb-1"><?= htmlspecialchars($v['customer_nama']) ?></h5>
                            <p class="text-sm text-gray-600 mb-3"><i class="fas fa-bus mr-1"></i> <?= htmlspecialchars($v['bus_nama']) ?></p>

                            <div class="bg-light p-3 rounded mb-3">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Nominal Transfer (Cek Mutasi)</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($nominal_harus_dibayar, 0, ',', '.') ?></div>
                                <?php if($is_dp): ?>
                                    <div class="text-xs text-danger mt-1">Termasuk Kode Unik: <?= $v['kode_unik'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <button type="button" class="btn btn-outline-info btn-sm btn-block" data-toggle="modal" data-target="#buktiModal<?= $v['booking_id'] ?>">
                                    <i class="fas fa-image"></i> Lihat Bukti Transfer
                                </button>
                            </div>

                            <form action="<?= base_url('booking/verifikasi_pembayaran') ?>" method="post">
                                <input type="hidden" name="booking_id" value="<?= $v['booking_id'] ?>">
                                
                                <div class="row">
                                    <div class="col-6 pr-1">
                                        <button type="submit" name="action" value="terima" class="btn btn-success btn-block" onclick="return confirm('Sahkan pembayaran ini? Pastikan mutasi bank sudah sesuai.')">
                                            <i class="fas fa-check"></i> Sahkan
                                        </button>
                                    </div>
                                    <div class="col-6 pl-1">
                                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#tolakModal<?= $v['booking_id'] ?>">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Tolak -->
                <div class="modal fade" id="tolakModal<?= $v['booking_id'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="<?= base_url('booking/verifikasi_pembayaran') ?>" method="post">
                                <input type="hidden" name="booking_id" value="<?= $v['booking_id'] ?>">
                                <input type="hidden" name="action" value="tolak">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tolak Pembayaran #BK-<?= str_pad($v['booking_id'], 4, '0', STR_PAD_LEFT) ?></h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Alasan Penolakan</label>
                                        <textarea name="alasan_penolakan" class="form-control" rows="3" required placeholder="Contoh: Nominal transfer tidak sesuai mutasi..."></textarea>
                                    </div>
                                    <p class="text-sm text-danger"><i class="fas fa-exclamation-triangle"></i> Status akan dikembalikan dan konsumen diminta upload ulang.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Bukti Transfer -->
                <div class="modal fade" id="buktiModal<?= $v['booking_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Bukti Transfer #BK-<?= str_pad($v['booking_id'], 4, '0', STR_PAD_LEFT) ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <h6 class="font-weight-bold mb-3"><?= $tipe_text ?> - Rp <?= number_format($nominal_harus_dibayar, 0, ',', '.') ?></h6>
                                <img src="<?= base_url('assets/img/bukti_transfer/' . $bukti_img) ?>" alt="Bukti Transfer" class="img-fluid rounded border" style="max-height: 500px; object-fit: contain;">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
