<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CustomerModel;

class ProfileController extends BaseController
{
    protected UserModel $userModel;
    protected CustomerModel $customerModel;

    public function __construct()
    {
        $this->userModel     = new UserModel();
        $this->customerModel = new CustomerModel();

        // Guard: harus login sebagai customer
        if (!session()->has('customer')) {
            redirect()->to(site_url('customer/login'))->send();
            exit;
        }
    }

    // ----------------------------------------------------------------
    // PROFILE
    // ----------------------------------------------------------------

    public function index()
    {
        $userId   = session()->get('customer')['id'];
        $customer = $this->customerModel->getByUserId($userId);

        // Statistik order
        $db    = \Config\Database::connect();
        $stats = $db->table('orders')
            ->select('COUNT(*) as total_orders, COALESCE(SUM(total), 0) as total_spent')
            ->where('customer_id', $customer['id'])
            ->whereNotIn('status', ['Cancelled'])
            ->get()
            ->getRowArray();

        return view('customer/profile', [
            'customer'     => $customer,
            'total_orders' => $stats['total_orders'] ?? 0,
            'total_spent'  => $stats['total_spent']  ?? 0,
        ]);
    }

    // ----------------------------------------------------------------
    // EDIT PROFILE
    // ----------------------------------------------------------------

    public function edit()
    {
        $userId   = session()->get('customer')['id'];
        $customer = $this->customerModel->getByUserId($userId);

        return view('customer/edit_profile', [
            'customer' => $customer,
        ]);
    }

    public function editPost()
    {
        $rules = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'phone' => 'required|min_length[9]|max_length[20]',
            'email' => 'required|valid_email|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('customer')['id'];

        // Update tabel users
        $this->userModel->update($userId, [
            'name'  => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
        ]);

        // Update tabel customers
        $customer = $this->customerModel->where('user_id', $userId)->first();
        $this->customerModel->update($customer['id'], [
            'address'    => $this->request->getPost('address'),
            'gender'     => $this->request->getPost('gender'),
            'birth_date' => $this->request->getPost('birth_date') ?: null,
        ]);

        // Update session supaya nama langsung berubah
        $sessionData            = session()->get('customer');
        $sessionData['name']    = $this->request->getPost('name');
        $sessionData['email']   = $this->request->getPost('email');
        $sessionData['phone']   = $this->request->getPost('phone');
        session()->set('customer', $sessionData);

        return redirect()->to(site_url('customer/profile'))
            ->with('success', 'Profile berhasil diperbarui!');
    }

    // ----------------------------------------------------------------
    // CHANGE PASSWORD
    // ----------------------------------------------------------------

    public function changePassword()
    {
        return view('customer/change_password');
    }

    public function changePasswordPost()
    {
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('customer')['id'];
        $user   = $this->userModel->find($userId);

        if (!$this->userModel->verifyPassword(
            $this->request->getPost('current_password'),
            $user['password']
        )) {
            return redirect()->back()
                ->with('error', 'Password lama tidak sesuai.');
        }

        $this->userModel->update($userId, [
            'password' => password_hash(
                $this->request->getPost('new_password'),
                PASSWORD_DEFAULT
            ),
        ]);

        return redirect()->to(site_url('customer/profile'))
            ->with('success', 'Password berhasil diubah!');
    }
}