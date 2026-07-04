<?php
/**
 * Tambahkan blok route berikut ke dalam file app/Config/Routes.php
 * proyek CodeIgniter 4 kamu (gabungkan dengan route yang sudah ada,
 * jangan ganti seluruh file).
 */

// ---------------------------------------------------------------------
// AUTENTIKASI: register customer + 3 pintu login terpisah
// ---------------------------------------------------------------------
$routes->get('register',           'Auth::registerForm');
$routes->post('register',          'Auth::registerAction');

$routes->get('login',              'Auth::customerLoginForm');
$routes->post('login',             'Auth::customerLoginAction');

$routes->get('staff/login',        'Auth::staffLoginForm');
$routes->post('staff/login',       'Auth::staffLoginAction');

$routes->get('admin/login',        'Auth::ownerLoginForm');
$routes->post('admin/login',       'Auth::ownerLoginAction');

$routes->post('logout',            'Auth::logout'); // logout umum, dipakai semua role

// ---------------------------------------------------------------------
// PANEL STAF (setelah login role_id = 2)
// ---------------------------------------------------------------------
$routes->group('staff', ['namespace' => 'App\Controllers', 'filter' => 'auth-staff'], function ($routes) {
    $routes->get('/',                          'Staff::index');
    $routes->get('orders',                     'Staff::orders');
    $routes->get('processing',                 'Staff::processing');
    $routes->post('processing/update-stage',   'Staff::updateStage');
    $routes->get('customers',                  'Staff::customers');
    $routes->get('notifications',              'Staff::notifications');
    $routes->post('notifications/mark-all-read','Staff::markAllNotificationsRead');
    $routes->get('profile',                    'Staff::profile');
    $routes->post('profile/update',            'Staff::updateProfile');
    $routes->post('profile/change-password',   'Staff::changePassword');
});

// ---------------------------------------------------------------------
// PANEL ADMIN / OWNER (setelah login role_id = 1) — placeholder
// ---------------------------------------------------------------------
$routes->group('admin', ['namespace' => 'App\Controllers', 'filter' => 'auth-admin'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
});

// ---------------------------------------------------------------------
// AREA PELANGGAN (setelah login role_id = 3) — placeholder
// ---------------------------------------------------------------------
$routes->group('customer', ['namespace' => 'App\Controllers', 'filter' => 'auth-customer'], function ($routes) {
    $routes->get('dashboard', 'Customer::dashboard');
});

// Catatan:
// - 'auth-staff' adalah contoh nama filter otentikasi. Daftarkan filter ini
//   di app/Config/Filters.php dan arahkan ke middleware login staf kamu,
//   supaya semua halaman di atas hanya bisa diakses staf yang sudah login.
// - Jika belum punya filter otentikasi, sementara bisa dihapus dulu bagian
//   'filter' => 'auth-staff' di atas.
