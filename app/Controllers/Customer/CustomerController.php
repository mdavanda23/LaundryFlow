<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    protected CustomerModel $custModel;
    protected array $customer;

    public function __construct()
    {
        helper(['form', 'url']);

        if (! session()->has('customer')) {
            redirect()->to(site_url('customer/login'))->send();
            exit;
        }

        $this->custModel = new CustomerModel();

        $sess = session()->get('customer');

        $this->customer = $this->custModel->getByUserId((int) $sess['id']);

        if (! $this->customer) {
            throw new \RuntimeException(
                'Data customer tidak ditemukan. Pastikan tabel customers memiliki user_id yang sesuai.'
            );
        }
    }

    private function getCustomerId(): int
    {
        return (int) $this->customer['id'];
    }

    public function index()
    {
        $sess = session()->get('customer');

        $db = \Config\Database::connect();

        $currentOrder = $db->table('orders o')
            ->select('o.*, s.name as service_name')
            ->join('services s', 's.id = o.service_id')
            ->where('o.customer_id', $this->getCustomerId())
            ->whereNotIn('o.status', ['Completed', 'Cancelled'])
            ->orderBy('o.created_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        $recentOrders = $db->table('orders o')
            ->select('o.*, s.name as service_name')
            ->join('services s', 's.id = o.service_id')
            ->where('o.customer_id', $this->getCustomerId())
            ->orderBy('o.created_at', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();

        return view('customer/home', [
            'title'         => 'Home - LaundryFlow',
            'user'          => ['name' => $sess['name']],
            'current_order' => $currentOrder,
            'recent_orders' => $recentOrders,
            'promo' => [
                'text' => 'Get 25% off Express service',
                'code' => 'FRESH25',
            ],
        ]);
    }

    public function newOrder()
    {
        $db = \Config\Database::connect();

        $services = $db->table('services')
            ->where('status', 'active')
            ->orderBy('price_per_kg', 'ASC')
            ->get()
            ->getResultArray();

        // 🔥 PERBAIKAN: Menggunakan fungsi bawaan CI4 yang aman dari perbedaan huruf besar/kecil (case-insensitive)
        if ($this->request->is('post')) {
            $rules = [
                'service_id' => 'required|integer',
                'weight'     => 'required|numeric|greater_than[0]|less_than_equal_to[999.99]',
                'address'    => 'required|min_length[5]',
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $serviceId = (int) $this->request->getPost('service_id');
            $weight    = (float) $this->request->getPost('weight');
            $address   = $this->request->getPost('address');
            $notes     = $this->request->getPost('notes');

            $service = $db->table('services')
                ->where('id', $serviceId)
                ->where('status', 'active')
                ->get()
                ->getRowArray();

            if (! $service) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', ['service_id' => 'Layanan tidak ditemukan atau sudah tidak aktif.']);
            }

            $subtotal = $service['price_per_kg'] * $weight;
            $discount = 0.00;
            $total    = $subtotal - $discount;

            $invoice = 'INV-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));

            $db->table('orders')->insert([
                'invoice'        => $invoice,
                'customer_id'    => $this->getCustomerId(),
                'service_id'     => $serviceId,
                'weight'         => $weight,
                'pickup_address' => $address,
                'pickup_date'    => date('Y-m-d H:i:s'),
                'status'         => 'Diterima', 
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'total'          => $total,
                'notes'          => $notes,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

            $newOrderId = $db->insertID();

            $db->table('order_status_logs')->insert([
                'order_id'    => $newOrderId,
                'status'      => 'Diterima', 
                'description' => 'Order dibuat oleh customer',
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            // Di-redirect ke halaman payment sesuai routes: customer/payment/(:num)
            return redirect()->to(site_url('customer/payment/' . $newOrderId));
        }

        return view('customer/new_order', [
            'title'            => 'Buat Pesanan - LaundryFlow',
            'services'         => $services,
            'customer_address' => $this->customer['address'] ?? '',
        ]);
    }

    /**
     * Tampilkan halaman pembayaran untuk order tertentu
     */
    public function payment(int $orderId)
    {
        $db = \Config\Database::connect();

        $order = $db->table('orders o')
            ->select('o.*, s.name as service_name, s.icon as service_icon')
            ->join('services s', 's.id = o.service_id')
            ->where('o.id', $orderId)
            ->where('o.customer_id', $this->getCustomerId())
            ->get()
            ->getRowArray();

        if (! $order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order tidak ditemukan.');
        }

        // Cek apakah sudah pernah dibayar
        $existingPayment = $db->table('payments')
            ->where('order_id', $orderId)
            ->where('payment_status', 'Paid')
            ->get()
            ->getRowArray();

        if ($existingPayment) {
            return redirect()->to(site_url('customer/track'))
                ->with('info', 'Pesanan ini sudah dibayar.');
        }

        return view('customer/payment', [
            'title' => 'Pembayaran - LaundryFlow',
            'order' => $order,
        ]);
    }

   /**
 * Proses pembayaran
 */
public function processPayment(int $orderId)
{
    $db = \Config\Database::connect();

    $order = $db->table('orders')
        ->where('id', $orderId)
        ->where('customer_id', $this->getCustomerId())
        ->get()
        ->getRowArray();

    if (! $order) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Order tidak ditemukan.');
    }

    $rules = [
        'payment_method' => 'required|in_list[Cash,QRIS,Transfer]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()
            ->with('errors', $this->validator->getErrors());
    }

    $method = $this->request->getPost('payment_method');

    // Cash dibayar saat pickup -> status pembayaran Pending, selain itu langsung Paid (simulasi)
    $paymentStatus = $method === 'Cash' ? 'Pending' : 'Paid';
    $paidAt        = $method === 'Cash' ? null : date('Y-m-d H:i:s');

    $db->table('payments')->insert([
        'order_id'       => $orderId,
        'payment_method' => $method,
        'payment_status' => $paymentStatus,
        'amount'         => $order['total'],
        'paid_at'        => $paidAt,
        'created_at'     => date('Y-m-d H:i:s'),
    ]);

    // Status order TIDAK diubah di sini — tetap 'Diterima'.
    // Tahap laundry (Dicuci/Dikeringkan/Disetrika/dst) hanya diubah oleh staff dari dashboard mereka.
    // Cukup catat event pembayaran ke log, tanpa mengubah kolom status di tabel orders.
    $db->table('order_status_logs')->insert([
        'order_id'    => $orderId,
        'status'      => 'Diterima',
        'description' => $method === 'Cash'
            ? 'Pembayaran cash dipilih, dibayar saat pickup'
            : 'Pembayaran ' . $method . ' berhasil',
        'created_at'  => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to(site_url('customer/payment-success/' . $orderId))
        ->with('success', 'Pembayaran berhasil dikonfirmasi!');
}

    public function track()
    {
        $db = \Config\Database::connect();

        $order = $db->table('orders o')
            ->select('o.*, s.name as service_name')
            ->join('services s', 's.id = o.service_id')
            ->where('o.customer_id', $this->getCustomerId())
            ->whereNotIn('o.status', ['Completed', 'Cancelled'])
            ->orderBy('o.created_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        $logs = [];
        if ($order) {
            $logs = $db->table('order_status_logs')
                ->where('order_id', $order['id'])
                ->orderBy('created_at', 'ASC')
                ->get()
                ->getResultArray();
        }

        return view('customer/track', [
            'title' => 'Track - LaundryFlow',
            'order' => $order,
            'logs'  => $logs,
        ]);
    }

    public function history()
    {
        $db = \Config\Database::connect();

        $orders = $db->table('orders o')
            ->select('o.id,o.invoice,o.weight,o.status,o.total,o.created_at,s.name as service_name')
            ->join('services s','s.id=o.service_id')
            ->where('o.customer_id',$this->getCustomerId())
            ->orderBy('o.created_at','DESC')
            ->get()
            ->getResultArray();

        return view('customer/history',[
            'title'=>'Riwayat - LaundryFlow',
            'orders'=>$orders,
        ]);
    }

    public function notifications()
    {
        $db = \Config\Database::connect();

        $notifications = $db->table('notifications')
            ->where('customer_id',$this->getCustomerId())
            ->orderBy('created_at','DESC')
            ->get()
            ->getResultArray();

        $unreadCount = count(array_filter($notifications, fn($n)=>!$n['is_read']));

        return view('customer/notifications',[
            'title'=>'Notifikasi - LaundryFlow',
            'notifications'=>$notifications,
            'unread_count'=>$unreadCount,
        ]);
    }

/**
 * Halaman sukses setelah pembayaran/konfirmasi
 */
public function paymentSuccess(int $orderId)
{
    $db = \Config\Database::connect();

    $order = $db->table('orders o')
        ->select('o.*, s.name as service_name, s.icon as service_icon')
        ->join('services s', 's.id = o.service_id')
        ->where('o.id', $orderId)
        ->where('o.customer_id', $this->getCustomerId())
        ->get()
        ->getRowArray();

    if (! $order) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Order tidak ditemukan.');
    }

    $payment = $db->table('payments')
        ->where('order_id', $orderId)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getRowArray();

    if (! $payment) {
        // Belum ada pembayaran tercatat, jangan tampilkan halaman sukses
        return redirect()->to(site_url('customer/payment/' . $orderId));
    }

    // Gabungkan payment_method dari tabel payments ke $order
    $order['payment_method'] = $payment['payment_method'];

    return view('customer/payment_success', [
        'title' => 'Pembayaran Berhasil - LaundryFlow',
        'order' => $order,
    ]);
}
}
