<?= $this->extend('layouts/staff') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-5">
  <p class="text-sm text-slate-500">Semua pemberitahuan terkait pesanan dan aktivitas akun Anda.</p>
  <form action="<?= site_url('staff/notifications/mark-all-read') ?>" method="post">
    <?= csrf_field() ?>
    <button type="submit" class="text-sm font-semibold text-teal-600 hover:text-teal-700">Tandai semua sudah dibaca</button>
  </form>
</div>

<div class="glass rounded-2xl divide-y divide-slate-200/60 overflow-hidden">
  <?php
    $notifications = $notifications ?? [
      ['icon' => 'fa-box-open',   'tone' => 'bg-teal-100 text-teal-600',   'title' => 'Pesanan baru diterima', 'desc' => 'Pesanan #LF-2042 dari Rizky Ramadhan baru saja masuk.', 'time' => '2 menit lalu', 'unread' => true],
      ['icon' => 'fa-truck-fast', 'tone' => 'bg-indigo-100 text-indigo-600','title' => 'Siap untuk diambil',    'desc' => 'Pesanan #LF-2040 milik Sarah Lin sudah siap diambil.', 'time' => '25 menit lalu', 'unread' => true],
      ['icon' => 'fa-triangle-exclamation', 'tone' => 'bg-amber-100 text-amber-600', 'title' => 'Stok deterjen menipis', 'desc' => 'Sisa stok deterjen di gudang tinggal 3 unit, segera ajukan pengadaan.', 'time' => '1 jam lalu', 'unread' => true],
      ['icon' => 'fa-circle-check', 'tone' => 'bg-emerald-100 text-emerald-600', 'title' => 'Pesanan selesai', 'desc' => 'Pesanan #LF-2039 milik Marc Owens telah ditandai selesai.', 'time' => '3 jam lalu', 'unread' => false],
      ['icon' => 'fa-comment-dots', 'tone' => 'bg-sky-100 text-sky-600', 'title' => 'Ulasan baru', 'desc' => 'Aiko Tanaka memberikan ulasan bintang 5 untuk layanan Anda.', 'time' => 'Kemarin', 'unread' => false],
      ['icon' => 'fa-user-plus', 'tone' => 'bg-rose-100 text-rose-600', 'title' => 'Pelanggan baru terdaftar', 'desc' => 'Nina Putri baru saja mendaftar sebagai pelanggan LaundryFlow.', 'time' => 'Kemarin', 'unread' => false],
    ];
  ?>
  <?php foreach ($notifications as $n): ?>
    <div class="flex items-start gap-3.5 px-5 lg:px-6 py-4 <?= $n['unread'] ? 'bg-teal-50/50' : '' ?>">
      <div class="w-10 h-10 rounded-xl <?= $n['tone'] ?> flex items-center justify-center shrink-0">
        <i class="fa-solid <?= $n['icon'] ?> text-sm"></i>
      </div>
      <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2">
          <p class="text-sm font-semibold text-slate-700"><?= esc($n['title']) ?></p>
          <?php if ($n['unread']): ?><span class="w-2 h-2 rounded-full bg-teal-500"></span><?php endif; ?>
        </div>
        <p class="text-sm text-slate-500 mt-0.5"><?= esc($n['desc']) ?></p>
        <p class="text-xs text-slate-400 mt-1"><?= esc($n['time']) ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
