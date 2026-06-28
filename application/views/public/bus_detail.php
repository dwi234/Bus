<?php $this->load->view('public/layout/header'); ?>

<style>
    .detail-section {
        background-color: #f9fafb;
        padding: 60px 0;
        min-height: calc(100vh - 80px);
    }
    .detail-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 12px 32px rgba(0,0,0,0.05);
        border: 1px solid #eaecf0;
    }
    .detail-img-wrapper {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16 / 10;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .detail-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    .detail-img-wrapper .placeholder-icon {
        font-size: 8rem;
        color: rgba(255,255,255,0.2);
    }
    .detail-content {
        padding: 40px;
    }
    .detail-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 10px;
        letter-spacing: -0.02em;
    }
    .detail-price-box {
        background: #f0f4ff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        border: 1px solid #c7d2fe;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .price-item {
        text-align: center;
        flex: 1;
    }
    .price-item:first-child {
        border-right: 1px solid #c7d2fe;
    }
    .price-label {
        font-size: 0.8rem;
        color: #667085;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
    }
    .price-amount {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a3bb5;
    }
    .detail-subtitle {
        font-size: 1.1rem;
        font-weight: 700;
        color: #344054;
        margin-bottom: 16px;
        border-bottom: 2px solid #eaecf0;
        padding-bottom: 8px;
    }
    .spec-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 30px;
    }
    .spec-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .spec-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #f9fafb;
        border: 1px solid #eaecf0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #1a3bb5;
    }
    .spec-text .label {
        font-size: 0.75rem;
        color: #667085;
        font-weight: 600;
        text-transform: uppercase;
    }
    .spec-text .value {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
    }
    .desc-text {
        font-size: 1rem;
        line-height: 1.8;
        color: #475467;
        margin-bottom: 40px;
        white-space: pre-line;
    }
    .btn-book-large {
        display: block;
        width: 100%;
        padding: 16px;
        background: #1a3bb5;
        color: white;
        text-align: center;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
    }
    .btn-book-large:hover {
        background: #1530a0;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26,59,181,0.25);
        color: white;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667085;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 24px;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #1a3bb5;
    }
</style>

