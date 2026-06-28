<?php $this->load->view('public/layout/header'); ?>
<style>
        /* Page Layout */
        .page-layout { display: grid; grid-template-columns: 260px 1fr; gap: 32px; padding: 40px 0 60px; align-items: start; }

        /* Sidebar Filters */
        .sidebar { position: sticky; top: 90px; }
        .filter-card {
            background: #fff; border-radius: 16px; padding: 28px; border: 1px solid #eaecf0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .filter-card h3 { font-size: 1.1rem; font-weight: 800; margin-bottom: 4px; }
        .filter-card .filter-sub { font-size: 0.72rem; color: #98a2b3; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; margin-bottom: 24px; }

        .filter-section { margin-bottom: 24px; }
        .filter-section h4 { font-size: 0.85rem; font-weight: 700; color: #344054; margin-bottom: 12px; }

        /* Range Slider */
        .range-slider { width: 100%; -webkit-appearance: none; height: 4px; border-radius: 4px; background: #eaecf0; outline: none; }
        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none; width: 18px; height: 18px; border-radius: 50%;
            background: #1a3bb5; cursor: pointer; box-shadow: 0 2px 6px rgba(26,59,181,0.3);
        }
        .range-labels { display: flex; justify-content: space-between; margin-top: 8px; font-size: 0.78rem; color: #667085; }

        /* Capacity Buttons */
        .capacity-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .cap-btn {
            padding: 8px 10px; border: 1px solid #d0d5dd; border-radius: 8px; text-align: center;
            font-size: 0.78rem; font-weight: 600; color: #344054; cursor: pointer;
            transition: all 0.2s; background: #fff;
        }
        .cap-btn:hover, .cap-btn.active { background: #1a3bb5; color: #fff; border-color: #1a3bb5; }

        /* Checkbox */
        .filter-check { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; cursor: pointer; }
        .filter-check input[type="checkbox"] {
            width: 18px; height: 18px; accent-color: #1a3bb5; cursor: pointer;
            border-radius: 4px;
        }
        .filter-check label { font-size: 0.85rem; color: #344054; cursor: pointer; }

        .clear-btn {
            width: 100%; padding: 12px; border: 1px solid #d0d5dd; border-radius: 10px;
            background: #fff; font-size: 0.85rem; font-weight: 600; color: #344054;
            cursor: pointer; transition: all 0.2s; margin-top: 8px; font-family: 'Inter', sans-serif;
        }
        .clear-btn:hover { background: #f9fafb; border-color: #1a3bb5; color: #1a3bb5; }

        /* Main Content */
        .catalog-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; flex-wrap: wrap; gap: 16px; }
        .catalog-header h1 { font-size: 2rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 6px; }
        .catalog-header p { color: #667085; font-size: 0.95rem; max-width: 500px; line-height: 1.6; }
        .catalog-meta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .showing-badge { padding: 8px 16px; background: #fff; border: 1px solid #eaecf0; border-radius: 8px; font-size: 0.8rem; font-weight: 600; color: #344054; }
        .sort-link { font-size: 0.85rem; font-weight: 600; color: #1a3bb5; cursor: pointer; }

        /* Bus Grid */
        .bus-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .bus-card {
            background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #eaecf0;
            transition: all 0.3s;
        }
        .bus-card:hover { box-shadow: 0 12px 32px rgba(0,0,0,0.08); transform: translateY(-3px); border-color: transparent; }

        .bus-card-img {
            width: 100%;
            aspect-ratio: 16 / 10;
            position: relative;
            overflow: hidden;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
        }
        .bus-card-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .bus-card-img .bus-placeholder { color: rgba(255,255,255,0.2); font-size: 5rem; }
        .top-rated-badge {
            position: absolute; top: 14px; left: 14px; padding: 5px 12px; border-radius: 6px;
            background: #e74a3b; color: #fff; font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        .status-badge-card {
            position: absolute; top: 14px; right: 14px; padding: 5px 12px; border-radius: 6px;
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
        }
        .status-available { background: rgba(28,200,138,0.9); color: #fff; }
        .status-booked { background: rgba(246,194,62,0.9); color: #fff; }
        .status-maintenance { background: rgba(231,74,59,0.9); color: #fff; }

        .bus-card-body { padding: 24px; }

        .bus-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; gap: 8px; }
        .bus-card-top h3 { font-size: 1.1rem; font-weight: 700; flex: 1; min-width: 0; word-wrap: break-word; }
        .bus-card-price { text-align: right; flex-shrink: 0; }
        .bus-card-price .amount { font-size: 1.3rem; font-weight: 800; color: #1a3bb5; white-space: nowrap; }
        .bus-card-price .per { font-size: 0.72rem; color: #98a2b3; text-transform: uppercase; font-weight: 600; }

        .bus-card-cap { font-size: 0.83rem; color: #667085; margin-bottom: 16px; display: flex; align-items: center; gap: 6px; }
        .bus-card-cap i { color: #1a3bb5; }

        /* Facilities Icons */
        .facilities-row { display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
        .fac-item { display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .fac-icon {
            width: 40px; height: 40px; border-radius: 10px; background: #f9fafb; border: 1px solid #eaecf0;
            display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #667085;
        }
        .fac-label { font-size: 0.62rem; color: #98a2b3; text-transform: uppercase; font-weight: 600; letter-spacing: 0.04em; }

        /* Card Actions */
        .bus-card-actions { display: flex; gap: 10px; }
        .btn-details {
            flex: 1; padding: 12px; border: 1px solid #d0d5dd; border-radius: 8px;
            background: #fff; font-size: 0.88rem; font-weight: 600; color: #344054;
            cursor: pointer; text-align: center; transition: all 0.2s; font-family: 'Inter', sans-serif;
            text-decoration: none;
        }
        .btn-details:hover { border-color: #1a3bb5; color: #1a3bb5; }
        .btn-book {
            flex: 1; padding: 12px; border: none; border-radius: 8px;
            background: #1a3bb5; font-size: 0.88rem; font-weight: 600; color: #fff;
            cursor: pointer; text-align: center; transition: all 0.2s; font-family: 'Inter', sans-serif;
            text-decoration: none;
        }
        .btn-book:hover { background: #1530a0; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(26,59,181,0.3); }

        /* Footer */
        .footer-mini { text-align: center; padding: 24px 0; color: #98a2b3; font-size: 0.8rem; border-top: 1px solid #eaecf0; }

        /* Mobile Toggle */
        .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #344054; }
        .filter-toggle { display: none; }

        /* ===== RESPONSIVE: Tablet / iPad (≤992px) ===== */
        @media (max-width: 992px) {
            .page-layout { grid-template-columns: 1fr; gap: 20px; padding: 28px 0 40px; }
            .sidebar { position: static; }
            .filter-toggle {
                display: block; width: 100%; padding: 12px; background: #fff; border: 1px solid #eaecf0;
                border-radius: 10px; text-align: center; font-weight: 600; font-size: 0.9rem; cursor: pointer;
                margin-bottom: 16px; font-family: 'Inter', sans-serif; color: #344054;
            }
            .filter-card { display: none; }
            .filter-card.show { display: block; }
        }

        /* ===== RESPONSIVE: Small Tablet / iPad Mini (≤768px) ===== */
        @media (max-width: 768px) {
            .page-layout { padding: 20px 0 32px; gap: 16px; }

            .bus-grid { grid-template-columns: 1fr; gap: 20px; }

            .catalog-header { margin-bottom: 20px; gap: 12px; }
            .catalog-header h1 { font-size: 1.5rem; }
            .catalog-header p { font-size: 0.88rem; }
            .catalog-meta { gap: 10px; width: 100%; }
            .catalog-meta .showing-badge { font-size: 0.75rem; padding: 6px 12px; }
            .catalog-meta #sortSelect { font-size: 0.8rem; width: 100%; max-width: 220px; }

            .bus-card-body { padding: 18px; }
            .bus-card-top h3 { font-size: 1rem; }
            .bus-card-price .amount { font-size: 1.15rem; }
            .facilities-row { gap: 12px; margin-bottom: 16px; }
            .fac-icon { width: 36px; height: 36px; font-size: 0.9rem; }

            .bus-card-actions { gap: 8px; }
            .btn-details, .btn-book { padding: 10px 8px; font-size: 0.82rem; }

            .nav-links { display: none; }
            .mobile-toggle { display: block; }
        }

        /* ===== RESPONSIVE: Large Phone (≤576px) ===== */
        @media (max-width: 576px) {
            .page-layout { padding: 16px 0 24px; gap: 12px; }

            .bus-grid { gap: 16px; }
            .bus-card { border-radius: 12px; }

            .catalog-header h1 { font-size: 1.3rem; }
            .catalog-header p { font-size: 0.82rem; line-height: 1.5; }
            .catalog-meta { flex-direction: column; align-items: stretch; }
            .catalog-meta .showing-badge { text-align: center; }
            .catalog-meta #sortSelect { max-width: 100%; }

            .bus-card-body { padding: 16px; }
            .bus-card-top { flex-direction: column; gap: 4px; }
            .bus-card-top h3 { font-size: 0.95rem; }
            .bus-card-price { text-align: left; }
            .bus-card-price .amount { font-size: 1.1rem; }
            .bus-card-price .per { font-size: 0.65rem; }
            .bus-card-cap { font-size: 0.78rem; margin-bottom: 12px; }

            .facilities-row { gap: 10px; margin-bottom: 14px; }
            .fac-icon { width: 34px; height: 34px; font-size: 0.85rem; border-radius: 8px; }
            .fac-label { font-size: 0.58rem; }

            .bus-card-actions { flex-direction: column; gap: 8px; }
            .btn-details, .btn-book { padding: 11px; font-size: 0.82rem; border-radius: 10px; }

            .filter-toggle { font-size: 0.85rem; padding: 10px; }
            .filter-card { padding: 20px; border-radius: 12px; }
            .filter-card h3 { font-size: 1rem; }
            .capacity-grid { gap: 6px; }
            .cap-btn { padding: 7px 8px; font-size: 0.72rem; }
        }

        /* ===== RESPONSIVE: Small Phone (≤400px) ===== */
        @media (max-width: 400px) {
            .page-layout { padding: 12px 0 20px; }

            .catalog-header h1 { font-size: 1.15rem; }
            .catalog-header p { font-size: 0.78rem; }

            .bus-card-body { padding: 14px; }
            .bus-card-top h3 { font-size: 0.9rem; }
            .bus-card-price .amount { font-size: 1rem; }

            .fac-icon { width: 30px; height: 30px; font-size: 0.78rem; }
            .fac-label { font-size: 0.55rem; }
            .facilities-row { gap: 8px; }

            .btn-details, .btn-book { padding: 10px; font-size: 0.78rem; }
        }
    </style>
<div class="container">
        <div class="page-layout">
            <!-- SIDEBAR FILTERS -->
            <aside class="sidebar">
                <button class="filter-toggle" onclick="document.querySelector('.filter-card').classList.toggle('show')">
                    <i class="fas fa-sliders-h" style="margin-right: 6px;"></i> Tampilkan Filter
                </button>
                <div class="filter-card" id="filterCard">
                    <h3>Filter</h3>
                    <div class="filter-sub">Sempurnakan Pencarian Anda</div>

                    <!-- Date Availability -->
                    <div class="filter-section" style="background: #f0f4ff; padding: 16px; border-radius: 12px; border: 1px solid #c7d2fe; margin-bottom: 24px;">
                        <h4 style="color: #1a3bb5; display: flex; align-items: center; gap: 8px;"><i class="far fa-calendar-alt"></i> Cek Ketersediaan</h4>
                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 0.75rem; color: #475467; font-weight: 700;">Tanggal Berangkat</label>
                            <input type="date" id="filterStartDate" class="form-control" style="font-size: 0.85rem;" min="<?= date('Y-m-d') ?>">
                        </div>
                        <div>
                            <label style="font-size: 0.75rem; color: #475467; font-weight: 700;">Tanggal Pulang</label>
                            <input type="date" id="filterEndDate" class="form-control" style="font-size: 0.85rem;" min="<?= date('Y-m-d') ?>">
                        </div>
                        <div id="availabilityMsg" style="font-size: 0.75rem; color: #e74a3b; margin-top: 8px; display: none; font-weight: 600;"></div>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-section">
                        <h4>Kisaran Harga (per hari)</h4>
                        <input type="range" class="range-slider" id="priceRange" min="0" max="50000000" value="50000000" step="500000">
                        <div class="range-labels">
                            <span>Rp 0</span>
                            <span id="priceMax">Rp 50.000.000</span>
                        </div>
                    </div>

                    <!-- Capacity -->
                    <div class="filter-section">
                        <h4>Kapasitas</h4>
                        <div class="capacity-grid">
                            <div class="cap-btn" data-min="1" data-max="30" onclick="filterCap(this)">1-30 Kursi</div>
                            <div class="cap-btn" data-min="31" data-max="45" onclick="filterCap(this)">31-45 Kursi</div>
                            <div class="cap-btn" data-min="46" data-max="60" onclick="filterCap(this)">46-60 Kursi</div>
                            <div class="cap-btn" data-min="61" data-max="999" onclick="filterCap(this)">60+ Kursi</div>
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div class="filter-section">
                        <h4>Fasilitas</h4>
                        <div class="filter-check"><input type="checkbox" id="fAC" onchange="applyFilters()"><label for="fAC">Air Conditioner (AC)</label></div>
                        <div class="filter-check"><input type="checkbox" id="fWifi" onchange="applyFilters()"><label for="fWifi">WiFi di dalam bus</label></div>
                        <div class="filter-check"><input type="checkbox" id="fToilet" onchange="applyFilters()"><label for="fToilet">Toilet dalam bus</label></div>
                        <div class="filter-check"><input type="checkbox" id="fTV" onchange="applyFilters()"><label for="fTV">Sistem Hiburan</label></div>
                    </div>

                    <button class="clear-btn" onclick="clearFilters()">Hapus Semua Filter</button>
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <main>
                <div class="catalog-header">
                    <div>
                        <h1>Katalog Bus</h1>
                        <p>Temukan pilihan armada premium untuk perjalanan perusahaan atau acara pribadi Anda.</p>
                    </div>
                    <div class="catalog-meta">
                        <div class="showing-badge">Menampilkan <strong id="busCount"><?= count($buses) ?></strong> Kendaraan</div>
                        <select id="sortSelect" onchange="sortBuses()" style="padding: 6px 12px; border: 1px solid #eaecf0; border-radius: 8px; font-size: 0.85rem; font-weight: 600; color: #344054; background: #fff; cursor: pointer;">
                            <option value="rec">Urutkan: Direkomendasikan</option>
                            <option value="price_asc">Harga: Termurah</option>
                            <option value="price_desc">Harga: Termahal</option>
                            <option value="cap_asc">Kapasitas: Terkecil</option>
                            <option value="cap_desc">Kapasitas: Terbesar</option>
                        </select>
                    </div>
                </div>

                <div class="bus-grid" id="busGrid">
                    <?php if(!empty($buses)): ?>
                        <?php $i = 0; foreach($buses as $b): $i++;
                            $is_unavailable_today = in_array($b['bus_id'], $unavailable_today ?? []);
                            $card_status = ($b['status'] == 'maintenance') ? 'maintenance' : ($is_unavailable_today ? 'booked' : 'available');
                        ?>
                        <div class="bus-card" 
                             data-id="<?= $b['bus_id'] ?>"
                             data-price="<?= $b['harga_dalam_kota'] ?>" 
                             data-cap="<?= $b['kapasitas'] ?>" 
                             data-fac="<?= strtolower($b['fasilitas'] ?? '') ?>"
                             data-status="<?= $card_status ?>">
                            <div class="bus-card-img">
                                <?php if(!empty($b['foto'])): ?>
                                    <img src="<?= base_url('assets/img/bus/' . $b['foto']) ?>" alt="<?= htmlspecialchars($b['bus_nama']) ?>">
                                <?php else: ?>
                                    <i class="fas fa-bus-alt bus-placeholder"></i>
                                <?php endif; ?>
                                <?php if(isset($b['avg_rating']) && $b['avg_rating'] >= 4.8 && $b['total_rentals'] >= 10): ?>
                                    <span class="top-rated-badge"><i class="fas fa-star" style="margin-right: 3px;"></i> TERPOPULER</span>
                                <?php endif; ?>
                                <span class="status-badge-card status-<?= $card_status ?>">
                                    <?php if($card_status === 'booked'): ?>
                                        Sedang Disewa
                                    <?php elseif($card_status === 'maintenance'): ?>
                                        Perawatan
                                    <?php else: ?>
                                        Tersedia
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="bus-card-body">
                                <div class="bus-card-top">
                                    <div>
                                        <h3 style="margin-bottom: 4px;"><?= htmlspecialchars($b['bus_nama']) ?></h3>
                                        <?php if(isset($b['avg_rating']) && $b['total_reviews'] > 0): ?>
                                        <div style="font-size: 0.8rem; color: #fbbf24; font-weight: 700;">
                                            <i class="fas fa-star"></i> <?= number_format($b['avg_rating'], 1) ?> 
                                            <span style="color: #98a2b3; font-weight: 500;">(<?= $b['total_reviews'] ?> Ulasan)</span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="bus-card-price">
                                        <div class="amount">Mulai Rp <?= number_format($b['harga_dalam_kota']/1000, 0, ',', '.') ?>k</div>
                                        <div class="per">PER HARI</div>
                                    </div>
                                </div>
                                <div class="bus-card-cap">
                                    <i class="fas fa-user"></i> Hingga <?= $b['kapasitas'] ?> penumpang
                                </div>

                                <!-- Facilities Icons -->
                                <?php
                                    $fac = strtolower($b['fasilitas'] ?? '');
                                    $icons = [];
                                    if (strpos($fac, 'ac') !== false) $icons[] = ['fas fa-snowflake', 'AC'];
                                    if (strpos($fac, 'wifi') !== false) $icons[] = ['fas fa-wifi', 'WIFI'];
                                    if (strpos($fac, 'toilet') !== false) $icons[] = ['fas fa-restroom', 'TOILET'];
                                    if (strpos($fac, 'tv') !== false || strpos($fac, 'audio') !== false) $icons[] = ['fas fa-tv', 'TV/AUDIO'];
                                    if (strpos($fac, 'usb') !== false) $icons[] = ['fas fa-plug', 'USB'];
                                    if (strpos($fac, 'reclining') !== false) $icons[] = ['fas fa-couch', 'SANDARAN'];
                                    if (strpos($fac, 'bagasi') !== false) $icons[] = ['fas fa-suitcase', 'BAGASI'];
                                    if (empty($icons)) $icons[] = ['fas fa-check-circle', 'STANDAR'];
                                ?>
                                <div class="facilities-row">
                                    <?php foreach($icons as $ic): ?>
                                    <div class="fac-item">
                                        <div class="fac-icon"><i class="<?= $ic[0] ?>"></i></div>
                                        <span class="fac-label"><?= $ic[1] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="bus-card-actions">
                                    <a href="<?= base_url('home/bus_detail/' . $b['bus_id']) ?>" class="btn-details">Lihat Detail</a>
                                    <?php if($card_status === 'maintenance'): ?>
                                        <button type="button" class="btn-book" style="background: #98a2b3; color: #fff; cursor: not-allowed; box-shadow: none;" disabled>Perawatan</button>
                                    <?php elseif($card_status === 'booked'): ?>
                                        <button type="button" class="btn-book" style="background: #f59e0b; color: #fff; cursor: not-allowed; box-shadow: none;" disabled>Sedang Disewa</button>
                                    <?php else: ?>
                                        <a href="<?= base_url('home/booking_page?bus_id=' . $b['bus_id']) ?>" class="btn-book">Pesan Sekarang</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="grid-column: 1/-1; text-align: center; color: #98a2b3; padding: 60px 0;">Tidak ada bus yang tersedia saat ini.</p>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    
<?php $this->load->view('public/layout/footer'); ?>
<script>
        let activeCap = null;
        // Seed from server-side: buses unavailable today (active bookings / maintenance)
        let unavailableBusIds = <?= json_encode(array_map('strval', $unavailable_today ?? [])) ?>;

        // Auto-apply on load to grey out booked buses
        applyFilters();

        // Check Availability
        function checkCatalogAvailability() {
            const start = document.getElementById('filterStartDate').value;
            const end = document.getElementById('filterEndDate').value;
            const msg = document.getElementById('availabilityMsg');
            
            if (start && end) {
                if (new Date(end) < new Date(start)) {
                    msg.textContent = 'Tanggal pulang tidak boleh sebelum keberangkatan.';
                    msg.style.display = 'block';
                    return;
                }
                msg.style.display = 'none';

                $.ajax({
                    url: '<?= base_url('home/check_availability') ?>',
                    type: 'POST',
                    data: { start_date: start, end_date: end },
                    dataType: 'json',
                    success: function(ids) {
                        unavailableBusIds = ids || [];
                        applyFilters();
                    }
                });
            } else {
                unavailableBusIds = [];
                msg.style.display = 'none';
                applyFilters();
            }
        }

        document.getElementById('filterStartDate').addEventListener('change', checkCatalogAvailability);
        document.getElementById('filterEndDate').addEventListener('change', checkCatalogAvailability);

        // Price Range Slider
        document.getElementById('priceRange').addEventListener('input', function() {
            document.getElementById('priceMax').textContent = 'Rp ' + parseInt(this.value).toLocaleString('id-ID');
            applyFilters();
        });

        // Capacity Filter
        function filterCap(el) {
            document.querySelectorAll('.cap-btn').forEach(b => b.classList.remove('active'));
            if (activeCap === el) { activeCap = null; }
            else { el.classList.add('active'); activeCap = el; }
            applyFilters();
        }

        // Apply All Filters
        function applyFilters() {
            const maxPrice = parseInt(document.getElementById('priceRange').value);
            const capMin = activeCap ? parseInt(activeCap.dataset.min) : 0;
            const capMax = activeCap ? parseInt(activeCap.dataset.max) : 9999;
            const fAC = document.getElementById('fAC').checked;
            const fWifi = document.getElementById('fWifi').checked;
            const fToilet = document.getElementById('fToilet').checked;
            const fTV = document.getElementById('fTV').checked;

            let count = 0;
            document.querySelectorAll('.bus-card').forEach(card => {
                const price = parseInt(card.dataset.price);
                const cap = parseInt(card.dataset.cap);
                const fac = card.dataset.fac;
                const busId = card.dataset.id;

                let show = true;
                if (unavailableBusIds.includes(busId)) show = false;
                if (price > maxPrice) show = false;
                if (activeCap && (cap < capMin || cap > capMax)) show = false;
                if (fAC && fac.indexOf('ac') === -1) show = false;
                if (fWifi && fac.indexOf('wifi') === -1) show = false;
                if (fToilet && fac.indexOf('toilet') === -1) show = false;
                if (fTV && fac.indexOf('tv') === -1 && fac.indexOf('audio') === -1) show = false;

                card.style.display = show ? '' : 'none';
                if (show) count++;
            });

            document.getElementById('busCount').textContent = count;
        }

        function sortBuses() {
            const grid = document.getElementById('busGrid');
            const cards = Array.from(grid.querySelectorAll('.bus-card'));
            const sortBy = document.getElementById('sortSelect').value;

            cards.sort((a, b) => {
                const priceA = parseInt(a.dataset.price);
                const priceB = parseInt(b.dataset.price);
                const capA = parseInt(a.dataset.cap);
                const capB = parseInt(b.dataset.cap);

                if (sortBy === 'price_asc') return priceA - priceB;
                if (sortBy === 'price_desc') return priceB - priceA;
                if (sortBy === 'cap_asc') return capA - capB;
                if (sortBy === 'cap_desc') return capB - capA;
                return 0; // rec keeps original order roughly or we don't care
            });

            cards.forEach(card => grid.appendChild(card));
        }

        // Clear Filters
        function clearFilters() {
            document.getElementById('filterStartDate').value = '';
            document.getElementById('filterEndDate').value = '';
            unavailableBusIds = [];
            document.getElementById('priceRange').value = 50000000;
            document.getElementById('priceMax').textContent = 'Rp 50.000.000';
            document.querySelectorAll('.cap-btn').forEach(b => b.classList.remove('active'));
            activeCap = null;
            document.getElementById('fAC').checked = false;
            document.getElementById('fWifi').checked = false;
            document.getElementById('fToilet').checked = false;
            document.getElementById('fTV').checked = false;
            applyFilters();
        }
    </script>
