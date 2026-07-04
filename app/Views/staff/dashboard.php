<?= $this->extend('layouts/staff') ?>
<?= $this->section('content') ?>

<!-- Banner sambutan -->
<div class="rounded-3xl overflow-hidden relative mb-6 glass-dark text-white px-6 lg:px-8 py-7">
  <div class="absolute -right-10 -top-14 w-56 h-56 rounded-full bg-teal-400/20 blur-3xl"></div>
  <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <p class="text-teal-200/80 text-xs font-semibold tracking-wide uppercase mb-1">Selamat pagi</p>
      <h2 class="font-display font-bold text-2xl lg:text-3xl">Selamat datang kembali, <?= esc($staffName ?? 'Maya') ?> 👋</h2>
      <p class="text-teal-100/70 text-sm mt-2">Ada <span class="font-semibold text-white"><?= $stats['pending'] ?? 12 ?> pesanan baru</span> yang menunggu untuk diproses hari ini.</p>
    </div>
    <a href="<?= site_url('staff/processing') ?>" class="shrink-0 inline-flex items-center gap-2 bg-teal-300 hover:bg-teal-200 text-teal-950 font-semibold text-sm px-5 py-2.5 rounded-xl transition shadow-lg shadow-teal-500/20">
      Buka Antrean <i class="fa-solid fa-arrow-right text-xs"></i>
    </a>
  </div>
</div>

<!-- Kartu statistik -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <?php
    $cards = [
      ['label' => 'Pesanan Hari Ini', 'value' => $stats['today_orders'] ?? 48, 'delta' => '+12%', 'icon' => 'fa-box', 'tone' => 'teal'],
      ['label' => 'Sedang Diproses', 'value' => $stats['in_progress'] ?? 16, 'delta' => '+3',   'icon' => 'fa-arrows-spin', 'tone' => 'indigo'],
      ['label' => 'Selesai',         'value' => $stats['completed'] ?? 29,   'delta' => '+18%', 'icon' => 'fa-circle-check', 'tone' => 'emerald'],
      ['label' => 'Pendapatan Hari Ini', 'value' => 'Rp ' . number_format($stats['revenue'] ?? 1284000, 0, ',', '.'), 'delta' => '+22%', 'icon' => 'fa-sack-dollar', 'tone' => 'amber'],
    ];
    $toneMap = [
      'teal'    => 'from-teal-400 to-teal-600',
      'indigo'  => 'from-indigo-400 to-indigo-600',
      'emerald' => 'from-emerald-400 to-emerald-600',
      'amber'   => 'from-amber-400 to-amber-600',
    ];
  ?>
  <?php foreach ($cards as $c): ?>
    <div class="glass rounded-2xl p-5 shadow-sm">
      <div class="flex items-start justify-between">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br <?= $toneMap[$c['tone']] ?> flex items-center justify-center text-white shadow">
          <i class="fa-solid <?= $c['icon'] ?> text-sm"></i>
        </div>
        <span class="badge badge-completed"><?= $c['delta'] ?></span>
      </div>
      <p class="text-2xl font-display font-bold mt-4 text-slate-800"><?= $c['value'] ?></p>
      <p class="text-xs text-slate-500 mt-1"><?= $c['label'] ?></p>
    </div>
  <?php endforeach; ?>
</div>

<!-- Pesanan terbaru -->
<div class="glass rounded-2xl overflow-hidden">
  <div class="flex items-center justify-between px-5 lg:px-6 py-4 border-b border-slate-200/70">
    <div>
      <h3 class="font-display font-bold text-slate-800">Pesanan Terbaru</h3>
      <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-bolt text-amber-500"></i> Diperbarui langsung via Socket.IO</p>
    </div>
    <a href="<?= site_url('staff/orders') ?>" class="text-sm font-semibold text-teal-600 hover:text-teal-700">Lihat semua &rarr;</a>
  </div>

  <div class="overflow-x-auto scrollbar-thin">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-xs text-slate-500 uppercase tracking-wide border-b border-slate-200/70">
          <th class="px-5 lg:px-6 py-3 font-semibold">Pesanan</th>
          <th class="px-3 py-3 font-semibold">Pelanggan</th>
          <th class="px-3 py-3 font-semibold">Layanan</th>
          <th class="px-3 py-3 font-semibold">Berat</th>
          <th class="px-3 py-3 font-semibold">Total</th>
          <th class="px-3 py-3 font-semibold">Status</th>
          <th class="px-3 py-3 font-semibold text-right pr-5 lg:pr-6">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200/60">
        <?php
          $recent = $recentOrders ?? [
            ['code' => 'LF-2041', 'customer' => 'John Carter', 'service' => 'Cuci & Setrika', 'weight' => '4.2 kg', 'total' => 'Rp 157.500', 'status' => 'processing'],
            ['code' => 'LF-2040', 'customer' => 'Sarah Lin',   'service' => 'Kilat',          'weight' => '2.0 kg', 'total' => 'Rp 80.000',  'status' => 'ready'],
            ['code' => 'LF-2039', 'customer' => 'Marc Owens',  'service' => 'Reguler',        'weight' => '6.5 kg', 'total' => 'Rp 162.500', 'status' => 'completed'],
            ['code' => 'LF-2038', 'customer' => 'Aiko Tanaka', 'service' => 'Setrika Saja',   'weight' => '3.4 kg', 'total' => 'Rp 51.000',  'status' => 'pending'],
            ['code' => 'LF-2037', 'customer' => 'Diego Ruiz',  'service' => 'Cuci & Setrika', 'weight' => '5.1 kg', 'total' => 'Rp 178.500', 'status' => 'processing'],
          ];
          $statusLabel = [
            'pending' => ['Menunggu', 'badge-pending'],
            'processing' => ['Diproses', 'badge-processing'],
            'ready' => ['Siap Diambil', 'badge-ready'],
            'completed' => ['Selesai', 'badge-completed'],
          ];
        ?>
        <?php foreach ($recent as $o): [$label, $cls] = $statusLabel[$o['status']]; ?>
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
          <td class="px-3 py-3.5"><span class="badge <?= $cls ?>"><?= $label ?></span></td>
          <td class="px-3 py-3.5 text-right pr-5 lg:pr-6">
            <a href="<?= site_url('staff/processing') ?>" class="text-xs font-semibold text-teal-600 hover:text-teal-700 border border-teal-200 hover:bg-teal-50 px-3 py-1.5 rounded-lg transition">Perbarui</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
