<?= $this->extend('layouts/staff') ?>
<?= $this->section('content') ?>

<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-5">
  <div class="flex items-center gap-2 overflow-x-auto scrollbar-thin pb-1">
    <?php
      $filters = ['all' => 'Semua', 'pending' => 'Menunggu', 'processing' => 'Diproses', 'ready' => 'Siap Diambil', 'completed' => 'Selesai'];
      $activeFilter = $activeFilter ?? 'all';
    ?>
    <?php foreach ($filters as $key => $label): ?>
      <a href="<?= site_url('staff/orders') ?>?status=<?= $key ?>"
         class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap transition
                <?= $activeFilter === $key ? 'bg-teal-600 text-white shadow shadow-teal-500/30' : 'glass text-slate-600 hover:text-teal-700' ?>">
        <?= $label ?>
      </a>
    <?php endforeach; ?>
  </div>

  <form class="flex items-center gap-2 w-full lg:w-auto" method="get">
    <div class="relative flex-1 lg:w-72">
      <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
      <input type="text" name="q" value="<?= esc($searchQuery ?? '') ?>" placeholder="Cari kode pesanan atau nama pelanggan..."
             class="w-full pl-9 pr-3 py-2.5 rounded-xl glass border border-slate-200/70 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/60">
    </div>
    <button type="submit" class="glass px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:text-teal-700 border border-slate-200/70">Cari</button>
  </form>
</div>

<div class="glass rounded-2xl overflow-hidden">
  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-xs text-slate-500 uppercase tracking-wide border-b border-slate-200/70">
          <th class="px-5 lg:px-6 py-3 font-semibold">Pesanan</th>
          <th class="px-3 py-3 font-semibold">Pelanggan</th>
          <th class="px-3 py-3 font-semibold">Layanan</th>
          <th class="px-3 py-3 font-semibold">Berat</th>
          <th class="px-3 py-3 font-semibold">Total</th>
          <th class="px-3 py-3 font-semibold">Masuk</th>
          <th class="px-3 py-3 font-semibold">Status</th>
          <th class="px-3 py-3 font-semibold text-right pr-5 lg:pr-6">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200/60">
        <?php
          $orders = $orders ?? [
            ['code' => 'LF-2041', 'customer' => 'John Carter', 'service' => 'Cuci & Setrika', 'weight' => '4.2 kg', 'total' => 'Rp 157.500', 'time' => '08:12', 'status' => 'processing'],
            ['code' => 'LF-2040', 'customer' => 'Sarah Lin',   'service' => 'Kilat',          'weight' => '2.0 kg', 'total' => 'Rp 80.000',  'time' => '08:05', 'status' => 'ready'],
            ['code' => 'LF-2039', 'customer' => 'Marc Owens',  'service' => 'Reguler',        'weight' => '6.5 kg', 'total' => 'Rp 162.500', 'time' => '07:48', 'status' => 'completed'],
            ['code' => 'LF-2038', 'customer' => 'Aiko Tanaka', 'service' => 'Setrika Saja',   'weight' => '3.4 kg', 'total' => 'Rp 51.000',  'time' => '07:30', 'status' => 'pending'],
            ['code' => 'LF-2037', 'customer' => 'Diego Ruiz',  'service' => 'Cuci & Setrika', 'weight' => '5.1 kg', 'total' => 'Rp 178.500', 'time' => '07:15', 'status' => 'processing'],
            ['code' => 'LF-2036', 'customer' => 'Nina Putri',  'service' => 'Reguler',        'weight' => '3.0 kg', 'total' => 'Rp 45.000',  'time' => '06:58', 'status' => 'completed'],
            ['code' => 'LF-2035', 'customer' => 'Budi Santoso','service' => 'Kilat',          'weight' => '1.8 kg', 'total' => 'Rp 72.000',  'time' => '06:40', 'status' => 'pending'],
          ];
          $statusLabel = [
            'pending' => ['Menunggu', 'badge-pending'],
            'processing' => ['Diproses', 'badge-processing'],
            'ready' => ['Siap Diambil', 'badge-ready'],
            'completed' => ['Selesai', 'badge-completed'],
          ];
        ?>
        <?php foreach ($orders as $o): [$label, $cls] = $statusLabel[$o['status']]; ?>
        <tr class="hover:bg-white/60 transition">
          <td class="px-5 lg:px-6 py-3.5 font-semibold text-slate-700">#<?= esc($o['code']) ?></td>
          <td class="px-3 py-3.5">
            <div class="flex items-center gap-2">
              <div class="w-7 h-7 rounded-full bg-teal-100 text-teal-700 text-[11px] font-bold flex items-center justify-center"><?= strtoupper(substr($o['customer'],0,1)) ?></div>
              <?= esc($o['customer']) ?>
            </div>
          </td>
          <td class="px-3 py-3.5 text-slate-600"><?= esc($o['service']) ?></td>
          <td class="px-3 py-3.5 text-slate-600"><?= esc($o['weight']) ?></td>
          <td class="px-3 py-3.5 font-semibold text-slate-700"><?= esc($o['total']) ?></td>
          <td class="px-3 py-3.5 text-slate-500"><?= esc($o['time']) ?></td>
          <td class="px-3 py-3.5"><span class="badge <?= $cls ?>"><?= $label ?></span></td>
          <td class="px-3 py-3.5 text-right pr-5 lg:pr-6 space-x-1 whitespace-nowrap">
            <a href="<?= site_url('staff/processing') ?>" title="Perbarui status" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-teal-200 text-teal-600 hover:bg-teal-50"><i class="fa-solid fa-pen text-xs"></i></a>
            <button title="Lihat detail" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50"><i class="fa-solid fa-eye text-xs"></i></button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="flex items-center justify-between px-5 lg:px-6 py-4 border-t border-slate-200/70 text-sm text-slate-500">
    <p>Menampilkan <span class="font-semibold text-slate-700">7</span> dari <span class="font-semibold text-slate-700">48</span> pesanan</p>
    <div class="flex items-center gap-1.5">
      <button class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-white text-slate-500"><i class="fa-solid fa-chevron-left text-xs"></i></button>
      <button class="w-8 h-8 rounded-lg bg-teal-600 text-white font-semibold">1</button>
      <button class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-white text-slate-500">2</button>
      <button class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-white text-slate-500">3</button>
      <button class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-white text-slate-500"><i class="fa-solid fa-chevron-right text-xs"></i></button>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
