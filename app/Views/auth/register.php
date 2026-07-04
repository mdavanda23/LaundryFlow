<?php
$title           = 'Daftar Akun';
$brandBadge      = 'Portal Pelanggan';
$brandHeading    = 'Gabung dan nikmati laundry tanpa antre.';
$brandSubtext    = 'Buat akun untuk memesan layanan laundry, memantau status pesanan secara real-time, dan menyimpan riwayat transaksimu.';
?>

<?= $this->extend('auth/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="font-display font-bold text-2xl text-slate-800">
        Buat Akun Baru
    </h2>
    <p class="text-sm text-slate-500 mt-1">
        Daftar sebagai pelanggan untuk mulai menggunakan layanan LaundryFlow.
    </p>
</div>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
        <ul class="list-disc pl-5 space-y-1">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('customer/register') ?>" method="post" class="space-y-4">

    <?= csrf_field() ?>

    <div>
        <label class="block text-xs font-semibold text-slate-500 mb-2">
            Nama Lengkap
        </label>

        <div class="relative">
            <i class="fa-regular fa-user absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

            <input
                type="text"
                name="name"
                value="<?= old('name') ?>"
                class="input-field pl-10"
                placeholder="Masukkan nama lengkap"
                required>
        </div>
    </div>

    <div>
        <label class="block text-xs font-semibold text-slate-500 mb-2">
            Email
        </label>

        <div class="relative">
            <i class="fa-regular fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

            <input
                type="email"
                name="email"
                value="<?= old('email') ?>"
                class="input-field pl-10"
                placeholder="contoh@email.com"
                required>
        </div>
    </div>

    <div>
        <label class="block text-xs font-semibold text-slate-500 mb-2">
            Nomor WhatsApp
        </label>

        <div class="relative">
            <i class="fa-solid fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

            <input
                type="text"
                name="phone"
                value="<?= old('phone') ?>"
                class="input-field pl-10"
                placeholder="08xxxxxxxxxx"
                required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-2">
                Kata Sandi
            </label>

            <div class="relative">
                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

                <input
                    type="password"
                    name="password"
                    class="input-field pl-10"
                    placeholder="Minimal 8 karakter"
                    required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-2">
                Konfirmasi Kata Sandi
            </label>

            <div class="relative">
                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

                <input
                    type="password"
                    name="password_confirm"
                    class="input-field pl-10"
                    placeholder="Ulangi kata sandi"
                    required>
            </div>
        </div>

    </div>

    <label class="flex items-start gap-2 text-xs text-slate-500">

        <input
            type="checkbox"
            required
            class="mt-1 rounded border-slate-300">

        <span>
            Saya menyetujui
            <a href="#" class="text-teal-600 font-semibold">
                Syarat & Ketentuan
            </a>
            serta
            <a href="#" class="text-teal-600 font-semibold">
                Kebijakan Privasi
            </a>.
        </span>

    </label>

    <button
        type="submit"
        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition">

        Daftar Sekarang

    </button>

</form>

<p class="text-center text-sm text-slate-500 mt-6">
    Sudah memiliki akun?
    <a href="<?= site_url('customer/login') ?>"
       class="text-teal-600 font-semibold hover:underline">
        Masuk di sini
    </a>
</p>

<?= $this->endSection() ?>