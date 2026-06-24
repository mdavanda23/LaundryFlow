<?php

// Tambahkan baris ini ke dalam file app/Config/Routes.php kamu
// di dalam blok $routes->group() atau langsung di bawah $routes->get('/', ...)

$routes->group('customer', ['namespace' => 'App\Controllers\Customer'], function ($routes) {
    $routes->get('/',              'CustomerController::index');
    $routes->get('new-order',      'CustomerController::newOrder');
    $routes->post('new-order',   'CustomerController::storeOrder');   
    $routes->get('track',          'CustomerController::track');
    $routes->get('history',        'CustomerController::history');
    $routes->get('notifications', 'CustomerController::notifications');
});
