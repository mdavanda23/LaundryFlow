<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div style="max-width:640px">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Pengaturan Toko</div>
        </div>

        <form action="<?= site_url('admin/settings') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">Nama Toko</label>
                <input type="text" name="shop_name" class="form-input"
                       value="<?= esc($settings['shop_name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-input" rows="3"
                          style="resize:none"><?= esc($settings['address'] ?? '') ?></textarea>
            </div>

            <div class="grid-2" style="gap:12px">
                <div class="form-group">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="phone" class="form-input"
                           value="<?= esc($settings['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input"
                           value="<?= esc($settings['email'] ?? '') ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </form>
    </div>

    <!-- Info tambahan -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Informasi Sistem</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:12px">
            <?php foreach([
                ['label'=>'PHP Version',  'value'=>phpversion()],
                ['label'=>'CodeIgniter',  'value'=>\CodeIgniter\CodeIgniter::CI_VERSION],
                ['label'=>'Environment', 'value'=>ENVIRONMENT],
                ['label'=>'Timezone',    'value'=>date_default_timezone_get()],
            ] as $info): ?>
            <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #F1F5F9">
                <span style="font-size:13px;color:#64748B"><?= $info['label'] ?></span>
                <span style="font-size:13px;font-weight:600"><?= esc($info['value']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>