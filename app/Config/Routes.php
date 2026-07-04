<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================================================
// LANDING PAGE
// ======================================================

$routes->get('/', 'LandingPage::index');


// ======================================================
// AUTH
// ======================================================

// Register Customer
$routes->get('customer/register', 'Auth::registerForm');
$routes->post('customer/register', 'Auth::registerAction');

// Login Customer
$routes->get('customer/login', 'Auth::customerLoginForm');
$routes->post('customer/login', 'Auth::customerLoginAction');

// Login Staff
$routes->get('staff/login', 'Auth::staffLoginForm');
$routes->post('staff/login', 'Auth::staffLoginAction');

// Login Admin / Owner
$routes->get('admin/login', 'Auth::ownerLoginForm');
$routes->post('admin/login', 'Auth::ownerLoginAction');


// ======================================================
// CUSTOMER
// ======================================================

$routes->group('customer', [
    'namespace' => 'App\Controllers\Customer',
    // 'filter' => 'auth-customer',
], function ($routes) {

    // Logout
    $routes->post('logout', '\App\Controllers\Auth::logout');

    // Dashboard
    $routes->get('/', 'CustomerController::index');

    // Pesanan Baru
    $routes->get('new-order', 'CustomerController::newOrder');
    $routes->post('new-order', 'CustomerController::storeOrder');

    // Tracking
    $routes->get('track', 'CustomerController::track');

    // Riwayat
    $routes->get('history', 'CustomerController::history');

    // Notifikasi
    $routes->get('notifications', 'CustomerController::notifications');

    // Profil
    $routes->get('profile', 'CustomerController::profile');
    $routes->post('profile/update', 'CustomerController::updateProfile');
});


// ======================================================
// STAFF
// ======================================================

$routes->group('staff', [
    'namespace' => 'App\Controllers',
    // 'filter' => 'auth-staff',
], function ($routes) {

    // Logout
    $routes->post('logout', 'Auth::logout');

    // Dashboard
    $routes->get('/', 'Staff::index');

    // Pesanan
    $routes->get('orders', 'Staff::orders');

    // Proses Laundry
    $routes->get('processing', 'Staff::processing');
    $routes->post('processing/update-stage', 'Staff::updateStage');

    // Pelanggan
    $routes->get('customers', 'Staff::customers');

    // Notifikasi
    $routes->get('notifications', 'Staff::notifications');
    $routes->post('notifications/mark-all-read', 'Staff::markAllNotificationsRead');

    // Profil
    $routes->get('profile', 'Staff::profile');
    $routes->post('profile/update', 'Staff::updateProfile');
    $routes->post('profile/change-password', 'Staff::changePassword');
});


// ======================================================
// ADMIN / OWNER
// ======================================================

$routes->group('admin', [
    'namespace' => 'App\Controllers',
    // 'filter' => 'auth-admin',
], function ($routes) {

    // Logout
    $routes->post('logout', 'Auth::logout');

    // Dashboard
    $routes->get('/', 'Admin::index');
    $routes->get('dashboard', 'Admin::dashboard');

    // User Management
    $routes->get('users', 'Admin::users');

    // Staff Management
    $routes->get('staff', 'Admin::staff');

    // Customer Management
    $routes->get('customers', 'Admin::customers');

    // Laporan
    $routes->get('reports', 'Admin::reports');

    // Pengaturan
    $routes->get('settings', 'Admin::settings');
});