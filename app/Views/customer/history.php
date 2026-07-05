<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="page-header-simple">
    <h1 class="page-title">Riwayat Pesanan</h1>
    <p class="page-sub">Lihat seluruh riwayat transaksi laundry Anda</p>
</div>

<!-- Pencarian & Filter -->
<div class="search-row">
    <div class="search-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="search-input" class="search-input"
               placeholder="Cari berdasarkan nomor invoice...">
    </div>
    <button class="filter-btn" title="Filter">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
        </svg>
    </button>
</div>

<!-- Daftar Riwayat -->
<div class="history-list" id="history-list">

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
        <?php
        $statusMap = [
            'pending'   => ['label' => 'Menunggu',       'class' => 'processing'],
            'received'  => ['label' => 'Diterima',       'class' => 'processing'],
            'washing'   => ['label' => 'Dicuci',         'class' => 'processing'],
            'drying'    => ['label' => 'Dikeringkan',    'class' => 'processing'],
            'ironing'   => ['label' => 'Disetrika',      'class' => 'processing'],
            'ready'     => ['label' => 'Siap Diambil',   'class' => 'ready'],
            'completed' => ['label' => 'Selesai',        'class' => 'completed'],
            'cancelled' => ['label' => 'Dibatalkan',     'class' => 'cancelled'],
        ];
        $key         = strtolower($order['status']);
        $statusLabel = $statusMap[$key]['label'] ?? $order['status'];
        $statusClass = $statusMap[$key]['class'] ?? 'processing';
        ?>
        <div class="history-item">
            <div class="history-info">
                <p class="order-num"><?= esc($order['invoice']) ?></p>
                <p class="order-sub">
                    <?= esc($order['service_name']) ?> · <?= date('d M Y', strtotime($order['created_at'])) ?>
                </p>
                <span class="badge <?= $statusClass ?>">
                    ● <?= $statusLabel ?>
                </span>
            </div>
            <div class="history-right">
                <p class="history-total">
                    Rp<?= number_format($order['total'], 0, ',', '.') ?>
                </p>
                <a href="<?= site_url('customer/track?invoice=' . $order['invoice']) ?>"
                   class="view-invoice">Lihat Detail →</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align:center;padding:40px 0;color:#94A3B8">
            <p style="font-size:14px">Belum ada riwayat pesanan.</p>
        </div>
    <?php endif; ?>

</div>

<script>
document.getElementById('search-input').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('.history-item').forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>