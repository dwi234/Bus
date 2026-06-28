<style>
    /* Custom Dashboard CSS */
    .dashboard-header { margin-bottom: 2rem; }
    .card-stat {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: transform 0.2s;
    }
    .card-stat:hover { transform: translateY(-3px); }
    .card-stat .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .icon-box-primary { background: rgba(78, 115, 223, 0.1); color: #4e73df; }
    .icon-box-success { background: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .icon-box-warning { background: rgba(246, 194, 62, 0.1); color: #f6c23e; }
    .icon-box-danger { background: rgba(231, 74, 59, 0.1); color: #e74a3b; }
    .icon-box-info { background: rgba(54, 185, 204, 0.1); color: #36b9cc; }

    .stat-label { font-size: 0.75rem; font-weight: 700; color: #858796; letter-spacing: 0.1em; text-transform: uppercase; }
    .stat-value { font-size: 1.8rem; font-weight: 800; color: #2a2a2a; margin-top: 0.3rem; }
    .stat-trend { font-size: 0.85rem; font-weight: 600; }
    .trend-up { color: #1cc88a; }
    .trend-down { color: #e74a3b; }
    .trend-neutral { color: #858796; }

    .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    .card-header-custom { background: transparent; border-bottom: 1px solid rgba(0,0,0,0.05); padding: 1.25rem 1.5rem; }
    .card-title-custom { font-weight: 700; font-size: 1.1rem; color: #2a2a2a; margin: 0; }
    .card-subtitle-custom { font-size: 0.85rem; color: #858796; }

    /* Timeline styles */
    .timeline { position: relative; padding: 0 0 0 1rem; list-style: none; margin-top: 1rem; }
    .timeline::before {
        content: ''; position: absolute; top: 0; bottom: 0; left: 34px; width: 2px;
        background: #eaecf4; z-index: 0;
    }
    .timeline-item { position: relative; margin-bottom: 1.5rem; padding-left: 3.5rem; }
    .timeline-item::last-child { margin-bottom: 0; }
    .timeline-marker {
        position: absolute; left: 0; top: 0; width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; z-index: 1; font-size: 0.8rem;
    }
    .marker-primary { background: #e3f2fd; color: #4e73df; }
    .marker-danger { background: #ffebee; color: #e74a3b; }
    .marker-warning { background: #fff8e1; color: #f6c23e; }
    .marker-success { background: #e8f5e9; color: #1cc88a; }
    .timeline-content { padding-top: 0.3rem; }
    .timeline-title { font-weight: 700; font-size: 0.9rem; margin-bottom: 0.2rem; color: #2a2a2a; }
    .timeline-desc { font-size: 0.8rem; color: #858796; margin-bottom: 0.2rem; }
    .timeline-time { font-size: 0.7rem; color: #b7b9cc; font-weight: 600; text-transform: uppercase; }

    /* Gradient Banner */
    .banner-gradient {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border-radius: 12px;
        color: white; padding: 2rem; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .banner-gradient::after {
        content: '\f005'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
        position: absolute; right: -20px; top: -30px; font-size: 15rem; opacity: 0.05;
        transform: rotate(-15deg);
    }
    .banner-title { font-weight: 700; font-size: 1.5rem; margin-bottom: 0.5rem; }
    .banner-text { font-size: 0.9rem; opacity: 0.9; max-width: 60%; line-height: 1.6; margin-bottom: 1.5rem; }

    /* Table Minimalist */
    .table-minimal th { border-top: none; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: #858796; }
    .table-minimal td { vertical-align: middle; border-top: 1px solid #f8f9fc; padding: 1rem 0.75rem; font-size: 0.9rem;}
    .badge-status { font-weight: 700; padding: 0.4em 0.8em; border-radius: 20px; font-size: 0.7rem; }
    .badge-status-boarding { background-color: #ffebee; color: #e74a3b; }
    .badge-status-scheduled { background-color: #eaecf4; color: #858796; }
    .badge-status-completed { background-color: #e3f2fd; color: #4e73df; }
    
    .bus-icon-bg {
        width: 40px; height: 40px; border-radius: 8px; background: rgba(78, 115, 223, 0.1); color: #4e73df;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
</style>

<div class="container-fluid mb-5">
    
    <!-- Header Title (Replaces usual dashboard title) -->
    <div class="d-sm-flex align-items-center justify-content-between dashboard-header mt-2">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">Dashboard</h1>
            <p class="mb-0 text-gray-600">Selamat datang kembali, <?= $this->session->userdata('nama') ?? 'Admin' ?>. Sistem beroperasi dengan baik.</p>
        </div>
        <div class="d-flex align-items-center">
            <!-- Filter Period -->
            <form action="<?= base_url('dashboard') ?>" method="GET" class="form-inline mr-3">
                <select name="filter_month" class="form-control form-control-sm mr-2 rounded-pill shadow-sm border-0 bg-white" onchange="this.form.submit()">
                    <?php 
                    $months = ['01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'Mei', '06'=>'Jun', '07'=>'Jul', '08'=>'Agu', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'];
                    foreach($months as $num => $name): ?>
                        <option value="<?= $num ?>" <?= (isset($filter_month) && $filter_month == $num) ? 'selected' : '' ?>><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="filter_year" class="form-control form-control-sm mr-2 rounded-pill shadow-sm border-0 bg-white" onchange="this.form.submit()">
                    <?php 
                    $current_year = date('Y');
                    for($y = $current_year; $y >= $current_year - 2; $y--): ?>
                        <option value="<?= $y ?>" <?= (isset($filter_year) && $filter_year == $y) ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </form>

            <?php if($role == 'reservasi'): ?>
            <a href="<?= base_url('report/customer') ?>" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm rounded-pill px-3"><i class="fas fa-download fa-sm text-white-50 mr-1"></i> Transaksi Pelanggan</a>
            <?php elseif($role == 'operasional'): ?>
            <a href="<?= base_url('report/bus') ?>" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm rounded-pill px-3"><i class="fas fa-download fa-sm text-white-50 mr-1"></i> Laporan</a>
            <?php else: ?>
            <a href="<?= base_url('report') ?>" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm rounded-pill px-3"><i class="fas fa-download fa-sm text-white-50 mr-1"></i> Laporan Lengkap</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Flash message -->
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-left-danger shadow-sm" role="alert">
        <i class="fas fa-exclamation-triangle mr-1"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- 1. TOP CARDS ROW -->
    <div class="row">
        <?php if($role == 'superadmin' || $role == 'reservasi'): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stat h-100 py-3 px-3">
                <div class="d-flex justify-content-between">
                    <div class="icon-box icon-box-primary"><i class="fas fa-receipt"></i></div>
                    <div class="text-right"><span class="stat-trend trend-neutral">Difilter</span></div>
                </div>
                <div class="mt-3">
                    <div class="stat-label">Total Pemesanan (Per Bulan)</div>
                    <div class="stat-value"><?= number_format($total_booking) ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role == 'superadmin' || $role == 'operasional'): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stat h-100 py-3 px-3">
                <div class="d-flex justify-content-between">
                    <div class="icon-box icon-box-info"><i class="fas fa-running"></i></div>
                    <div class="text-right"><span class="stat-trend trend-neutral">Saat Ini</span></div>
                </div>
                <div class="mt-3">
                    <div class="stat-label">Perjalanan Aktif</div>
                    <div class="stat-value"><?= number_format($active_trips ?? 0) ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role == 'operasional' && $role != 'superadmin'): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stat h-100 py-3 px-3">
                <div class="d-flex justify-content-between">
                    <div class="icon-box icon-box-primary"><i class="fas fa-bus"></i></div>
                    <div class="text-right"><span class="stat-trend trend-neutral">Armada</span></div>
                </div>
                <div class="mt-3">
                    <div class="stat-label">Total Bus</div>
                    <div class="stat-value"><?= number_format($total_bus) ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role == 'superadmin' || $role == 'reservasi'): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stat h-100 py-3 px-3">
                <div class="d-flex justify-content-between">
                    <div class="icon-box icon-box-success"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="text-right"><span class="stat-trend trend-neutral">Difilter</span></div>
                </div>
                <div class="mt-3">
                    <div class="stat-label">Pendapatan (Per Bulan)</div>
                    <div class="stat-value">Rp <?= number_format(($revenue_mtd ?? 0)/1000, 0, ',', '.') ?>k</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stat h-100 py-3 px-3">
                <div class="d-flex justify-content-between">
                    <div class="icon-box icon-box-danger"><i class="fas fa-exclamation-circle"></i></div>
                    <div class="text-right"><span class="stat-trend trend-down">Kritis</span></div>
                </div>
                <div class="mt-3">
                    <div class="stat-label">Pembayaran Tertunda</div>
                    <div class="stat-value"><?= number_format($pending_payment ?? 0) ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role == 'operasional' || $role == 'reservasi' && $role != 'superadmin'): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stat h-100 py-3 px-3">
                <div class="d-flex justify-content-between">
                    <div class="icon-box icon-box-warning"><i class="fas fa-users"></i></div>
                    <div class="text-right">
                        <?php if($role != 'operasional'): ?>
                            <?php if(isset($growth_percentage)): ?>
                                <?php if($growth_percentage > 0): ?>
                                    <span class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> <?= $growth_percentage ?>%</span>
                                <?php elseif($growth_percentage < 0): ?>
                                    <span class="stat-trend trend-down"><i class="fas fa-arrow-down"></i> <?= abs($growth_percentage) ?>%</span>
                                <?php else: ?>
                                    <span class="stat-trend trend-neutral"><i class="fas fa-minus"></i> 0%</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="stat-trend trend-neutral">Total</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="stat-label"><?= $role == 'operasional' ? 'Supir' : 'Pelanggan Aktif (Per Bulan)' ?></div>
                    <div class="stat-value"><?= $role == 'operasional' ? number_format($total_driver) : number_format($active_bookers) ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- 2. MIDDLE ROW (Chart & Recent Activity) -->
    <div class="row">
        <!-- left col: Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card card-custom mb-4">
                <div class="card-header-custom d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title-custom">Tren Pemesanan</h6>
                        <span class="card-subtitle-custom">Volume harian selama 7 hari terakhir</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 25rem;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
            
            <?php if($role == 'superadmin' || $role == 'operasional'): ?>
            <!-- Banner Optimization -->
            <div class="banner-gradient mb-4">
                <h3 class="banner-title">Optimasi Kinerja Armada</h3>
                <p class="banner-text">Utilisasi kendaraan Anda naik 14% dibandingkan bulan lalu. Pertimbangkan menambah 2 bus pada rute dengan permintaan tertinggi.</p>
                <a href="<?= base_url('jadwal') ?>" class="btn btn-light text-primary font-weight-bold px-4 py-2 rounded">Lihat Analitik</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- right col: Recent Activity -->
        <div class="col-xl-4 col-lg-5">
            <div class="card card-custom mb-4 h-100" style="min-height: 400px;">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h6 class="card-title-custom">Aktivitas Terbaru</h6>
                    <a href="<?= base_url('booking') ?>" class="text-primary" style="font-size: 0.8rem; font-weight: 700;">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <?php if(!empty($recent_activity)): ?>
                            <?php foreach($recent_activity as $act): ?>
                                <?php 
                                    $marker_class = 'marker-primary';
                                    $icon = '<i class="fas fa-check"></i>';
                                    $title = 'Pemesanan #BK-'.$act['booking_id'].' Dikonfirmasi';
                                    
                                    if ($act['booking_status'] == 'pending') {
                                        $marker_class = 'marker-danger';
                                        $icon = '<i class="fas fa-exclamation"></i>';
                                        $title = 'Pembayaran Tertunda/Gagal';
                                    } elseif ($act['booking_status'] == 'batal') {
                                        $marker_class = 'marker-warning';
                                        $icon = '<i class="fas fa-times"></i>';
                                        $title = 'Pemesanan Dibatalkan';
                                    }
                                ?>
                                <li class="timeline-item">
                                    <div class="timeline-marker <?= $marker_class ?>"><?= $icon ?></div>
                                    <div class="timeline-content">
                                        <div class="timeline-title"><?= $title ?></div>
                                        <div class="timeline-desc"><?= htmlspecialchars($act['customer_nama']) ?> • ID Pemesanan #<?= $act['booking_id'] ?></div>
                                        <div class="timeline-time">Berangkat: <?= date('d M Y', strtotime($act['tanggal_keberangkatan'])) ?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="timeline-item">
                                <div class="timeline-marker marker-success"><i class="fas fa-info"></i></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Sistem Siap</div>
                                    <div class="timeline-desc">Tidak ada aktivitas terbaru.</div>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. BOTTOM ROW (Table) -->
    <div class="row">
        <?php if($role == 'superadmin' || $role == 'operasional'): ?>
        <div class="col-lg-12">
            <div class="card card-custom mb-4">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h6 class="card-title-custom">Manifest Mendatang</h6>
                    <div class="input-group" style="width: 250px;">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari perjalanan..." aria-label="Cari">
                        <div class="input-group-append">
                            <button class="btn btn-light" type="button"><i class="fas fa-search fa-sm"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-minimal w-100 mb-0">
                            <thead>
                                <tr>
                                    <th class="pl-4">Detail Bus</th>
                                    <th>Rute</th>
                                    <th>Keberangkatan</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($upcoming_jadwal)): ?>
                                    <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada jadwal mendatang</td></tr>
                                <?php else: ?>
                                    <?php foreach($upcoming_jadwal as $j): ?>
                                    <tr>
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bus-icon-bg mr-3"><i class="fas fa-bus-alt"></i></div>
                                                <div>
                                                    <div class="font-weight-bold text-dark mb-0"><?= $j['bus_nama'] ?></div>
                                                    <div class="text-muted" style="font-size: 0.75rem;">Supir: <?= $j['driver_nama'] ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark"><?= date('d M Y', strtotime($j['tangal_mulai'])) ?></div>
                                            <div class="text-muted" style="font-size: 0.75rem;">Sampai <?= date('d M Y', strtotime($j['tanggal_selesai'])) ?></div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark">Jadwal</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">Dikonfirmasi</div>
                                        </td>
                                        <td>
                                            <?php if(date('Y-m-d') == $j['tangal_mulai']): ?>
                                                <span class="badge badge-status badge-status-boarding"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i> NAIK</span>
                                            <?php else: ?>
                                                <span class="badge badge-status badge-status-scheduled"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i> TERJADWAL</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('jadwal') ?>" class="text-gray-500"><i class="fas fa-ellipsis-v"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if($role == 'reservasi'): ?>
        <div class="col-lg-12">
            <div class="card card-custom mb-4">
                <div class="card-header-custom">
                    <h6 class="card-title-custom">Pemesanan Tertunda</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-minimal w-100 mb-0">
                            <thead>
                                <tr>
                                    <th class="pl-4">Pelanggan</th>
                                    <th>Bus</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($recent_pending)): ?>
                                    <tr><td colspan="3" class="text-center py-4 text-muted">Tidak ada booking pending</td></tr>
                                <?php else: ?>
                                    <?php foreach($recent_pending as $b): ?>
                                    <tr>
                                        <td class="pl-4 font-weight-bold text-dark"><?= $b['customer_nama'] ?></td>
                                        <td><?= $b['bus_nama'] ?></td>
                                        <td><a href="<?= base_url('booking') ?>" class="btn btn-sm btn-info rounded-pill px-3">Tinjau</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof Chart === 'undefined') {
        console.error("Chart.js is not loaded!");
        return;
    }

    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    var labelsArr = <?= $chart_labels ?? '[]' ?>;
    var dataArr = <?= $chart_data ?? '[]' ?>;

    var ctx = document.getElementById("myAreaChart");
    if(ctx && labelsArr.length > 0) {
        // Create gradient
        var gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.2)');   
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');

        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsArr,
                datasets: [{
                    label: "Pendapatan",
                    lineTension: 0.4, // Smoother curve
                    backgroundColor: gradient,
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 0, // hide points by default for cleaner look
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "#fff",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "#fff",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    borderWidth: 4, // Thicker line
                    data: dataArr,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
                scales: {
                    xAxes: [{
                        time: { unit: 'date' },
                        gridLines: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: 7 }
                    }],
                    yAxes: [{
                        display: false, // Hide Y axis like in the image for cleaner look
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) { return 'Rp ' + number_format(value, 0, ',', '.'); }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: { display: false },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel, 0, ',', '.');
                        }
                    }
                }
            }
        });
    }
});
</script>
