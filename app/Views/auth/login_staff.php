<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Staff - LaundryFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;min-height:100vh;display:grid;grid-template-columns:1fr 1fr;background:#F8FAFC}

        /* Left Panel */
        .left-panel{background:linear-gradient(135deg,#06B6D4 0%,#0D9488 100%);display:flex;flex-direction:column;justify-content:center;padding:60px 48px;color:white;position:relative;overflow:hidden}
        .left-panel::before{content:'';position:absolute;top:-80px;right:-80px;width:300px;height:300px;background:rgba(255,255,255,.05);border-radius:50%}
        .left-panel::after{content:'';position:absolute;bottom:-60px;left:-60px;width:200px;height:200px;background:rgba(255,255,255,.05);border-radius:50%}
        .brand{display:flex;align-items:center;gap:12px;margin-bottom:48px;position:relative;z-index:1}
        .brand-icon{width:48px;height:48px;background:rgba(255,255,255,.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;border:1px solid rgba(255,255,255,.3)}
        .brand-name{font-size:20px;font-weight:700}
        .brand-badge{background:rgba(255,255,255,.2);font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;display:inline-block;margin-bottom:16px;position:relative;z-index:1;letter-spacing:.5px}
        .left-heading{font-size:32px;font-weight:700;line-height:1.3;margin-bottom:16px;position:relative;z-index:1}
        .left-sub{font-size:14px;opacity:.85;line-height:1.6;position:relative;z-index:1;max-width:340px}

        /* Stats row */
        .stats-row{display:flex;gap:20px;margin-top:40px;position:relative;z-index:1}
        .stat-box{background:rgba(255,255,255,.15);border-radius:12px;padding:14px 18px;border:1px solid rgba(255,255,255,.2)}
        .stat-box-val{font-size:22px;font-weight:700}
        .stat-box-lbl{font-size:11px;opacity:.8;margin-top:2px}

        /* Right Panel */
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
        input{width:100%;padding:12px 14px 12px 40px;border:1px solid #E2E8F0;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s;color:#0F172A}
        input:focus{border-color:#06B6D4;box-shadow:0 0 0 3px rgba(6,182,212,.08)}

        .btn-submit{width:100%;padding:13px;background:linear-gradient(135deg,#06B6D4,#0D9488);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;margin-top:8px;transition:opacity .2s}
        .btn-submit:hover{opacity:.9}

        .footer-note{text-align:center;font-size:12px;color:#94A3B8;margin-top:24px}
        .footer-note a{color:#06B6D4;text-decoration:none;font-weight:600}

        /* Role switcher */
        .role-tabs{display:flex;gap:8px;margin-bottom:24px;background:#F1F5F9;border-radius:10px;padding:4px}
        .role-tab{flex:1;text-align:center;padding:8px;border-radius:8px;font-size:12px;font-weight:600;color:#64748B;text-decoration:none;transition:all .2s}
        .role-tab.active{background:#fff;color:#06B6D4;box-shadow:0 1px 3px rgba(0,0,0,.08)}

        @media(max-width:768px){
            body{grid-template-columns:1fr}
            .left-panel{display:none}
            .right-panel{padding:32px 20px}
        }
    </style>
</head>
<body>

<!-- Left Panel -->
<div class="left-panel">
    <div class="brand">
        <div class="brand-icon">🧺</div>
        <span class="brand-name">LaundryFlow</span>
    </div>
    <span class="brand-badge">PORTAL STAFF</span>
    <h2 class="left-heading">Kelola Pesanan<br>dengan Efisien</h2>
    <p class="left-sub">Pantau antrian, perbarui status, dan tangani pesanan pelanggan secara real-time dari satu dashboard.</p>

    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-box-val">48</div>
            <div class="stat-box-lbl">Pesanan Hari Ini</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-val">16</div>
            <div class="stat-box-lbl">Sedang Diproses</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-val">29</div>
            <div class="stat-box-lbl">Selesai</div>
        </div>
    </div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-card">

        <!-- Role Tabs -->
        <div class="role-tabs">
            <a href="<?= site_url('customer/login') ?>" class="role-tab">Pelanggan</a>
            <a href="<?= site_url('staff/login') ?>" class="role-tab active">Staff</a>
            <a href="<?= site_url('admin/login') ?>" class="role-tab">Admin</a>
        </div>

        <h2>Masuk Staff</h2>
        <p class="sub">Login menggunakan akun staff LaundryFlow.</p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">✗ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('staff/login') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Email</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <input type="email" name="email" placeholder="staff@laundryflow.com"
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

            <button type="submit" class="btn-submit">Masuk sebagai Staff →</button>
        </form>

        <p class="footer-note">
            Butuh bantuan? Hubungi
            <a href="mailto:admin@laundryflow.com">admin@laundryflow.com</a>
        </p>
    </div>
</div>

</body>
</html>