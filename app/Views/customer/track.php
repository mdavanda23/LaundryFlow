<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="page-header-simple">
    <h1 class="page-title">Track laundry</h1>
    <p class="page-sub">Order <?= esc($order['id']) ?> · Live updates</p>
</div>

<!-- Progress Card -->
<div class="current-order-card">
    <div class="order-card-top">
        <span class="label-small"><?= esc($order['type']) ?> · <?= esc($order['weight']) ?></span>
        <span class="badge-live">● Live</span>
    </div>
    <h2 class="progress-percent"><?= esc($order['progress']) ?>%</h2>
    <div class="progress-bar" style="margin-top:8px">
        <div class="progress-fill" style="width: <?= esc($order['progress']) ?>%"></div>
    </div>
    <p class="finish-time" style="margin-top:8px">Estimated finish · <?= esc($order['finish']) ?></p>
</div>

<!-- Steps Timeline -->
<div class="timeline">
    <?php foreach ($steps as $step): ?>
    <div class="timeline-item <?= esc($step['status']) ?>">
        <div class="timeline-dot">
            <?php if ($step['status'] === 'done'): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            <?php elseif ($step['status'] === 'active'): ?>
                <div class="dot-spin"></div>
            <?php endif; ?>
        </div>
        <div class="timeline-content">
            <div class="timeline-row">
                <span class="timeline-label"><?= esc($step['label']) ?></span>
                <span class="timeline-time"><?= esc($step['time']) ?: '—' ?></span>
            </div>
            <?php if ($step['sub']): ?>
                <p class="timeline-sub"><?= esc($step['sub']) ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
