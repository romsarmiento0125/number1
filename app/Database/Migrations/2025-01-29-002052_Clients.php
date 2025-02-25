<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clients extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' =>11,
                'auto_increment' => true
            ],
            'client_name' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => 255,
                'null' => false,
            ],
            'client_tin' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'client_address' => [
                'type' => 'TEXT'
            ],
            'client_business_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'client_term' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'creator_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'updater_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('clients');
    }

    public function down()
    {
        $this->forge->dropTable('clients');
    }
}
