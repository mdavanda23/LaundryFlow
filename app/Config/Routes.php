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
$routes->post('staff/orders/delete/(:num)', 'Staff\StaffController::delete/$1');

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

// ── Admin Auth ───────────────────────────────────────────────
$routes->get('admin/login',  'Auth::ownerLoginForm');
$routes->post('admin/login', 'Auth::ownerLoginAction');
$routes->get('admin/logout', 'Auth::logout');

// ── Admin Panel ──────────────────────────────────────────────
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/',                      'AdminController::index');
    $routes->get('services',               'AdminController::services');
    $routes->post('services',              'AdminController::serviceStore');
    $routes->post('services/update/(:num)','AdminController::serviceUpdate/$1');
    $routes->get('services/delete/(:num)', 'AdminController::serviceDelete/$1');
    $routes->get('prices',                 'AdminController::prices');
    $routes->post('prices/update/(:num)',  'AdminController::priceUpdate/$1');
    $routes->get('users',                  'AdminController::users');
    $routes->get('users/toggle/(:num)',    'AdminController::userToggleStatus/$1');
    $routes->get('users/delete/(:num)',    'AdminController::userDelete/$1');
    $routes->get('reports',                'AdminController::reports');
    $routes->get('notifications',          'AdminController::notifications');
    $routes->get('settings',               'AdminController::settings');
    $routes->post('settings',              'AdminController::settingsUpdate');
});