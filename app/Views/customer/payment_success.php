<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="form-page">
    <div style="text-align:center;padding:8px 0 4px">

        <?php if ($order['payment_method'] === 'Cash'): ?>
            <!-- ICON: Menunggu -->
            <div style="width:72px;height:72px;border-radius:50%;background:#FEF3C7;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <h1 class="page-title" style="margin-bottom:4px">Pesanan Dikonfirmasi</h1>
            <p class="page-sub">Terima kasih! Pesanan kamu sudah tercatat.</p>
        <?php else: ?>
            <!-- ICON: Sukses -->
            <div style="width:72px;height:72px;border-radius:50%;background:#D1FAE5;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.5">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
            </div>
            <h1 class="page-title" style="margin-bottom:4px">Pembayaran Berhasil</h1>
            <p class="page-sub">Terima kasih! Pembayaran kamu sudah kami terima.</p>
        <?php endif; ?>

    </div>

    <!-- Ringkasan Order -->
    <div class="form-section">
        <label class="form-label">Detail Pesanan</label>
        <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:16px">

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                <div style="display:flex;align-items:center;gap:8px">
                    <span style="font-size:20px"><?= esc($order['service_icon']) ?></span>
                    <div>
                        <p style="font-weight:600;font-size:14px;margin:0"><?= esc($order['service_name']) ?></p>
                        <p style="font-size:12px;color:#64748B;margin:0">Invoice: <?= esc($order['invoice']) ?></p>
                    </div>
                </div>
                <span style="font-size:13px;font-weight:600;color:#06B6D4"><?= esc($order['weight']) ?> kg</span>
            </div>

            <div style="border-top:1px dashed #CBD5E1;padding-top:10px;font-size:13px">
                <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                    <span style="color:#64748B">Metode Pembayaran</span>
                    <span style="font-weight:600">
                        <?php
                        $methodIcon = [
                            'QRIS' => '📱', 'Transfer' => '🏦', 'Cash' => '💵',
                        ];
                        $methodLabel = [
                            'QRIS' => 'QRIS', 'Transfer' => 'Transfer BCA', 'Cash' => 'Cash (saat penjemputan)',
                        ];
                        echo ($methodIcon[$order['payment_method']] ?? '') . ' ' . esc($methodLabel[$order['payment_method']] ?? $order['payment_method']);
                        ?>
                    </span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                    <span style="color:#64748B">Status</span>
                    <?php if ($order['payment_method'] === 'Cash'): ?>
                        <span style="font-weight:600;color:#D97706">Menunggu Penjemputan</span>
                    <?php else: ?>
                        <span style="font-weight:600;color:#16A34A">Lunas</span>
                    <?php endif; ?>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:8px;padding-top:8px;border-top:1px solid #E2E8F0">
                    <span style="font-weight:700">Total</span>
                    <span style="font-weight:700;color:#06B6D4;font-size:16px">
                        Rp<?= number_format($order['total'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Info tambahan sesuai metode -->
    <div class="form-section">
        <?php if ($order['payment_method'] === 'Cash'): ?>
            <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:10px;padding:14px 16px;display:flex;gap:10px;align-items:flex-start">
                <span style="font-size:18px">🚚</span>
                <p style="font-size:13px;color:#92400E;margin:0">
                    Petugas laundry akan menjemput cucian kamu dan menagih pembayaran tunai langsung di tempat.
                </p>
            </div>
        <?php else: ?>
            <div style="background:#EFF9FB;border:1px solid #A5F3FC;border-radius:10px;padding:14px 16px;display:flex;gap:10px;align-items:flex-start">
                <span style="font-size:18px">📦</span>
                <p style="font-size:13px;color:#0E7490;margin:0">
                    Pesanan kamu akan segera diproses. Kamu bisa memantau status laundry di halaman "Lacak Pesanan".
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:10px;margin-top:8px">
        <a href="<?= site_url('customer/track') ?>" class="btn-primary" style="flex:1;text-align:center;text-decoration:none">
            Lacak Pesanan →
        </a>
        <a href="<?= site_url('customer') ?>" style="flex:1;text-align:center;padding:12px 14px;border:1px solid #E2E8F0;border-radius:10px;color:#334155;font-weight:600;font-size:14px;text-decoration:none">
            Kembali ke Beranda
        </a>
    </div>

</div>

<?= $this->endSection() ?>