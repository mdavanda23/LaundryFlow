<?= $this->extend('staff/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Semua Pesanan</span>
        <form action="" method="GET" style="display:flex;gap:10px;align-items:center">
            <div class="search-wrap" style="width:260px">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" class="search-input"
                       placeholder="Cari invoice / customer..."
                       value="<?= esc($search ?? '') ?>">
            </div>
            <select name="status" class="form-input" style="width:130px;padding:9px 12px">
                <option value="">Semua Status</option>
                <?php foreach(['Pending','Received','Washing','Drying','Ironing','Ready','Completed','Cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= ($status??'')===$s?'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ORDER</th><th>CUSTOMER</th><th>LAYANAN</th>
                <th>BERAT</th><th>TOTAL</th><th>TANGGAL</th><th>STATUS</th><th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
            <?php $sc = 'badge-' . strtolower($order['status']); ?>
            <tr>
                <td style="font-weight:600;color:#06B6D4"><?= esc($order['invoice']) ?></td>
                <td>
                    <span class="customer-avatar"><?= strtoupper(substr($order['customer_name'],0,1)) ?></span>
                    <?= esc($order['customer_name']) ?>
                </td>
                <td><?= esc($order['service_name']) ?></td>
                <td><?= esc($order['weight']) ?> kg</td>
                <td style="font-weight:600">Rp<?= number_format($order['total'],0,',','.') ?></td>
                <td style="color:#64748B"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                <td><span class="badge <?= $sc ?>"><?= esc($order['status']) ?></span></td>
                <td>
                    <form action="<?= site_url('staff/orders/update-status') ?>" method="POST" style="display:flex;gap:6px">
                        <?= csrf_field() ?>
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="status" class="form-input" style="padding:4px 8px;font-size:11px;width:110px">
                            <?php foreach(['Pending','Received','Washing','Drying','Ironing','Ready','Completed','Cancelled'] as $s): ?>
                            <option value="<?= $s ?>" <?= $order['status']===$s?'selected':'' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
                <td>
                <div style="display:flex;gap:6px;align-items:center">
                    <form action="<?= site_url('staff/orders/update-status') ?>" method="POST" style="display:flex;gap:6px">
                        <?= csrf_field() ?>
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="status" class="form-input" style="padding:4px 8px;font-size:11px;width:110px">
                            <?php foreach(['Pending','Received','Washing','Drying','Ironing','Ready','Completed','Cancelled'] as $s): ?>
                            <option value="<?= $s ?>" <?= $order['status']===$s?'selected':'' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>

                    <form action="<?= site_url('staff/orders/delete/'.$order['id']) ?>" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus pesanan <?= esc($order['invoice']) ?>?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>
            </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="8" style="text-align:center;color:#94A3B8;padding:32px">Tidak ada pesanan ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>