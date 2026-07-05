<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="page-header">
    <div>
        <p class="greeting-text">Selamat Datang 👋</p>
        <h1 class="greeting-name"><?= esc($user['name']) ?></h1>
    </div>
    <a href="<?= site_url('customer/notifications') ?>" class="notif-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 01-3.46 0"/>
        </svg>
        <span class="notif-dot"></span>
    </a>
</div>

<!-- Current Order Card -->
<?php if ($current_order): ?>
<?php
$progressMap = [
    'Pending'   => 10,
    'Received'  => 25,
    'Washing'   => 50,
    'Drying'    => 65,
    'Ironing'   => 80,
    'Ready'     => 95,
    'Completed' => 100,
];
$pct = $progressMap[$current_order['status']] ?? 0;
?>
<div class="current-order-card">
    <div class="order-card-top">
        <span class="label-small">PESANAN BERJALAN</span>
        <span class="badge-status"><?= esc($current_order['status']) ?></span>
    </div>
    <h2 class="order-id"><?= esc($current_order['invoice']) ?></h2>
    <div class="progress-row">
        <span class="label-small">Progress</span>
        <span class="label-small"><?= $pct ?>%</span>
    </div>
    <div class="progress-bar">
        <div class="progress-fill" style="width: <?= $pct ?>%"></div>
    </div>
    <div class="order-card-bottom">
        <div>
            <p class="label-small">Estimasi Selesai</p>
            <p class="finish-time">
                <?= $current_order['finish_date']
                    ? date('d M · H:i', strtotime($current_order['finish_date']))
                    : '-' ?>
            </p>
        </div>
        <a href="<?= site_url('customer/track') ?>" class="btn-track">Lacak →</a>
    </div>
</div>
<?php else: ?>
<div style="background:#F1F5F9;border-radius:16px;padding:24px;text-align:center;margin-bottom:20px;color:#64748B">
    <p style="font-size:14px;margin-bottom:8px">Tidak ada pesanan aktif saat ini.</p>
    <a href="<?= site_url('customer/new-order') ?>"
       style="color:#06B6D4;font-weight:600;font-size:13px;text-decoration:none">
        + Buat Pesanan Baru
    </a>
</div>
<?php endif; ?>

<!-- Menu Cepat -->
<div class="quick-actions">
    <a href="<?= site_url('customer/new-order') ?>" class="action-item">
        <div class="action-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </div>
        <span>Pesan</span>
    </a>
    <a href="<?= site_url('customer/track') ?>" class="action-item">
        <div class="action-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </div>
        <span>Lacak</span>
    </a>
    <a href="<?= site_url('customer/history') ?>" class="action-item">
        <div class="action-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <span>Riwayat</span>
    </a>
    <a href="<?= site_url('customer/notifications') ?>" class="action-item">
        <div class="action-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
        </div>
        <span>Notifikasi</span>
    </a>
</div>

<!-- Promo -->
<div class="promo-banner">
    <span class="promo-icon">🎁</span>
    <div>
        <p class="promo-text"><?= esc($promo['text']) ?></p>
        <p class="promo-code">
            Gunakan kode <strong><?= esc($promo['code']) ?></strong> • Berlaku hari ini
        </p>
    </div>
    <span class="promo-settings">🎉</span>
</div>

<!-- Pesanan Terbaru -->
<div class="section-header">
    <h3>Pesanan Terbaru</h3>
    <a href="<?= site_url('customer/history') ?>" class="see-all">Lihat Semua</a>
</div>

<div class="orders-list">
    <?php if (!empty($recent_orders)): ?>
        <?php foreach ($recent_orders as $order): ?>
        <?php
        // Map status DB ke label & class Indonesia
        $statusMap = [
            'pending'   => ['label' => 'Menunggu',    'class' => 'processing'],
            'received'  => ['label' => 'Diterima',    'class' => 'processing'],
            'washing'   => ['label' => 'Dicuci',      'class' => 'processing'],
            'drying'    => ['label' => 'Dikeringkan', 'class' => 'processing'],
            'ironing'   => ['label' => 'Disetrika',   'class' => 'processing'],
            'ready'     => ['label' => 'Siap Diambil','class' => 'ready'],
            'completed' => ['label' => 'Selesai',     'class' => 'completed'],
            'cancelled' => ['label' => 'Dibatalkan',  'class' => 'cancelled'],
        ];
        $statusKey   = strtolower($order['status']);
        $statusLabel = $statusMap[$statusKey]['label'] ?? $order['status'];
        $statusClass = $statusMap[$statusKey]['class'] ?? 'processing';
        ?>
        <div class="order-item">
            <div class="order-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                    <line x1="8" y1="21" x2="16" y2="21"/>
                    <line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
            </div>
            <div class="order-info">
                <p class="order-num"><?= esc($order['invoice']) ?></p>
                <p class="order-sub">
                    <?= esc($order['service_name']) ?> · <?= esc($order['weight']) ?> kg
                </p>
            </div>
            <div class="order-right">
                <p class="order-date"><?= date('d M', strtotime($order['created_at'])) ?></p>
                <span class="badge <?= $statusClass ?>">
                    ● <?= $statusLabel ?>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align:center;padding:24px 0;color:#94A3B8">
            <p style="font-size:13px">Belum ada pesanan.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>