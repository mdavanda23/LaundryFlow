<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Admin · LaundryFlow</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
  body{ font-family:'Inter', sans-serif; background:#0f172a; }
  .font-display{ font-family:'Poppins', sans-serif; }
</style>
</head>
<body class="min-h-screen text-white flex items-center justify-center p-6">
  <div class="max-w-md w-full text-center bg-white/5 border border-white/10 rounded-3xl p-10 backdrop-blur">
    <div class="w-14 h-14 rounded-2xl bg-indigo-500/20 flex items-center justify-center mx-auto mb-5">
      <i class="fa-solid fa-shield-halved text-indigo-300 text-xl"></i>
    </div>
    <h1 class="font-display font-bold text-2xl mb-2">Selamat datang, <?= esc($admin['name']) ?> 👋</h1>
    <p class="text-white/60 text-sm mb-6">Kamu berhasil masuk ke Panel Admin LaundryFlow. Halaman ini masih placeholder — lanjutkan pengembangan modul manajemen staf, cabang, dan laporan di sini.</p>
    <form action="<?= site_url('logout') ?>" method="post">
      <?= csrf_field() ?>
      <button type="submit" class="w-full bg-white/10 hover:bg-white/15 text-white text-sm font-semibold py-2.5 rounded-xl transition">
        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
      </button>
    </form>
  </div>
</body>
</html>
