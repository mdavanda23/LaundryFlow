<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;

class CustomerController extends BaseController
{
   public function index()
    {
        $sess      = session()->get('customer');
        $custModel = new \App\Models\CustomerModel();
        $customer  = $custModel->getByUserId((int) $sess['id']);

        // Ambil order aktif (bukan Completed/Cancelled)
        $db           = \Config\Database::connect();
        $currentOrder = $db->table('orders o')
            ->select('o.*, s.name as service_name')
            ->join('services s', 's.id = o.service_id')
            ->where('o.customer_id', $customer['id'])
            ->whereNotIn('o.status', ['Completed', 'Cancelled'])
            ->orderBy('o.created_at', 'DESC')
            ->limit(1)
            ->get()->getRowArray();

        // Ambil 3 order terbaru
        $recentOrders = $db->table('orders o')
            ->select('o.*, s.name as service_name')
            ->join('services s', 's.id = o.service_id')
            ->where('o.customer_id', $customer['id'])
            ->orderBy('o.created_at', 'DESC')
            ->limit(3)
            ->get()->getResultArray();

        $data = [
            'title'         => 'Home - LaundryFlow',
            'user'          => ['name' => $sess['name']],
            'current_order' => $currentOrder,
            'recent_orders' => $recentOrders,
            'promo'         => [
                'text' => 'Get 25% off Express service',
                'code' => 'FRESH25',
            ],
        ];

        return view('customer/home', $data);
    }
        
    // Tambah di __construct() CustomerController
    public function __construct()
    {
        helper(['form', 'url']);

        if (!session()->has('customer')) {
            redirect()->to(site_url('customer/login'))->send();
            exit;
        }
    }
    
    public function newOrder()
    {
        $sess      = session()->get('customer');
        $custModel = new \App\Models\CustomerModel();
        $customer  = $custModel->getByUserId($sess['id']);

        $db       = \Config\Database::connect();
        $services = $db->table('services')
            ->select('id, name, description, price_per_kg, duration, icon')  // ← eksplisit select id
            ->where('status', 'active')
            ->get()->getResultArray();

        return view('customer/new_order', [
            'title'            => 'Pesanan Baru - LaundryFlow',
            'services'         => $services,
            'customer_address' => $customer['address'] ?? '',
        ]);
    }

    public function track()
    {
        $data = [
            'title' => 'Track - LaundryFlow',
            'order' => [
                'id'       => '#LF-2041',
                'type'     => 'Wash & Iron',
                'weight'   => '4.2 kg',
                'progress' => 60,
                'finish'   => 'Today 4:30 PM',
            ],
            'steps' => [
                ['label' => 'Order received', 'time' => '10:24 AM', 'status' => 'done',   'sub' => ''],
                ['label' => 'Being washed',   'time' => '11:10 AM', 'status' => 'active', 'sub' => 'In progress · machine #3'],
                ['label' => 'Drying',         'time' => '',         'status' => 'pending','sub' => ''],
                ['label' => 'Ironing',        'time' => '',         'status' => 'pending','sub' => ''],
                ['label' => 'Ready for pickup','time' => '',        'status' => 'pending','sub' => ''],
                ['label' => 'Completed',      'time' => '',         'status' => 'pending','sub' => ''],
            ],
        ];

        return view('customer/track', $data);
    }

    public function history()
    {
        $customerId = $this->getCustomerId();
        $db         = \Config\Database::connect();

        $orders = $db->table('orders o')
            ->select('o.id, o.invoice, o.weight, o.status, o.total, o.created_at, s.name as service_name')
            ->join('services s', 's.id = o.service_id')
            ->where('o.customer_id', $customerId)
            ->orderBy('o.created_at', 'DESC')
            ->get()->getResultArray();

        return view('customer/history', [
            'title'  => 'Riwayat - LaundryFlow',
            'orders' => $orders,
        ]);
    }

    public function notifications()
    {
        $customerId = $this->getCustomerId();
        $db         = \Config\Database::connect();

        $notifications = $db->table('notifications')
            ->select('id, customer_id, title, message, is_read, created_at')  // ← eksplisit
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        $unreadCount = count(array_filter($notifications, fn($n) => !$n['is_read']));

        return view('customer/notifications', [
            'title'         => 'Notifikasi - LaundryFlow',
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }
}
