<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LaundryFlow — Manajemen Laundry Modern</title>
  <link rel="stylesheet" href="<?= base_url('css/landing.css') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <header class="navbar" id="navbar">
    <div class="navbar__container">
      <a href="#" class="navbar__brand">
        <div class="navbar__logo">
          <svg width="24" height="24" viewBox="0 0 52 52" fill="none">
            <rect x="4" y="6" width="44" height="40" rx="5" fill="white" fill-opacity="0.15" stroke="white" stroke-width="1.5"/>
            <rect x="4" y="6" width="44" height="10" rx="5" fill="white" fill-opacity="0.2"/>
            <circle cx="13" cy="11" r="2.5" fill="white" fill-opacity="0.8"/>
            <circle cx="21" cy="11" r="2.5" fill="white" fill-opacity="0.8"/>
            <circle cx="26" cy="30" r="14" fill="white" fill-opacity="0.12" stroke="white" stroke-width="1.5"/>
            <circle cx="26" cy="30" r="10" fill="white" fill-opacity="0.08" stroke="white" stroke-width="1"/>
            <g class="logo-spin">
              <circle cx="26" cy="21" r="2.8" fill="white" fill-opacity="0.65"/>
              <circle cx="35" cy="30" r="2.8" fill="white" fill-opacity="0.65"/>
              <circle cx="26" cy="39" r="2.8" fill="white" fill-opacity="0.65"/>
              <circle cx="17" cy="30" r="2.8" fill="white" fill-opacity="0.65"/>
            </g>
            <circle cx="26" cy="30" r="3.5" fill="white" fill-opacity="0.75"/>
          </svg>
        </div>
        <span><strong>Laundry</strong><span class="navbar__accent">Flow</span></span>
      </a>

      <button class="navbar__toggle" id="navToggle" aria-label="Buka menu">
        <span></span><span></span><span></span>
      </button>

      <nav class="navbar__nav" id="navMenu">
        <a href="#fitur" class="navbar__link">Fitur</a>
        <a href="#teknologi" class="navbar__link">Teknologi</a>
      </nav>

      <a href="<?= base_url('customer/') ?>" class="navbar__cta">Masuk →</a>
    </div>
  </header>

  <!-- ===== HERO ===== -->
  <section class="hero">
    <div class="hero__container">
      <div class="hero__badge">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        Manajemen laundry modern, dirancang ulang
      </div>

      <h1 class="hero__title">
        Cara terbaik kelola <span class="hero__accent">bisnis laundry</span> kamu.
      </h1>

      <p class="hero__sub">
        Aplikasi pelanggan yang cantik, dasbor staf real-time, dan analitik admin<br class="hero__br"/>
        yang powerful — semua dalam satu platform elegan.
      </p>

      <div class="hero__actions">
        <a href="<?= base_url('customer') ?>" class="btn btn--primary">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
          Coba Aplikasi Pelanggan
        </a>
      </div>
    </div>

    <!-- Socket badge card -->
    <div class="hero__socket-card">
      <div class="hero__socket-icon">
        <svg width="56" height="56" viewBox="0 0 52 52" fill="none">
          <rect x="4" y="6" width="44" height="40" rx="5" fill="white" fill-opacity="0.15" stroke="white" stroke-width="1.5"/>
          <rect x="4" y="6" width="44" height="10" rx="5" fill="white" fill-opacity="0.2"/>
          <circle cx="13" cy="11" r="2.5" fill="white" fill-opacity="0.8"/>
          <circle cx="21" cy="11" r="2.5" fill="white" fill-opacity="0.8"/>
          <circle cx="26" cy="30" r="14" fill="white" fill-opacity="0.12" stroke="white" stroke-width="1.5"/>
          <circle cx="26" cy="30" r="10" fill="white" fill-opacity="0.08" stroke="white" stroke-width="1"/>
          <g class="logo-spin">
            <circle cx="26" cy="20" r="3" fill="white" fill-opacity="0.65"/>
            <circle cx="36" cy="30" r="3" fill="white" fill-opacity="0.65"/>
            <circle cx="26" cy="40" r="3" fill="white" fill-opacity="0.65"/>
            <circle cx="16" cy="30" r="3" fill="white" fill-opacity="0.65"/>
          </g>
          <circle cx="26" cy="30" r="4" fill="white" fill-opacity="0.75"/>
        </svg>
      </div>
      <p class="hero__socket-label">Pelacakan pesanan real-time · Didukung Socket.IO</p>
    </div>
  </section>

  <!-- ===== FITUR ===== -->
  <section class="features" id="fitur">
    <div class="features__container">
      <div class="features__header">
        <span class="features__eyebrow">Semua yang kamu butuhkan</span>
        <h2 class="features__title">Fitur canggih,<br/>dirancang untuk laundry</h2>
      </div>

      <div class="features__grid">
        <div class="feature-item">
          <div class="feature-item__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <h4 class="feature-item__title">Pelacakan Real-time</h4>
          <p class="feature-item__desc">Update status pesanan langsung via Socket.IO. Pelanggan selalu tahu di mana cucian mereka berada.</p>
        </div>

        <div class="feature-item">
          <div class="feature-item__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
          </div>
          <h4 class="feature-item__title">Papan Kanban</h4>
          <p class="feature-item__desc">Staf kelola pesanan dengan kanban drag-and-drop. Dari diterima hingga selesai — divisualisasikan dengan jelas.</p>
        </div>

        <div class="feature-item">
          <div class="feature-item__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          </div>
          <h4 class="feature-item__title">Analitik Admin</h4>
          <p class="feature-item__desc">Grafik pendapatan, tren pesanan, dan laporan pengguna — semua dalam dasbor admin yang bersih.</p>
        </div>

        <div class="feature-item">
          <div class="feature-item__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
          </div>
          <h4 class="feature-item__title">Kelola Layanan</h4>
          <p class="feature-item__desc">Atur jenis layanan, harga, dan paket. Kontrol penuh dari panel admin.</p>
        </div>

        <div class="feature-item">
          <div class="feature-item__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18C1.62 2.09 2.5 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.57a16 16 0 0 0 6 6l.94-.94a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </div>
          <h4 class="feature-item__title">Notifikasi Otomatis</h4>
          <p class="feature-item__desc">Notifikasi status otomatis agar pelanggan selalu terinformasi di setiap tahap proses cucian.</p>
        </div>

        <div class="feature-item">
          <div class="feature-item__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <h4 class="feature-item__title">Akses Berbasis Peran</h4>
          <p class="feature-item__desc">Tiga antarmuka terpisah untuk pelanggan, staf, dan admin. Masing-masing hanya melihat apa yang mereka butuhkan.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== TEKNOLOGI ===== -->
  <section class="tech" id="teknologi">
    <div class="tech__container">
      <p class="tech__label">Dibangun dengan teknologi modern</p>
      <div class="tech__badges">
        <span class="tech__badge">CodeIgniter 4</span>
        <span class="tech__badge">MySQL</span>
        <span class="tech__badge">Node.js</span>
        <span class="tech__badge">Socket.IO</span>
        <span class="tech__badge">REST API</span>
      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <div class="footer__container">
      <div class="footer__brand">
        <div class="footer__logo">
          <svg width="20" height="20" viewBox="0 0 52 52" fill="none">
            <rect x="4" y="6" width="44" height="40" rx="5" fill="white" fill-opacity="0.15" stroke="white" stroke-width="1.5"/>
            <rect x="4" y="6" width="44" height="10" rx="5" fill="white" fill-opacity="0.2"/>
            <circle cx="13" cy="11" r="2.5" fill="white" fill-opacity="0.8"/>
            <circle cx="26" cy="30" r="14" fill="white" fill-opacity="0.12" stroke="white" stroke-width="1.5"/>
            <g class="logo-spin">
              <circle cx="26" cy="21" r="2.8" fill="white" fill-opacity="0.65"/>
              <circle cx="35" cy="30" r="2.8" fill="white" fill-opacity="0.65"/>
              <circle cx="26" cy="39" r="2.8" fill="white" fill-opacity="0.65"/>
              <circle cx="17" cy="30" r="2.8" fill="white" fill-opacity="0.65"/>
            </g>
            <circle cx="26" cy="30" r="3.5" fill="white" fill-opacity="0.75"/>
          </svg>
        </div>
        <span><strong>Laundry</strong><span class="footer__accent">Flow</span></span>
      </div>
      <p class="footer__copy">Dibangun dengan CodeIgniter 4 · MySQL · Node.js Socket.IO · LaundryFlow © <?= date('Y') ?></p>
    </div>
  </footer>

  <script>
    // Navbar scroll effect — smooth transition
    const navbar = document.getElementById('navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
      const currentScroll = window.scrollY;
      if (currentScroll > 10) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
      lastScroll = currentScroll;
    }, { passive: true });

    // Hamburger toggle
    const toggle = document.getElementById('navToggle');
    const menu = document.getElementById('navMenu');
    toggle.addEventListener('click', () => {
      menu.classList.toggle('navbar__nav--open');
      toggle.classList.toggle('navbar__toggle--active');
    });

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          e.preventDefault();
          menu.classList.remove('navbar__nav--open');
          toggle.classList.remove('navbar__toggle--active');
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  </script>
</body>
</html>