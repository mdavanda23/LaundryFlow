<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<?php if (!$order): ?>
<div style="text-align:center;padding:60px 20px;color:#94A3B8">
    <p style="font-size:15px;margin-bottom:8px">Tidak ada pesanan aktif untuk dilacak.</p>
    <a href="<?= site_url('customer/new-order') ?>"
       style="color:#06B6D4;font-weight:600;text-decoration:none">+ Buat Pesanan Baru</a>
</div>
<?php else: ?>

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
$pct = $progressMap[$order['status']] ?? 0;

// Semua tahapan
$allSteps = ['Received', 'Washing', 'Drying', 'Ironing', 'Ready', 'Completed'];

// Ambil log status dari DB (sudah dipass dari controller)
$doneStatuses = array_column($logs ?? [], 'status');
?>

<div class="page-header-simple">
    <h1 class="page-title">Lacak Pesanan</h1>
    <p class="page-sub"><?= esc($order['invoice']) ?> · Update Langsung</p>
</div>

<!-- Progress Card -->
<div class="current-order-card">
    <div class="order-card-top">
        <span class="label-small">
            <?= esc($order['service_name']) ?> · <?= esc($order['weight']) ?> kg
        </span>
        <span class="badge-live">● Live</span>
    </div>
    <h2 class="progress-percent"><?= $pct ?>%</h2>
    <div class="progress-bar" style="margin-top:8px">
        <div class="progress-fill" style="width:<?= $pct ?>%"></div>
    </div>
    <p class="finish-time" style="margin-top:10px">
        Estimasi Selesai ·
        <?= $order['finish_date']
            ? date('d M Y · H:i', strtotime($order['finish_date']))
            : 'Belum ditentukan' ?>
    </p>
</div>

<!-- Timeline -->
<div class="timeline">
    <?php foreach ($allSteps as $step): ?>
    <?php
    $isDone   = in_array($step, $doneStatuses);
    $isActive = ($order['status'] === $step);

    // Cari waktu dari log
    $logTime = '';
    foreach (($logs ?? []) as $log) {
        if ($log['status'] === $step) {
            $logTime = date('H:i', strtotime($log['created_at']));
            break;
        }
    }

    // Label Indonesia
    $labelMap = [
        'Received'  => 'Pesanan Diterima',
        'Washing'   => 'Sedang Dicuci',
        'Drying'    => 'Sedang Dikeringkan',
        'Ironing'   => 'Sedang Disetrika',
        'Ready'     => 'Siap Diambil',
        'Completed' => 'Selesai',
    ];
    $label = $labelMap[$step] ?? $step;

    if ($isDone && !$isActive) $itemClass = 'done';
    elseif ($isActive)         $itemClass = 'active';
    else                       $itemClass = 'pending';
    ?>
    <div class="timeline-item <?= $itemClass ?>">
        <div class="timeline-dot">
            <?php if ($isDone && !$isActive): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            <?php elseif ($isActive): ?>
                <div class="dot-spin"></div>
            <?php endif; ?>
        </div>
        <div class="timeline-content">
            <div class="timeline-row">
                <span class="timeline-label"><?= $label ?></span>
                <span class="timeline-time"><?= $logTime ?: '—' ?></span>
            </div>
            <?php if ($isActive): ?>
                <p class="timeline-sub">Sedang berlangsung...</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<?= $this->endSection() ?>