<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Clients extends Seeder
{
    public function run()
    {
        $data = [
            [
                'client_name' => 'ADELIA M. SANTOS',
                'client_tin' => '232-144-159-000',
                'client_address' => 'TIBAG BALIUAG BULACAN',
                'client_business_name' => 'LITO(alt39)S POULTRY AND AGRICULTURAL SUPPLY',
                'client_term' => 'cod',
                'creator_id' => 1,
                'updater_id' => 1,
            ],
            [
                'client_name' => 'AGBERSON BERNABE',
                'client_tin' => '',
                'client_address' => 'SITIO BULALO NORZAGARAY BULACAN',
                'client_business_name' => '',
                'client_term' => 'cod',
                'creator_id' => 1,
                'updater_id' => 1,
            ]
        ];

        $this->db->table('clients')->insertBatch($data);
    }
}
