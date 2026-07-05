<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'address',
        'gender',
        'birth_date',
        'points'
    ];

    /**
     * Ambil customer berdasarkan user_id
     */
    public function getByUserId(int $userId): ?array
    {
        return $this->select('customers.*, users.name, users.email, users.phone, users.photo, users.role_id')
            ->join('users', 'users.id = customers.user_id')
            ->where('customers.user_id', $userId)
            ->first();
    }

    /**
     * Membuat data customer setelah register
     */
    public function createForUser(int $userId)
    {
        return $this->insert([
            'user_id' => $userId,
            'address' => '',
            'points' => 0,
        ]);
    }
}