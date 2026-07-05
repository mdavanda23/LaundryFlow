<?= $this->extend('staff/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 1.5fr;gap:20px">

    <!-- Profile Card -->
    <div>
        <div class="card" style="text-align:center;padding:28px">
            <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#06B6D4,#0D9488);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:26px;font-weight:700;color:white">
                <?= strtoupper(substr($user['name'],0,2)) ?>
            </div>
            <h2 style="font-size:18px;font-weight:700"><?= esc($user['name']) ?></h2>
            <p style="font-size:13px;color:#64748B;margin-top:4px">Staff LaundryFlow</p>

            <div style="display:flex;justify-content:space-around;margin-top:20px;padding-top:16px;border-top:1px solid #F1F5F9">
                <div>
                    <p style="font-size:20px;font-weight:700;color:#06B6D4"><?= $total_handled ?></p>
                    <p style="font-size:11px;color:#64748B">Diproses</p>
                </div>
                <div>
                    <p style="font-size:14px;font-weight:600"><?= esc($user['status'] === 'active' ? 'Aktif' : 'Nonaktif') ?></p>
                    <p style="font-size:11px;color:#64748B">Status</p>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="card">
            <p style="font-size:12px;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px">Informasi Akun</p>
            <div style="display:flex;flex-direction:column;gap:12px">
                <div>
                    <p style="font-size:10px;color:#94A3B8;font-weight:600">EMAIL</p>
                    <p style="font-size:13px;font-weight:500"><?= esc($user['email']) ?></p>
                </div>
                <div>
                    <p style="font-size:10px;color:#94A3B8;font-weight:600">TELEPON</p>
                    <p style="font-size:13px;font-weight:500"><?= esc($user['phone'] ?? '-') ?></p>
                </div>
                <div>
                    <p style="font-size:10px;color:#94A3B8;font-weight:600">BERGABUNG</p>
                    <p style="font-size:13px;font-weight:500"><?= date('d M Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Forms -->
    <div>
        <!-- Edit Profile -->
        <div class="card" style="margin-bottom:16px">
            <p style="font-size:15px;font-weight:600;margin-bottom:16px">Edit Profile</p>
            <form action="<?= site_url('staff/profile/edit') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input"
                           value="<?= esc($user['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="phone" class="form-input"
                           value="<?= esc($user['phone'] ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>

        <!-- Change Password -->
        <div class="card">
            <p style="font-size:15px;font-weight:600;margin-bottom:16px">Ganti Password</p>
            <form action="<?= site_url('staff/profile/change-password') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-input"
                           placeholder="Password lama" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-input"
                           placeholder="Min. 8 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="confirm_password" class="form-input"
                           placeholder="Ulangi password baru" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>