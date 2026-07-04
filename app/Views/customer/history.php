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
        <input
            type="text"
            id="search-input"
            class="search-input"
            placeholder="Cari berdasarkan nomor invoice..."
        >
    </div>

    <button class="filter-btn" title="Filter">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
        </svg>
    </button>
</div>

<!-- Daftar Riwayat -->
<div class="history-list" id="history-list">

    <?php foreach ($orders as $order): ?>

        <?php
            $status = strtolower($order['status']);

            switch ($status) {
                case 'processing':
                    $statusText = 'Sedang Diproses';
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

        <div class="history-item">
            <div class="history-info">
                <p class="order-num">
                    <?= esc($order['inv']) ?>
                </p>

                <p class="order-sub">
                    <?= esc($order['type']) ?> • <?= esc($order['date']) ?>
                </p>

                <span class="badge <?= esc($statusClass) ?>">
                    ● <?= esc($statusText) ?>
                </span>
            </div>

            <div class="history-right">
                <p class="history-total">
                    <?= esc($order['total']) ?>
                </p>

                <a href="#" class="view-invoice">
                    Lihat Detail →
                </a>
            </div>
        </div>

    <?php endforeach; ?>

</div>

<script>
document.getElementById('search-input').addEventListener('input', function () {

    const keyword = this.value.toLowerCase();

    document.querySelectorAll('.history-item').forEach(item => {

        item.style.display =
            item.textContent.toLowerCase().includes(keyword)
                ? ''
                : 'none';

    });

});
</script>

<?= $this->endSection() ?>