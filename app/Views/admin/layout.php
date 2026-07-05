<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= esc($title ?? 'Admin - LaundryFlow') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;background:#F8FAFC;color:#0F172A;display:flex;min-height:100vh}

        .sidebar{width:210px;background:#0F172A;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:50}
        .sidebar-logo{padding:20px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid rgba(255,255,255,.08)}
        .sidebar-logo-icon{width:36px;height:36px;background:linear-gradient(135deg,#06B6D4,#0D9488);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px}
        .sidebar-logo-text span{font-size:15px;font-weight:700;color:white;display:block}
        .sidebar-logo-text small{font-size:10px;color:#64748B}
        .sidebar-nav{padding:12px 0;flex:1;overflow-y:auto}
        .nav-section{padding:8px 16px 4px;font-size:10px;font-weight:600;color:#475569;letter-spacing:.8px;text-transform:uppercase}
        .nav-link{display:flex;align-items:center;gap:10px;padding:9px 16px;color:#94A3B8;text-decoration:none;font-size:13px;font-weight:500;transition:all .15s;border-left:3px solid transparent}
        .nav-link:hover{background:rgba(255,255,255,.05);color:#E2E8F0}
        .nav-link.active{background:rgba(6,182,212,.1);color:#06B6D4;border-left-color:#06B6D4;font-weight:600}
        .nav-link svg{width:16px;height:16px;flex-shrink:0}
        .sidebar-footer{padding:12px 16px;border-top:1px solid rgba(255,255,255,.08)}

        .topbar{position:fixed;top:0;left:210px;right:0;height:56px;background:#fff;border-bottom:1px solid #E2E8F0;display:flex;align-items:center;justify-content:space-between;padding:0 24px;z-index:40}
        .topbar-title{font-size:16px;font-weight:700;color:#0F172A}
        .topbar-right{display:flex;align-items:center;gap:12px}
        .topbar-user{display:flex;align-items:center;gap:8px}
        .topbar-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#0F172A,#1E293B);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:12px}
        .notif-bell{position:relative;width:32px;height:32px;background:#F1F5F9;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;text-decoration:none}
        .notif-bell svg{width:16px;height:16px;color:#64748B}
        .notif-badge{position:absolute;top:4px;right:4px;width:8px;height:8px;background:#EF4444;border-radius:50%;border:2px solid white}

        .main{margin-left:210px;margin-top:56px;flex:1;padding:24px}

        /* Cards & Tables */
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:#fff;border-radius:16px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.05);display:flex;flex-direction:column}
        .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
        .stat-icon svg{width:22px;height:22px}
        .stat-top{display:flex;justify-content:space-between;align-items:flex-start}
        .stat-badge-up{font-size:11px;font-weight:600;color:#10B981;background:#D1FAE5;padding:2px 8px;border-radius:20px}
        .stat-value{font-size:28px;font-weight:700;margin-bottom:2px}
        .stat-label{font-size:12px;color:#64748B}

        .card{background:#fff;border-radius:16px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.05);margin-bottom:20px}
        .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
        .card-title{font-size:15px;font-weight:600}
        .card-sub{font-size:12px;color:#94A3B8;margin-top:2px}

        table{width:100%;border-collapse:collapse}
        th{font-size:11px;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:.5px;padding:10px 12px;text-align:left;border-bottom:1px solid #F1F5F9}
        td{padding:12px;font-size:13px;border-bottom:1px solid #F8FAFC;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#FAFAFA}

        .avatar{width:32px;height:32px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:white;font-size:12px;font-weight:700;margin-right:8px;vertical-align:middle}

        .badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
        .badge-active{background:#D1FAE5;color:#065F46}
        .badge-inactive{background:#FEE2E2;color:#991B1B}
        .badge-pending{background:#FEF3C7;color:#92400E}
        .badge-paid{background:#D1FAE5;color:#065F46}
        .badge-customer{background:#DBEAFE;color:#1E40AF}
        .badge-staff{background:#EDE9FE;color:#5B21B6}
        .badge-admin{background:#FEF3C7;color:#92400E}
        .badge-draft{background:#F1F5F9;color:#64748B}

        .btn{padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;border:none;text-decoration:none;display:inline-block;font-family:'Inter',sans-serif;transition:opacity .2s}
        .btn:hover{opacity:.85}
        .btn-primary{background:linear-gradient(135deg,#06B6D4,#0D9488);color:white}
        .btn-dark{background:#0F172A;color:white}
        .btn-danger{background:#FEE2E2;color:#991B1B}
        .btn-outline{background:#fff;border:1px solid #E2E8F0;color:#0F172A}
        .btn-sm{padding:5px 10px;font-size:11px}

        .form-input{width:100%;padding:9px 12px;border:1px solid #E2E8F0;border-radius:8px;font-size:13px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s}
        .form-input:focus{border-color:#06B6D4}
        .form-group{margin-bottom:14px}
        .form-label{font-size:12px;font-weight:600;display:block;margin-bottom:5px;color:#374151}

        .search-wrap{position:relative}
        .search-wrap svg{position:absolute;left:10px;top:50%;transform:translateY(-50%);width:14px;height:14px;color:#94A3B8}
        .search-input{padding:8px 10px 8px 32px;border:1px solid #E2E8F0;border-radius:8px;font-size:13px;font-family:'Inter',sans-serif;outline:none;width:240px}
        .search-input:focus{border-color:#06B6D4}

        .alert-success{background:#D1FAE5;color:#065F46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;font-weight:500}
        .alert-error{background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px}

        /* Modal */
        .modal-backdrop{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;align-items:center;justify-content:center}
        .modal-backdrop.show{display:flex}
        .modal{background:#fff;border-radius:16px;padding:28px;width:100%;max-width:460px;box-shadow:0 20px 60px rgba(0,0,0,.15)}
        .modal-title{font-size:17px;font-weight:700;margin-bottom:20px}
        .modal-footer{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}

        /* Progress bar */
        .progress-bar-wrap{background:#F1F5F9;border-radius:99px;height:6px;overflow:hidden}
        .progress-bar-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#06B6D4,#0D9488)}

        /* Two column grid */
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">🧺</div>
        <div class="sidebar-logo-text">
            <span>LaundryFlow</span>
            <small>Administrator</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <?php
        $uri  = uri_string();
        $navs = [
            ['section' => 'OVERVIEW'],
            ['href' => 'admin',               'label' => 'Dashboard',      'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
            ['section' => 'KELOLA'],
            ['href' => 'admin/services',      'label' => 'Services',       'icon' => '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>'],
            ['href' => 'admin/prices',        'label' => 'Laundry Prices', 'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>'],
            ['href' => 'admin/users',         'label' => 'Users',          'icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>'],
            ['section' => 'ANALITIK'],
            ['href' => 'admin/reports',       'label' => 'Reports',        'icon' => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>'],
            ['section' => 'SISTEM'],
            ['href' => 'admin/settings',      'label' => 'Settings',       'icon' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>'],
        ];
        foreach ($navs as $nav):
            if (isset($nav['section'])):
        ?>
            <div class="nav-section"><?= $nav['section'] ?></div>
        <?php else:
            $active = ($uri === $nav['href'] || str_starts_with($uri, $nav['href'].'/'));
        ?>
            <a href="<?= site_url($nav['href']) ?>" class="nav-link <?= $active?'active':'' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?= $nav['icon'] ?></svg>
                <?= $nav['label'] ?>
            </a>
        <?php endif; endforeach; ?>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= site_url('admin/logout') ?>" class="nav-link" style="color:#EF4444">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Logout
        </a>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <h1 class="topbar-title"><?= esc($title ?? '') ?></h1>
    <div class="topbar-right">
        <a href="<?= site_url('admin/notifications') ?>" class="notif-bell">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
            <span class="notif-badge"></span>
        </a>
        <div class="topbar-user">
            <div class="topbar-avatar">
                <?= strtoupper(substr(session()->get('admin')['name']??'A',0,1)) ?>
            </div>
            <div>
                <div style="font-weight:600;font-size:13px"><?= esc(session()->get('admin')['name']??'') ?></div>
                <div style="font-size:11px;color:#94A3B8">Administrator</div>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <?= $this->renderSection('content') ?>
</main>

</body>
</html>