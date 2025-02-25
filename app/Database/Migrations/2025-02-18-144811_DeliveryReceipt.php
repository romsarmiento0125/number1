<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeliveryReceipt extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' =>11,
                'auto_increment' => true
            ],
            'client_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'client_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'client_tin' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'client_term' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'client_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'client_business_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'sub_total' => [
                'type' => 'DOUBLE'
            ],
            'freight_cost' => [
                'type' => 'DOUBLE'
            ],
            'total_amount' => [
                'type' => 'DOUBLE'
            ],
            'dr_status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'creator_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'updater_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'dr_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('delivery_receipt');
    }

    public function down()
    {
        $this->forge->dropTable('delivery_receipt');
    }
}
