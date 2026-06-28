<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Dheemobilindo</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/tiya/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'DM Sans', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .login-card img {
            height: 50px;
            margin-bottom: 20px;
        }
        .login-card h3 {
            font-weight: 700;
            color: #3D405B;
            margin-bottom: 10px;
        }
        .login-card p {
            color: #6c757d;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <a href="<?= base_url('home') ?>"><img src="<?= base_url('assets/img/logo_dru.png') ?>" alt="Dheemobilindo"></a>
        <h3>Welcome</h3>
        <p>Login to manage your bookings</p>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger" style="font-size:0.85rem; padding:10px;">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

      
        <div id="g_id_onload"
            data-client_id="332745184990-uhqfi9e5kbh2fr2lron0gqd6cdo2g8qr.apps.googleusercontent.com"
            data-login_uri="<?= base_url('home/google_callback') ?>"
            data-auto_prompt="false">
        </div>
        <div class="g_id_signin"
            data-type="standard"
            data-size="large"
            data-theme="outline"
            data-text="sign_in_with"
            data-shape="rectangular"
            data-logo_alignment="left"
            style="display: flex; justify-content: center;">
        </div>

        <div style="margin-top: 30px;">
            <a href="<?= base_url('home') ?>" style="color: #81B29A; text-decoration: none; font-size: 0.85rem; font-weight:500;">
                &larr; Back to Home
            </a>
        </div>
    </div>

    <!-- Google Accounts Library -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</body>
</html>
