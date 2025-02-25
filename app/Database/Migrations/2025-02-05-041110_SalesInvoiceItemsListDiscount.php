<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SalesInvoiceItemsListDiscount extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' =>11,
                'auto_increment' => true
            ],
            'si_item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'discount_label' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'discount' => [
                'type' => 'DOUBLE',
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
        $this->forge->createTable('sales_invoice_items_list_discount');
    }

    public function down()
    {
        $this->forge->dropTable('sales_invoice_items_list_discount');
    }
}
