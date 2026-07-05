<?= $this->extend('staff/layout') ?>
<?= $this->section('content') ?>

<!-- Welcome Banner -->
<div style="background:linear-gradient(135deg,#06B6D4,#0D9488);border-radius:16px;padding:24px 28px;margin-bottom:24px;color:white;display:flex;justify-content:space-between;align-items:center">
    <div>
        <p style="font-size:12px;opacity:.8;margin-bottom:4px">SELAMAT DATANG</p>
        <h2 style="font-size:22px;font-weight:700">Halo, <?= esc(session()->get('staff')['name']) ?> 👋</h2>
        <p style="font-size:13px;opacity:.85;margin-top:4px">Ada <?= $in_progress ?> pesanan sedang diproses hari ini.</p>
    </div>
    <a href="<?= site_url('staff/processing') ?>"
       style="background:rgba(255,255,255,.2);color:white;padding:10px 18px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;border:1px solid rgba(255,255,255,.3)">
        Buka Queue →
    </a>
</div>

<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF9FB;color:#06B6D4">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
        </div>
        <div class="stat-value"><?= $today_orders ?></div>
        <div class="stat-label">Pesanan Hari Ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#EDE9FE;color:#7C3AED">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
        </div>
        <div class="stat-value"><?= $in_progress ?></div>
        <div class="stat-label">Sedang Diproses</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#D1FAE5;color:#059669">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="stat-value"><?= $completed ?></div>
        <div class="stat-label">Selesai Hari Ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF3C7;color:#D97706">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
        </div>
        <div class="stat-value">Rp<?= number_format($revenue, 0, ',', '.') ?></div>
        <div class="stat-label">Revenue Hari Ini</div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header">
        <span class="card-title">Pesanan Terbaru</span>
        <a href="<?= site_url('staff/orders') ?>" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ORDER</th>
                <th>CUSTOMER</th>
                <th>LAYANAN</th>
                <th>BERAT</th>
                <th>TOTAL</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_orders as $order): ?>
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
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>