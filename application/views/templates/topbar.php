
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <?php 
                        $CI =& get_instance();
                        $CI->load->model('Notification_model');
                        $current_role = $CI->session->userdata('role');
                        $notif_count = $CI->Notification_model->count_unread($current_role);
                        $notif_list = $CI->Notification_model->get_by_role($current_role, 5);

                        // Map type to icon & color
                        $type_map = [
                            'info'    => ['icon' => 'fas fa-info-circle',       'bg' => 'bg-info'],
                            'success' => ['icon' => 'fas fa-check-circle',      'bg' => 'bg-success'],
                            'warning' => ['icon' => 'fas fa-exclamation-triangle','bg' => 'bg-warning'],
                            'danger'  => ['icon' => 'fas fa-times-circle',      'bg' => 'bg-danger'],
                        ];
                        ?>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw text-gray-600"></i>
                                <!-- Counter - Alerts -->
                                <?php if($notif_count > 0): ?>
                                    <span class="badge badge-danger badge-counter" style="right: .25rem; font-size: .65rem;"><?= $notif_count ?></span>
                                <?php endif; ?>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="width: 420px;">
                                <h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                    <span>Notifikasi</span>
                                    <?php if($notif_count > 0): ?>
                                        <a href="#" id="markAllReadBtn" class="text-white small" style="font-weight: 400; text-decoration: underline;">Tandai semua dibaca</a>
                                    <?php endif; ?>
                                </h6>
                                <?php if(!empty($notif_list)): ?>
                                    <?php foreach($notif_list as $notif): 
                                        $t = isset($type_map[$notif['type']]) ? $type_map[$notif['type']] : $type_map['info'];
                                        $is_unread = $notif['is_read'] == 0;
                                        
                                        // Tentukan link tujuan berdasarkan target/role user
                                        $target_url = '#';
                                        if ($notif['booking_id']) {
                                            if ($current_role == 'operasional' || $notif['role_target'] == 'operasional') {
                                                $target_url = base_url('jadwal?booking_id=' . $notif['booking_id']);
                                            } else {
                                                $target_url = base_url('booking');
                                            }
                                        }
                                    ?>
                                    <a class="dropdown-item d-flex align-items-center <?= $is_unread ? '' : 'bg-light' ?>" 
                                        href="<?= $target_url ?>"
                                        data-notif-id="<?= $notif['notification_id'] ?>"
                                        onclick="markNotifRead(<?= $notif['notification_id'] ?>)">
                                        <div class="mr-3">
                                            <div class="icon-circle <?= $t['bg'] ?>">
                                                <i class="<?= $t['icon'] ?> text-white"></i>
                                            </div>
                                        </div>
                                        <div style="flex:1; min-width:0;">
                                            <div class="small text-gray-500"><?= date('d M Y, H:i', strtotime($notif['created_at'])) ?></div>
                                            <span class="<?= $is_unread ? 'font-weight-bold' : '' ?>"><?= htmlspecialchars($notif['title']) ?></span>
                                            <div class="small text-gray-600 text-truncate"><?= htmlspecialchars($notif['message']) ?></div>
                                        </div>
                                        <?php if($is_unread): ?>
                                            <span class="ml-2"><i class="fas fa-circle text-primary" style="font-size: 8px;"></i></span>
                                        <?php endif; ?>
                                    </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Belum ada notifikasi</a>
                                <?php endif; ?>
                            </div>
                        </li>

                        <script>
                        function markNotifRead(id) {
                            var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
                            var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
                            fetch('<?= base_url("notification/mark_read") ?>', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                body: 'notification_id=' + id + '&' + csrfName + '=' + csrfHash,
                                keepalive: true
                            });
                        }
                        document.addEventListener('DOMContentLoaded', function() {
                            var btn = document.getElementById('markAllReadBtn');
                            if (btn) {
                                btn.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    var csrfName2 = '<?= $this->security->get_csrf_token_name() ?>';
                                    var csrfHash2 = '<?= $this->security->get_csrf_hash() ?>';
                                    fetch('<?= base_url("notification/mark_all_read") ?>', {
                                        method: 'POST',
                                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                        body: csrfName2 + '=' + csrfHash2
                                    }).then(function() {
                                        // Hapus badge counter
                                        var badge = document.querySelector('.badge-counter');
                                        if (badge) badge.remove();
                                        // Hapus semua dot biru dan bold
                                        document.querySelectorAll('[data-notif-id]').forEach(function(el) {
                                            el.classList.add('bg-light');
                                            var dot = el.querySelector('.fa-circle');
                                            if (dot) dot.parentElement.remove();
                                            var bold = el.querySelector('.font-weight-bold');
                                            if (bold) bold.classList.remove('font-weight-bold');
                                        });
                                        btn.style.display = 'none';
                                    });
                                });
                            }
                        });
                        </script>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $this->session->userdata('nama_lengkap') ? $this->session->userdata('nama_lengkap') : $this->session->userdata('username') ?>
                                    <span class="badge badge-<?= $this->session->userdata('role') == 'operasional' ? 'warning' : 'info' ?> ml-1"><?= ucfirst($this->session->userdata('role')) ?></span>
                                </span>
                                <img class="img-profile rounded-circle" src="<?= base_url('assets/') ?>img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('auth/login') ?>" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->