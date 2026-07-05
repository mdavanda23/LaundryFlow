<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Harga Laundry</div>
            <div class="card-sub">Perbarui harga per kilogram untuk setiap layanan</div>
        </div>
    </div>

    <table>
        <thead>
            <tr><th>LAYANAN</th><th>DESKRIPSI</th><th>DURASI</th><th>HARGA/KG</th><th>STATUS</th><th>AKSI</th></tr>
        </thead>
        <tbody>
            <?php foreach ($services as $s): ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:22px"><?= esc($s['icon']) ?></span>
                        <span style="font-weight:600"><?= esc($s['name']) ?></span>
                    </div>
                </td>
                <td style="color:#64748B;font-size:12px"><?= esc($s['description']) ?></td>
                <td style="color:#64748B"><?= esc($s['duration']) ?></td>
                <td>
                    <span style="font-size:15px;font-weight:700;color:#06B6D4">
                        Rp<?= number_format($s['price_per_kg'],0,',','.') ?>/kg
                    </span>
                </td>
                <td>
                    <span class="badge <?= $s['status']==='active'?'badge-active':'badge-draft' ?>">
                        <?= $s['status']==='active'?'Active':'Draft' ?>
                    </span>
                </td>
                <td>
                    <form action="<?= site_url('admin/prices/update/'.$s['id']) ?>" method="POST"
                          style="display:flex;gap:6px;align-items:center">
                        <?= csrf_field() ?>
                        <input type="number" name="price_per_kg" value="<?= $s['price_per_kg'] ?>"
                               class="form-input" style="width:100px;padding:6px 10px" step="500" required>
                        <select name="status" class="form-input" style="width:90px;padding:6px 10px">
                            <option value="active"   <?= $s['status']==='active'?'selected':'' ?>>Active</option>
                            <option value="inactive" <?= $s['status']==='inactive'?'selected':'' ?>>Draft</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>