<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SalesInvoiceItemsList extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'si_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'si_item_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'si_item_price' => [
                'type' => 'DOUBLE',
            ],
            'si_item_qty' => [
                'type' => 'DOUBLE',
            ],
            'si_item_vat' => [
                'type' => 'DOUBLE',
            ],
            'si_item_vat_check' => [
                'type' => 'BOOLEAN',
            ],
            'si_item_vatable_sales' => [
                'type' => 'DOUBLE',
            ],
            'si_unique_id' => [
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
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        // $this->forge->addForeignKey('discount_id', 'sales_invoice_items_list_discount', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sales_invoice_items_list');
    }

    public function down()
    {
        $this->forge->dropTable('sales_invoice_items_list');
    }
}
