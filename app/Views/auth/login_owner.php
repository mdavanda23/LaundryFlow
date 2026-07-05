<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Admin - LaundryFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;min-height:100vh;display:grid;grid-template-columns:1fr 1fr;background:#F8FAFC}
        .left-panel{background:linear-gradient(135deg,#0F172A 0%,#1E293B 60%,#0D9488 100%);display:flex;flex-direction:column;justify-content:center;padding:60px 48px;color:white;position:relative;overflow:hidden}
        .left-panel::before{content:'';position:absolute;top:-100px;right:-100px;width:350px;height:350px;background:rgba(6,182,212,.08);border-radius:50%}
        .left-panel::after{content:'';position:absolute;bottom:-80px;left:-80px;width:250px;height:250px;background:rgba(13,148,136,.08);border-radius:50%}
        .brand{display:flex;align-items:center;gap:12px;margin-bottom:48px;position:relative;z-index:1}
        .brand-icon{width:48px;height:48px;background:linear-gradient(135deg,#06B6D4,#0D9488);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px}
        .brand-name{font-size:20px;font-weight:700}
        .brand-badge{background:rgba(6,182,212,.2);border:1px solid rgba(6,182,212,.3);color:#06B6D4;font-size:11px;font-weight:600;padding:3px 12px;border-radius:20px;display:inline-block;margin-bottom:16px;position:relative;z-index:1;letter-spacing:.5px}
        .left-heading{font-size:34px;font-weight:700;line-height:1.3;margin-bottom:16px;position:relative;z-index:1}
        .left-sub{font-size:14px;opacity:.7;line-height:1.7;position:relative;z-index:1;max-width:340px}
        .feature-list{margin-top:36px;position:relative;z-index:1;display:flex;flex-direction:column;gap:12px}
        .feature-item{display:flex;align-items:center;gap:10px;font-size:13px;opacity:.85}
        .feature-dot{width:6px;height:6px;border-radius:50%;background:#06B6D4;flex-shrink:0}

        .right-panel{display:flex;align-items:center;justify-content:center;padding:48px}
        .form-card{width:100%;max-width:400px}
        h2{font-size:24px;font-weight:700;color:#0F172A;margin-bottom:4px}
        .sub{font-size:13px;color:#64748B;margin-bottom:28px}

        .alert-success{background:#D1FAE5;color:#065F46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;font-weight:500}
        .alert-error{background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px}

        .form-group{margin-bottom:16px}
        label{font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px}
        .input-wrap{position:relative}
        .input-wrap svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94A3B8}
        input{width:100%;padding:12px 14px 12px 40px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s;color:#0F172A}
        input:focus{border-color:#06B6D4;box-shadow:0 0 0 3px rgba(6,182,212,.08)}

        .btn-submit{width:100%;padding:13px;background:linear-gradient(135deg,#0F172A,#1E293B);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;margin-top:8px;transition:opacity .2s;position:relative;overflow:hidden}
        .btn-submit::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(135deg,#06B6D4,#0D9488);opacity:0;transition:opacity .3s}
        .btn-submit:hover::before{opacity:1}
        .btn-submit span{position:relative;z-index:1}

        .role-tabs{display:flex;gap:8px;margin-bottom:24px;background:#F1F5F9;border-radius:10px;padding:4px}
        .role-tab{flex:1;text-align:center;padding:8px;border-radius:8px;font-size:12px;font-weight:600;color:#64748B;text-decoration:none;transition:all .2s}
        .role-tab.active{background:#fff;color:#0F172A;box-shadow:0 1px 3px rgba(0,0,0,.08)}

        .footer-note{text-align:center;font-size:12px;color:#94A3B8;margin-top:24px}

        @media(max-width:768px){body{grid-template-columns:1fr}.left-panel{display:none}.right-panel{padding:32px 20px}}
    </style>
</head>
<body>

<div class="left-panel">
    <div class="brand">
        <div class="brand-icon">🧺</div>
        <span class="brand-name">LaundryFlow</span>
    </div>
    <span class="brand-badge">ADMIN PANEL</span>
    <h2 class="left-heading">Kendali Penuh<br>di Satu Tempat</h2>
    <p class="left-sub">Kelola layanan, pengguna, laporan keuangan, dan seluruh operasional LaundryFlow dari dashboard admin.</p>

    <div class="feature-list">
        <div class="feature-item"><span class="feature-dot"></span>Manajemen layanan & harga</div>
        <div class="feature-item"><span class="feature-dot"></span>Kelola pengguna & staff</div>
        <div class="feature-item"><span class="feature-dot"></span>Laporan revenue & statistik</div>
        <div class="feature-item"><span class="feature-dot"></span>Konfigurasi sistem</div>
    </div>
</div>

<div class="right-panel">
    <div class="form-card">

        <div class="role-tabs">
            <a href="<?= site_url('customer/login') ?>" class="role-tab">Pelanggan</a>
            <a href="<?= site_url('staff/login') ?>" class="role-tab">Staff</a>
            <a href="<?= site_url('admin/login') ?>" class="role-tab active">Admin</a>
        </div>

        <h2>Admin Login</h2>
        <p class="sub">Masuk menggunakan akun administrator.</p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">✗ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('admin/login') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Email</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <input type="email" name="email" placeholder="admin@laundryflow.com"
                           value="<?= old('email') ?>" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-submit"><span>Masuk sebagai Admin →</span></button>
        </form>

        <p class="footer-note">Akses terbatas untuk administrator sistem.</p>
    </div>
</div>

</body>
</html>