<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;

class CustomerController extends BaseController
{
    public function index()
    {
        $data = [
            'title'        => 'Home - LaundryFlow',
            'user'         => ['name' => 'Ramdan Moo'],
            'current_order' => [
                'id'       => '#LF-2041',
                'status'   => 'Washing',
                'progress' => 60,
                'finish'   => 'Today · 4:30 PM',
            ],
            'recent_orders' => [
                ['id' => '#LF-2041', 'type' => 'Wash & Iron', 'weight' => '4.2kg', 'date' => 'Today',     'status' => 'Processing'],
                ['id' => '#LF-2039', 'type' => 'Express',     'weight' => '2.0kg', 'date' => 'Yesterday', 'status' => 'Ready'],
                ['id' => '#LF-2032', 'type' => 'Regular',     'weight' => '6.5kg', 'date' => '12 Jun',    'status' => 'Completed'],
            ],
            'promo' => [
                'text' => 'Get 25% off Express service',
                'code' => 'FRESH25',
            ],
        ];

        return view('customer/home', $data);
    }
    
    public function __construct()
    {
        helper(['form', 'url']);
    }
    
    public function newOrder()
    {
        $data = [
            'title'    => 'New order - LaundryFlow',
            'services' => [
                ['key' => 'regular',   'label' => 'Regular',    'desc' => 'Standard wash · 24h',  'price' => '$2.5/kg', 'icon' => '👕'],
                ['key' => 'express',   'label' => 'Express',    'desc' => 'Ready in 6 hours',     'price' => '$4.0/kg', 'icon' => '⚡'],
                ['key' => 'wash_iron', 'label' => 'Wash & Iron','desc' => 'Cleaned + pressed',    'price' => '$3.5/kg', 'icon' => '✨'],
                ['key' => 'iron_only', 'label' => 'Iron Only',  'desc' => 'Crisp & wrinkle-free', 'price' => '$1.5/kg', 'icon' => '🔥'],
            ],
        ];

        return view('customer/new_order', $data);
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
        $data = [
            'title'  => 'History - LaundryFlow',
            'orders' => [
                ['inv' => 'INV-2041', 'type' => 'Wash & Iron', 'date' => 'Today',    'total' => '$15.75', 'status' => 'Processing'],
                ['inv' => 'INV-2039', 'type' => 'Express',     'date' => 'Yesterday','total' => '$18.40', 'status' => 'Ready'],
                ['inv' => 'INV-2032', 'type' => 'Regular',     'date' => '12 Jun',   'total' => '$22.10', 'status' => 'Completed'],
                ['inv' => 'INV-2028', 'type' => 'Iron Only',   'date' => '08 Jun',   'total' => '$9.00',  'status' => 'Completed'],
                ['inv' => 'INV-2021', 'type' => 'Wash & Iron', 'date' => '03 Jun',   'total' => '$14.50', 'status' => 'Cancelled'],
            ],
        ];

        return view('customer/history', $data);
    }

    public function notifications()
    {
        $data = [
            'title'         => 'Notifications - LaundryFlow',
            'unread_count'  => 2,
            'notifications' => [
                ['icon' => 'wash',    'title' => 'Laundry is now washing', 'desc' => 'Order #LF-2041 entered the wash cycle.',  'time' => 'Just now',  'unread' => true],
                ['icon' => 'ready',   'title' => 'Laundry is ready',       'desc' => 'Order #LF-2039 ready for pickup.',        'time' => '1h ago',    'unread' => true],
                ['icon' => 'payment', 'title' => 'Payment received',       'desc' => '$18.40 received for order #LF-2039.',     'time' => '3h ago',    'unread' => false],
                ['icon' => 'promo',   'title' => 'Promo unlocked',         'desc' => 'Enjoy 25% off Express service today.',    'time' => 'Yesterday', 'unread' => false],
                ['icon' => 'order',   'title' => 'Order received',         'desc' => 'We picked up your laundry order #LF-2041.','time' => 'Yesterday', 'unread' => false],
            ],
        ];

        return view('customer/notifications', $data);
    }
}
