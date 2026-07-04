<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Masuk' ?> · LaundryFlow</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
  tailwind.config = { theme: { extend: { fontFamily: {
    display: ['Poppins', 'sans-serif'], body: ['Inter', 'sans-serif'],
  } } } }
</script>

<style>
  body{ font-family:'Inter', sans-serif; }
  .font-display{ font-family:'Poppins', sans-serif; }
  .glass{
    background: rgba(255,255,255,.7);
    backdrop-filter: blur(18px) saturate(160%);
    -webkit-backdrop-filter: blur(18px) saturate(160%);
    border: 1px solid rgba(255,255,255,.6);
  }
  .brand-panel{
    background:
      radial-gradient(700px 420px at 15% 0%, rgba(45,212,191,.30), transparent 60%),
      radial-gradient(600px 500px at 100% 100%, rgba(99,102,241,.22), transparent 55%),
      linear-gradient(160deg, #042f2c 0%, #0d3c38 55%, #042f2c 100%);
  }
  .brand-panel.owner{
    background:
      radial-gradient(700px 420px at 15% 0%, rgba(129,140,248,.28), transparent 60%),
      radial-gradient(600px 500px at 100% 100%, rgba(45,212,191,.16), transparent 55%),
      linear-gradient(160deg, #0f172a 0%, #1e2440 55%, #0f172a 100%);
  }
  .input-field{
    width:100%; padding:.72rem .95rem; border-radius:.85rem;
    border:1px solid rgb(226 232 240); background: rgba(255,255,255,.85);
    font-size:.9rem; transition: all .15s ease;
  }
  .input-field:focus{ outline:none; box-shadow: 0 0 0 3px rgba(45,212,191,.35); border-color:#2dd4bf; }
  .input-field.owner-focus:focus{ box-shadow: 0 0 0 3px rgba(99,102,241,.35); border-color:#818cf8; }
</style>
</head>
<body class="min-h-screen bg-slate-100">

<div class="min-h-screen grid lg:grid-cols-2">

  <!-- ===== Panel kiri: branding ===== -->
  <div class="hidden lg:flex brand-panel <?= $ownerTheme ?? false ? 'owner' : '' ?> relative flex-col justify-between text-white p-10 xl:p-14 overflow-hidden">
    <div class="absolute -right-16 -bottom-20 w-72 h-72 rounded-full bg-white/5 blur-3xl"></div>

    <div class="flex items-center gap-2.5">
      <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-300 to-teal-500 flex items-center justify-center shadow-lg shadow-teal-500/30">
        <i class="fa-solid fa-shirt text-teal-950"></i>
      </div>
      <span class="font-display font-bold text-lg">LaundryFlow</span>
    </div>

    <div class="relative">
      <span class="inline-block text-xs font-semibold tracking-wide uppercase px-3 py-1 rounded-full bg-white/10 <?= $badgeTextColor ?? 'text-teal-200' ?> mb-4">
        <?= $brandBadge ?? 'Portal Pelanggan' ?>
      </span>
      <h1 class="font-display font-bold text-3xl xl:text-4xl leading-tight mb-3"><?= $brandHeading ?? 'Cucian bersih, tanpa ribet.' ?></h1>
      <p class="text-white/70 text-sm leading-relaxed max-w-sm"><?= $brandSubtext ?? 'Pantau status cucianmu secara real-time, dari antar sampai siap diambil, semua dalam satu tempat.' ?></p>

      <div class="flex items-center gap-4 mt-8">
        <?php foreach (($brandStats ?? [['value'=>'2.4k+','label'=>'Pesanan/bulan'], ['value'=>'98%','label'=>'Tepat waktu'], ['value'=>'4.9★','label'=>'Rating pelanggan']]) as $s): ?>
          <div>
            <p class="font-display font-bold text-xl"><?= $s['value'] ?></p>
            <p class="text-white/60 text-[11px]"><?= $s['label'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="relative text-white/40 text-xs">&copy; <?= date('Y') ?> LaundryFlow. Semua hak cipta dilindungi.</p>
  </div>

  <!-- ===== Panel kanan: form ===== -->
  <div class="flex items-center justify-center p-6 sm:p-10 bg-gradient-to-b from-slate-50 to-slate-100">
    <div class="w-full max-w-md">

      <div class="lg:hidden flex items-center gap-2.5 justify-center mb-8">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center shadow">
          <i class="fa-solid fa-shirt text-white text-sm"></i>
        </div>
        <span class="font-display font-bold text-lg text-slate-800">LaundryFlow</span>
      </div>

      <div class="glass rounded-3xl p-7 sm:p-9 shadow-xl shadow-slate-900/5">
        <?= $this->renderSection('content') ?>
      </div>

      <p class="text-center text-xs text-slate-400 mt-6">
        <?= $footerNote ?? 'Butuh bantuan? Hubungi Customer Service kami.' ?>
      </p>
    </div>
  </div>

</div>

</body>
</html>
