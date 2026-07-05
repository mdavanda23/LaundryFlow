<?= $this->extend('staff/layout') ?>
<?= $this->section('content') ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

    <!-- Pesanan Baru / Pending -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">🔔 Pesanan Perlu Diproses</span>
            <span class="badge badge-pending"><?= count($new_orders) ?> pesanan</span>
        </div>
        <?php if (!empty($new_orders)): ?>
            <?php foreach ($new_orders as $o): ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #F1F5F9">
                <div>
                    <p style="font-weight:600;font-size:13px;color:#06B6D4"><?= esc($o['invoice']) ?></p>
                    <p style="font-size:12px;color:#64748B"><?= esc($o['customer_name']) ?> · <?= esc($o['service_name']) ?></p>
                    <p style="font-size:11px;color:#94A3B8"><?= date('d M H:i', strtotime($o['created_at'])) ?></p>
                </div>
                <form action="<?= site_url('staff/orders/update-status') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                    <input type="hidden" name="status" value="Received">
                    <button type="submit" class="btn btn-primary btn-sm">Terima</button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;color:#94A3B8;padding:20px 0;font-size:13px">Tidak ada pesanan baru.</p>
        <?php endif; ?>
    </div>

    <!-- Pesanan Siap Diambil -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">✅ Siap Diambil Customer</span>
            <span class="badge badge-ready"><?= count($ready_orders) ?> pesanan</span>
        </div>
        <?php if (!empty($ready_orders)): ?>
            <?php foreach ($ready_orders as $o): ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #F1F5F9">
                <div>
                    <p style="font-weight:600;font-size:13px;color:#059669"><?= esc($o['invoice']) ?></p>
                    <p style="font-size:12px;color:#64748B"><?= esc($o['customer_name']) ?> · <?= esc($o['service_name']) ?></p>
                    <p style="font-size:11px;color:#94A3B8"><?= esc($o['weight']) ?> kg · Rp<?= number_format($o['total'],0,',','.') ?></p>
                </div>
                <form action="<?= site_url('staff/orders/update-status') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                    <input type="hidden" name="status" value="Completed">
                    <button type="submit" class="btn btn-primary btn-sm">Selesai</button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;color:#94A3B8;padding:20px 0;font-size:13px">Tidak ada pesanan siap diambil.</p>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>