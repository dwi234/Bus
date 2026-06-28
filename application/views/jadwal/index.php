<?php
$bus_driver_map = [];
foreach($driver as $dr) {
    if(!empty($dr['bus_id'])) {
        $bus_driver_map[$dr['bus_id']] = [
            'driver_id' => $dr['driver_id'],
            'nama' => $dr['nama']
        ];
    }
}
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Jadwal</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Jadwal</h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahModal">
                        <i class="fas fa-plus fa-sm"></i> Tambah Jadwal
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Booking</th>
                                    <th>Bus</th>
                                    <th>Driver</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($jadwal as $j) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>#<?= $j['booking_id']; ?></td>
                                    <td><?= $j['bus_nama']; ?></td>
                                    <td><?= $j['driver_nama']; ?></td>
                                    <td><?= $j['tangal_mulai']; ?></td>
                                    <td><?= $j['tanggal_selesai']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mb-1" data-toggle="modal" data-target="#editModal<?= $j['jadwal_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                                        <a href="<?= base_url('jadwal/hapus/'.$j['jadwal_id']); ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i> Hapus</a>
                                        <?php if (!empty($j['driver_id']) && !empty($j['driver_tlp'])): ?>
                                            <?php
                                            $phone = preg_replace('/[^0-9]/', '', $j['driver_tlp']);
                                            if (strpos($phone, '0') === 0) {
                                                $phone = '62' . substr($phone, 1);
                                            }
                                            $message = "Halo *" . $j['driver_nama'] . "*,\n\n"
                                                     . "Anda telah ditugaskan untuk mengemudikan armada *" . $j['bus_nama'] . "* (" . $j['tipe_bus'] . ") dengan detail jadwal berikut:\n"
                                                     . "• *Kode Booking:* #BK-" . str_pad($j['booking_id'], 4, '0', STR_PAD_LEFT) . "\n"
                                                     . "• *Customer:* " . ($j['customer_nama'] ?? '-') . "\n"
                                                     . "• *Tanggal Mulai:* " . date('d-m-Y', strtotime($j['tangal_mulai'])) . "\n"
                                                     . "• *Tanggal Selesai:* " . date('d-m-Y', strtotime($j['tanggal_selesai'])) . "\n"
                                                     . "• *Penjemputan:* " . ($j['lokasi_penjemputan'] ?? '-') . "\n"
                                                     . "• *Tujuan:* " . ($j['tempat_tujuan'] ?? '-') . "\n\n"
                                                     . "Mohon untuk bersiap-siap dan melakukan konfirmasi jika sudah menerima informasi ini.\n"
                                                     . "Terima kasih.";
                                            $wa_url = "https://wa.me/" . $phone . "?text=" . urlencode($message);
                                            ?>
                                            <a href="<?= $wa_url ?>" target="_blank" class="btn btn-sm btn-success mb-1" title="Kirim Jadwal via WhatsApp">
                                                <i class="fab fa-whatsapp"></i> Hubungi
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
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Jadwal</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('jadwal/tambah') ?>" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label>Booking ID</label>
                    <select name="booking_id" class="form-control" id="bookingSelectTambah" required>
                        <option value="">-- Pilih Booking --</option>
                        <?php foreach($booking as $bk): 
                            $dr_id = isset($bus_driver_map[$bk['bus_id']]) ? $bus_driver_map[$bk['bus_id']]['driver_id'] : '';
                            $dr_nama = isset($bus_driver_map[$bk['bus_id']]) ? $bus_driver_map[$bk['bus_id']]['nama'] : 'Belum Ada Supir';
                        ?>
                            <option value="<?= $bk['booking_id'] ?>" 
                                data-start="<?= $bk['tanggal_keberangkatan'] ?>" 
                                data-end="<?= $bk['tanggal_pulang'] ?>"
                                data-busid="<?= $bk['bus_id'] ?>"
                                data-busnama="<?= htmlspecialchars($bk['bus_nama']) ?>"
                                data-driverid="<?= $dr_id ?>"
                                data-drivernama="<?= htmlspecialchars($dr_nama) ?>">
                                Booking #<?= $bk['booking_id'] ?> - <?= htmlspecialchars($bk['customer_nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bus yang Bertugas</label>
                    <input type="hidden" name="bus_id" id="busIdTambah" required>
                    <input type="text" id="busNamaTambah" class="form-control" readonly placeholder="Otomatis terisi...">
                </div>
                <div class="form-group">
                    <label>Supir yang Bertugas</label>
                    <input type="hidden" name="driver_id" id="driverIdTambah" required>
                    <input type="text" id="driverNamaTambah" class="form-control" readonly placeholder="Otomatis terisi...">
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tangal_mulai" id="startTambah" class="form-control" required readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="endTambah" class="form-control" required readonly>
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
<?php foreach ($jadwal as $j) : ?>
<div class="modal fade" id="editModal<?= $j['jadwal_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Jadwal</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('jadwal/edit') ?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="jadwal_id" value="<?= $j['jadwal_id']; ?>">
                <div class="form-group">
                    <label>Booking ID</label>
                    <select name="booking_id" class="form-control bookingSelectEdit" data-target="<?= $j['jadwal_id'] ?>" required>
                        <option value="">-- Pilih Booking --</option>
                        <?php foreach($booking as $bk): 
                            $dr_id = isset($bus_driver_map[$bk['bus_id']]) ? $bus_driver_map[$bk['bus_id']]['driver_id'] : '';
                            $dr_nama = isset($bus_driver_map[$bk['bus_id']]) ? $bus_driver_map[$bk['bus_id']]['nama'] : 'Belum Ada Supir';
                        ?>
                            <option value="<?= $bk['booking_id'] ?>" 
                                data-start="<?= $bk['tanggal_keberangkatan'] ?>" 
                                data-end="<?= $bk['tanggal_pulang'] ?>"
                                data-busid="<?= $bk['bus_id'] ?>"
                                data-busnama="<?= htmlspecialchars($bk['bus_nama']) ?>"
                                data-driverid="<?= $dr_id ?>"
                                data-drivernama="<?= htmlspecialchars($dr_nama) ?>"
                                <?= $j['booking_id'] == $bk['booking_id'] ? 'selected' : '' ?>>
                                Booking #<?= $bk['booking_id'] ?> - <?= htmlspecialchars($bk['customer_nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bus yang Bertugas</label>
                    <input type="hidden" name="bus_id" id="busIdEdit<?= $j['jadwal_id'] ?>" value="<?= $j['bus_id'] ?>" required>
                    <input type="text" id="busNamaEdit<?= $j['jadwal_id'] ?>" class="form-control" value="<?= htmlspecialchars($j['bus_nama']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Supir yang Bertugas</label>
                    <input type="hidden" name="driver_id" id="driverIdEdit<?= $j['jadwal_id'] ?>" value="<?= $j['driver_id'] ?>" required>
                    <input type="text" id="driverNamaEdit<?= $j['jadwal_id'] ?>" class="form-control" value="<?= htmlspecialchars($j['driver_nama']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tangal_mulai" id="startEdit<?= $j['jadwal_id'] ?>" class="form-control" value="<?= $j['tangal_mulai']; ?>" required readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="endEdit<?= $j['jadwal_id'] ?>" class="form-control" value="<?= $j['tanggal_selesai']; ?>" required readonly>
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
    // Handling auto-fill for Tambah Modal
    const bookingSelectTambah = document.getElementById('bookingSelectTambah');
    if (bookingSelectTambah) {
        bookingSelectTambah.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const startDate = selectedOption.getAttribute('data-start');
            const endDate = selectedOption.getAttribute('data-end');
            const busId = selectedOption.getAttribute('data-busid');
            const busNama = selectedOption.getAttribute('data-busnama');
            const driverId = selectedOption.getAttribute('data-driverid');
            const driverNama = selectedOption.getAttribute('data-drivernama');
            
            if(this.value !== "") {
                document.getElementById('startTambah').value = startDate;
                document.getElementById('endTambah').value = endDate;
                document.getElementById('busIdTambah').value = busId;
                document.getElementById('busNamaTambah').value = busNama;
                document.getElementById('driverIdTambah').value = driverId;
                document.getElementById('driverNamaTambah').value = driverNama;
            } else {
                document.getElementById('startTambah').value = '';
                document.getElementById('endTambah').value = '';
                document.getElementById('busIdTambah').value = '';
                document.getElementById('busNamaTambah').value = '';
                document.getElementById('driverIdTambah').value = '';
                document.getElementById('driverNamaTambah').value = '';
            }
        });

        // Auto-select booking dan buka modal jika diarahkan dari notifikasi
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = urlParams.get('booking_id');
        if (bookingId) {
            let optionFound = false;
            for (let i = 0; i < bookingSelectTambah.options.length; i++) {
                if (bookingSelectTambah.options[i].value === bookingId) {
                    optionFound = true;
                    break;
                }
            }
            if (optionFound) {
                bookingSelectTambah.value = bookingId;
                bookingSelectTambah.dispatchEvent(new Event('change'));
                
                // Trigger klik tombol Tambah Jadwal agar modal Bootstrap muncul secara alami
                const btnTambah = document.querySelector('[data-target="#tambahModal"]');
                if (btnTambah) {
                    // Beri sedikit delay agar rendering halaman & dependensi Bootstrap siap
                    setTimeout(() => {
                        btnTambah.click();
                    }, 200);
                }
            }
        }
    }

    // Handling auto-fill for Edit Modals
    const editSelects = document.querySelectorAll('.bookingSelectEdit');
    editSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const targetId = this.getAttribute('data-target');
            const selectedOption = this.options[this.selectedIndex];
            const startDate = selectedOption.getAttribute('data-start');
            const endDate = selectedOption.getAttribute('data-end');
            const busId = selectedOption.getAttribute('data-busid');
            const busNama = selectedOption.getAttribute('data-busnama');
            const driverId = selectedOption.getAttribute('data-driverid');
            const driverNama = selectedOption.getAttribute('data-drivernama');
            
            if(this.value !== "") {
                document.getElementById('startEdit' + targetId).value = startDate;
                document.getElementById('endEdit' + targetId).value = endDate;
                document.getElementById('busIdEdit' + targetId).value = busId;
                document.getElementById('busNamaEdit' + targetId).value = busNama;
                document.getElementById('driverIdEdit' + targetId).value = driverId;
                document.getElementById('driverNamaEdit' + targetId).value = driverNama;
            } else {
                document.getElementById('startEdit' + targetId).value = '';
                document.getElementById('endEdit' + targetId).value = '';
                document.getElementById('busIdEdit' + targetId).value = '';
                document.getElementById('busNamaEdit' + targetId).value = '';
                document.getElementById('driverIdEdit' + targetId).value = '';
                document.getElementById('driverNamaEdit' + targetId).value = '';
            }
        });
    });
});
</script>
