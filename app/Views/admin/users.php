<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div style="display:flex;gap:8px;align-items:center">
            <?php foreach(['all'=>'All','customers'=>'Customers','staff'=>'Staff','admins'=>'Admins'] as $k=>$v): ?>
            <a href="?role=<?= $k ?>"
               style="padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;text-decoration:none;
                      background:<?= ($filter??'all')===$k?'#06B6D4':'#F1F5F9' ?>;
                      color:<?= ($filter??'all')===$k?'white':'#64748B' ?>">
                <?= $v ?>
            </a>
            <?php endforeach; ?>
        </div>
        <div style="display:flex;gap:10px">
            <form action="" method="GET" style="display:flex;gap:8px">
                <input type="hidden" name="role" value="<?= esc($filter??'all') ?>">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input"
                           placeholder="Cari nama / email..."
                           value="<?= esc($search??'') ?>">
                </div>
                <button type="submit" class="btn btn-outline btn-sm">Cari</button>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr><th>USER</th><th>ROLE</th><th>STATUS</th><th>ORDERS</th><th>BERGABUNG</th><th>AKSI</th></tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
            <?php foreach ($users as $u):
                $roleColors = [1=>'badge-admin',2=>'badge-staff',3=>'badge-customer'];
                $roleLabels = [1=>'Admin',2=>'Staff',3=>'Customer'];
                $bgColors   = ['#06B6D4','#10B981','#F59E0B','#8B5CF6','#EF4444'];
                $bg         = $bgColors[$u['id'] % count($bgColors)];
            ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <span class="avatar" style="background:<?= $bg ?>">
                            <?= strtoupper(substr($u['name'],0,2)) ?>
                        </span>
                        <div>
                            <p style="font-weight:600"><?= esc($u['name']) ?></p>
                            <p style="font-size:11px;color:#64748B"><?= esc($u['email']) ?></p>
                        </div>
                    </div>
                </td>
                <td><span class="badge <?= $roleColors[$u['role_id']]??'badge-customer' ?>"><?= $roleLabels[$u['role_id']]??'Customer' ?></span></td>
                <td>
                    <span class="badge <?= $u['status']==='active'?'badge-active':'badge-inactive' ?>">
                        <?= $u['status']==='active'?'Active':'Suspended' ?>
                    </span>
                </td>
                <td style="text-align:center;font-weight:600"><?= $u['total_orders'] ?></td>
                <td style="color:#64748B;font-size:12px"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="<?= site_url('admin/users/toggle/'.$u['id']) ?>"
                           class="btn btn-outline btn-sm">
                            <?= $u['status']==='active'?'Suspend':'Aktifkan' ?>
                        </a>
                        <?php if ($u['role_id'] != 1): ?>
                        <a href="<?= site_url('admin/users/delete/'.$u['id']) ?>"
                           onclick="return confirm('Hapus user ini?')"
                           class="btn btn-danger btn-sm">Hapus</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="6" style="text-align:center;color:#94A3B8;padding:32px">Tidak ada user ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>