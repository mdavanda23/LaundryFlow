<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="page-header">
    <div>
        <p class="greeting-text">Selamat Datang 👋</p>
        <h1 class="greeting-name"><?= esc($user['name']) ?></h1>
    </div>

    <a href="<?= base_url('customer/notifications') ?>" class="notif-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 01-3.46 0"/>
        </svg>
        <span class="notif-dot"></span>
    </a>
</div>

<!-- Pesanan Berjalan -->
<div class="current-order-card">
    <div class="order-card-top">
        <span class="label-small">PESANAN BERJALAN</span>
        <span class="badge-status"><?= esc($current_order['status']) ?></span>
    </div>

    <h2 class="order-id"><?= esc($current_order['id']) ?></h2>

    <div class="progress-row">
        <span class="label-small">Progress</span>
        <span class="label-small"><?= esc($current_order['progress']) ?>%</span>
    </div>

    <div class="progress-bar">
        <div class="progress-fill" style="width: <?= esc($current_order['progress']) ?>%"></div>
    </div>

    <div class="order-card-bottom">
        <div>
            <p class="label-small">Estimasi Selesai</p>
            <p class="finish-time"><?= esc($current_order['finish']) ?></p>
        </div>

        <a href="<?= base_url('customer/track') ?>" class="btn-track">
            Lacak →
        </a>
    </div>
</div>

<!-- Menu Cepat -->
<div class="quick-actions">

    <a href="<?= base_url('customer/new-order') ?>" class="action-item">
        <div class="action-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </div>
        <span>Pesan</span>
    </a>

    <a href="<?= base_url('customer/track') ?>" class="action-item">
        <div class="action-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </div>
        <span>Lacak</span>
    </a>

    <a href="<?= base_url('customer/history') ?>" class="action-item">
        <div class="action-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <span>Riwayat</span>
    </a>

    <a href="<?= base_url('customer/notifications') ?>" class="action-item">
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

<!-- Riwayat Terbaru -->
<div class="section-header">
    <h3>Pesanan Terbaru</h3>

    <a href="<?= base_url('customer/history') ?>" class="see-all">
        Lihat Semua
    </a>
</div>

<div class="orders-list">

    <?php foreach ($recent_orders as $order): ?>

    <div class="order-item">

        <div class="order-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <line x1="8" y1="21" x2="16" y2="21"/>
                <line x1="12" y1="17" x2="12" y2="21"/>
            </svg>
        </div>

        <div class="order-info">
            <p class="order-num"><?= esc($order['id']) ?></p>
            <p class="order-sub">
                <?= esc($order['type']) ?> • <?= esc($order['weight']) ?>
            </p>
        </div>

        <div class="order-right">

            <p class="order-date"><?= esc($order['date']) ?></p>

            <?php
                $status = strtolower($order['status']);

                switch ($status) {
                    case 'processing':
                        $statusText = 'Diproses';
                        $statusClass = 'processing';
                        break;

                    case 'ready':
                        $statusText = 'Siap Diambil';
                        $statusClass = 'ready';
                        break;

                    case 'completed':
                        $statusText = 'Selesai';
                        $statusClass = 'completed';
                        break;

                    case 'cancelled':
                        $statusText = 'Dibatalkan';
                        $statusClass = 'cancelled';
                        break;

                    default:
                        $statusText = $order['status'];
                        $statusClass = strtolower(str_replace(' ', '-', $order['status']));
                        break;
                }
            ?>

            <span class="badge <?= esc($statusClass) ?>">
                ● <?= esc($statusText) ?>
            </span>

        </div>

    </div>

    <?php endforeach; ?>

</div>

<?= $this->endSection() ?>