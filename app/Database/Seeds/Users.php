<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'first_name' => 'Admin',
                'last_name' => 'User',
                'archive' => 0,
                'creator_id' => 1,
                'updater_id' => 1,
                'role_id' => 1,
            ],
            [
                'username' => 'user',
                'password' => password_hash('user123', PASSWORD_BCRYPT),
                'first_name' => 'Regular',
                'last_name' => 'User',
                'archive' => 0,
                'creator_id' => 1,
                'updater_id' => 1,
                'role_id' => 2,
            ],
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
