<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= esc($title ?? 'Staff - LaundryFlow') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;background:#F8FAFC;color:#0F172A;display:flex;min-height:100vh}

        /* Sidebar */
        .sidebar{width:200px;background:#fff;border-right:1px solid #E2E8F0;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:50}
        .sidebar-logo{padding:20px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid #E2E8F0}
        .sidebar-logo-icon{width:36px;height:36px;background:linear-gradient(135deg,#06B6D4,#0D9488);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px}
        .sidebar-logo span{font-size:15px;font-weight:700;color:#06B6D4}
        .sidebar-logo small{font-size:10px;color:#94A3B8;display:block;font-weight:400}
        .sidebar-nav{padding:12px 0;flex:1;overflow-y:auto}
        .nav-link{display:flex;align-items:center;gap:10px;padding:10px 16px;color:#64748B;text-decoration:none;font-size:13px;font-weight:500;transition:all .15s;border-left:3px solid transparent}
        .nav-link:hover{background:#F1F5F9;color:#0F172A}
        .nav-link.active{background:#EFF9FB;color:#06B6D4;border-left-color:#06B6D4;font-weight:600}
        .nav-link svg{width:16px;height:16px;flex-shrink:0}
        .sidebar-footer{padding:12px 16px;border-top:1px solid #E2E8F0}

        /* Topbar */
        .topbar{position:fixed;top:0;left:200px;right:0;height:56px;background:#fff;border-bottom:1px solid #E2E8F0;display:flex;align-items:center;justify-content:space-between;padding:0 24px;z-index:40}
        .topbar-title{font-size:16px;font-weight:700}
        .topbar-right{display:flex;align-items:center;gap:12px}
        .topbar-user{display:flex;align-items:center;gap:8px;font-size:13px}
        .topbar-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#06B6D4,#0D9488);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:12px}
        .notif-bell{position:relative;width:32px;height:32px;background:#F1F5F9;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer}
        .notif-bell svg{width:16px;height:16px;color:#64748B}
        .notif-badge{position:absolute;top:4px;right:4px;width:8px;height:8px;background:#EF4444;border-radius:50%;border:2px solid white}

        /* Main */
        .main{margin-left:200px;margin-top:56px;flex:1;padding:24px;min-height:calc(100vh - 56px)}

        /* Cards */
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:#fff;border-radius:16px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.05)}
        .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:12px}
        .stat-icon svg{width:22px;height:22px}
        .stat-value{font-size:26px;font-weight:700;margin-bottom:2px}
        .stat-label{font-size:12px;color:#64748B}
        .stat-badge{font-size:11px;font-weight:600;color:#10B981;float:right;margin-top:2px}

        /* Table */
        .card{background:#fff;border-radius:16px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.05);margin-bottom:20px}
        .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
        .card-title{font-size:15px;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{font-size:11px;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:.5px;padding:10px 12px;text-align:left;border-bottom:1px solid #F1F5F9}
        td{padding:12px;font-size:13px;border-bottom:1px solid #F8FAFC;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        .customer-avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#06B6D4,#0D9488);display:inline-flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700;margin-right:8px;vertical-align:middle}

        /* Badges */
        .badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
        .badge-pending{background:#FEF3C7;color:#92400E}
        .badge-received{background:#DBEAFE;color:#1E40AF}
        .badge-washing{background:#EDE9FE;color:#5B21B6}
        .badge-drying{background:#E0F2FE;color:#0369A1}
        .badge-ironing{background:#FCE7F3;color:#9D174D}
        .badge-ready{background:#D1FAE5;color:#065F46}
        .badge-completed{background:#D1FAE5;color:#065F46}
        .badge-cancelled{background:#FEE2E2;color:#991B1B}

        /* Buttons */
        .btn{padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;border:none;text-decoration:none;display:inline-block;font-family:'Inter',sans-serif}
        .btn-primary{background:linear-gradient(135deg,#06B6D4,#0D9488);color:white}
        .btn-sm{padding:5px 10px;font-size:11px}
        .btn-outline{background:#fff;border:1px solid #E2E8F0;color:#0F172A}

        /* Form */
        .form-input{width:100%;padding:10px 14px;border:1px solid #E2E8F0;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;outline:none}
        .form-input:focus{border-color:#06B6D4}
        .form-label{font-size:13px;font-weight:600;display:block;margin-bottom:6px;color:#374151}
        .form-group{margin-bottom:16px}

        /* Search */
        .search-wrap{position:relative;flex:1}
        .search-wrap svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#94A3B8}
        .search-input{width:100%;padding:9px 12px 9px 36px;border:1px solid #E2E8F0;border-radius:10px;font-size:13px;font-family:'Inter',sans-serif;outline:none}
        .search-input:focus{border-color:#06B6D4}

        /* Alert */
        .alert-success{background:#D1FAE5;color:#065F46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;font-weight:500}
        .alert-error{background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px}

        /* Kanban */
        .kanban-board{display:flex;gap:14px;overflow-x:auto;padding-bottom:12px}
        .kanban-col{min-width:220px;background:#F8FAFC;border-radius:14px;padding:14px}
        .kanban-col-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
        .kanban-col-title{font-size:13px;font-weight:600;display:flex;align-items:center;gap:6px}
        .kanban-dot{width:8px;height:8px;border-radius:50%}
        .kanban-count{background:#E2E8F0;color:#64748B;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px}
        .kanban-card{background:#fff;border-radius:10px;padding:12px;margin-bottom:8px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
        .kanban-invoice{font-size:12px;font-weight:700;color:#06B6D4;margin-bottom:4px}
        .kanban-customer{font-size:13px;font-weight:600;margin-bottom:2px}
        .kanban-detail{font-size:11px;color:#64748B}
        .kanban-time{font-size:10px;color:#94A3B8;margin-top:6px}
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">🧺</div>
        <div>
            <span>LaundryFlow</span>
            <small><?= esc(session()->get('staff')['role'] ?? 'Staff') ?></small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <?php
        $uri = uri_string();
        $navs = [
            ['href' => 'staff',              'label' => 'Dashboard',     'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
            ['href' => 'staff/orders',       'label' => 'Orders',        'icon' => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/>'],
            ['href' => 'staff/processing',   'label' => 'Processing',    'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>'],
            ['href' => 'staff/customers',    'label' => 'Customers',     'icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>'],
            ['href' => 'staff/profile',      'label' => 'Profile',       'icon' => '<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
        ];
        foreach ($navs as $nav):
            $active = ($uri === $nav['href'] || str_starts_with($uri, $nav['href'] . '/'));
        ?>
        <a href="<?= site_url($nav['href']) ?>" class="nav-link <?= $active ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <?= $nav['icon'] ?>
            </svg>
            <?= $nav['label'] ?>
        </a>
        <?php endforeach; ?>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= site_url('staff/logout') ?>" class="nav-link" style="color:#EF4444">
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
        <a href="<?= site_url('staff/notifications') ?>" class="notif-bell">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
            <span class="notif-badge"></span>
        </a>
        <div class="topbar-user">
            <div class="topbar-avatar">
                <?= strtoupper(substr(session()->get('staff')['name'] ?? 'S', 0, 1)) ?>
            </div>
            <div>
                <div style="font-weight:600;font-size:13px"><?= esc(session()->get('staff')['name'] ?? '') ?></div>
                <div style="font-size:11px;color:#94A3B8">Staff</div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="main">
    <?= $this->renderSection('content') ?>
</main>

</body>
</html>