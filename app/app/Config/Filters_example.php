<?php
/**
 * CONTOH pendaftaran filter otentikasi untuk app/Config/Filters.php.
 * Ini BUKAN file lengkap Filters.php — gabungkan bagian yang relevan
 * ke dalam file Filters.php proyekmu yang sudah ada.
 *
 * Konsep filter (app/Filters/AuthStaffFilter.php, dst.) contohnya:
 *
 *   namespace App\Filters;
 *   use CodeIgniter\Filters\FilterInterface;
 *   use CodeIgniter\HTTP\RequestInterface;
 *   use CodeIgniter\HTTP\ResponseInterface;
 *
 *   class AuthStaffFilter implements FilterInterface
 *   {
 *       public function before(RequestInterface $request, $arguments = null)
 *       {
 *           if (! session()->get('staff')) {
 *               return redirect()->to(site_url('staff/login'))
 *                   ->with('error', 'Silakan masuk terlebih dahulu.');
 *           }
 *       }
 *
 *       public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
 *   }
 *
 * Buat juga AuthAdminFilter (cek session('admin')) dan
 * AuthCustomerFilter (cek session('customer')) dengan pola yang sama.
 *
 * Lalu daftarkan alias-nya di app/Config/Filters.php:
 *
 *   public array $aliases = [
 *       // ...alias bawaan CI4...
 *       'auth-staff'    => \App\Filters\AuthStaffFilter::class,
 *       'auth-admin'    => \App\Filters\AuthAdminFilter::class,
 *       'auth-customer' => \App\Filters\AuthCustomerFilter::class,
 *   ];
 *
 * Alias 'auth-staff', 'auth-admin', 'auth-customer' inilah yang dipakai
 * pada app/Config/Routes.php di project ini (lihat $routes->group(...)).
 */
