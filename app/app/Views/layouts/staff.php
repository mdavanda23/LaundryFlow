<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Staff Dashboard' ?> · LaundryFlow</title>

<!-- Tailwind (CDN, hanya untuk keperluan demo tampilan. Untuk produksi sebaiknya build via CLI) -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          display: ['Poppins', 'sans-serif'],
          body: ['Inter', 'sans-serif'],
        },
        colors: {
          teal: {
            950: '#042f2c',
          }
        }
      }
    }
  }
</script>

<style>
  body{
    font-family:'Inter', sans-serif;
    background:
      radial-gradient(1100px 500px at 8% -10%, rgba(45,212,191,.20), transparent 60%),
      radial-gradient(900px 500px at 100% 0%, rgba(99,102,241,.14), transparent 55%),
      linear-gradient(180deg, #f3f7f6 0%, #eef2f5 100%);
    min-height:100vh;
  }
  .font-display{ font-family:'Poppins', sans-serif; }

  .glass{
    background: rgba(255,255,255,.65);
    backdrop-filter: blur(18px) saturate(160%);
    -webkit-backdrop-filter: blur(18px) saturate(160%);
    border: 1px solid rgba(255,255,255,.55);
  }
  .glass-dark{
    background: linear-gradient(160deg, rgba(4,47,44,.97), rgba(13,60,56,.94));
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
  }
  .nav-link{
    display:flex; align-items:center; gap:.75rem;
    padding:.65rem .9rem; border-radius:.9rem;
    color:rgba(240,253,250,.65);
    font-size:.875rem; font-weight:500;
    transition: all .18s ease;
  }
  .nav-link:hover{ background:rgba(255,255,255,.08); color:#fff; }
  .nav-link.active{
    background: linear-gradient(135deg, rgba(45,212,191,.95), rgba(20,184,166,.85));
    color:#042f2c; font-weight:700;
    box-shadow: 0 8px 20px -6px rgba(45,212,191,.55);
  }
  .badge{ font-size:.72rem; font-weight:600; padding:.2rem .6rem; border-radius:999px; white-space:nowrap; }
  .badge-pending{ background:#fef3c7; color:#92400e; }
  .badge-processing{ background:#dbeafe; color:#1e40af; }
  .badge-ready{ background:#e0e7ff; color:#4338ca; }
  .badge-completed{ background:#d1fae5; color:#065f46; }
  .scrollbar-thin::-webkit-scrollbar{ width:6px; height:6px; }
  .scrollbar-thin::-webkit-scrollbar-thumb{ background:#cbd5e1; border-radius:999px; }

  [x-cloak]{ display:none !important; }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
</head>
<body class="font-body text-slate-800">

<div class="flex min-h-screen">

  <!-- ============ SIDEBAR ============ -->
  <aside class="hidden lg:flex flex-col w-64 shrink-0 glass-dark text-white px-4 py-6 sticky top-0 h-screen">
    <div class="flex items-center gap-2 px-2 mb-8">
      <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-300 to-teal-500 flex items-center justify-center shadow-lg shadow-teal-500/30">
        <i class="fa-solid fa-shirt text-teal-950 text-sm"></i>
      </div>
      <div>
        <p class="font-display font-bold text-[15px] leading-none">LaundryFlow</p>
        <p class="text-[11px] text-teal-200/70 mt-1 tracking-wide">PANEL STAF</p>
      </div>
    </div>

    <?php
      $menu = [
        'dashboard'     => ['icon' => 'fa-gauge-high',       'label' => 'Dashboard'],
        'orders'        => ['icon' => 'fa-receipt',          'label' => 'Pesanan'],
        'processing'    => ['icon' => 'fa-arrows-spin',      'label' => 'Proses Cucian'],
        'customers'     => ['icon' => 'fa-users',            'label' => 'Pelanggan'],
        'notifications' => ['icon' => 'fa-bell',             'label' => 'Notifikasi'],
        'profile'       => ['icon' => 'fa-user-gear',        'label' => 'Profil Saya'],
      ];
      $active = $activeMenu ?? 'dashboard';
    ?>

    <nav class="flex-1 flex flex-col gap-1.5">
      <?php foreach ($menu as $key => $item): ?>
        <a href="<?= site_url('staff/' . ($key === 'dashboard' ? '' : $key)) ?>"
           class="nav-link <?= $active === $key ? 'active' : '' ?>">
          <i class="fa-solid <?= $item['icon'] ?> w-4 text-center"></i>
          <span><?= $item['label'] ?></span>
          <?php if ($key === 'notifications' && ($unreadNotifCount ?? 0) > 0): ?>
            <span class="ml-auto bg-rose-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center"><?= $unreadNotifCount ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="border-t border-white/10 pt-4 mt-4">
      <form action="<?= site_url('logout') ?>" method="post" onsubmit="return confirm('Yakin ingin keluar dari akun ini?');">
        <?= csrf_field() ?>
        <button type="submit" class="nav-link w-full text-rose-200 hover:bg-rose-500/20 hover:text-rose-100">
          <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
          <span>Keluar</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ============ MAIN ============ -->
  <div class="flex-1 flex flex-col min-w-0">

    <!-- TOPBAR -->
    <header class="glass sticky top-0 z-30 px-5 lg:px-8 py-3.5 flex items-center justify-between border-b border-white/40">
      <div class="flex items-center gap-3">
        <button class="lg:hidden w-9 h-9 rounded-lg bg-white/70 flex items-center justify-center border border-slate-200" onclick="document.getElementById('mobileNav').classList.toggle('hidden')">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div>
          <h1 class="font-display font-bold text-lg text-slate-800"><?= $pageTitle ?? 'Dashboard' ?></h1>
          <p class="text-xs text-slate-500 hidden sm:block"><?= $pageSubtitle ?? '' ?></p>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?= site_url('staff/notifications') ?>" class="relative w-9 h-9 rounded-full bg-white/70 border border-slate-200 flex items-center justify-center text-slate-600 hover:text-teal-600 transition">
          <i class="fa-regular fa-bell"></i>
          <?php if (($unreadNotifCount ?? 0) > 0): ?>
            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center"><?= $unreadNotifCount ?></span>
          <?php endif; ?>
        </a>
        <a href="<?= site_url('staff/profile') ?>" class="flex items-center gap-2 pl-3 border-l border-slate-300/60">
          <img src="https://api.dicebear.com/7.x/notionists/svg?seed=Maya" class="w-9 h-9 rounded-full bg-teal-100 border border-white shadow" alt="Foto profil">
          <div class="hidden md:block text-left">
            <p class="text-sm font-semibold leading-none text-slate-700"><?= $staffName ?? 'Maya Chen' ?></p>
            <p class="text-[11px] text-slate-500 mt-1">Staf Laundry</p>
          </div>
        </a>
      </div>
    </header>

    <!-- Mobile nav -->
    <div id="mobileNav" class="hidden lg:hidden glass-dark text-white p-4 space-y-1">
      <?php foreach ($menu as $key => $item): ?>
        <a href="<?= site_url('staff/' . ($key === 'dashboard' ? '' : $key)) ?>" class="nav-link <?= $active === $key ? 'active' : '' ?>">
          <i class="fa-solid <?= $item['icon'] ?> w-4 text-center"></i><span><?= $item['label'] ?></span>
        </a>
      <?php endforeach; ?>
      <form action="<?= site_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="nav-link w-full text-rose-200"><i class="fa-solid fa-right-from-bracket w-4 text-center"></i><span>Keluar</span></button>
      </form>
    </div>

    <main class="flex-1 px-5 lg:px-8 py-6">
      <?= $this->renderSection('content') ?>
    </main>

    <footer class="px-8 py-4 text-center text-xs text-slate-400">
      LaundryFlow &copy; <?= date('Y') ?> — Panel Staf, dibangun dengan CodeIgniter 4
    </footer>
  </div>
</div>

</body>
</html>
