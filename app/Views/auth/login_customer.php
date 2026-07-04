<?php
$title           = 'Masuk Pelanggan';
$brandBadge      = 'Portal Pelanggan';
$brandHeading    = 'Cucian Bersih, Tanpa Ribet';
$brandSubtext    = 'Pantau status cucianmu secara real-time, dari penjemputan hingga selesai.';
$footerNote      = 'Butuh bantuan? Hubungi Customer Service LaundryFlow.';
?>

<?= $this->extend('auth/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="font-display font-bold text-2xl text-slate-800">
        Selamat Datang Kembali
    </h2>

    <p class="text-sm text-slate-500 mt-1">
        Silakan masuk untuk melihat status dan riwayat pesanan laundry Anda.
    </p>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3">
    <i class="fa-solid fa-circle-check mr-2"></i>
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<div class="mb-5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm px-4 py-3">
    <i class="fa-solid fa-circle-exclamation mr-2"></i>
    <?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<form action="<?= site_url('customer/login') ?>" method="post" class="space-y-4">

    <?= csrf_field() ?>

    <div>
        <label class="block text-xs font-semibold text-slate-500 mb-1.5">
            Email
        </label>

        <div class="relative">
            <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

            <input
                type="email"
                name="email"
                value="<?= old('email') ?>"
                placeholder="nama@email.com"
                required
                autofocus
                class="input-field pl-9">
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label class="block text-xs font-semibold text-slate-500">
                Kata Sandi
            </label>

            <a href="#" class="text-xs font-semibold text-teal-600 hover:underline">
                Lupa Kata Sandi?
            </a>
        </div>

        <div class="relative">
            <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

            <input
                type="password"
                name="password"
                placeholder="Masukkan kata sandi"
                required
                class="input-field pl-9">
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm text-slate-500">
        <input
            type="checkbox"
            name="remember"
            class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">

        Ingat saya
    </label>

    <button
        type="submit"
        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-teal-500/20">

        Masuk
    </button>

</form>

<p class="text-center text-sm text-slate-500 mt-6">
    Belum memiliki akun?

    <a href="<?= site_url('customer/register') ?>"
       class="text-teal-600 font-semibold hover:underline">

        Daftar Sekarang
    </a>
</p>

<?= $this->endSection() ?>