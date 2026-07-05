<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'LaundryFlow') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/customer.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="app-wrapper">
    <div class="page-content">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="<?= base_url('customer') ?>" class="nav-item <?= (uri_string() === 'customer' || uri_string() === 'customer/') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span>Home</span>
        </a>
        <a href="<?= base_url('customer/history') ?>" class="nav-item <?= str_contains(uri_string(), 'history') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
            <span>Orders</span>
        </a>
        <a href="<?= base_url('customer/notifications') ?>" class="nav-item <?= str_contains(uri_string(), 'notif') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
            <span>Alerts</span>
        </a>
        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Profile</span>
        </a>
        <a href="<?= site_url('customer/profile') ?>" 
        class="nav-item <?= str_contains(uri_string(), 'profile') ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Profile</span>
        </a>
    </nav>
</div>

<script src="<?= base_url('js/customer.js') ?>"></script>
</body>
</html>
