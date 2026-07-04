<?php

namespace App\Controllers;

/**
 * Customer Controller (placeholder)
 * ------------------------------------------------------------------------
 * Landing setelah login pelanggan berhasil. Kembangkan lebih lanjut untuk
 * menampilkan riwayat pesanan pelanggan, status cucian real-time, dsb.
 */
class Customer extends BaseController
{
    public function dashboard()
    {
        $customer = session()->get('customer');

        if (! $customer) {
            return redirect()->to(site_url('login'));
        }

        return view('customer/dashboard', ['customer' => $customer]);
    }
}
