<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // =====================================================
    // REGISTER CUSTOMER
    // =====================================================

    public function registerForm()
    {
        return view('auth/register');
    }

    public function registerAction()
    {
        $rules = $this->userModel->registrationRules();

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $insert = $this->userModel->registerCustomer([
            'name'     => $this->request->getPost('name'),
            'email'    => trim($this->request->getPost('email')),
            'phone'    => $this->request->getPost('phone'),
            'password' => $this->request->getPost('password'),
        ]);

        if (!$insert) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat akun.');
        }

        return redirect()->to(site_url('customer/login'))
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // =====================================================
    // LOGIN CUSTOMER
    // =====================================================

    public function customerLoginForm()
    {
        if (session()->has('customer')) {
            return redirect()->to(site_url('customer'));
        }

        return view('auth/login_customer');
    }

    public function customerLoginAction()
    {
        $user = $this->attemptLogin(UserModel::ROLE_CUSTOMER);

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password salah.');
        }

        session()->regenerate();

        session()->set('customer', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'photo' => $user['photo'],
        ]);

        return redirect()->to(site_url('customer'))
            ->with('success', 'Selamat datang, ' . $user['name']);
    }

    // =====================================================
    // LOGIN STAFF
    // =====================================================

    public function staffLoginForm()
    {
        if (session()->has('staff')) {
            return redirect()->to(site_url('staff'));
        }

        return view('auth/login_staff');
    }

    public function staffLoginAction()
    {
        $user = $this->attemptLogin(UserModel::ROLE_STAFF);

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password salah.');
        }

        session()->regenerate();

        session()->set('staff', [
            'id'     => $user['id'],
            'name'   => $user['name'],
            'email'  => $user['email'],
            'phone'  => $user['phone'],
            'photo'  => $user['photo'],
            'role'   => 'Staff Laundry',
            'shift'  => 'Pagi',
            'branch' => 'LaundryFlow',
        ]);

        return redirect()->to(site_url('staff'))
            ->with('success', 'Selamat datang, ' . $user['name']);
    }

    // =====================================================
    // LOGIN OWNER / ADMIN
    // =====================================================

    public function ownerLoginForm()
    {
        if (session()->has('admin')) {
            return redirect()->to(site_url('admin'));
        }

        return view('auth/login_owner');
    }

    public function ownerLoginAction()
    {
        $user = $this->attemptLogin(UserModel::ROLE_ADMIN);

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password salah.');
        }

        session()->regenerate();

        session()->set('admin', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'photo' => $user['photo'],
        ]);

        return redirect()->to(site_url('admin'))
            ->with('success', 'Selamat datang, ' . $user['name']);
    }

    // =====================================================
    // LOGOUT
    // =====================================================

    public function logout()
{
    if (session()->has('staff')) {
        session()->remove('staff');

        return redirect()->to(site_url('staff/login'))
            ->with('success', 'Berhasil logout.');
    }

    if (session()->has('admin')) {
        session()->remove('admin');

        return redirect()->to(site_url('admin/login'))
            ->with('success', 'Berhasil logout.');
    }

    if (session()->has('customer')) {
        session()->remove('customer');

        return redirect()->to(site_url('customer/login'))
            ->with('success', 'Berhasil logout.');
    }

    session()->destroy();

    return redirect()->to(site_url('/'));
}
}