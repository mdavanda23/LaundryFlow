<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Stats -->
<div class="stat-grid">
    <?php
    $stats = [
        ['label'=>'Revenue','value'=>'Rp'.number_format($total_revenue,0,',','.'),'icon'=>'<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>','bg'=>'#D1FAE5','color'=>'#059669','badge'=>'+18.2%'],
        ['label'=>'Total Orders','value'=>number_format($total_orders),'icon'=>'<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/>','bg'=>'#DBEAFE','color'=>'#2563EB','badge'=>'+12.4%'],
        ['label'=>'Customers','value'=>number_format($total_customers),'icon'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>','bg'=>'#EDE9FE','color'=>'#7C3AED','badge'=>'+8.1%'],
        ['label'=>'Active Staff','value'=>$active_staff,'icon'=>'<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>','bg'=>'#FEF3C7','color'=>'#D97706','badge'=>'+2'],
    ];
    foreach ($stats as $s):
    ?>
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background:<?= $s['bg'] ?>;color:<?= $s['color'] ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?= $s['icon'] ?></svg>
            </div>
            <span class="stat-badge-up"><?= $s['badge'] ?></span>
        </div>
        <div class="stat-value"><?= $s['value'] ?></div>
        <div class="stat-label"><?= $s['label'] ?></div>
    </div>
    <?php endforeach; ?>
</div>

<div class="grid-2">
    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Transaksi Terbaru</div>
                <div class="card-sub">24 jam terakhir</div>
            </div>
            <a href="<?= site_url('admin/reports') ?>" class="btn btn-outline btn-sm">Export →</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ORDER</th><th>CUSTOMER</th><th>METODE</th><th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td style="font-weight:600;color:#06B6D4"><?= esc($t['invoice']) ?></td>
                    <td>
                        <span class="avatar" style="background:linear-gradient(135deg,#06B6D4,#0D9488)">
                            <?= strtoupper(substr($t['customer_name'],0,1)) ?>
                        </span>
                        <?= esc($t['customer_name']) ?>
                    </td>
                    <td style="color:#64748B"><?= esc($t['method']) ?></td>
                    <td style="font-weight:600;color:#059669">Rp<?= number_format($t['amount'],0,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Popular Services -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Layanan Populer</div>
                <div class="card-sub">Bulan ini</div>
            </div>
        </div>
        <?php
        $total = array_sum(array_column($popular_services,'total')) ?: 1;
        $colors = ['#06B6D4','#10B981','#F59E0B','#EF4444','#8B5CF6'];
        foreach ($popular_services as $i => $s):
            $pct = round(($s['total']/$total)*100);
        ?>
        <div style="margin-bottom:14px">
            <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
                <span style="font-weight:500"><?= esc($s['name']) ?></span>
                <span style="color:#64748B"><?= $pct ?>%</span>
            </div>
            <div class="progress-bar-wrap">
                <div class="progress-bar-fill" style="width:<?= $pct ?>%;background:<?= $colors[$i%count($colors)] ?>"></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>