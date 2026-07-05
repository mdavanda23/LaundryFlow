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
    $routes->get('new-order',      'CustomerController::newOrder');
    $routes->post('new-order',     'CustomerController::newOrder');
    $routes->get('payment/(:num)',  'CustomerController::payment/$1');
    $routes->post('payment/(:num)', 'CustomerController::processPayment/$1');
    $routes->get('payment-success/(:num)', 'CustomerController::paymentSuccess/$1'); // <-- baru
    $routes->get('track',          'CustomerController::track');
    $routes->get('history',        'CustomerController::history');
    $routes->get('notifications',  'CustomerController::notifications');

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

$routes->get('staff/login',  'Auth::staffLoginForm');
$routes->post('staff/login', 'Auth::staffLoginAction');
$routes->get('staff/logout', 'Auth::logout');

$routes->group('staff', ['namespace' => 'App\Controllers\Staff'], function ($routes) {
    $routes->get('/',                       'StaffController::index');
    $routes->get('orders',                  'StaffController::orders');
    $routes->post('orders/update-status',   'StaffController::updateStatus');
    $routes->get('processing',              'StaffController::processing');
    $routes->get('customers',               'StaffController::customers');
    $routes->get('notifications',           'StaffController::notifications');
    $routes->get('profile',                 'StaffController::profile');
    $routes->post('profile/edit',           'StaffController::profileEditPost');
    $routes->post('profile/change-password','StaffController::changePasswordPost');
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