<?php $this->load->view('public/layout/header'); ?>

<section class="events-section section-bg py-5" style="background-color: #f8fafc; min-height: calc(100vh - 80px);">
    <div class="container py-4">
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert-landing alert-landing-danger">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert-landing alert-landing-success">
                <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if(!$this->session->userdata('guest_email')): ?>
                <div class="col-12">
                    <div class="cta-banner" style="background: linear-gradient(rgba(0, 48, 91, 0.85), rgba(0, 48, 91, 0.85)), url('<?= base_url('assets/img/bus_dru.jpg') ?>') center/cover no-repeat; border-radius: 20px; padding: 80px 40px; text-align: center; color: white; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                        <h2 style="color: white; font-weight: 700; margin-bottom: 20px; font-size: 2.5rem;">Siap Memulai Perjalanan Bersama Kami?</h2>
                        <p style="font-size: 1.1rem; max-width: 700px; margin: 0 auto 40px; line-height: 1.8; color: #e0f2fe;">Bergabunglah dengan ribuan pelanggan yang telah menikmati perjalanan aman dan nyaman. Masuk dengan Google sekarang dan pesan armada Anda hanya dalam hitungan detik.</p>
                        <a href="<?= base_url('home/guest_login') ?>" class="btn" style="background: #fff; color: #00305b; font-weight: 600; padding: 15px 35px; border-radius: 50px; font-size: 1.1rem; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                            <i class="bi bi-google" style="font-size: 1.3rem;"></i>
                            Login & Pesan Sekarang
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-lg-12 col-12 text-center mb-5">
                    <h2 class="fw-bold" style="color: #1e293b;">Form Pemesanan Bus</h2>
                    <p style="color: #64748b;">Lengkapi formulir di bawah ini untuk memesan armada Anda. Tim kami akan mengkonfirmasi ketersediaan dan mengirimkan instruksi pembayaran.</p>
                </div>

                <div class="col-xl-11 col-lg-12 col-12 mx-auto">
                <form action="<?= base_url('home/booking') ?>" method="POST" id="bookingForm" role="form">
                    <div class="row">
                        <!-- Kolom Kiri: Informasi Perjalanan & Pilih Armada -->
                        <div class="col-lg-6 col-12 d-flex flex-column">
                            <!-- Section 1: Informasi Perjalanan -->
                            <div class="bg-white shadow-sm mb-4 flex-fill d-flex flex-column justify-content-between" style="padding: 30px; border-radius: 16px; border: 1px solid #eaecf0;">
                                <div>
                                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #1a3bb5; margin-bottom: 20px; border-bottom: 2px solid #f0f4ff; padding-bottom: 10px;">
                                        <i class="fas fa-calendar-alt mr-2"></i> 1. Informasi Perjalanan
                                    </h4>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="tanggal_keberangkatan" id="tanggal_keberangkatan" class="form-control" required min="<?= date('Y-m-d') ?>">
                                                <label for="tanggal_keberangkatan">Tanggal Berangkat *</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="tanggal_pulang" id="tanggal_pulang" class="form-control" required min="<?= date('Y-m-d') ?>">
                                                <label for="tanggal_pulang">Tanggal Pulang *</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12">
                                            <div class="form-floating mb-3">
                                                <select name="tipe_perjalanan" id="tipe_perjalanan" class="form-control" required style="padding-top: 1.625rem; padding-bottom: 0.625rem; height: auto;">
                                                    <option value="">— Pilih Tipe Perjalanan —</option>
                                                    <option value="dalam_kota">Dalam Kota</option>
                                                    <option value="luar_kota">Luar Kota</option>
                                                </select>
                                                <label for="tipe_perjalanan">Tipe Perjalanan *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Pilih Armada -->
                            <div class="bg-white shadow-sm mb-4 flex-fill d-flex flex-column justify-content-between" style="padding: 30px; border-radius: 16px; border: 1px solid #eaecf0;">
                                <div>
                                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #1a3bb5; margin-bottom: 20px; border-bottom: 2px solid #f0f4ff; padding-bottom: 10px;">
                                        <i class="fas fa-bus mr-2"></i> 2. Pilih Armada
                                    </h4>
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="alert alert-info" id="busSelectAlert" style="font-size: 0.9rem; display: none;">
                                                <i class="fas fa-info-circle mr-2"></i> Silakan tentukan Tanggal Berangkat dan Tanggal Pulang terlebih dahulu untuk melihat armada yang tersedia.
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select name="bus_id" id="bus_id" class="form-control" required style="padding-top: 1.625rem; padding-bottom: 0.625rem; height: auto;" disabled>
                                                    <option value="">— Pilih Armada —</option>
                                                    <?php if(!empty($buses)): ?>
                                                        <?php $selected_bus = $this->input->get('bus_id'); ?>
                                                        <?php foreach($buses as $b): ?>
                                                        <option value="<?= $b['bus_id'] ?>" data-price-dalam="<?= $b['harga_dalam_kota'] ?>" data-price-luar="<?= $b['harga_luar_kota'] ?>" <?= ($selected_bus == $b['bus_id']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($b['bus_nama']) ?> — <?= $b['kapasitas'] ?? '-' ?> Kursi
                                                        </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                                <label for="bus_id">Pilih Bus *</label>
                                            </div>

                                            <!-- Live Price Estimate -->
                                            <div id="priceEstimate" style="display: none; background: #f0f4ff; border-radius: 10px; padding: 16px; margin-top: 15px; border: 1px solid #c7d2fe;">
                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                                    <span style="font-size: 0.9rem; color: #667085;">Estimasi Harga</span>
                                                    <span id="estDays" style="font-size: 0.9rem; color: #667085;"></span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                                    <span style="font-weight: 700; font-size: 1.1rem; color: #1a1a2e;">Total</span>
                                                    <span id="estTotal" style="font-weight: 800; font-size: 1.2rem; color: #1a3bb5;"></span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                    <span style="font-size: 0.9rem; color: #667085;">Minimal DP (30%)</span>
                                                    <span id="estDP" style="font-weight: 700; font-size: 1rem; color: #e74a3b;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Detail Rute & Data Pemesan -->
                        <div class="col-lg-6 col-12 d-flex flex-column">
                            <!-- Section 3: Detail Rute & Lokasi -->
                            <div class="bg-white shadow-sm mb-4 flex-fill d-flex flex-column justify-content-between" style="padding: 30px; border-radius: 16px; border: 1px solid #eaecf0;">
                                <div>
                                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #1a3bb5; margin-bottom: 20px; border-bottom: 2px solid #f0f4ff; padding-bottom: 10px;">
                                        <i class="fas fa-map-marker-alt mr-2"></i> 3. Detail Rute & Lokasi
                                    </h4>
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="lokasi_penjemputan" id="lokasi_penjemputan" class="form-control" placeholder="Lokasi Penjemputan" required>
                                                <label for="lokasi_penjemputan">Lokasi Penjemputan *</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="tempat_tujuan" id="tempat_tujuan" class="form-control" placeholder="Tempat Tujuan" required>
                                                <label for="tempat_tujuan">Tempat Tujuan *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Data Pemesan -->
                            <div class="bg-white shadow-sm mb-4 flex-fill d-flex flex-column justify-content-between" style="padding: 30px; border-radius: 16px; border: 1px solid #eaecf0;">
                                <div>
                                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #1a3bb5; margin-bottom: 20px; border-bottom: 2px solid #f0f4ff; padding-bottom: 10px;">
                                        <i class="fas fa-user mr-2"></i> 4. Data Pemesan
                                    </h4>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" value="<?= htmlspecialchars($this->session->userdata('guest_name') ?? '') ?>" required>
                                                <label for="nama">Nama Lengkap *</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="08xxxxxxxxxx" required>
                                                <label for="no_telp">No. WhatsApp *</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat">
                                                <label for="alamat">Alamat</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3 mb-5">
                        <button type="button" class="btn" style="background-color: #1a3bb5; color: white; padding: 18px 60px; border-radius: 12px; font-weight: 700; font-size: 1.15rem; transition: all 0.3s; display: inline-block; width: auto; min-width: 280px;" onclick="openSnkModal()" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(26,59,181,0.25)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">Booking Sekarang</button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Syarat & Ketentuan Modal -->
<div class="modal fade" id="snkModal" tabindex="-1" aria-labelledby="snkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="snkModalLabel" style="font-weight: 700; color: #1e293b;">Syarat dan Ketentuan Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="snkModalBody" style="font-size: 0.9rem; line-height: 1.6; max-height: 400px; overflow-y: auto;" onscroll="checkScroll()">
                <p><strong>1. Sistem Pembayaran</strong></p>
                <ul>
                    <li>Pemesanan dianggap sah apabila pelanggan telah melakukan pembayaran Down Payment (DP) sebesar 30% dari total harga sewa.</li>
                    <li>Pelunasan biaya sewa (Sisa Pembayaran) wajib dibayarkan maksimal H-3 sebelum tanggal keberangkatan.</li>
                </ul>
                <p><strong>2. Pembatalan & Denda</strong></p>
                <ul>
                    <li>Apabila hingga H-3 keberangkatan pihak pelanggan belum melakukan pelunasan, maka booking otomatis <strong>DIBATALKAN</strong> oleh sistem.</li>
                    <li>Dalam kasus pembatalan otomatis tersebut, uang DP hangus dan pelanggan dikenakan denda sebesar <strong>Rp 50.000</strong>.</li>
                    <li>Apabila pelanggan membatalkan pesanan secara sepihak pada Hari H (setelah lunas), maka seluruh uang yang telah dibayarkan <strong>HANGUS 100%</strong> dan tetap dikenakan denda sebesar <strong>Rp 50.000</strong>.</li>
                </ul>
                <p><strong>3. Harga dan Layanan</strong></p>
                <ul>
                    <li>Harga Sewa Dalam Kota dan Luar Kota memiliki perbedaan tarif sesuai dengan jarak tempuh dan biaya operasional.</li>
                    <li>Harga belum termasuk biaya tol, parkir, retribusi daerah, dan tip supir (opsional).</li>
                </ul>
                <p><strong>4. Lain-lain</strong></p>
                <ul>
                    <li>Pihak perusahaan berhak merubah armada bus yang setara apabila terjadi kendala teknis pada armada yang dipesan.</li>
                    <li>Dilarang membawa barang bawaan yang melanggar hukum ke dalam bus.</li>
                    <li>Kerusakan fasilitas bus akibat kelalaian penyewa akan dikenakan biaya ganti rugi sesuai kerusakan.</li>
                </ul>
                <p>Dengan mencentang kotak persetujuan, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh aturan di atas secara sadar tanpa paksaan dari pihak mana pun.</p>
                
                <div class="form-check mt-4" style="border-top: 1px solid #ddd; padding-top: 15px;">
                    <input class="form-check-input" type="checkbox" id="modal_snk_checkbox" disabled onchange="toggleModalSubmit()">
                    <label class="form-check-label" for="modal_snk_checkbox" style="font-size: 0.9rem; font-weight: bold; color: #b42318; transition: color 0.3s;">
                        ↓ Silakan scroll ke bawah untuk dapat menyetujui Syarat dan Ketentuan.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="border-radius: 8px; font-weight: 500;" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn" style="background: #1a3bb5; color: white; padding: 8px 24px; border-radius: 8px; font-weight: 600;" id="btnModalSubmit" disabled onclick="submitBookingForm()">Setuju & Booking</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('public/layout/footer'); ?>

<script>
    const busSelect = document.getElementById('bus_id');
    const tipeSelect = document.getElementById('tipe_perjalanan');
    const dateStart = document.getElementById('tanggal_keberangkatan');
    const dateEnd = document.getElementById('tanggal_pulang');
    const priceBox = document.getElementById('priceEstimate');

    function calcEstimate() {
        if(!busSelect) return;
        const opt = busSelect.options[busSelect.selectedIndex];
        const tipe = tipeSelect.value;
        
        let price = 0;
        if (opt && opt.value !== "" && tipe) {
            if (tipe === 'dalam_kota') {
                price = parseInt(opt.getAttribute('data-price-dalam'));
            } else if (tipe === 'luar_kota') {
                price = parseInt(opt.getAttribute('data-price-luar'));
            }
        }
        
        const d1 = new Date(dateStart.value);
        const d2 = new Date(dateEnd.value);

        if (price && dateStart.value && dateEnd.value && d2 >= d1) {
            let days = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
            if (days < 1) days = 1;
            const total = price * days;
            const dp = total * 0.3; // DP 30% dari total
            
            document.getElementById('estDays').textContent = days + ' hari × Rp ' + price.toLocaleString('id-ID');
            document.getElementById('estTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('estDP').textContent = 'Rp ' + dp.toLocaleString('id-ID');
            priceBox.style.display = 'block';
        } else {
            priceBox.style.display = 'none';
        }
    }

    function checkAvailability() {
        if(!dateStart || !dateEnd) return;
        const start = dateStart.value;
        const end = dateEnd.value;
        const alertBox = document.getElementById('busSelectAlert');
        
        if(start && end && new Date(end) >= new Date(start)) {
            // Tampilkan state loading
            busSelect.disabled = true;
            if(alertBox) {
                alertBox.style.display = 'block';
                alertBox.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengecek ketersediaan armada...';
            }

            // Call AJAX
            $.ajax({
                url: '<?= base_url('home/check_availability') ?>',
                type: 'POST',
                data: { start_date: start, end_date: end },
                dataType: 'json',
                success: function(unavailable_ids) {
                    // Reset all options first
                    Array.from(busSelect.options).forEach(opt => {
                        if(opt.value !== "") {
                            opt.disabled = false;
                            opt.text = opt.text.replace(' (Tidak Tersedia)', '');
                        }
                    });

                    if(unavailable_ids && unavailable_ids.length > 0) {
                        Array.from(busSelect.options).forEach(opt => {
                            if(unavailable_ids.includes(opt.value)) {
                                opt.disabled = true;
                                opt.text = opt.text + ' (Tidak Tersedia)';
                                // If currently selected is disabled, reset selection
                                if(opt.selected) {
                                    busSelect.value = "";
                                    calcEstimate();
                                }
                            }
                        });
                    }
                    
                    // Enable select & hide alert
                    busSelect.disabled = false;
                    if(alertBox) alertBox.style.display = 'none';
                },
                error: function() {
                    // Fallback
                    busSelect.disabled = false;
                    if(alertBox) alertBox.style.display = 'none';
                }
            });
        } else {
            // Disable select if dates are invalid
            busSelect.disabled = true;
            if(alertBox) {
                alertBox.style.display = 'block';
                alertBox.innerHTML = '<i class="fas fa-info-circle mr-2"></i> Silakan tentukan Tanggal Berangkat dan Tanggal Pulang terlebih dahulu untuk melihat armada yang tersedia.';
            }
        }
    }
    // JavaScript Modal Logic for S&K
    function openSnkModal() {
        var form = document.getElementById("bookingForm");
        if (form.reportValidity()) { // HTML5 Validation
            var myModal = new bootstrap.Modal(document.getElementById('snkModal'));
            myModal.show();
            
            // Reset states
            var cb = document.getElementById('modal_snk_checkbox');
            var lbl = document.querySelector('label[for="modal_snk_checkbox"]');
            var btn = document.getElementById('btnModalSubmit');
            
            cb.checked = false;
            cb.disabled = true;
            btn.disabled = true;
            lbl.innerHTML = "↓ Silakan scroll ke bawah untuk dapat menyetujui Syarat dan Ketentuan.";
            lbl.style.color = "#b42318";
            
            var body = document.getElementById('snkModalBody');
            body.scrollTop = 0; // reset scroll to top
            
            // Allow checking immediately if the content is too short to scroll
            setTimeout(function() {
                if (body.scrollHeight <= body.clientHeight + 10) {
                    enableCheckbox();
                }
            }, 300);
        }
    }
    
    function checkScroll() {
        var body = document.getElementById('snkModalBody');
        // Allow a 10px margin of error
        if (body.scrollTop + body.clientHeight >= body.scrollHeight - 10) {
            enableCheckbox();
        }
    }
    
    function enableCheckbox() {
        var cb = document.getElementById('modal_snk_checkbox');
        var lbl = document.querySelector('label[for="modal_snk_checkbox"]');
        if (cb.disabled) {
            cb.disabled = false;
            lbl.innerHTML = "✓ Saya menyetujui seluruh Syarat dan Ketentuan perusahaan.";
            lbl.style.color = "#1a3bb5";
        }
    }
    
    function toggleModalSubmit() {
        var cb = document.getElementById('modal_snk_checkbox');
        var btn = document.getElementById('btnModalSubmit');
        btn.disabled = !cb.checked;
    }
    
    function submitBookingForm() {
        document.getElementById('btnModalSubmit').disabled = true;
        document.getElementById('btnModalSubmit').innerHTML = "Memproses...";
        document.getElementById("bookingForm").submit();
    }

    if(busSelect) busSelect.addEventListener('change', calcEstimate);
    if(tipeSelect) tipeSelect.addEventListener('change', calcEstimate);
    if(dateStart) {
        dateStart.addEventListener('change', function() {
            calcEstimate();
            checkAvailability();
        });
    }
    if(dateEnd) {
        dateEnd.addEventListener('change', function() {
            calcEstimate();
            checkAvailability();
        });
    }

    // Run on load to handle pre-filled dates or URL parameters
    window.addEventListener('DOMContentLoaded', (event) => {
        // Pre-fill from hero search form URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const heroPickup = urlParams.get('pickup');
        const heroDest = urlParams.get('destination');
        const heroDate = urlParams.get('date');

        if (heroPickup) {
            const pickupInput = document.getElementById('lokasi_penjemputan');
            if (pickupInput) pickupInput.value = decodeURIComponent(heroPickup);
        }
        if (heroDest) {
            const destInput = document.getElementById('tempat_tujuan');
            if (destInput) destInput.value = decodeURIComponent(heroDest);
        }
        if (heroDate) {
            const dStart = document.getElementById('tanggal_keberangkatan');
            if (dStart) {
                dStart.value = heroDate;
                dStart.dispatchEvent(new Event('change'));
            }
        }

        checkAvailability();
    });
</script>
