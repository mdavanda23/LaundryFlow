<?= $this->extend('layouts/staff') ?>
<?= $this->section('content') ?>

<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-5">
  <div class="grid grid-cols-3 gap-3 w-full lg:w-auto">
    <div class="glass rounded-xl px-4 py-2.5 text-center">
      <p class="text-lg font-display font-bold text-slate-800"><?= $customerStats['total'] ?? 214 ?></p>
      <p class="text-[11px] text-slate-500">Total Pelanggan</p>
    </div>
    <div class="glass rounded-xl px-4 py-2.5 text-center">
      <p class="text-lg font-display font-bold text-slate-800"><?= $customerStats['new_month'] ?? 18 ?></p>
      <p class="text-[11px] text-slate-500">Baru Bulan Ini</p>
    </div>
    <div class="glass rounded-xl px-4 py-2.5 text-center">
      <p class="text-lg font-display font-bold text-slate-800"><?= $customerStats['active'] ?? 96 ?></p>
      <p class="text-[11px] text-slate-500">Pelanggan Aktif</p>
    </div>
  </div>

  <form class="flex items-center gap-2 w-full lg:w-80" method="get">
    <div class="relative flex-1">
      <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
      <input type="text" name="q" placeholder="Cari nama, telepon, atau email..."
             class="w-full pl-9 pr-3 py-2.5 rounded-xl glass border border-slate-200/70 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
    </div>
  </form>
</div>

<div class="glass rounded-2xl overflow-hidden">
  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-xs text-slate-500 uppercase tracking-wide border-b border-slate-200/70">
          <th class="px-5 lg:px-6 py-3 font-semibold">Pelanggan</th>
          <th class="px-3 py-3 font-semibold">Kontak</th>
          <th class="px-3 py-3 font-semibold">Total Pesanan</th>
          <th class="px-3 py-3 font-semibold">Pesanan Terakhir</th>
          <th class="px-3 py-3 font-semibold">Total Belanja</th>
          <th class="px-3 py-3 font-semibold text-right pr-5 lg:pr-6">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200/60">
        <?php
          $customers = $customers ?? [
            ['name' => 'John Carter',  'phone' => '0812-3456-7890', 'email' => 'john.carter@mail.com',  'orders' => 24, 'last' => '5 Jul 2026', 'spent' => 'Rp 3.240.000'],
            ['name' => 'Sarah Lin',    'phone' => '0813-2211-9087', 'email' => 'sarah.lin@mail.com',     'orders' => 11, 'last' => '5 Jul 2026', 'spent' => 'Rp 1.120.000'],
            ['name' => 'Marc Owens',   'phone' => '0857-6633-1120', 'email' => 'marc.owens@mail.com',    'orders' => 32, 'last' => '4 Jul 2026', 'spent' => 'Rp 4.980.000'],
            ['name' => 'Aiko Tanaka',  'phone' => '0821-9090-4455', 'email' => 'aiko.tanaka@mail.com',   'orders' => 6,  'last' => '4 Jul 2026', 'spent' => 'Rp 540.000'],
            ['name' => 'Diego Ruiz',   'phone' => '0838-4477-2201', 'email' => 'diego.ruiz@mail.com',    'orders' => 18, 'last' => '3 Jul 2026', 'spent' => 'Rp 2.410.000'],
            ['name' => 'Nina Putri',   'phone' => '0812-7788-3344', 'email' => 'nina.putri@mail.com',    'orders' => 9,  'last' => '2 Jul 2026', 'spent' => 'Rp 980.000'],
          ];
        ?>
        <?php foreach ($customers as $c): ?>
        <tr class="hover:bg-white/60 transition">
          <td class="px-5 lg:px-6 py-3.5">
            <div class="flex items-center gap-2.5">
              <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-700 text-xs font-bold flex items-center justify-center"><?= strtoupper(substr($c['name'],0,2)) ?></div>
              <span class="font-semibold text-slate-700"><?= esc($c['name']) ?></span>
            </div>
          </td>
          <td class="px-3 py-3.5 text-slate-600">
            <p><?= esc($c['phone']) ?></p>
            <p class="text-xs text-slate-400"><?= esc($c['email']) ?></p>
          </td>
          <td class="px-3 py-3.5 text-slate-600"><?= $c['orders'] ?> pesanan</td>
          <td class="px-3 py-3.5 text-slate-500"><?= esc($c['last']) ?></td>
          <td class="px-3 py-3.5 font-semibold text-slate-700"><?= esc($c['spent']) ?></td>
          <td class="px-3 py-3.5 text-right pr-5 lg:pr-6 space-x-1 whitespace-nowrap">
            <button title="Lihat riwayat" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50"><i class="fa-solid fa-clock-rotate-left text-xs"></i></button>
            <button title="Hubungi" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-teal-200 text-teal-600 hover:bg-teal-50"><i class="fa-solid fa-phone text-xs"></i></button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
