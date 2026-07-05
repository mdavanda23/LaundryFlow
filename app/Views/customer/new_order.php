<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="form-page">
    <p class="step-label">LANGKAH 1 DARI 1</p>
    <h1 class="page-title">Buat Pesanan Baru</h1>
    <p class="page-sub">Pilih layanan, masukkan berat dan alamat penjemputan.</p>

    <?php if (session()->getFlashdata('errors')): ?>
    <div style="background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px">
        <?php foreach(session()->getFlashdata('errors') as $e): ?>
            <div>• <?= esc($e) ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form action="<?= site_url('customer/new-order') ?>" method="POST" id="order-form">
        <?= csrf_field() ?>

        <!-- Pilih Layanan -->
        <div class="form-section">
            <label class="form-label">Pilih Layanan</label>
            <div class="service-grid">
                <?php foreach ($services as $i => $service): ?>
                <label class="service-card <?= $i === 0 ? 'selected' : '' ?>">
                    <input type="radio" name="service_id"
                           value="<?= esc($service['id']) ?>"
                           <?= $i === 0 ? 'checked' : '' ?>>
                    <span class="service-icon"><?= esc($service['icon']) ?></span>
                    <span class="service-name"><?= esc($service['name']) ?></span>
                    <span class="service-desc"><?= esc($service['description']) ?></span>
                    <span class="service-price">
                        Rp<?= number_format($service['price_per_kg'], 0, ',', '.') ?>/kg
                    </span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Berat -->
        <div class="form-section">
            <label class="form-label" for="weight">Estimasi Berat (kg)</label>
            <input type="number" id="weight" name="weight" class="form-input"
                   placeholder="Contoh: 4.5" step="0.1" min="0.5"
                   value="<?= old('weight') ?>" required
                   style="padding:12px 14px">
        </div>

        <!-- Estimasi Harga -->
        <div class="form-section" id="price-preview" style="display:none">
            <div style="background:#EFF9FB;border-radius:10px;padding:12px 14px;border:1px solid #A5F3FC">
                <p style="font-size:12px;color:#64748B;margin-bottom:2px">Estimasi Total</p>
                <p id="price-result" style="font-size:18px;font-weight:700;color:#06B6D4">Rp 0</p>
            </div>
        </div>

        <!-- Alamat Penjemputan -->
        <div class="form-section">
            <label class="form-label" for="address">Alamat Penjemputan</label>
            <div class="input-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5"/>
                </svg>
                <input type="text" id="address" name="address" class="form-input has-icon"
                       placeholder="Masukkan alamat lengkap"
                       value="<?= old('address', $customer_address ?? '') ?>" required>
            </div>
        </div>

        <!-- Catatan Khusus -->
        <div class="form-section">
            <label class="form-label" for="notes">Catatan Khusus</label>
            <textarea id="notes" name="notes" class="form-textarea" rows="3"
                      placeholder="Contoh: hati-hati bahan silk"><?= old('notes') ?></textarea>
        </div>

        <button type="submit" class="btn-primary">Buat Pesanan →</button>
    </form>
</div>

<script>
// Data harga dari PHP ke JS
const prices = {
    <?php foreach ($services as $s): ?>
    '<?= $s['id'] ?>': <?= $s['price_per_kg'] ?>,
    <?php endforeach; ?>
};

function hitungHarga() {
    const serviceId = document.querySelector('input[name=service_id]:checked')?.value;
    const weight    = parseFloat(document.getElementById('weight').value) || 0;
    const price     = prices[serviceId] || 0;
    const total     = price * weight;

    if (weight > 0 && serviceId) {
        document.getElementById('price-preview').style.display = 'block';
        document.getElementById('price-result').textContent =
            'Rp ' + total.toLocaleString('id-ID');
    } else {
        document.getElementById('price-preview').style.display = 'none';
    }
}

// Highlight service card + hitung harga
document.querySelectorAll('.service-card input[type=radio]').forEach(radio => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
        this.closest('.service-card').classList.add('selected');
        hitungHarga();
    });
});

document.getElementById('weight').addEventListener('input', hitungHarga);
</script>

<?= $this->endSection() ?>