<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Daftar Layanan</span>
        <div style="display:flex;gap:10px">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-svc" class="search-input" placeholder="Cari layanan...">
            </div>
            <button onclick="document.getElementById('modal-add').classList.add('show')" class="btn btn-primary">
                + Tambah Layanan
            </button>
        </div>
    </div>

    <table id="svc-table">
        <thead>
            <tr><th>LAYANAN</th><th>HARGA/KG</th><th>DURASI</th><th>STATUS</th><th>AKSI</th></tr>
        </thead>
        <tbody>
            <?php foreach ($services as $s): ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:22px"><?= esc($s['icon']) ?></span>
                        <div>
                            <p style="font-weight:600"><?= esc($s['name']) ?></p>
                            <p style="font-size:11px;color:#64748B"><?= esc($s['description']) ?></p>
                        </div>
                    </div>
                </td>
                <td style="font-weight:600;color:#06B6D4">Rp<?= number_format($s['price_per_kg'],0,',','.') ?>/kg</td>
                <td style="color:#64748B"><?= esc($s['duration']) ?></td>
                <td>
                    <span class="badge <?= $s['status']==='active'?'badge-active':'badge-draft' ?>">
                        <?= $s['status'] === 'active' ? 'Active' : 'Draft' ?>
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button onclick="openEdit(<?= htmlspecialchars(json_encode($s)) ?>)"
                                class="btn btn-outline btn-sm">Edit</button>
                        <a href="<?= site_url('admin/services/delete/'.$s['id']) ?>"
                           onclick="return confirm('Hapus layanan ini?')"
                           class="btn btn-danger btn-sm">Hapus</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal-backdrop" id="modal-add">
    <div class="modal">
        <h3 class="modal-title">Tambah Layanan</h3>
        <form action="<?= site_url('admin/services') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label">Nama Layanan</label>
                <input type="text" name="name" class="form-input" placeholder="Contoh: Wash & Iron" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="description" class="form-input" placeholder="Deskripsi singkat">
            </div>
            <div class="grid-2" style="gap:12px">
                <div class="form-group">
                    <label class="form-label">Harga/kg (Rp)</label>
                    <input type="number" name="price_per_kg" class="form-input" placeholder="7000" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="duration" class="form-input" placeholder="1 Day">
                </div>
            </div>
            <div class="grid-2" style="gap:12px">
                <div class="form-group">
                    <label class="form-label">Icon (emoji)</label>
                    <input type="text" name="icon" class="form-input" placeholder="🧺">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('modal-add').classList.remove('show')"
                        class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal-backdrop" id="modal-edit">
    <div class="modal">
        <h3 class="modal-title">Edit Layanan</h3>
        <form id="edit-form" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label">Nama Layanan</label>
                <input type="text" name="name" id="edit-name" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="description" id="edit-desc" class="form-input">
            </div>
            <div class="grid-2" style="gap:12px">
                <div class="form-group">
                    <label class="form-label">Harga/kg (Rp)</label>
                    <input type="number" name="price_per_kg" id="edit-price" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="duration" id="edit-duration" class="form-input">
                </div>
            </div>
            <div class="grid-2" style="gap:12px">
                <div class="form-group">
                    <label class="form-label">Icon</label>
                    <input type="text" name="icon" id="edit-icon" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" id="edit-status" class="form-input">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('modal-edit').classList.remove('show')"
                        class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(data) {
    document.getElementById('edit-name').value     = data.name;
    document.getElementById('edit-desc').value     = data.description;
    document.getElementById('edit-price').value    = data.price_per_kg;
    document.getElementById('edit-duration').value = data.duration;
    document.getElementById('edit-icon').value     = data.icon;
    document.getElementById('edit-status').value   = data.status;
    document.getElementById('edit-form').action    = '<?= site_url('admin/services/update/') ?>' + data.id;
    document.getElementById('modal-edit').classList.add('show');
}

document.getElementById('search-svc').addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('#svc-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>