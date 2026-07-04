<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Pelanggan · LaundryFlow</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
  body{
    font-family:'Inter', sans-serif;
    background:
      radial-gradient(1100px 500px at 8% -10%, rgba(45,212,191,.20), transparent 60%),
      linear-gradient(180deg, #f3f7f6 0%, #eef2f5 100%);
  }
  .font-display{ font-family:'Poppins', sans-serif; }
</style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 text-slate-800">
  <div class="max-w-md w-full text-center bg-white/70 backdrop-blur border border-white/60 rounded-3xl p-10 shadow-xl shadow-slate-900/5">
    <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= urlencode($customer['name']) ?>" class="w-16 h-16 rounded-full mx-auto bg-teal-100 border-4 border-white shadow mb-4" alt="Foto profil">
    <h1 class="font-display font-bold text-2xl mb-2">Halo, <?= esc($customer['name']) ?> 👋</h1>
    <p class="text-slate-500 text-sm mb-6">Kamu berhasil masuk sebagai pelanggan. Halaman ini masih placeholder — lanjutkan pengembangan riwayat pesanan dan pelacakan status cucian real-time di sini.</p>
    <form action="<?= site_url('logout') ?>" method="post">
      <?= csrf_field() ?>
      <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold py-2.5 rounded-xl transition">
        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
      </button>
    </form>
  </div>
</body>
</html>
