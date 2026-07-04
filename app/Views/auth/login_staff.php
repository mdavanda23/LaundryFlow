<?php
$title           = 'Masuk Staf';
$brandBadge      = 'Portal Staf';
$brandHeading    = 'Kelola antrean cucian dengan tenang.';
$brandSubtext    = 'Pantau pesanan masuk, perbarui tahap proses, dan layani pelanggan lebih cepat dari satu dashboard.';
$badgeTextColor  = 'text-teal-200';
$footerNote      = 'Lupa kata sandi? Hubungi supervisor cabang kamu.';
?>
<?= $this->extend('auth/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
  <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wide text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full mb-3">
    <i class="fa-solid fa-shirt"></i> Portal Staf
  </span>
  <h2 class="font-display font-bold text-2xl text-slate-800">Masuk ke Dashboard Staf</h2>
  <p class="text-sm text-slate-500 mt-1">Khusus untuk staf/kasir LaundryFlow yang terdaftar.</p>
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

<form action="<?= site_url('staff/login') ?>" method="post" class="space-y-4">
  <?= csrf_field() ?>

  <div>
    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Email Staf</label>
    <div class="relative">
      <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
      <input type="email" name="email" value="<?= old('email') ?>" placeholder="nama@laundryflow.com" required autofocus
             class="input-field pl-9">
    </div>
  </div>

  <div>
    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kata Sandi</label>
    <div class="relative">
      <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
      <input type="password" name="password" placeholder="Kata sandi kamu" required
             class="input-field pl-9">
    </div>
  </div>

  <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm py-3 rounded-xl transition shadow-lg shadow-teal-500/25">
    Masuk sebagai Staf
  </button>
</form>

<div class="flex items-center gap-3 my-6">
  <span class="h-px flex-1 bg-slate-200"></span>
  <span class="text-[11px] text-slate-400 uppercase tracking-wide">Bukan staf?</span>
  <span class="h-px flex-1 bg-slate-200"></span>
</div>

<div class="flex gap-2">
  <a href="<?= site_url('login') ?>" class="flex-1 text-center text-xs font-semibold text-slate-500 border border-slate-200 rounded-xl py-2.5 hover:bg-slate-50">Masuk sebagai Pelanggan</a>
  <a href="<?= site_url('admin/login') ?>" class="flex-1 text-center text-xs font-semibold text-slate-500 border border-slate-200 rounded-xl py-2.5 hover:bg-slate-50">Masuk sebagai Owner</a>
</div>

<?= $this->endSection() ?>
