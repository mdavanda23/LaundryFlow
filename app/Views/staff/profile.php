<?= $this->extend('layouts/staff') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3">
    <i class="fa-solid fa-circle-check mr-1"></i> <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

  <!-- Kartu profil -->
  <div class="glass rounded-2xl p-6 text-center h-fit">
    <img src="https://api.dicebear.com/7.x/notionists/svg?seed=Maya" class="w-24 h-24 rounded-full mx-auto bg-teal-100 border-4 border-white shadow" alt="Foto profil">
    <h3 class="font-display font-bold text-lg text-slate-800 mt-4"><?= esc($profile['name'] ?? 'Maya Chen') ?></h3>
    <p class="text-sm text-slate-500"><?= esc($profile['role'] ?? 'Staf Laundry') ?></p>
    <span class="inline-block mt-2 badge badge-completed">Aktif</span>

    <div class="mt-5 pt-5 border-t border-slate-200/70 text-left space-y-2.5 text-sm">
      <p class="flex items-center gap-2 text-slate-600"><i class="fa-solid fa-envelope w-4 text-slate-400"></i> <?= esc($profile['email'] ?? 'maya.chen@laundryflow.id') ?></p>
      <p class="flex items-center gap-2 text-slate-600"><i class="fa-solid fa-phone w-4 text-slate-400"></i> <?= esc($profile['phone'] ?? '0812-9988-7766') ?></p>
      <p class="flex items-center gap-2 text-slate-600"><i class="fa-solid fa-clock w-4 text-slate-400"></i> Shift <?= esc($profile['shift'] ?? 'Pagi (07.00 - 15.00)') ?></p>
      <p class="flex items-center gap-2 text-slate-600"><i class="fa-solid fa-store w-4 text-slate-400"></i> <?= esc($profile['branch'] ?? 'Cabang Bandung Kota') ?></p>
    </div>

    <button class="mt-5 w-full inline-flex items-center justify-center gap-2 border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-semibold py-2.5 rounded-xl transition">
      <i class="fa-solid fa-camera text-xs"></i> Ganti Foto
    </button>
  </div>

  <!-- Form informasi akun -->
  <div class="lg:col-span-2 space-y-5">

    <div class="glass rounded-2xl p-6">
      <h3 class="font-display font-bold text-slate-800 mb-4">Informasi Akun</h3>
      <form action="<?= site_url('staff/profile/update') ?>" method="post" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <?= csrf_field() ?>
        <div>
          <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama Lengkap</label>
          <input type="text" name="name" value="<?= esc($profile['name'] ?? 'Maya Chen') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-500 mb-1.5">Email</label>
          <input type="email" name="email" value="<?= esc($profile['email'] ?? 'maya.chen@laundryflow.id') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nomor Telepon</label>
          <input type="text" name="phone" value="<?= esc($profile['phone'] ?? '0812-9988-7766') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-500 mb-1.5">Shift Kerja</label>
          <select name="shift" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
            <option>Pagi (07.00 - 15.00)</option>
            <option>Siang (11.00 - 19.00)</option>
            <option>Malam (15.00 - 23.00)</option>
          </select>
        </div>
        <div class="sm:col-span-2 flex justify-end">
          <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow shadow-teal-500/30">Simpan Perubahan</button>
        </div>
      </form>
    </div>

    <div class="glass rounded-2xl p-6">
      <h3 class="font-display font-bold text-slate-800 mb-4">Ubah Kata Sandi</h3>
      <form action="<?= site_url('staff/profile/change-password') ?>" method="post" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <?= csrf_field() ?>
        <div class="sm:col-span-2">
          <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kata Sandi Saat Ini</label>
          <input type="password" name="current_password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kata Sandi Baru</label>
          <input type="password" name="new_password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-500 mb-1.5">Konfirmasi Kata Sandi Baru</label>
          <input type="password" name="new_password_confirm" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
        </div>
        <div class="sm:col-span-2 flex justify-end">
          <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Perbarui Kata Sandi</button>
        </div>
      </form>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
