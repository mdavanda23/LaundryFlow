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
// ── Customer Auth ────────────────────────────────────────────
$routes->get('customer/login',    'Auth::customerLoginForm');
$routes->post('customer/login',   'Auth::customerLoginAction');
$routes->get('customer/register', 'Auth::registerForm');
$routes->post('customer/register','Auth::registerAction');
$routes->get('customer/logout',   'Auth::logout');

// ── Customer Dashboard (semua pakai namespace Customer) ──────
$routes->group('customer', ['namespace' => 'App\Controllers\Customer'], function ($routes) {
    $routes->get('/',              'CustomerController::index');
    $routes->get('new-order',     'CustomerController::newOrder');
    $routes->get('track',         'CustomerController::track');
    $routes->get('history',       'CustomerController::history');
    $routes->get('notifications', 'CustomerController::notifications');

    // Profile
    $routes->get('profile',                   'ProfileController::index');
    $routes->get('profile/edit',              'ProfileController::edit');
    $routes->post('profile/edit',             'ProfileController::editPost');
    $routes->get('profile/change-password',   'ProfileController::changePassword');
    $routes->post('profile/change-password',  'ProfileController::changePasswordPost');
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