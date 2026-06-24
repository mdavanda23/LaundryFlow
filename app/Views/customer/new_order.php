<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="form-page">
    <p class="step-label">STEP 1 OF 1</p>
    <h1 class="page-title">Create new order</h1>
    <p class="page-sub">Pick a service, enter weight & address.</p>

    <?= form_open('customer/new-order', ['id' => 'order-form']) ?>
        <?= csrf_field() ?>

        <!-- Choose Service -->
        <div class="form-section">
            <label class="form-label">Choose service</label>
            <div class="service-grid">
                <?php foreach ($services as $service): ?>
                <label class="service-card <?= $service['key'] === 'wash_iron' ? 'selected' : '' ?>">
                    <input type="radio" name="service" value="<?= esc($service['key']) ?>"
                        <?= $service['key'] === 'wash_iron' ? 'checked' : '' ?>>
                    <span class="service-icon"><?= $service['icon'] ?></span>
                    <span class="service-name"><?= esc($service['label']) ?></span>
                    <span class="service-desc"><?= esc($service['desc']) ?></span>
                    <span class="service-price"><?= esc($service['price']) ?></span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Weight -->
        <div class="form-section">
            <label class="form-label" for="weight">Estimated weight (kg)</label>
            <input type="number" id="weight" name="weight" class="form-input"
                   placeholder="4,5" step="0.1" min="0.5" required>
        </div>

        <!-- Pickup Address -->
        <div class="form-section">
            <label class="form-label" for="address">Pickup address</label>
            <div class="input-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5"/>
                </svg>
                <input type="text" id="address" name="address" class="form-input has-icon"
                       placeholder="221B Baker Street, Apt 4" required>
            </div>
        </div>

        <!-- Special Notes -->
        <div class="form-section">
            <label class="form-label" for="notes">Special notes</label>
            <textarea id="notes" name="notes" class="form-textarea"
                      placeholder="e.g. handle silk shirts with care" rows="3"></textarea>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary">Continue</button>
    <?= form_close() ?>
</div>

<script>
// Service card selection highlight
document.querySelectorAll('.service-card input[type=radio]').forEach(radio => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
        this.closest('.service-card').classList.add('selected');
    });
});
</script>

<?= $this->endSection() ?>
