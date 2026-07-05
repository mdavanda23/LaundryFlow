<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div style="background:#D1FAE5;color:#065F46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;font-weight:500">
        ✓ <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Profile Card -->
<div class="current-order-card" style="text-align:center;padding:28px 20px;margin-bottom:24px">
    <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:26px;font-weight:700;color:white;border:3px solid rgba(255,255,255,.4)">
        <?= strtoupper(substr($customer['name'], 0, 2)) ?>
    </div>
    <h2 style="color:white;font-size:18px;font-weight:700;margin-bottom:2px"><?= esc($customer['name']) ?></h2>
    <p style="color:rgba(255,255,255,.75);font-size:12px">
        Member sejak <?= date('Y', strtotime($customer['joined_at'] ?? $customer['created_at'])) ?>
    </p>

    <div style="display:flex;justify-content:space-around;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.2)">
        <div>
            <p style="color:white;font-size:22px;font-weight:700"><?= $total_orders ?></p>
            <p style="color:rgba(255,255,255,.7);font-size:11px">Orders</p>
        </div>
        <div>
            <p style="color:white;font-size:18px;font-weight:700">Rp<?= number_format($total_spent, 0, ',', '.') ?></p>
            <p style="color:rgba(255,255,255,.7);font-size:11px">Total Spent</p>
        </div>
        <div>
            <p style="color:white;font-size:22px;font-weight:700"><?= $customer['points'] ?? 0 ?></p>
            <p style="color:rgba(255,255,255,.7);font-size:11px">Points</p>
        </div>
    </div>
</div>

<!-- Personal Information -->
<h3 style="font-size:14px;font-weight:600;color:#64748B;margin-bottom:10px;text-transform:uppercase;letter-spacing:.5px">Informasi Pribadi</h3>

<div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.06);margin-bottom:20px">

    <?php
    $infos = [
        ['icon' => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z M22,6 12,13 2,6', 'label' => 'EMAIL',   'value' => $customer['email']],
        ['icon' => 'M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3-8.59A2 2 0 012.18 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.1a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 15.1z', 'label' => 'PHONE',   'value' => $customer['phone'] ?? '-'],
        ['icon' => 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z M12,9 m-2.5,0 a2.5,2.5 0 1,0 5,0 a2.5,2.5 0 1,0 -5,0', 'label' => 'ADDRESS', 'value' => $customer['address'] ?? '-'],
    ];
    ?>

    <?php foreach ($infos as $i => $info): ?>
    <div style="display:flex;align-items:center;gap:14px;padding:14px 16px;<?= $i < count($infos)-1 ? 'border-bottom:1px solid #F1F5F9' : '' ?>">
        <div style="width:36px;height:36px;background:#EFF9FB;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#06B6D4;flex-shrink:0">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <?= $info['icon'] === $infos[0]['icon']
                    ? '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>'
                    : ($info['icon'] === $infos[1]['icon']
                        ? '<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3-8.59A2 2 0 012.18 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.1a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 15.1z"/>'
                        : '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/>')
                ?>
            </svg>
        </div>
        <div>
            <p style="font-size:10px;color:#94A3B8;font-weight:600;letter-spacing:.5px;margin-bottom:2px"><?= $info['label'] ?></p>
            <p style="font-size:14px;font-weight:500;color:#0F172A"><?= esc($info['value']) ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Account Actions -->
<h3 style="font-size:14px;font-weight:600;color:#64748B;margin-bottom:10px;text-transform:uppercase;letter-spacing:.5px">Akun</h3>

<div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.06);margin-bottom:12px">
    <a href="<?= site_url('customer/profile/edit') ?>" style="display:flex;align-items:center;justify-content:space-between;padding:16px;text-decoration:none;color:#0F172A;border-bottom:1px solid #F1F5F9">
        <div style="display:flex;align-items:center;gap:12px">
            <div style="width:36px;height:36px;background:#EFF9FB;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#06B6D4">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span style="font-weight:500;font-size:14px">Edit Profile</span>
        </div>
        <span style="color:#94A3B8;font-size:18px">›</span>
    </a>
    <a href="<?= site_url('customer/profile/change-password') ?>" style="display:flex;align-items:center;justify-content:space-between;padding:16px;text-decoration:none;color:#0F172A">
        <div style="display:flex;align-items:center;gap:12px">
            <div style="width:36px;height:36px;background:#EFF9FB;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#06B6D4">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
            </div>
            <span style="font-weight:500;font-size:14px">Ganti Password</span>
        </div>
        <span style="color:#94A3B8;font-size:18px">›</span>
    </a>
</div>

<!-- Logout -->
<a href="<?= site_url('customer/logout') ?>" style="display:flex;align-items:center;gap:12px;background:#FEF2F2;border-radius:16px;padding:16px;text-decoration:none;color:#EF4444;font-weight:600;font-size:14px">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
    </svg>
    Log out
</a>

<?= $this->endSection() ?>