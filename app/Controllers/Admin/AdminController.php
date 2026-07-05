<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        if (!session()->has('admin')) {
            redirect()->to(site_url('admin/login'))->send();
            exit;
        }
    }

    // ── DASHBOARD ─────────────────────────────────────────────
    public function index()
    {
        $totalRevenue = $this->db->table('payments')
            ->selectSum('amount', 'total')
            ->where('payment_status', 'Paid')
            ->get()->getRowArray();

        $totalOrders = $this->db->table('orders')->countAllResults();

        $totalCustomers = $this->db->table('users')
            ->where('role_id', 3)->where('status', 'active')
            ->countAllResults();

        $activeStaff = $this->db->table('users')
            ->where('role_id', 2)->where('status', 'active')
            ->countAllResults();

        // Recent transactions
        $transactions = $this->db->table('payments p')
            ->select('p.*, o.invoice, u.name as customer_name, p.payment_method as method')
            ->join('orders o', 'o.id = p.order_id')
            ->join('customers c', 'c.id = o.customer_id')
            ->join('users u', 'u.id = c.user_id')
            ->where('p.payment_status', 'Paid')
            ->orderBy('p.paid_at', 'DESC')
            ->limit(8)
            ->get()->getResultArray();

        // Popular services
        $popularServices = $this->db->table('orders o')
            ->select('s.name, COUNT(o.id) as total')
            ->join('services s', 's.id = o.service_id')
            ->groupBy('o.service_id')
            ->orderBy('total', 'DESC')
            ->get()->getResultArray();

        return view('admin/dashboard', [
            'title'           => 'Dashboard - Admin',
            'total_revenue'   => $totalRevenue['total'] ?? 0,
            'total_orders'    => $totalOrders,
            'total_customers' => $totalCustomers,
            'active_staff'    => $activeStaff,
            'transactions'    => $transactions,
            'popular_services'=> $popularServices,
        ]);
    }

    // ── SERVICES ──────────────────────────────────────────────
    public function services()
    {
        $services = $this->db->table('services')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();

        return view('admin/services', [
            'title'    => 'Services - Admin',
            'services' => $services,
        ]);
    }

    public function serviceStore()
    {
        $this->db->table('services')->insert([
            'name'          => $this->request->getPost('name'),
            'description'   => $this->request->getPost('description'),
            'price_per_kg'  => $this->request->getPost('price_per_kg'),
            'duration'      => $this->request->getPost('duration'),
            'icon'          => $this->request->getPost('icon') ?: '🧺',
            'status'        => $this->request->getPost('status') ?: 'active',
        ]);

        return redirect()->to(site_url('admin/services'))
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function serviceUpdate($id)
    {
        $this->db->table('services')->where('id', $id)->update([
            'name'         => $this->request->getPost('name'),
            'description'  => $this->request->getPost('description'),
            'price_per_kg' => $this->request->getPost('price_per_kg'),
            'duration'     => $this->request->getPost('duration'),
            'icon'         => $this->request->getPost('icon'),
            'status'       => $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('admin/services'))
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function serviceDelete($id)
    {
        $this->db->table('services')->where('id', $id)->delete();
        return redirect()->to(site_url('admin/services'))
            ->with('success', 'Layanan berhasil dihapus.');
    }

    // ── LAUNDRY PRICES ────────────────────────────────────────
    public function prices()
    {
        $services = $this->db->table('services')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();

        return view('admin/prices', [
            'title'    => 'Laundry Prices - Admin',
            'services' => $services,
        ]);
    }

    public function priceUpdate($id)
    {
        $this->db->table('services')->where('id', $id)->update([
            'price_per_kg' => $this->request->getPost('price_per_kg'),
            'status'       => $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('admin/prices'))
            ->with('success', 'Harga berhasil diperbarui.');
    }

    // ── USERS ─────────────────────────────────────────────────
    public function users()
    {
        $filter = $this->request->getGet('role') ?? 'all';
        $search = $this->request->getGet('search');

        $query = $this->db->table('users u')
            ->select('u.*, r.name as role_name,
                (SELECT COUNT(*) FROM orders o JOIN customers c ON c.id = o.customer_id WHERE c.user_id = u.id) as total_orders')
            ->join('roles r', 'r.id = u.role_id')
           ->where('u.deleted_at', null);

        if ($filter === 'customers') $query->where('u.role_id', 3);
        elseif ($filter === 'staff')  $query->where('u.role_id', 2);
        elseif ($filter === 'admins') $query->where('u.role_id', 1);

        if ($search) {
            $query->groupStart()
                ->like('u.name', $search)
                ->orLike('u.email', $search)
                ->groupEnd();
        }

        $users = $query->orderBy('u.created_at', 'DESC')->get()->getResultArray();

        return view('admin/users', [
            'title'  => 'Users - Admin',
            'users'  => $users,
            'filter' => $filter,
            'search' => $search,
        ]);
    }

    public function userToggleStatus($id)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();
        $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
        $this->db->table('users')->where('id', $id)->update(['status' => $newStatus]);
        return redirect()->back()->with('success', 'Status user diperbarui.');
    }

    public function userDelete($id)
    {
        $this->db->table('users')->where('id', $id)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);
        return redirect()->to(site_url('admin/users'))
            ->with('success', 'User berhasil dihapus.');
    }

    // ── REPORTS ───────────────────────────────────────────────
    public function reports()
    {
        $totalRevenue = $this->db->table('payments')
            ->selectSum('amount','total')
            ->where('payment_status','Paid')
            ->get()->getRowArray();

        $avgOrder = $this->db->table('orders')
            ->selectAvg('total','avg')
            ->where('status','Completed')
            ->get()->getRowArray();

        $completedOrders = $this->db->table('orders')
            ->where('status','Completed')
            ->countAllResults();

        $cancelledOrders = $this->db->table('orders')
            ->where('status','Cancelled')
            ->countAllResults();

        $totalOrders = $this->db->table('orders')->countAllResults();
        $cancelRate  = $totalOrders > 0 ? round(($cancelledOrders/$totalOrders)*100, 1) : 0;

        // Revenue per layanan
        $revenueByService = $this->db->table('orders o')
            ->select('s.name, SUM(o.total) as total, COUNT(o.id) as count')
            ->join('services s', 's.id = o.service_id')
            ->where('o.status', 'Completed')
            ->groupBy('o.service_id')
            ->orderBy('total', 'DESC')
            ->get()->getResultArray();

        // Weekly orders (7 hari terakhir)
        $weeklyOrders = [];
        for ($i = 6; $i >= 0; $i--) {
            $date  = date('Y-m-d', strtotime("-$i days"));
            $count = $this->db->table('orders')
                ->where('DATE(created_at)', $date)
                ->countAllResults();
            $weeklyOrders[] = [
                'day'   => date('D', strtotime($date)),
                'count' => $count,
                'date'  => $date,
            ];
        }

        return view('admin/reports', [
            'title'              => 'Reports - Admin',
            'total_revenue'      => $totalRevenue['total'] ?? 0,
            'avg_order'          => $avgOrder['avg'] ?? 0,
            'completed_orders'   => $completedOrders,
            'cancel_rate'        => $cancelRate,
            'revenue_by_service' => $revenueByService,
            'weekly_orders'      => $weeklyOrders,
        ]);
    }

    // ── NOTIFICATIONS ─────────────────────────────────────────
    public function notifications()
    {
        $newOrders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, s.name as service_name')
            ->join('customers c', 'c.id = o.customer_id')
            ->join('users u', 'u.id = c.user_id')
            ->join('services s', 's.id = o.service_id')
            ->where('o.status', 'Pending')
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

        $pendingPayments = $this->db->table('payments p')
            ->select('p.*, o.invoice, u.name as customer_name')
            ->join('orders o', 'o.id = p.order_id')
            ->join('customers c', 'c.id = o.customer_id')
            ->join('users u', 'u.id = c.user_id')
            ->where('p.payment_status', 'Pending')
            ->orderBy('p.created_at', 'DESC')
            ->get()->getResultArray();

        return view('admin/notifications', [
            'title'            => 'Notifications - Admin',
            'new_orders'       => $newOrders,
            'ready_orders'     => $readyOrders,
            'pending_payments' => $pendingPayments,
        ]);
    }

    // ── SETTINGS ──────────────────────────────────────────────
    public function settings()
    {
        $settings = $this->db->table('settings')->where('id', 1)->get()->getRowArray();

        return view('admin/settings', [
            'title'    => 'Settings - Admin',
            'settings' => $settings,
        ]);
    }

    public function settingsUpdate()
    {
        $this->db->table('settings')->where('id', 1)->update([
            'shop_name' => $this->request->getPost('shop_name'),
            'address'   => $this->request->getPost('address'),
            'phone'     => $this->request->getPost('phone'),
            'email'     => $this->request->getPost('email'),
        ]);

        return redirect()->to(site_url('admin/settings'))
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}