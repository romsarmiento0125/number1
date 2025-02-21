<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeliveryReceiptItemList extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'dr_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'dr_item_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'dr_item_price' => [
                'type' => 'DOUBLE',
            ],
            'dr_item_qty' => [
                'type' => 'DOUBLE',
            ],
            'dr_unique_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'creator_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'updater_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'archive' => [
                'type' => 'BOOLEAN',
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('delivery_receipt_items_list');
    }

    public function down()
    {
        $this->forge->dropTable('delivery_receipt_items_list');
    }
}
