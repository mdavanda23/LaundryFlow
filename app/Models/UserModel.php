<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 * ------------------------------------------------------------------------
 * Merepresentasikan tabel `users` pada database `laundryflow`.
 *
 * Kolom role_id mengacu ke tabel `roles`:
 *   1 = Admin / Owner   (Panel Admin)
 *   2 = Kasir / Staf     (Panel Staf)
 *   3 = Customer         (Pelanggan)
 *
 * Jika tabel `roles` kamu belum ada, buat dulu dengan struktur minimal:
 *
 *   CREATE TABLE roles (
 *     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 *     name VARCHAR(50) NOT NULL
 *   );
 *   INSERT INTO roles (id, name) VALUES (1, 'admin'), (2, 'staff'), (3, 'customer');
 */
class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'role_id', 'name', 'email', 'phone', 'password', 'photo', 'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Role constants, dipakai di seluruh aplikasi supaya tidak menulis angka mentah (magic number).
    public const ROLE_ADMIN    = 1;
    public const ROLE_STAFF    = 2;
    public const ROLE_CUSTOMER = 3;

    protected $validationRules = [
        'name'  => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'phone' => 'permit_empty|min_length[9]|max_length[20]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email ini sudah terdaftar, silakan gunakan email lain atau masuk.',
        ],
    ];

    /**
     * Aturan validasi khusus untuk pendaftaran customer baru.
     */
    public function registrationRules(): array
    {
        return [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|max_length[100]|is_unique[users.email]',
            'phone'            => 'required|min_length[9]|max_length[20]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];
    }

    /**
     * Cari user aktif berdasarkan email + role tertentu.
     * Dipakai saat proses login (customer / staff / owner).
     */
    public function findActiveByEmailAndRole(string $email, int $roleId): ?array
    {
        return $this->where('email', $email)
                     ->where('role_id', $roleId)
                     ->where('status', 'active')
                     ->first();
    }

    /**
     * Simpan user baru dengan password yang sudah di-hash.
     */
    public function registerCustomer(array $data): int|string|false
    {
        return $this->insert([
            'role_id'  => self::ROLE_CUSTOMER,
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'status'   => 'active',
        ]);
    }

    /**
     * Verifikasi password plain text terhadap hash yang tersimpan.
     */
    public function verifyPassword(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
