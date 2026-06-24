<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="page-header-simple">
    <h1 class="page-title">Notifications</h1>
    <p class="page-sub"><?= esc($unread_count) ?> unread updates</p>
</div>

<div class="notif-list">
    <?php
    $icon_map = [
        'wash'    => ['bg' => '#06B6D4', 'svg' => '<circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2" stroke="white" stroke-width="2"/><line x1="9" y1="9" x2="9.01" y2="9" stroke="white" stroke-width="2"/><line x1="15" y1="9" x2="15.01" y2="9" stroke="white" stroke-width="2"/>'],
        'ready'   => ['bg' => '#10B981', 'svg' => '<circle cx="12" cy="12" r="10"/><polyline points="20 6 9 17 4 12" stroke="white" stroke-width="2"/>'],
        'payment' => ['bg' => '#F59E0B', 'svg' => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>'],
        'promo'   => ['bg' => '#EC4899', 'svg' => '<polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>'],
        'order'   => ['bg' => '#06B6D4', 'svg' => '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>'],
    ];
    ?>

    <?php foreach ($notifications as $notif): ?>
    <?php $ic = $icon_map[$notif['icon']] ?? $icon_map['order']; ?>
    <div class="notif-item <?= $notif['unread'] ? 'unread' : '' ?>">
        <div class="notif-icon-wrap" style="background: <?= $ic['bg'] ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <?= $ic['svg'] ?>
            </svg>
        </div>
        <div class="notif-content">
            <p class="notif-title"><?= esc($notif['title']) ?></p>
            <p class="notif-desc"><?= esc($notif['desc']) ?></p>
        </div>
        <div class="notif-meta">
            <span class="notif-time"><?= esc($notif['time']) ?></span>
            <?php if ($notif['unread']): ?>
                <span class="notif-dot-blue"></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
