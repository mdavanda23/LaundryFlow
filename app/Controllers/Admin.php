<?php

namespace App\Controllers;

/**
 * Admin Controller (placeholder)
 * ------------------------------------------------------------------------
 * Halaman ini hanya contoh landing setelah login owner/admin berhasil.
 * Kembangkan lebih lanjut sesuai kebutuhan panel admin kamu
 * (manajemen staf, laporan omzet, manajemen cabang, dll).
 */
class Admin extends BaseController
{
    public function dashboard()
    {
        $admin = session()->get('admin');

        if (! $admin) {
            return redirect()->to(site_url('admin/login'));
        }

        return view('admin/dashboard', ['admin' => $admin]);
    }
}
