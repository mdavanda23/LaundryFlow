<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="page-header-simple">
    <a href="<?= site_url('customer/profile') ?>" style="color:#06B6D4;font-size:13px;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:10px">
        ‹ Kembali
    </a>
    <h1 class="page-title">Edit Profile</h1>
    <p class="page-sub">Perbarui informasi akunmu.</p>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div style="background:#FEE2E2;color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px">
        <?php foreach(session()->getFlashdata('errors') as $e): ?>
            <div>• <?= esc($e) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('customer/profile/edit') ?>" method="POST">
    <?= csrf_field() ?>

    <div class="form-section">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-input"
               value="<?= esc(old('name', $customer['name'])) ?>"
               style="padding:12px 14px" required>
    </div>

    <div class="form-section">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-input"
               value="<?= esc(old('email', $customer['email'])) ?>"
               style="padding:12px 14px" required>
    </div>

    <div class="form-section">
        <label class="form-label">No. Telepon</label>
        <input type="text" name="phone" class="form-input"
               value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>"
               style="padding:12px 14px">
    </div>

    <div class="form-section">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-textarea" rows="3"><?= esc(old('address', $customer['address'] ?? '')) ?></textarea>
    </div>

    <div class="form-section">
        <label class="form-label">Jenis Kelamin</label>
        <select name="gender" style="width:100%;padding:12px 14px;border:1px solid #E2E8F0;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;outline:none;background:#fff">
            <option value="">-- Pilih --</option>
            <option value="Male"   <?= old('gender', $customer['gender'] ?? '') === 'Male'   ? 'selected' : '' ?>>Laki-laki</option>
            <option value="Female" <?= old('gender', $customer['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Perempuan</option>
        </select>
    </div>

    <div class="form-section">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="birth_date" class="form-input"
               value="<?= esc(old('birth_date', $customer['birth_date'] ?? '')) ?>"
               style="padding:12px 14px">
    </div>

    <button type="submit" class="btn-primary">Simpan Perubahan</button>
</form>

<?= $this->endSection() ?>