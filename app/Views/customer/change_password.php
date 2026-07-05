<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="page-header-simple">
    <a href="<?= site_url('customer/profile') ?>" style="color:#06B6D4;font-size:13px;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:10px">
        ‹ Kembali
    </a>
    <h1 class="page-title">Ganti Password</h1>
    <p class="page-sub">Pastikan password baru minimal 8 karakter.</p>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div style="background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div style="background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px">
        <?php foreach(session()->getFlashdata('errors') as $e): ?>
            <div>• <?= esc($e) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('customer/profile/change-password') ?>" method="POST">
    <?= csrf_field() ?>

    <div class="form-section">
        <label class="form-label">Password Saat Ini</label>
        <input type="password" name="current_password" class="form-input"
               placeholder="Masukkan password lama" style="padding:12px 14px" required>
    </div>

    <div class="form-section">
        <label class="form-label">Password Baru</label>
        <input type="password" name="new_password" class="form-input"
               placeholder="Minimal 8 karakter" style="padding:12px 14px" required>
    </div>

    <div class="form-section">
        <label class="form-label">Konfirmasi Password Baru</label>
        <input type="password" name="confirm_password" class="form-input"
               placeholder="Ulangi password baru" style="padding:12px 14px" required>
    </div>

    <button type="submit" class="btn-primary">Update Password</button>
</form>

<?= $this->endSection() ?>