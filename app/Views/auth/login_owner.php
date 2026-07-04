<?php
$title           = 'Masuk Admin';
$brandBadge      = 'Panel Admin';
$brandHeading    = 'Kendalikan seluruh operasional dari satu tempat.';
$brandSubtext    = 'Pantau performa cabang, kelola staf dan pelanggan, serta lihat laporan pendapatan secara menyeluruh.';
$badgeTextColor  = 'text-indigo-200';
$ownerTheme      = true;
$brandStats      = [
  ['value' => '5', 'label' => 'Cabang aktif'],
  ['value' => '32', 'label' => 'Staf terdaftar'],
  ['value' => 'Rp 48jt', 'label' => 'Omzet bulan ini'],
];
$footerNote      = 'Akses ini khusus untuk pemilik & administrator LaundryFlow.';
?>
<?= $this->extend('auth/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
  <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wide text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-full mb-3">
    <i class="fa-solid fa-shield-halved"></i> Panel Admin
  </span>
  <h2 class="font-display font-bold text-2xl text-slate-800">Masuk sebagai Owner</h2>
  <p class="text-sm text-slate-500 mt-1">Akses penuh untuk pemilik dan administrator LaundryFlow.</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3">
    <i class="fa-solid fa-circle-check mr-1"></i> <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="mb-5 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-sm px-4 py-3">
    <i class="fa-solid fa-circle-exclamation mr-1"></i> <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<form action="<?= site_url('admin/login') ?>" method="post" class="space-y-4">
  <?= csrf_field() ?>

  <div>
    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Email Admin</label>
    <div class="relative">
      <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
      <input type="email" name="email" value="<?= old('email') ?>" placeholder="admin@laundryflow.com" required autofocus
             class="input-field owner-focus pl-9">
    </div>
  </div>

  <div>
    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kata Sandi</label>
    <div class="relative">
      <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
      <input type="password" name="password" placeholder="Kata sandi kamu" required
             class="input-field owner-focus pl-9">
    </div>
  </div>

  <label class="flex items-center gap-2 text-sm text-slate-500">
    <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-400">
    Ingat saya di perangkat ini
  </label>

  <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm py-3 rounded-xl transition shadow-lg shadow-slate-900/25">
    Masuk ke Panel Admin
  </button>
</form>

<div class="flex items-center gap-3 my-6">
  <span class="h-px flex-1 bg-slate-200"></span>
  <span class="text-[11px] text-slate-400 uppercase tracking-wide">Bukan owner?</span>
  <span class="h-px flex-1 bg-slate-200"></span>
</div>

<div class="flex gap-2">
  <a href="<?= site_url('login') ?>" class="flex-1 text-center text-xs font-semibold text-slate-500 border border-slate-200 rounded-xl py-2.5 hover:bg-slate-50">Masuk sebagai Pelanggan</a>
  <a href="<?= site_url('staff/login') ?>" class="flex-1 text-center text-xs font-semibold text-slate-500 border border-slate-200 rounded-xl py-2.5 hover:bg-slate-50">Masuk sebagai Staf</a>
</div>

<?= $this->endSection() ?>
