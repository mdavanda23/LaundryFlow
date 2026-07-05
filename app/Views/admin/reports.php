<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#D1FAE5;color:#059669">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
        </div>
        <div class="stat-value">Rp<?= number_format($total_revenue,0,',','.') ?></div>
        <div class="stat-label">Total Revenue</div>
        <div style="font-size:11px;color:#10B981;margin-top:4px">+18.2%</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#DBEAFE;color:#2563EB">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
        </div>
        <div class="stat-value">Rp<?= number_format($avg_order,0,',','.') ?></div>
        <div class="stat-label">Rata-rata Order</div>
        <div style="font-size:11px;color:#10B981;margin-top:4px">+4.1%</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#D1FAE5;color:#059669">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="stat-value"><?= number_format($completed_orders) ?></div>
        <div class="stat-label">Order Selesai</div>
        <div style="font-size:11px;color:#10B981;margin-top:4px">+12%</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEE2E2;color:#DC2626">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        <div class="stat-value"><?= $cancel_rate ?>%</div>
        <div class="stat-label">Cancellation Rate</div>
        <div style="font-size:11px;color:#EF4444;margin-top:4px">-0.3%</div>
    </div>
</div>

<div class="grid-2">
    <!-- Weekly Orders -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Order Mingguan</div>
                <div class="card-sub">7 hari terakhir</div>
            </div>
        </div>
        <?php $maxCount = max(array_column($weekly_orders,'count') ?: [1]); ?>
        <div style="display:flex;align-items:flex-end;gap:8px;height:140px;padding-top:10px">
            <?php foreach ($weekly_orders as $w): ?>
            <?php $h = $maxCount > 0 ? max(8, round(($w['count']/$maxCount)*120)) : 8; ?>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px">
                <span style="font-size:11px;font-weight:600;color:#06B6D4"><?= $w['count'] ?></span>
                <div style="width:100%;height:<?= $h ?>px;background:linear-gradient(180deg,#06B6D4,#0D9488);border-radius:6px 6px 0 0"></div>
                <span style="font-size:10px;color:#94A3B8"><?= $w['day'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Revenue by Service -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Revenue per Layanan</div>
                <div class="card-sub">Berdasarkan total revenue</div>
            </div>
        </div>
        <?php
        $totalRev   = array_sum(array_column($revenue_by_service,'total')) ?: 1;
        $pieColors  = ['#06B6D4','#10B981','#F59E0B','#EF4444'];
        foreach ($revenue_by_service as $i => $r):
            $pct = round(($r['total']/$totalRev)*100);
        ?>
        <div style="margin-bottom:14px">
            <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
                <div style="display:flex;align-items:center;gap:8px">
                    <span style="width:10px;height:10px;border-radius:50%;background:<?= $pieColors[$i%4] ?>;display:inline-block"></span>
                    <span style="font-weight:500"><?= esc($r['name']) ?></span>
                </div>
                <div style="text-align:right">
                    <span style="font-weight:600">Rp<?= number_format($r['total'],0,',','.') ?></span>
                    <span style="color:#94A3B8;font-size:11px;margin-left:6px"><?= $pct ?>%</span>
                </div>
            </div>
            <div class="progress-bar-wrap">
                <div class="progress-bar-fill" style="width:<?= $pct ?>%;background:<?= $pieColors[$i%4] ?>"></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>