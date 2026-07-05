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
// Pemetaan progress: Diterima & Penjemputan jadi satu tahap awal (10%),
// lalu naik 20% tiap tahap sampai Selesai (100%)
$progressMap = [
    'Diterima'     => 10,
    'Dicuci'       => 30,
    'Dikeringkan'  => 50,
    'Disetrika'    => 70,
    'Siap Diambil' => 90,
    'Selesai'      => 100,
];

$currentStatus = (isset($order) && is_array($order) && isset($order['status'])) ? $order['status'] : '';
$pct = $progressMap[$currentStatus] ?? 0;

// Urutan tahap yang ditampilkan (Diterima & Penjemputan digabung jadi 1 kartu)
$allSteps = ['Diterima', 'Dicuci', 'Dikeringkan', 'Disetrika', 'Siap Diambil', 'Selesai'];

$doneStatuses = array_column($logs ?? [], 'status');

// Label tampilan tiap step
$labelMap = [
    'Diterima'     => 'Pesanan Diterima & Penjemputan Baju',
    'Dicuci'       => 'Sedang Dicuci',
    'Dikeringkan'  => 'Sedang Dikeringkan',
    'Disetrika'    => 'Sedang Disetrika',
    'Siap Diambil' => 'Siap Diambil',
    'Selesai'      => 'Selesai',
];

// Subtitle saat step lagi aktif
$activeSubMap = [
    'Diterima'     => 'Kurir akan menjemput baju kamu',
    'Dicuci'       => 'Sedang berlangsung...',
    'Dikeringkan'  => 'Sedang berlangsung...',
    'Disetrika'    => 'Sedang berlangsung...',
    'Siap Diambil' => 'Menunggu diambil / diantar',
    'Selesai'      => 'Pesanan selesai',
];

// Icon SVG per step
$iconMap = [
    'Diterima'     => '<path d="M3 17V7a2 2 0 0 1 2-2h9v9"/><path d="M14 9h4l3 4v4h-2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/>',
    'Dicuci'       => '<path d="M12 2s6 7 6 12a6 6 0 0 1-12 0c0-5 6-12 6-12z"/>',
    'Dikeringkan'  => '<path d="M2 12h13a3 3 0 1 0-3-3"/><path d="M2 17h17a3 3 0 1 1-3 3"/>',
    'Disetrika'    => '<path d="M6 2h9l4 4v5H6z"/><path d="M4 20h16"/><path d="M6 11v9"/>',
    'Siap Diambil' => '<path d="M12 3v4"/><path d="M5.5 5.5l2.8 2.8"/><path d="M18.5 5.5l-2.8 2.8"/><path d="M3 12h4"/><path d="M17 12h4"/><path d="M12 17c-3 0-4-2-4-2h8s-1 2-4 2z"/>',
    'Selesai'      => '<circle cx="12" cy="12" r="10"/><polyline points="8 12.5 10.5 15 16 9"/>',
];

// Urutan indeks status, untuk menentukan mana yang sudah "done" walau tidak ada di log
$statusOrder = array_flip($allSteps);
$currentIndex = $statusOrder[$currentStatus] ?? -1;
?>

<div style="padding:4px 4px 8px">
    <h1 style="font-size:24px;font-weight:800;color:#0F172A;margin:0 0 2px">Lacak Pesanan</h1>
    <p style="font-size:13px;color:#64748B;margin:0">
        <?= esc($order['invoice'] ?? '') ?> · Update Langsung
    </p>
</div>

<!-- Kartu Progress Gradient -->
<div style="background:linear-gradient(135deg,#06B6D4,#10B981);border-radius:20px;padding:20px;color:#fff;margin:14px 0 20px;box-shadow:0 8px 20px rgba(6,182,212,0.25)">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
        <span style="font-size:13px;opacity:0.95">
            <?= esc($order['service_name'] ?? '') ?> · <?= esc($order['weight'] ?? '0') ?> kg
        </span>
        <span style="background:rgba(255,255,255,0.25);padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600">
            ● Live
        </span>
    </div>

    <h2 style="font-size:38px;font-weight:800;margin:0"><?= $pct ?>%</h2>

    <div style="background:rgba(255,255,255,0.3);border-radius:20px;height:8px;margin-top:10px;overflow:hidden">
        <div style="background:#fff;height:100%;width:<?= $pct ?>%;border-radius:20px;transition:width .3s"></div>
    </div>

    <p style="font-size:13px;opacity:0.95;margin-top:12px">
        Estimasi Selesai ·
        <?= (!empty($order['finish_date']))
            ? date('d M Y · H:i', strtotime($order['finish_date']))
            : 'Belum ditentukan' ?>
    </p>
</div>

<!-- Timeline -->
<div style="position:relative;padding-left:0">
    <div style="position:absolute;left:27px;top:28px;bottom:28px;width:2px;background:#E2E8F0;z-index:0"></div>

    <?php foreach ($allSteps as $i => $step): ?>
    <?php
        $isDone   = $currentIndex > $i;      // tahap sebelumnya, otomatis dianggap selesai
        $isActive = ($currentStatus === $step);

        $logTime = '';
        foreach (($logs ?? []) as $log) {
            if (isset($log['status']) && $log['status'] === $step && !empty($log['created_at'])) {
                $logTime = date('H:i', strtotime($log['created_at']));
                break;
            }
        }

        $label   = $labelMap[$step] ?? $step;
        $iconSvg = $iconMap[$step] ?? '';

        $isHighlighted = $isDone || $isActive;
    ?>
    <div style="display:flex;gap:14px;align-items:flex-start;margin-bottom:14px;position:relative;z-index:1">
        <div style="flex-shrink:0;width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;
            <?= $isHighlighted
                ? 'background:linear-gradient(135deg,#06B6D4,#10B981);'
                : 'background:#F1F5F9;' ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="<?= $isHighlighted ? '#fff' : '#94A3B8' ?>"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <?= $iconSvg ?>
            </svg>
        </div>

        <div style="flex:1;background:#fff;border-radius:14px;padding:14px 16px;box-shadow:0 1px 3px rgba(15,23,42,0.06)">
            <div style="display:flex;justify-content:space-between;align-items:center">
                <span style="font-weight:700;font-size:14px;color:#0F172A"><?= esc($label) ?></span>
                <span style="font-size:12px;color:#94A3B8"><?= $logTime ?: '—' ?></span>
            </div>
            <?php if ($isActive): ?>
                <p style="font-size:12px;color:#06B6D4;font-weight:600;margin:4px 0 0">
                    <?= esc($activeSubMap[$step] ?? 'Sedang berlangsung...') ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<?= $this->endSection() ?>