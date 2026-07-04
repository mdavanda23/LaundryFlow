<?= $this->extend('layouts/staff') ?>
<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
  <p class="text-sm text-slate-500"><i class="fa-solid fa-arrows-left-right text-teal-600"></i> Seret kartu antar kolom untuk memperbarui tahap proses cucian.</p>
  <div class="flex items-center gap-2 text-xs text-slate-500">
    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span> Tersambung real-time (Socket.IO)
  </div>
</div>

<div id="kanban" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
  <?php
    $columns = $columns ?? [
      'pending'  => ['label' => 'Menunggu',     'icon' => 'fa-hourglass-half', 'tone' => 'bg-amber-100 text-amber-700'],
      'washing'  => ['label' => 'Dicuci',       'icon' => 'fa-soap',           'tone' => 'bg-sky-100 text-sky-700'],
      'drying'   => ['label' => 'Dikeringkan',  'icon' => 'fa-wind',           'tone' => 'bg-cyan-100 text-cyan-700'],
      'ironing'  => ['label' => 'Disetrika',    'icon' => 'fa-fire-flame-simple','tone' => 'bg-indigo-100 text-indigo-700'],
      'ready'    => ['label' => 'Siap Diambil', 'icon' => 'fa-circle-check',   'tone' => 'bg-emerald-100 text-emerald-700'],
    ];
    $cards = $cards ?? [
      'pending' => [
        ['code'=>'LF-2038','customer'=>'Aiko Tanaka','service'=>'Setrika Saja','weight'=>'3.4 kg'],
        ['code'=>'LF-2035','customer'=>'Budi Santoso','service'=>'Kilat','weight'=>'1.8 kg'],
      ],
      'washing' => [
        ['code'=>'LF-2041','customer'=>'John Carter','service'=>'Cuci & Setrika','weight'=>'4.2 kg'],
        ['code'=>'LF-2037','customer'=>'Diego Ruiz','service'=>'Cuci & Setrika','weight'=>'5.1 kg'],
      ],
      'drying' => [
        ['code'=>'LF-2033','customer'=>'Rina Ayu','service'=>'Reguler','weight'=>'4.0 kg'],
      ],
      'ironing' => [
        ['code'=>'LF-2036','customer'=>'Nina Putri','service'=>'Reguler','weight'=>'3.0 kg'],
      ],
      'ready' => [
        ['code'=>'LF-2040','customer'=>'Sarah Lin','service'=>'Kilat','weight'=>'2.0 kg'],
        ['code'=>'LF-2039','customer'=>'Marc Owens','service'=>'Reguler','weight'=>'6.5 kg'],
      ],
    ];
  ?>
  <?php foreach ($columns as $key => $col): ?>
    <div class="glass rounded-2xl flex flex-col min-h-[420px]">
      <div class="flex items-center gap-2 px-4 py-3.5 border-b border-slate-200/70">
        <span class="w-7 h-7 rounded-lg <?= $col['tone'] ?> flex items-center justify-center"><i class="fa-solid <?= $col['icon'] ?> text-xs"></i></span>
        <h3 class="font-display font-semibold text-sm text-slate-700"><?= $col['label'] ?></h3>
        <span class="ml-auto text-xs font-semibold text-slate-400 bg-white/70 rounded-full px-2 py-0.5"><?= count($cards[$key] ?? []) ?></span>
      </div>
      <div class="kanban-col flex-1 p-3 space-y-3 overflow-y-auto scrollbar-thin" data-stage="<?= $key ?>" ondragover="event.preventDefault()" ondrop="dropCard(event, '<?= $key ?>')">
        <?php foreach (($cards[$key] ?? []) as $c): ?>
          <div class="kanban-card bg-white rounded-xl border border-slate-200/80 p-3 shadow-sm cursor-grab active:cursor-grabbing" draggable="true" ondragstart="dragCard(event)" data-code="<?= esc($c['code']) ?>">
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-xs font-bold text-teal-700">#<?= esc($c['code']) ?></span>
              <i class="fa-solid fa-grip-lines text-slate-300 text-xs"></i>
            </div>
            <p class="text-sm font-semibold text-slate-700"><?= esc($c['customer']) ?></p>
            <p class="text-xs text-slate-500 mt-0.5"><?= esc($c['service']) ?> &middot; <?= esc($c['weight']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
  // Demo drag & drop sederhana di sisi klien.
  // Saat produksi: kirim AJAX ke Staff::updateStage untuk menyimpan perubahan tahap ke database
  // dan pancarkan event Socket.IO agar dashboard lain ikut ter-update secara real-time.
  let draggedCard = null;

  function dragCard(e){
    draggedCard = e.target;
    e.dataTransfer.effectAllowed = 'move';
  }

  function dropCard(e, targetStage){
    e.preventDefault();
    if (!draggedCard) return;
    const targetCol = e.currentTarget;
    targetCol.appendChild(draggedCard);

    const orderCode = draggedCard.dataset.code;

    fetch("<?= site_url('staff/processing/update-stage') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ order_code: orderCode, stage: targetStage })
    }).catch(() => console.warn('Gagal menyimpan perubahan tahap, akan disinkronkan ulang.'));

    draggedCard = null;
  }
</script>

<?= $this->endSection() ?>
