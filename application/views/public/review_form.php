<?php $this->load->view('public/layout/header'); ?>

<style>
    .review-section {
        background-color: #f8fafc;
        padding: 60px 0;
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .review-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 12px 32px rgba(0,0,0,0.05);
        border: 1px solid #eaecf0;
        max-width: 600px;
        width: 100%;
        text-align: center;
    }
    .review-card h2 {
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 10px;
    }
    .review-card p {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 10px;
        margin-bottom: 24px;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        font-size: 2.5rem;
        color: #cbd5e1;
        cursor: pointer;
        transition: color 0.2s;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #fbbf24;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #1a3bb5;
    }
    .btn-submit {
        background: #1a3bb5;
        color: #fff;
        font-weight: 700;
        padding: 14px 30px;
        border-radius: 12px;
        width: 100%;
        border: none;
        transition: all 0.3s;
        margin-top: 20px;
    }
    .btn-submit:hover {
        background: #1530a0;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26,59,181,0.25);
    }
</style>

<section class="review-section">
    <div class="review-card">
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <h2>Beri Kami Penilaian!</h2>
        <p>Halo Kak <strong><?= htmlspecialchars($booking['customer_name']) ?></strong>,<br>
        Terima kasih telah mempercayakan perjalanan Anda menggunakan armada <strong><?= htmlspecialchars($booking['bus_nama']) ?></strong>.
        Bagaimana pengalaman Anda dengan bus dan layanan sopir kami? Masukan Anda sangat berarti.</p>

        <form action="<?= base_url('review/submit') ?>" method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" required />
                <label for="star5" title="5 Stars"><i class="fas fa-star"></i></label>
                
                <input type="radio" id="star4" name="rating" value="4" />
                <label for="star4" title="4 Stars"><i class="fas fa-star"></i></label>
                
                <input type="radio" id="star3" name="rating" value="3" />
                <label for="star3" title="3 Stars"><i class="fas fa-star"></i></label>
                
                <input type="radio" id="star2" name="rating" value="2" />
                <label for="star2" title="2 Stars"><i class="fas fa-star"></i></label>
                
                <input type="radio" id="star1" name="rating" value="1" />
                <label for="star1" title="1 Star"><i class="fas fa-star"></i></label>
            </div>

            <div class="form-group text-left">
                <label style="font-weight: 600; color: #475467; margin-bottom: 8px; display: block;">Ceritakan Pengalaman Anda (Opsional)</label>
                <textarea name="review_text" class="form-control" rows="4" placeholder="Misal: Sopir Pak Budi sangat sabar bawa anak-anak sekolah, busnya juga wangi dan dingin..." style="border-radius: 12px; resize: none;"></textarea>
            </div>

            <button type="submit" class="btn-submit">Kirim Ulasan</button>
        </form>
    </div>
</section>

<?php $this->load->view('public/layout/footer'); ?>