<section class="detail-section">
    <div class="container">
        <a href="<?= base_url('home/bus_catalog') ?>" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Katalog
        </a>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="detail-card">
                    <div class="detail-img-wrapper">
                        <?php if(!empty($bus['foto'])): ?>
                            <img src="<?= base_url('assets/img/bus/' . $bus['foto']) ?>" alt="<?= htmlspecialchars($bus['bus_nama']) ?>">
                        <?php else: ?>
                            <i class="fas fa-bus-alt placeholder-icon"></i>
                        <?php endif; ?>
                        <?php if(isset($bus['avg_rating']) && $bus['avg_rating'] >= 4.8 && $bus['total_rentals'] >= 10): ?>
                            <span style="position: absolute; top: 20px; left: 20px; font-size: 0.9rem; padding: 8px 16px; border-radius: 8px; background: #e74a3b; color: #fff; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;">
                                <i class="fas fa-star" style="margin-right: 3px;"></i> TOP RATED
                            </span>
                        <?php endif; ?>
                        <span class="badge badge-<?= $bus['status'] == 'available' ? 'success' : ($bus['status'] == 'booked' ? 'warning' : 'danger') ?>" style="position: absolute; top: 20px; right: 20px; font-size: 0.9rem; padding: 8px 16px; border-radius: 8px;">
                            <?= ucfirst($bus['status'] ?? 'available') ?>
                        </span>
                    </div>
                    
                    <div class="detail-content">
                        <h1 class="detail-title" style="margin-bottom: 5px;"><?= htmlspecialchars($bus['bus_nama']) ?></h1>
                        <?php if(isset($bus['avg_rating']) && $bus['total_reviews'] > 0): ?>
                        <div style="font-size: 1.2rem; color: #fbbf24; font-weight: 700; margin-bottom: 15px;">
                            <i class="fas fa-star"></i> <?= number_format($bus['avg_rating'], 1) ?> 
                            <span style="color: #667085; font-weight: 500; font-size: 0.9rem;">(<?= $bus['total_reviews'] ?> Ulasan)</span>
                        </div>
                        <?php endif; ?>
                        <p class="text-muted mb-4"><i class="fas fa-tag mr-2"></i> Kategori: <?= htmlspecialchars($bus['tipe_bus']) ?></p>

                        <div class="detail-price-box">
                            <div class="price-item">
                                <div class="price-label">Sewa Dalam Kota</div>
                                <div class="price-amount">Rp <?= number_format($bus['harga_dalam_kota'], 0, ',', '.') ?> <span style="font-size:0.8rem; color:#667085;">/ hari</span></div>
                            </div>
                            <div class="price-item">
                                <div class="price-label">Sewa Luar Kota</div>
                                <div class="price-amount">Rp <?= number_format($bus['harga_luar_kota'], 0, ',', '.') ?> <span style="font-size:0.8rem; color:#667085;">/ hari</span></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <h3 class="detail-subtitle">Spesifikasi & Fasilitas</h3>
                                <div class="spec-grid">
                                    <div class="spec-item">
                                        <div class="spec-icon"><i class="fas fa-users"></i></div>
                                        <div class="spec-text">
                                            <div class="label">Kapasitas</div>
                                            <div class="value"><?= $bus['kapasitas'] ?> Penumpang</div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                        $fac = strtolower($bus['fasilitas'] ?? '');
                                        $icons = [];
                                        if (strpos($fac, 'ac') !== false) $icons[] = ['fas fa-snowflake', 'Full AC'];
                                        if (strpos($fac, 'wifi') !== false) $icons[] = ['fas fa-wifi', 'WiFi Onboard'];
                                        if (strpos($fac, 'toilet') !== false) $icons[] = ['fas fa-restroom', 'Toilet'];
                                        if (strpos($fac, 'tv') !== false || strpos($fac, 'audio') !== false) $icons[] = ['fas fa-tv', 'Entertainment (TV/Audio)'];
                                        if (strpos($fac, 'usb') !== false) $icons[] = ['fas fa-plug', 'USB Charger'];
                                        if (strpos($fac, 'reclining') !== false) $icons[] = ['fas fa-couch', 'Reclining Seat'];
                                        if (strpos($fac, 'bagasi') !== false) $icons[] = ['fas fa-suitcase', 'Bagasi Luas'];
                                        if (empty($icons)) $icons[] = ['fas fa-check-circle', 'Standard'];
                                    ?>
                                    
                                    <?php foreach($icons as $ic): ?>
                                    <div class="spec-item">
                                        <div class="spec-icon"><i class="<?= $ic[0] ?>"></i></div>
                                        <div class="spec-text">
                                            <div class="label">Fasilitas</div>
                                            <div class="value"><?= $ic[1] ?></div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h3 class="detail-subtitle">Deskripsi Tambahan</h3>
                                <div class="desc-text">
                                    <?= !empty($bus['deskripsi']) ? nl2br(htmlspecialchars($bus['deskripsi'])) : 'Tidak ada deskripsi tambahan untuk armada ini.' ?>
                                </div>
                                
                                <div class="mt-4 pt-4 border-top">
                                    <?php if(isset($bus['status']) && strtolower($bus['status']) === 'maintenance'): ?>
                                        <button type="button" class="btn-book-large" style="background: #98a2b3; color: #fff; cursor: not-allowed; box-shadow: none;" disabled>
                                            <i class="fas fa-tools mr-2"></i> Bus Under Maintenance
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= base_url('home/booking_page?bus_id=' . $bus['bus_id']) ?>" class="btn-book-large">
                                            <i class="fas fa-calendar-check mr-2"></i> Book This Bus Now
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Review -->
                <?php if(!empty($reviews)): ?>
                <div class="detail-card mt-4" style="padding: 40px;">
                    <h3 class="detail-subtitle mb-4">Ulasan Penyewa</h3>
                    <div style="display: grid; gap: 24px;">
                        <?php foreach($reviews as $r): ?>
                        <div style="border-bottom: 1px solid #eaecf0; padding-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <div style="font-weight: 700; color: #1e293b; font-size: 1.05rem;">
                                    <?php 
                                        $name = htmlspecialchars($r['customer_name']); 
                                        echo $name;
                                    ?>
                                </div>
                                <div style="color: #98a2b3; font-size: 0.85rem; font-weight: 500;">
                                    <?= date('d M Y', strtotime($r['created_at'])) ?>
                                </div>
                            </div>
                            <div style="color: #fbbf24; margin-bottom: 12px; font-size: 0.95rem;">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i class="fas fa-star" <?= $i > $r['rating'] ? 'style="color: #e2e8f0;"' : '' ?>></i>
                                <?php endfor; ?>
                            </div>
                            <?php if(!empty($r['review_text'])): ?>
                                <p style="color: #475467; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                                    "<?= nl2br(htmlspecialchars($r['review_text'])) ?>"
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('public/layout/footer'); ?>
