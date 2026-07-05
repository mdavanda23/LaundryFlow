<?= $this->extend('staff/layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Data Pelanggan</span>
        <form action="" method="GET" style="display:flex;gap:10px">
            <div class="search-wrap" style="width:260px">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" class="search-input"
                       placeholder="Cari nama / email / telepon..."
                       value="<?= esc($search ?? '') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>PELANGGAN</th><th>EMAIL</th><th>TELEPON</th>
                <th>TOTAL ORDER</th><th>TOTAL SPENT</th><th>BERGABUNG</th><th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $c): ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <span class="customer-avatar" style="margin-right:0">
                            <?= strtoupper(substr($c['name'],0,2)) ?>
                        </span>
                        <span style="font-weight:600"><?= esc($c['name']) ?></span>
                    </div>
                </td>
                <td style="color:#64748B"><?= esc($c['email']) ?></td>
                <td style="color:#64748B"><?= esc($c['phone'] ?? '-') ?></td>
                <td style="font-weight:600;text-align:center"><?= $c['total_orders'] ?></td>
                <td style="font-weight:600;color:#06B6D4">Rp<?= number_format($c['total_spent'],0,',','.') ?></td>
                <td style="color:#64748B"><?= date('d M Y', strtotime($c['joined_at'])) ?></td>
                <td>
                    <span class="badge" style="background:<?= $c['status']==='active'?'#D1FAE5':'#FEE2E2' ?>;color:<?= $c['status']==='active'?'#065F46':'#991B1B' ?>">
                        <?= $c['status'] === 'active' ? 'Aktif' : 'Nonaktif' ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="7" style="text-align:center;color:#94A3B8;padding:32px">Tidak ada pelanggan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>