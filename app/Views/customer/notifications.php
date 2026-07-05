<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="page-header-simple">
    <h1 class="page-title">Notifikasi</h1>
    <p class="page-sub"><?= $unread_count ?> notifikasi belum dibaca</p>
</div>

<div class="notif-list">
    <?php if (!empty($notifications)): ?>

    <?php
    // Map judul notifikasi ke icon
    function getNotifIcon(string $title): array {
        $t = strtolower($title);
        if (str_contains($t, 'wash') || str_contains($t, 'cuci'))
            return ['bg' => '#06B6D4', 'path' => 'washing'];
        if (str_contains($t, 'ready') || str_contains($t, 'siap'))
            return ['bg' => '#10B981', 'path' => 'ready'];
        if (str_contains($t, 'payment') || str_contains($t, 'bayar'))
            return ['bg' => '#F59E0B', 'path' => 'payment'];
        if (str_contains($t, 'promo') || str_contains($t, 'diskon'))
            return ['bg' => '#EC4899', 'path' => 'promo'];
        return ['bg' => '#06B6D4', 'path' => 'order'];
    }
    ?>

    <?php foreach ($notifications as $notif): ?>
    <?php
    $ic = getNotifIcon($notif['title']);

    // Format waktu relatif
    $created = strtotime($notif['created_at']);
    $diff    = time() - $created;
    if ($diff < 60)          $timeLabel = 'Baru saja';
    elseif ($diff < 3600)    $timeLabel = floor($diff/60) . ' menit lalu';
    elseif ($diff < 86400)   $timeLabel = floor($diff/3600) . ' jam lalu';
    elseif ($diff < 172800)  $timeLabel = 'Kemarin';
    else                     $timeLabel = date('d M', $created);
    ?>
    <div class="notif-item <?= !$notif['is_read'] ? 'unread' : '' ?>">
        <div class="notif-icon-wrap" style="background:<?= $ic['bg'] ?>">
            <?php if ($ic['path'] === 'washing'): ?>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M4 4h16v16H4z"/><path d="M9 9c1.5-1.5 4-1.5 5.5 0s1.5 4 0 5.5"/>
            </svg>
            <?php elseif ($ic['path'] === 'ready'): ?>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <?php elseif ($ic['path'] === 'payment'): ?>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
            <?php elseif ($ic['path'] === 'promo'): ?>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <polyline points="20 12 20 22 4 22 4 12"/>
                <rect x="2" y="7" width="20" height="5"/>
                <line x1="12" y1="22" x2="12" y2="7"/>
            </svg>
            <?php else: ?>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <line x1="8" y1="21" x2="16" y2="21"/>
                <line x1="12" y1="17" x2="12" y2="21"/>
            </svg>
            <?php endif; ?>
        </div>
        <div class="notif-content">
            <p class="notif-title"><?= esc($notif['title']) ?></p>
            <p class="notif-desc"><?= esc($notif['message']) ?></p>
        </div>
        <div class="notif-meta">
            <span class="notif-time"><?= $timeLabel ?></span>
            <?php if (!$notif['is_read']): ?>
                <span class="notif-dot-blue"></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <?php else: ?>
    <div style="text-align:center;padding:40px 0;color:#94A3B8">
        <p style="font-size:14px">Tidak ada notifikasi.</p>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>