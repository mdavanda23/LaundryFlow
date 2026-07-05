<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="form-page">
    <p class="step-label">PEMBAYARAN</p>
    <h1 class="page-title">Selesaikan Pembayaran</h1>
    <p class="page-sub">Order <?= esc($order['invoice']) ?> — pilih metode pembayaran kamu.</p>

    <?php if (session()->getFlashdata('errors')): ?>
    <div style="background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px">
        <?php foreach(session()->getFlashdata('errors') as $e): ?>
            <div>• <?= esc($e) ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Ringkasan Order -->
    <div class="form-section">
        <label class="form-label">Ringkasan Pesanan</label>
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
                    <span style="color:#64748B">Subtotal</span>
                    <span>Rp<?= number_format($order['subtotal'], 0, ',', '.') ?></span>
                </div>
                <?php if ($order['discount'] > 0): ?>
                <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                    <span style="color:#64748B">Diskon</span>
                    <span style="color:#16A34A">-Rp<?= number_format($order['discount'], 0, ',', '.') ?></span>
                </div>
                <?php endif; ?>
                <div style="display:flex;justify-content:space-between;margin-top:8px;padding-top:8px;border-top:1px solid #E2E8F0">
                    <span style="font-weight:700">Total</span>
                    <span style="font-weight:700;color:#06B6D4;font-size:16px">
                        Rp<?= number_format($order['total'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form action="<?= site_url('customer/payment/' . $order['id']) ?>" method="POST" id="payment-form">
        <?= csrf_field() ?>

        <!-- Pilih Metode Pembayaran -->
        <div class="form-section">
            <label class="form-label">Metode Pembayaran</label>
            <div class="service-grid">

                <label class="service-card selected">
                    <input type="radio" name="payment_method" value="QRIS" checked>
                    <span class="service-icon">📱</span>
                    <span class="service-name">QRIS</span>
                    <span class="service-desc">Bayar instan lewat e-wallet / m-banking</span>
                </label>

                <label class="service-card">
                    <input type="radio" name="payment_method" value="Transfer">
                    <span class="service-icon">🏦</span>
                    <span class="service-name">Transfer Bank</span>
                    <span class="service-desc">Transfer manual ke rekening toko</span>
                </label>

                <label class="service-card">
                    <input type="radio" name="payment_method" value="Cash">
                    <span class="service-icon">💵</span>
                    <span class="service-name">Cash</span>
                    <span class="service-desc">Bayar tunai saat laundry dijemput</span>
                </label>

            </div>
        </div>

        <!-- ============ PANEL QRIS ============ -->
        <div id="panel-qris" class="form-section payment-panel">
            <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:20px;text-align:center">
                <p style="font-size:13px;color:#64748B;margin-bottom:12px">Scan QR di bawah ini menggunakan aplikasi e-wallet / m-banking kamu</p>

                <!-- Dummy QR code (SVG, bukan QR asli) -->
                <svg width="180" height="180" viewBox="0 0 180 180" style="background:#fff;border:1px solid #E2E8F0;border-radius:8px;margin:0 auto;display:block">
                    <rect width="180" height="180" fill="#fff"/>
                    <!-- pola dummy ala QR -->
                    <g fill="#0F172A">
                        <rect x="10" y="10" width="40" height="40"/>
                        <rect x="20" y="20" width="20" height="20" fill="#fff"/>
                        <rect x="130" y="10" width="40" height="40"/>
                        <rect x="140" y="20" width="20" height="20" fill="#fff"/>
                        <rect x="10" y="130" width="40" height="40"/>
                        <rect x="20" y="140" width="20" height="20" fill="#fff"/>
                        <rect x="60" y="10" width="10" height="10"/>
                        <rect x="80" y="10" width="10" height="10"/>
                        <rect x="100" y="30" width="10" height="10"/>
                        <rect x="60" y="60" width="10" height="10"/>
                        <rect x="80" y="60" width="10" height="10"/>
                        <rect x="100" y="60" width="10" height="10"/>
                        <rect x="60" y="80" width="10" height="10"/>
                        <rect x="120" y="80" width="10" height="10"/>
                        <rect x="70" y="100" width="10" height="10"/>
                        <rect x="90" y="100" width="10" height="10"/>
                        <rect x="110" y="100" width="10" height="10"/>
                        <rect x="60" y="120" width="10" height="10"/>
                        <rect x="100" y="120" width="10" height="10"/>
                        <rect x="130" y="130" width="10" height="10"/>
                        <rect x="150" y="130" width="10" height="10"/>
                        <rect x="130" y="150" width="10" height="10"/>
                        <rect x="150" y="150" width="10" height="10"/>
                        <rect x="70" y="150" width="10" height="10"/>
                        <rect x="90" y="150" width="10" height="10"/>
                    </g>
                </svg>

                <p style="font-size:12px;color:#94A3B8;margin-top:10px">*QR dummy untuk keperluan tampilan/demo</p>

                <div style="margin-top:14px;background:#EFF9FB;border:1px solid #A5F3FC;border-radius:10px;padding:10px 14px">
                    <p style="font-size:12px;color:#64748B;margin:0">Total Pembayaran</p>
                    <p style="font-size:18px;font-weight:700;color:#06B6D4;margin:0">Rp<?= number_format($order['total'], 0, ',', '.') ?></p>
                </div>
            </div>
        </div>

        <!-- ============ PANEL TRANSFER BCA ============ -->
        <div id="panel-transfer" class="form-section payment-panel" style="display:none">
            <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:18px">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px">
                    <span style="font-size:22px">🏦</span>
                    <span style="font-weight:700;font-size:15px;color:#0F172A">Bank BCA</span>
                </div>

                <div style="background:#fff;border:1px dashed #CBD5E1;border-radius:8px;padding:12px 14px;margin-bottom:10px">
                    <p style="font-size:12px;color:#64748B;margin:0 0 2px">Nomor Rekening</p>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <p id="rek-number" style="font-size:17px;font-weight:700;color:#0F172A;letter-spacing:1px;margin:0">1234567890</p>
                        <button type="button" onclick="salinRekening()" style="border:1px solid #06B6D4;color:#06B6D4;background:#fff;border-radius:6px;padding:4px 10px;font-size:12px;cursor:pointer">
                            Salin
                        </button>
                    </div>
                </div>

                <div style="background:#fff;border:1px dashed #CBD5E1;border-radius:8px;padding:12px 14px;margin-bottom:10px">
                    <p style="font-size:12px;color:#64748B;margin:0 0 2px">Atas Nama</p>
                    <p style="font-size:14px;font-weight:600;color:#0F172A;margin:0">Laundry Kilat</p>
                </div>

                <div style="background:#EFF9FB;border:1px solid #A5F3FC;border-radius:8px;padding:12px 14px">
                    <p style="font-size:12px;color:#64748B;margin:0 0 2px">Nominal yang Ditransfer</p>
                    <p style="font-size:18px;font-weight:700;color:#06B6D4;margin:0">Rp<?= number_format($order['total'], 0, ',', '.') ?></p>
                </div>

                <p style="font-size:12px;color:#94A3B8;margin-top:10px">Transfer sesuai nominal di atas, lalu klik tombol di bawah untuk konfirmasi.</p>
            </div>
        </div>

        <!-- ============ PANEL CASH ============ -->
        <div id="panel-cash" class="form-section payment-panel" style="display:none">
            <div style="background:#EFF9FB;border:1px solid #A5F3FC;border-radius:10px;padding:16px;display:flex;gap:10px;align-items:flex-start">
                <span style="font-size:20px">💵</span>
                <div>
                    <p style="font-weight:600;font-size:14px;color:#0E7490;margin:0 0 4px">Bayar Tunai saat Penjemputan</p>
                    <p style="font-size:13px;color:#0E7490;margin:0">Kamu tidak perlu membayar sekarang. Petugas laundry akan menagih pembayaran tunai saat datang menjemput cucian kamu.</p>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary" id="submit-btn">Bayar Sekarang →</button>
    </form>
</div>

<script>
const panels = {
    QRIS:     document.getElementById('panel-qris'),
    Transfer: document.getElementById('panel-transfer'),
    Cash:     document.getElementById('panel-cash'),
};

const submitBtn = document.getElementById('submit-btn');

const btnText = {
    QRIS:     'Saya Sudah Bayar →',
    Transfer: 'Saya Sudah Transfer →',
    Cash:     'Konfirmasi Pesanan →',
};

function tampilkanPanel(method) {
    Object.values(panels).forEach(p => p.style.display = 'none');
    if (panels[method]) panels[method].style.display = 'block';
    submitBtn.textContent = btnText[method] || 'Bayar Sekarang →';
}

document.querySelectorAll('.service-card input[type=radio]').forEach(radio => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
        this.closest('.service-card').classList.add('selected');
        tampilkanPanel(this.value);
    });
});

function salinRekening() {
    const number = document.getElementById('rek-number').textContent;
    navigator.clipboard.writeText(number).then(() => {
        alert('Nomor rekening disalin: ' + number);
    });
}

// Tampilkan panel default (QRIS) saat halaman dimuat
tampilkanPanel('QRIS');
</script>

<?= $this->endSection() ?>