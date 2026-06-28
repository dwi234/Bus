<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Armada - Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #0a0a0c;
            --bg-secondary: #111115;
            --bg-card: #16161a;
            --bg-input: #1a1a1f;
            --border-color: #2a2a30;
            --border-focus: #f59e0b;
            --text-primary: #fdfbf7;
            --text-secondary: #a1a1aa;
            --text-muted: #71717a;
            --accent-gold: #f59e0b; /* Elegant Gold */
            --accent-gold-light: #fcd34d;
            --accent-gold-dark: #b45309;
            --accent-cyan: #38bdf8;
            --accent-green: #34d399;
            --accent-red: #ef4444;
            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-mono: 'JetBrains Mono', 'Fira Code', monospace;
        }

        html, body {
            height: 100%;
            font-family: var(--font-main);
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow: hidden;
        }

        /* ── TOP BAR ── */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: rgba(10, 10, 12, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 100;
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-secondary);
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent-green);
            display: inline-block;
            margin-right: 8px;
            box-shadow: 0 0 8px var(--accent-green);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; box-shadow: 0 0 8px var(--accent-green); }
            50% { opacity: 0.6; box-shadow: 0 0 4px var(--accent-green); }
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .top-bar-right span {
            color: var(--accent-gold);
            font-weight: 600;
        }

        /* ── MAIN LAYOUT ── */
        .login-wrapper {
            display: flex;
            height: 100vh;
            padding-top: 40px;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(10, 10, 12, 0.2) 0%,
                rgba(10, 10, 12, 0.4) 40%,
                rgba(10, 10, 12, 0.85) 75%,
                rgba(10, 10, 12, 0.95) 100%
            );
            z-index: 1;
        }

        .bus-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            filter: brightness(0.9) contrast(1.1);
        }

        .left-logo-container {
            position: absolute;
            top: 40px;
            left: 40px;
            z-index: 10;
        }

        .dru-logo {
            height: 120px;
            filter: drop-shadow(0 4px 15px rgba(245, 158, 11, 0.4));
        }

        .left-content {
            position: relative;
            z-index: 2;
            margin-top: auto;
            padding: 0 40px 30px;
        }

        .brand-subtitle {
            font-family: var(--font-main);
            font-size: 42px;
            font-weight: 300;
            line-height: 1.1;
            text-transform: uppercase;
            color: var(--accent-gold);
            margin-bottom: 8px;
        }

        .brand-title {
            font-size: 42px;
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 12px;
        }

        .brand-title strong {
            font-weight: 900;
            color: var(--accent-gold);
        }

        .brand-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 400px;
            margin-bottom: 28px;
        }

        /* ── STAT CARDS ── */
        .stat-cards {
            display: flex;
            gap: 16px;
        }

        .stat-card {
            background: rgba(22, 22, 26, 0.8);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px 24px;
            min-width: 200px;
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .stat-card-header i {
            color: var(--accent-gold);
            font-size: 16px;
        }

        .stat-card-header span {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-secondary);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-value small {
            font-size: 16px;
            font-weight: 400;
            color: var(--text-secondary);
        }

        .stat-growth {
            font-size: 12px;
            color: var(--accent-green);
            margin-top: 2px;
        }

        .stat-growth i {
            margin-right: 4px;
        }

        .stat-sub {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 420px;
            background: var(--bg-secondary);
            border-left: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
            overflow-y: auto;
        }

        /* ── SIDE TABS ── */
        .side-tabs {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .side-tab {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            padding: 12px 6px;
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            border-right: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .side-tab.active {
            color: var(--accent-gold);
            border-right-color: var(--accent-gold);
            background: rgba(200, 168, 78, 0.05);
        }

        /* ── FORM ── */
        .form-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .form-subtitle {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 36px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-secondary);
            margin-bottom: 10px;
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-wrapper:focus-within {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(200, 168, 78, 0.1);
        }

        .input-icon {
            padding: 0 16px;
            color: var(--text-muted);
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            padding: 14px 16px 14px 0;
            font-family: var(--font-main);
            font-size: 14px;
            color: var(--text-primary);
            letter-spacing: 0.5px;
        }

        .input-wrapper input::placeholder {
            color: var(--text-muted);
            font-family: var(--font-mono);
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .toggle-password {
            padding: 0 16px;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: var(--text-secondary);
        }

        /* ── CHECK & LINK ROW ── */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-wrapper input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid var(--border-color);
            border-radius: 3px;
            background: var(--bg-input);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .checkbox-wrapper input[type="checkbox"]:checked {
            background: var(--accent-gold);
            border-color: var(--accent-gold);
        }

        .checkbox-wrapper input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            color: var(--bg-primary);
            font-size: 11px;
            font-weight: 700;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .checkbox-label {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-secondary);
        }

        .recovery-link {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .recovery-link:hover {
            color: var(--accent-gold-light);
        }

        /* ── SUBMIT BUTTON ── */
        .btn-login {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-gold-dark) 100%);
            border: none;
            border-radius: 10px;
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--bg-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(200, 168, 78, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            font-size: 14px;
        }

        /* ── ERROR MESSAGE ── */
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--accent-red);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* ── BIOMETRIC SECTION ── */
        .biometric-section {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .biometric-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .biometric-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(56, 189, 248, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-cyan);
            font-size: 14px;
        }

        .biometric-text {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .biometric-sub {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── FOOTER ── */
        .login-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border-color);
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--text-secondary);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .left-panel {
                display: none;
            }
            .right-panel {
                width: 100%;
                border-left: none;
            }
        }

        @media (max-width: 480px) {
            .right-panel {
                padding: 32px 24px;
            }
            .form-title {
                font-size: 24px;
            }
            .stat-cards {
                flex-direction: column;
            }
        }

        /* ── ANIMATION ── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
        .delay-5 { animation-delay: 0.5s; opacity: 0; }
        .delay-6 { animation-delay: 0.6s; opacity: 0; }
    </style>
</head>

<body>

    <!-- ── TOP BAR ── -->
    <div class="top-bar">
        <div class="top-bar-left">
            <div><span class="status-dot"></span> Status Sistem: Optimal</div>
            <div><i class="fas fa-shield-halved" style="color: var(--accent-cyan); margin-right: 6px;"></i> Protokol Terenkripsi v4.2</div>
        </div>
        <div class="top-bar-right">
            <div>Latensi: 14ms</div>
            <span>Klaster Aurelian Obsidian</span>
        </div>
    </div>

    <!-- ── MAIN LAYOUT ── -->
    <div class="login-wrapper">

        <!-- ── LEFT PANEL ── -->
        <div class="left-panel">
            <img src="<?= base_url('assets/img/bus_dru.jpg') ?>" alt="DRU Bus" class="bus-image">
            <div class="left-logo-container animate-in delay-1">
                <img src="<?= base_url('assets/img/logo_dru.png') ?>" alt="DRU Logo" class="dru-logo">
            </div>
            <div class="left-content">
                <div class="brand-subtitle animate-in delay-1" >DHEEMOBILINDO</div>
                <h1 class="brand-title animate-in delay-2" style="text-shadow: 0 2px 10px rgba(0,0,0,0.5);">RAJA<strong>UTAMA</strong></h1>
                <p class="brand-desc animate-in delay-3">Dipandu Hati, Bepergian dengan Keluarga. Bepergian sebagai teman, pulang sebagai keluarga.</p>
              
            </div>
        </div>

        <!-- ── RIGHT PANEL (LOGIN FORM) ── -->
        <div class="right-panel">

            

            <div>
                <h2 class="form-title animate-in delay-1">Verifikasi Identitas</h2>
                <p class="form-subtitle animate-in delay-2">Silakan inisialisasi protokol akses aman Anda.</p>

                <!-- Error Message -->
                <?php if($this->session->flashdata('error')): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('auth/proses_login'); ?>">

                    <!-- Username -->
                    <div class="form-group animate-in delay-3">
                        <label class="form-label">Username</label>
                        <div class="input-wrapper">
                            <div class="input-icon"><i class="fas fa-user"></i></div>
                            <input type="text" name="username" placeholder="Masukkan Username" required autocomplete="off">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group animate-in delay-4">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <div class="input-icon"><i class="fas fa-lock"></i></div>
                            <input type="password" name="password" id="password" placeholder="••••••••••" required>
                            <div class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Options Row -->
                    <div class="form-options animate-in delay-5">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember">
                            <span class="checkbox-label">Tetap Masuk</span>
                        </label>
                        <a href="#" class="recovery-link" onclick="openRecoveryModal(event)">Pemulihan</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login animate-in delay-5">
                        Inisialisasi Protokol
                        <i class="fas fa-arrow-right"></i>
                    </button>

                </form>

                <!-- Biometric Section -->
                <div class="biometric-section animate-in delay-6">
                    <div class="biometric-info">
                        <div class="biometric-icon"><i class="fas fa-fingerprint"></i></div>
                        <div>
                    <div class="biometric-text">Kunci Akses Biometrik</div>
                    <div class="biometric-sub">Kunci keamanan perangkat keras terdeteksi.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <div>&copy; 2026 Aurelian Obsidian. Hak Cipta Dilindungi.</div>
            </div>

        </div>

    </div>

    <!-- ── RECOVERY MODAL ── -->
    <div class="modal-overlay" id="recoveryModal">
        <div class="modal-container">
            <div class="modal-header-bar">
                <div class="modal-title-group">
                    <i class="fas fa-key" style="color: var(--accent-gold);"></i>
                    <span>Protokol Pemulihan Password</span>
                </div>
                <button class="modal-close" onclick="closeRecoveryModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Step 1: Verify Username -->
            <div class="modal-body" id="recoveryStep1">
                <div class="modal-step-indicator">
                    <div class="step active">1</div>
                    <div class="step-line"></div>
                    <div class="step">2</div>
                </div>
                <h3 class="modal-heading">Verifikasi Identitas</h3>
                <p class="modal-desc">Masukkan username Anda untuk memulai pemulihan password.</p>

                <div class="modal-alert" id="recoveryError" style="display:none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="recoveryErrorText"></span>
                </div>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <div class="input-icon"><i class="fas fa-user-shield"></i></div>
                        <input type="text" id="recovery_username" placeholder="Masukkan Username" required>
                    </div>
                </div>

                <button type="button" class="btn-login" onclick="verifyUsername()" id="btnVerify">
                    <span id="verifyText">Verifikasi Identitas</span>
                    <i class="fas fa-arrow-right" id="verifyIcon"></i>
                    <i class="fas fa-spinner fa-spin" id="verifySpinner" style="display:none;"></i>
                </button>
            </div>

            <!-- Step 2: Set New Password -->
            <div class="modal-body" id="recoveryStep2" style="display:none;">
                <div class="modal-step-indicator">
                    <div class="step completed"><i class="fas fa-check"></i></div>
                    <div class="step-line active"></div>
                    <div class="step active">2</div>
                </div>
                <h3 class="modal-heading">Atur Ulang Sandi Akses</h3>
                <p class="modal-desc">Tetapkan password baru untuk akun Anda.</p>

                <div class="modal-alert success" id="recoverySuccess" style="display:none;">
                    <i class="fas fa-check-circle"></i>
                    <span id="recoverySuccessText"></span>
                </div>
                <div class="modal-alert" id="recoveryError2" style="display:none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="recoveryErrorText2"></span>
                </div>

                <div class="verified-user">
                    <i class="fas fa-user-check"></i>
                    <span id="verifiedUsername"></span>
                </div>

                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <div class="input-wrapper">
                        <div class="input-icon"><i class="fas fa-lock"></i></div>
                        <input type="password" id="new_password" placeholder="Masukkan Password Baru" required>
                        <div class="toggle-password" onclick="toggleNewPassword()">
                            <i class="fas fa-eye" id="toggleNewIcon"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <div class="input-icon"><i class="fas fa-lock"></i></div>
                        <input type="password" id="confirm_password" placeholder="Konfirmasi Password Baru" required>
                        <div class="toggle-password" onclick="toggleConfirmPassword()">
                            <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                        </div>
                    </div>
                </div>

                <div class="password-strength" id="passwordStrength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <span class="strength-text" id="strengthText">Kekuatan Password</span>
                </div>

                <button type="button" class="btn-login" onclick="resetPassword()" id="btnReset">
                    <span id="resetText">Atur Ulang Password</span>
                    <i class="fas fa-shield-halved" id="resetIcon"></i>
                    <i class="fas fa-spinner fa-spin" id="resetSpinner" style="display:none;"></i>
                </button>
            </div>

        </div>
    </div>

    <style>
        /* ── MODAL STYLES ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            width: 440px;
            max-width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px) scale(0.95);
            transition: transform 0.3s ease;
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.5);
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0) scale(1);
        }

        .modal-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--bg-input);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .modal-close:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: var(--accent-red);
        }

        .modal-body {
            padding: 28px 24px;
        }

        .modal-step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 24px;
        }

        .step {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s ease;
        }

        .step.active {
            border-color: var(--accent-gold);
            color: var(--accent-gold);
            background: rgba(200, 168, 78, 0.1);
        }

        .step.completed {
            border-color: var(--accent-green);
            color: var(--accent-green);
            background: rgba(52, 211, 153, 0.1);
        }

        .step-line {
            width: 60px;
            height: 2px;
            background: var(--border-color);
            transition: background 0.3s ease;
        }

        .step-line.active {
            background: linear-gradient(to right, var(--accent-green), var(--accent-gold));
        }

        .modal-heading {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-primary);
            text-align: center;
        }

        .modal-desc {
            font-size: 13px;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 24px;
        }

        .modal-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--accent-red);
            animation: shake 0.5s ease-in-out;
        }

        .modal-alert.success {
            background: rgba(52, 211, 153, 0.1);
            border-color: rgba(52, 211, 153, 0.3);
            color: var(--accent-green);
            animation: none;
        }

        .verified-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: rgba(200, 168, 78, 0.08);
            border: 1px solid rgba(200, 168, 78, 0.2);
            border-radius: 8px;
            margin-bottom: 20px;
            font-family: var(--font-mono);
            font-size: 13px;
            color: var(--accent-gold);
        }

        .verified-user i {
            font-size: 16px;
        }

        .password-strength {
            margin-bottom: 20px;
        }

        .strength-bar {
            height: 4px;
            background: var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 4px;
            transition: all 0.4s ease;
        }

        .strength-text {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .modal-body .form-group {
            margin-bottom: 18px;
        }

        .modal-body .btn-login {
            margin-top: 8px;
        }
    </style>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function toggleNewPassword() {
            const input = document.getElementById('new_password');
            const icon = document.getElementById('toggleNewIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function toggleConfirmPassword() {
            const input = document.getElementById('confirm_password');
            const icon = document.getElementById('toggleConfirmIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Modal controls
        function openRecoveryModal(e) {
            e.preventDefault();
            document.getElementById('recoveryModal').classList.add('active');
            document.getElementById('recoveryStep1').style.display = 'block';
            document.getElementById('recoveryStep2').style.display = 'none';
            document.getElementById('recoveryError').style.display = 'none';
            document.getElementById('recovery_username').value = '';
            document.getElementById('recovery_username').focus();
        }

        function closeRecoveryModal() {
            document.getElementById('recoveryModal').classList.remove('active');
        }

        // Close modal on overlay click
        document.getElementById('recoveryModal').addEventListener('click', function(e) {
            if (e.target === this) closeRecoveryModal();
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeRecoveryModal();
        });

        // Step 1: Verify username via AJAX
        function verifyUsername() {
            const username = document.getElementById('recovery_username').value.trim();
            if (!username) {
                showError('recoveryError', 'recoveryErrorText', 'Username tidak boleh kosong!');
                return;
            }

            // Show loading
            document.getElementById('verifyText').textContent = 'Memverifikasi...';
            document.getElementById('verifyIcon').style.display = 'none';
            document.getElementById('verifySpinner').style.display = 'inline-block';
            document.getElementById('btnVerify').disabled = true;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url("auth/verify_username"); ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    // Reset button
                    document.getElementById('verifyText').textContent = 'Verifikasi Identitas';
                    document.getElementById('verifyIcon').style.display = 'inline-block';
                    document.getElementById('verifySpinner').style.display = 'none';
                    document.getElementById('btnVerify').disabled = false;

                    if (xhr.status === 200) {
                        const res = JSON.parse(xhr.responseText);
                        if (res.status === 'success') {
                            // Go to step 2
                            document.getElementById('recoveryStep1').style.display = 'none';
                            document.getElementById('recoveryStep2').style.display = 'block';
                            document.getElementById('verifiedUsername').textContent = username;
                            document.getElementById('recoveryError2').style.display = 'none';
                            document.getElementById('recoverySuccess').style.display = 'none';
                            document.getElementById('new_password').focus();
                        } else {
                            showError('recoveryError', 'recoveryErrorText', res.message);
                        }
                    } else {
                        showError('recoveryError', 'recoveryErrorText', 'Terjadi kesalahan server.');
                    }
                }
            };
            xhr.send('username=' + encodeURIComponent(username));
        }

        // Step 2: Reset password via AJAX
        function resetPassword() {
            const username = document.getElementById('verifiedUsername').textContent;
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;

            document.getElementById('recoveryError2').style.display = 'none';
            document.getElementById('recoverySuccess').style.display = 'none';

            if (!newPass || !confirmPass) {
                showError('recoveryError2', 'recoveryErrorText2', 'Semua field harus diisi!');
                return;
            }

            if (newPass.length < 4) {
                showError('recoveryError2', 'recoveryErrorText2', 'Password minimal 4 karakter!');
                return;
            }

            if (newPass !== confirmPass) {
                showError('recoveryError2', 'recoveryErrorText2', 'Password dan konfirmasi tidak cocok!');
                return;
            }

            // Show loading
            document.getElementById('resetText').textContent = 'Mengatur ulang...';
            document.getElementById('resetIcon').style.display = 'none';
            document.getElementById('resetSpinner').style.display = 'inline-block';
            document.getElementById('btnReset').disabled = true;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url("auth/reset_password"); ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    document.getElementById('resetText').textContent = 'Atur Ulang Password';
                    document.getElementById('resetIcon').style.display = 'inline-block';
                    document.getElementById('resetSpinner').style.display = 'none';
                    document.getElementById('btnReset').disabled = false;

                    if (xhr.status === 200) {
                        const res = JSON.parse(xhr.responseText);
                        if (res.status === 'success') {
                            document.getElementById('recoverySuccess').style.display = 'flex';
                            document.getElementById('recoverySuccessText').textContent = res.message;
                            // Auto close after 2 seconds
                            setTimeout(function() {
                                closeRecoveryModal();
                            }, 2000);
                        } else {
                            showError('recoveryError2', 'recoveryErrorText2', res.message);
                        }
                    } else {
                        showError('recoveryError2', 'recoveryErrorText2', 'Terjadi kesalahan server.');
                    }
                }
            };
            xhr.send('username=' + encodeURIComponent(username) + '&new_password=' + encodeURIComponent(newPass));
        }

        function showError(containerId, textId, message) {
            document.getElementById(containerId).style.display = 'flex';
            document.getElementById(textId).textContent = message;
        }

        // Password strength checker
        document.getElementById('new_password').addEventListener('input', function() {
            const val = this.value;
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');
            let strength = 0;

            if (val.length >= 4) strength++;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const levels = [
                { width: '0%', color: 'var(--border-color)', label: 'Kekuatan Password' },
                { width: '20%', color: 'var(--accent-red)', label: 'Lemah' },
                { width: '40%', color: '#f97316', label: 'Cukup' },
                { width: '60%', color: 'var(--accent-gold)', label: 'Baik' },
                { width: '80%', color: '#a3e635', label: 'Kuat' },
                { width: '100%', color: 'var(--accent-green)', label: 'Sangat Kuat' }
            ];

            fill.style.width = levels[strength].width;
            fill.style.background = levels[strength].color;
            text.textContent = levels[strength].label;
            text.style.color = levels[strength].color;
        });

        // Enter key support for recovery forms
        document.getElementById('recovery_username').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); verifyUsername(); }
        });
        document.getElementById('confirm_password').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); resetPassword(); }
        });
    </script>

</body>

</html>