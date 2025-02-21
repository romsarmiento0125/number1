<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Roles extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'creator_id' => 1,
                'updater_id' => 1,
            ],
            [
                'name' => 'User',
                'creator_id' => 1,
                'updater_id' => 1,
            ],
        ];

        // Using Query Builder
        $this->db->table('roles')->insertBatch($data);
    }
}
