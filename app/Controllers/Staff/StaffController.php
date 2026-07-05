<?php
namespace App\Controllers\Staff;

use App\Controllers\BaseController;

class StaffController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        if (!session()->has('staff')) {
            redirect()->to(site_url('staff/login'))->send();
            exit;
        }
    }

    // ── DASHBOARD ────────────────────────────────────────────
    public function index()
    {
        $today = date('Y-m-d');

        $todayOrders = $this->db->table('orders')
            ->where('DATE(created_at)', $today)
            ->countAllResults();

        $inProgress = $this->db->table('orders')
            ->whereIn('status', ['Received','Washing','Drying','Ironing'])
            ->countAllResults();

        $completed = $this->db->table('orders')
            ->where('status', 'Completed')
            ->where('DATE(updated_at)', $today)
            ->countAllResults();

        $revenue = $this->db->table('orders o')
            ->selectSum('o.total', 'total')
            ->join('payments p', 'p.order_id = o.id')
            ->where('p.payment_status', 'Paid')
            ->where('DATE(p.paid_at)', $today)
            ->get()->getRowArray();

        $recentOrders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, s.name as service_name')
            ->join('customers c', 'c.id = o.customer_id')
            ->join('users u', 'u.id = c.user_id')
            ->join('services s', 's.id = o.service_id')
            ->orderBy('o.created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('staff/dashboard', [
            'title'        => 'Dashboard - Staff',
            'today_orders' => $todayOrders,
            'in_progress'  => $inProgress,
            'completed'    => $completed,
            'revenue'      => $revenue['total'] ?? 0,
            'recent_orders'=> $recentOrders,
        ]);
    }

    // ── ORDERS ────────────────────────────────────────────────
    public function orders()
    {
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $query = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, s.name as service_name')
            ->join('customers c', 'c.id = o.customer_id')
            ->join('users u', 'u.id = c.user_id')
            ->join('services s', 's.id = o.service_id');

        if ($search) {
            $query->groupStart()
                ->like('o.invoice', $search)
                ->orLike('u.name', $search)
                ->groupEnd();
        }

        if ($status) {
            $query->where('o.status', $status);
        }

        $orders = $query->orderBy('o.created_at', 'DESC')->get()->getResultArray();

        return view('staff/orders', [
            'title'   => 'Orders - Staff',
            'orders'  => $orders,
            'search'  => $search,
            'status'  => $status,
        ]);
    }



    // ── PROCESSING (KANBAN) ───────────────────────────────────
    public function processing()
    {
        $stages = ['Received','Washing','Drying','Ironing','Ready','Completed'];
        $board  = [];

        foreach ($stages as $stage) {
            $board[$stage] = $this->db->table('orders o')
                ->select('o.*, u.name as customer_name, s.name as service_name')
                ->join('customers c', 'c.id = o.customer_id')
                ->join('users u', 'u.id = c.user_id')
                ->join('services s', 's.id = o.service_id')
                ->where('o.status', $stage)
                ->orderBy('o.created_at', 'ASC')
                ->get()->getResultArray();
        }

        return view('staff/processing', [
            'title' => 'Processing Board - Staff',
            'board' => $board,
        ]);
    }

    // ── CUSTOMERS ─────────────────────────────────────────────
    public function customers()
    {
        $search = $this->request->getGet('search');

        $query = $this->db->table('customers c')
            ->select('c.*, u.name, u.email, u.phone, u.status, u.created_at as joined_at')
            ->join('users u', 'u.id = c.user_id');

        if ($search) {
            $query->groupStart()
                ->like('u.name', $search)
                ->orLike('u.email', $search)
                ->orLike('u.phone', $search)
                ->groupEnd();
        }

        $customers = $query->orderBy('u.name', 'ASC')->get()->getResultArray();

        // Hitung total order tiap customer
        foreach ($customers as &$cust) {
            $stat = $this->db->table('orders')
                ->select('COUNT(*) as total_orders, COALESCE(SUM(total),0) as total_spent')
                ->where('customer_id', $cust['id'])
                ->get()->getRowArray();
            $cust['total_orders'] = $stat['total_orders'] ?? 0;
            $cust['total_spent']  = $stat['total_spent']  ?? 0;
        }

        return view('staff/customers', [
            'title'     => 'Customers - Staff',
            'customers' => $customers,
            'search'    => $search,
        ]);
    }

    // ── NOTIFICATIONS ─────────────────────────────────────────
    public function notifications()
    {
        // Notifikasi = semua order pending/baru hari ini
        $newOrders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, s.name as service_name')
            ->join('customers c', 'c.id = o.customer_id')
            ->join('users u', 'u.id = c.user_id')
            ->join('services s', 's.id = o.service_id')
            ->whereIn('o.status', ['Pending', 'Received'])
            ->orderBy('o.created_at', 'DESC')
            ->get()->getResultArray();

        $readyOrders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, s.name as service_name')
            ->join('customers c', 'c.id = o.customer_id')
            ->join('users u', 'u.id = c.user_id')
            ->join('services s', 's.id = o.service_id')
            ->where('o.status', 'Ready')
            ->orderBy('o.updated_at', 'DESC')
            ->get()->getResultArray();

        return view('staff/notifications', [
            'title'       => 'Notifikasi - Staff',
            'new_orders'  => $newOrders,
            'ready_orders'=> $readyOrders,
        ]);
    }

    // ── PROFILE ───────────────────────────────────────────────
    public function profile()
    {
        $userId   = session()->get('staff')['id'];
        $userModel = new \App\Models\UserModel();
        $user     = $userModel->find($userId);

        // Statistik staff
        $totalHandled = $this->db->table('order_status_logs')
            ->where('description', 'Status diubah oleh staff')
            ->countAllResults();

        return view('staff/profile', [
            'title'         => 'Profile - Staff',
            'user'          => $user,
            'total_handled' => $totalHandled,
        ]);
    }

    public function profileEditPost()
    {
        $userId = session()->get('staff')['id'];
        $userModel = new \App\Models\UserModel();

        $userModel->update($userId, [
            'name'  => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
        ]);

        $sess         = session()->get('staff');
        $sess['name'] = $this->request->getPost('name');
        session()->set('staff', $sess);

        return redirect()->to(site_url('staff/profile'))
            ->with('success', 'Profile berhasil diperbarui.');
    }

    public function changePasswordPost()
    {
        $userId    = session()->get('staff')['id'];
        $userModel = new \App\Models\UserModel();
        $user      = $userModel->find($userId);

        if (!$userModel->verifyPassword(
            $this->request->getPost('current_password'),
            $user['password']
        )) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        $new = $this->request->getPost('new_password');
        if ($new !== $this->request->getPost('confirm_password')) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $userModel->update($userId, [
            'password' => password_hash($new, PASSWORD_DEFAULT),
        ]);

        return redirect()->to(site_url('staff/profile'))
            ->with('success', 'Password berhasil diubah.');
    }
    public function delete($id)
    {
        $order = $this->db->table('orders')->where('id', $id)->get()->getRowArray();

        if (!$order) {
            return redirect()->to('staff/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $this->db->table('orders')->where('id', $id)->delete();

        return redirect()->to('staff/orders')->with('success', 'Pesanan ' . $order['invoice'] . ' berhasil dihapus.');
    }
    public function updateStatus()
    {
        $orderId   = $this->request->getPost('order_id');
        $newStatus = $this->request->getPost('status');

        $allowed = ['Pending','Received','Washing','Drying','Ironing','Ready','Completed','Cancelled'];
        if (!in_array($newStatus, $allowed)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        // Ambil data order (untuk tau customer_id & invoice)
        $order = $this->db->table('orders')->where('id', $orderId)->get()->getRowArray();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $this->db->table('orders')->where('id', $orderId)->update(['status' => $newStatus]);

        // Catat ke log
        $this->db->table('order_status_logs')->insert([
            'order_id'    => $orderId,
            'status'      => $newStatus,
            'description' => 'Status diubah oleh staff',
        ]);

        // Buat pesan notifikasi sesuai status
        $messages = [
            'Received'  => 'Pesanan Anda telah diterima dan akan segera diproses.',
            'Washing'   => 'Pesanan Anda sedang dalam proses pencucian.',
            'Drying'    => 'Pesanan Anda sedang dalam proses pengeringan.',
            'Ironing'   => 'Pesanan Anda sedang disetrika.',
            'Ready'     => 'Pesanan Anda sudah siap diambil!',
            'Completed' => 'Pesanan Anda telah selesai. Terima kasih!',
            'Cancelled' => 'Pesanan Anda telah dibatalkan.',
        ];

        if (isset($messages[$newStatus])) {
            $this->db->table('notifications')->insert([
                'customer_id' => $order['customer_id'],
                'title'       => 'Update Pesanan ' . $order['invoice'],
                'message'     => $messages[$newStatus],
                'is_read'     => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}