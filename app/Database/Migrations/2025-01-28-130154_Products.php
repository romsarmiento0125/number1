<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' =>11,
                'auto_increment' => true
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => 255,
                'null' => false,
            ],
            'product_item' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => 50,
                'null' => false,
            ],
            'product_unit' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'product_weight' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'product_price' => [
                'type' => 'DOUBLE'
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
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
