<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Staff Controller
 * ------------------------------------------------------------------------
 * Menangani seluruh halaman pada panel staf LaundryFlow:
 * dashboard, pesanan, proses cucian (kanban), pelanggan, notifikasi,
 * profil, dan logout.
 *
 * Catatan implementasi:
 * - Data pada method di bawah masih berupa contoh statis (dummy) agar
 *   tampilan bisa langsung dilihat. Ganti dengan pemanggilan Model
 *   (mis. OrderModel, CustomerModel, NotificationModel) sesuai skema
 *   database yang dipakai pada proyek CI4 kamu.
 * - Middleware/filter otentikasi staf sebaiknya didaftarkan pada
 *   app/Config/Filters.php agar seluruh route 'staff/*' wajib login.
 */
class Staff extends BaseController
{
    /**
     * Data staf yang sedang login.
     * Ganti dengan session('staff') / auth()->user() sesuai sistem login kamu.
     */
    protected function currentStaff(): array
    {
        return session()->get('staff') ?? [
            'name'  => 'Maya Chen',
            'role'  => 'Staf Laundry',
            'email' => 'maya.chen@laundryflow.id',
            'phone' => '0812-9988-7766',
            'shift' => 'Pagi (07.00 - 15.00)',
            'branch'=> 'Cabang Bandung Kota',
        ];
    }

    /**
     * Data umum yang dipakai di semua halaman (untuk sidebar & topbar).
     */
    protected function sharedData(string $activeMenu, string $pageTitle, string $pageSubtitle = ''): array
    {
        $staff = $this->currentStaff();

        return [
            'activeMenu'       => $activeMenu,
            'pageTitle'        => $pageTitle,
            'pageSubtitle'     => $pageSubtitle,
            'staffName'        => $staff['name'],
            'unreadNotifCount' => 3, // TODO: ganti dengan NotificationModel::countUnread(staffId)
        ];
    }

    /**
     * GET /staff  ->  Dashboard utama staf.
     */
    public function index()
    {
        $data = array_merge(
            $this->sharedData('dashboard', 'Dashboard', 'Ringkasan aktivitas laundry hari ini'),
            [
                'stats' => [
                    'today_orders' => 48,
                    'in_progress'  => 16,
                    'completed'    => 29,
                    'revenue'      => 1284000,
                    'pending'      => 12,
                ],
                // 'recentOrders' => $this->orderModel->getRecent(5),
            ]
        );

        return view('staff/dashboard', $data);
    }

    /**
     * GET /staff/orders  ->  Daftar seluruh pesanan dengan filter & pencarian.
     */
    public function orders()
    {
        $status = $this->request->getGet('status') ?? 'all';
        $query  = $this->request->getGet('q');

        $data = array_merge(
            $this->sharedData('orders', 'Pesanan', 'Kelola seluruh pesanan pelanggan'),
            [
                'activeFilter' => $status,
                'searchQuery'  => $query,
                // 'orders' => $this->orderModel->filter($status, $query),
            ]
        );

        return view('staff/orders', $data);
    }

    /**
     * GET /staff/processing  ->  Papan kanban proses cucian.
     */
    public function processing()
    {
        $data = $this->sharedData('processing', 'Proses Cucian', 'Pantau tahapan cucian secara real-time');

        return view('staff/processing', $data);
    }

    /**
     * POST /staff/processing/update-stage  ->  Dipanggil via AJAX saat kartu dipindah kolom.
     * Simpan perubahan ke database lalu broadcast lewat Socket.IO (Node.js).
     */
    public function updateStage()
    {
        $payload   = $this->request->getJSON(true);
        $orderCode = $payload['order_code'] ?? null;
        $stage     = $payload['stage'] ?? null;

        if (!$orderCode || !$stage) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak lengkap'])->setStatusCode(422);
        }

        // TODO: $this->orderModel->updateStage($orderCode, $stage);
        // TODO: emit event socket.io "order:stage_updated" ke server Node.js

        return $this->response->setJSON([
            'success' => true,
            'message' => "Pesanan {$orderCode} dipindahkan ke tahap {$stage}",
        ]);
    }

    /**
     * GET /staff/customers  ->  Daftar pelanggan.
     */
    public function customers()
    {
        $data = array_merge(
            $this->sharedData('customers', 'Pelanggan', 'Data dan riwayat pelanggan LaundryFlow'),
            [
                'customerStats' => [
                    'total'     => 214,
                    'new_month' => 18,
                    'active'    => 96,
                ],
                // 'customers' => $this->customerModel->paginate(10),
            ]
        );

        return view('staff/customers', $data);
    }

    /**
     * GET /staff/notifications  ->  Daftar notifikasi staf.
     */
    public function notifications()
    {
        $data = $this->sharedData('notifications', 'Notifikasi', 'Pemberitahuan terbaru untuk kamu');

        return view('staff/notifications', $data);
    }

    /**
     * POST /staff/notifications/mark-all-read
     */
    public function markAllNotificationsRead()
    {
        // TODO: $this->notificationModel->markAllRead(staffId);

        return redirect()->to(site_url('staff/notifications'))
            ->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }

    /**
     * GET /staff/profile  ->  Halaman profil staf.
     */
    public function profile()
    {
        $data = array_merge(
            $this->sharedData('profile', 'Profil Saya', 'Kelola informasi akun dan kata sandi'),
            ['profile' => $this->currentStaff()]
        );

        return view('staff/profile', $data);
    }

    /**
     * POST /staff/profile/update  ->  Perbarui data profil.
     */
    public function updateProfile()
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // TODO: $this->staffModel->update(staffId, $this->request->getPost(['name','email','phone','shift']));

        return redirect()->to(site_url('staff/profile'))
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * POST /staff/profile/change-password
     */
    public function changePassword()
    {
        $rules = [
            'current_password'     => 'required',
            'new_password'         => 'required|min_length[8]',
            'new_password_confirm' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // TODO: verifikasi current_password, lalu simpan hash password baru

        return redirect()->to(site_url('staff/profile'))
            ->with('success', 'Kata sandi berhasil diperbarui.');
    }

    // Catatan: logout ditangani secara terpusat oleh Auth::logout()
    // (lihat app/Controllers/Auth.php dan route POST /logout),
    // supaya satu logic dipakai untuk staf, owner, maupun pelanggan.
}
