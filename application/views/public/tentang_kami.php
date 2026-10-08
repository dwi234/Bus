<?php $this->load->view('public/layout/header'); ?>

<section class="about-section py-5">
    <div class="container py-4">
        <div class="row mb-5">
            <div class="col-lg-12 col-12 text-center">
                <h2 class="mb-4 fw-bold" style="color: #1e293b;">Tentang Dheemobilindo</h2>
            </div>
        </div>

        <div class="row align-items-center mb-5 pb-5">
            <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                <img src="<?= base_url('assets/img/bus/3473fb8ea2fe44e83aec89a65399e184.jpeg') ?>" class="img-fluid d-block" alt="Armada Dheemobilindo" style="width: 100%; aspect-ratio: 16/10; object-fit: cover; border-radius: 16px; box-shadow: 0 12px 35px rgba(0,0,0,0.15);">
            </div>

            <div class="col-lg-5 col-12 offset-lg-1 d-flex flex-column justify-content-center">
                <h5 style="color: #475467; font-weight: 600; font-size: 1.15rem; margin-bottom: 24px;">Mengenal Dheemobilindo Lebih Dekat</h5>
                <p style="color: #667085; font-size: 0.95rem; line-height: 1.7; text-align: justify; margin-bottom: 24px;">
                    Kami adalah penyedia layanan penyewaan armada bus premium yang berdedikasi untuk memberikan pengalaman perjalanan yang aman, nyaman, dan tak terlupakan. Dengan pilihan armada terlengkap yang selalu dalam kondisi prima serta didukung oleh pengemudi profesional, Dheemobilindo siap melayani segala kebutuhan perjalanan Anda mulai dari wisata keluarga, kunjungan industri, hingga acara perusahaan di seluruh Indonesia.
                </p>
                
                <div style="background-color: #f5f8ff; border-left: 4px solid #1a3bb5; padding: 24px; border-radius: 0 12px 12px 0; margin-top: 8px;">
                    <p style="color: #1a3bb5; font-style: italic; font-weight: 600; font-size: 0.95rem; margin: 0; line-height: 1.6;">
                        "Melayani dengan komitmen penuh pada kualitas, kenyamanan, dan ketepatan waktu."
                    </p>
                </div>
            </div>
        </div>

        <!-- Mengapa Memilih Kami Section -->
        <div class="row mt-5 pt-4">
            <div class="col-12 text-center mb-5">
                <h6 style="color: #475467; font-weight: 600; margin-bottom: 12px; font-size: 1.05rem;">Mengapa Memilih Kami?</h6>
                <p style="color: #667085; font-size: 0.95rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">Komitmen kami untuk memberikan pengalaman perjalanan yang tak terlupakan dengan standar layanan tertinggi.</p>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-shield-alt" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Keamanan Terjamin</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Armada terawat secara berkala dengan standar keamanan operasional yang ketat.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-bus" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Armada Mewah</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Fasilitas premium dalam kabin untuk kenyamanan maksimal sepanjang perjalanan.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-id-badge" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Driver Profesional</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Pengemudi berpengalaman dan bersertifikat yang memahami rute dengan baik.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 40px 24px; text-align: center; height: 100%; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <div style="width: 54px; height: 54px; background: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-tag" style="color: #0284c7; font-size: 1.3rem;"></i>
                    </div>
                    <h5 style="color: #334155; font-size: 1rem; font-weight: 600; margin-bottom: 12px;">Harga Terbaik</h5>
                    <p style="color: #64748b; font-size: 0.85rem; line-height: 1.7; margin: 0;">Penawaran harga transparan dan kompetitif tanpa biaya tersembunyi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('public/layout/footer'); ?>
