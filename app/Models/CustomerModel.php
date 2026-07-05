<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'user_id', 'address', 'gender', 'birth_date', 'points',
    ];

    /**
     * Ambil data customer lengkap beserta data user-nya.
     */
    public function getByUserId(int $userId): ?array
    {
        return $this->db->table('customers c')
            ->select('c.*, u.name, u.email, u.phone, u.photo, u.role_id, u.created_at as joined_at')
            ->join('users u', 'u.id = c.user_id')
            ->where('c.user_id', $userId)
            ->get()
            ->getRowArray();
    }

    /**
     * Buat entri customer baru setelah register user.
     */
    public function createForUser(int $userId): int|string|false
    {
        return $this->insert([
            'user_id' => $userId,
            'address' => '',
            'points'  => 0,
        ]);
    }
}