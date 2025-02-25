<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SalesInvoice extends Migration
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
            'vatable_sales' => [
                'type' => 'DOUBLE'
            ],
            'vat_exempt_sales' => [
                'type' => 'DOUBLE'
            ],
            'zero_rated' => [
                'type' => 'DOUBLE'
            ],
            'vat_amount' => [
                'type' => 'DOUBLE'
            ],
            'total_amount_due' => [
                'type' => 'DOUBLE'
            ],
            'freight_cost' => [
                'type' => 'DOUBLE'
            ],
            'total_amount' => [
                'type' => 'DOUBLE'
            ],
            'si_status' => [
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
            'si_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sales_invoice');
    }

    public function down()
    {
        $this->forge->dropTable('sales_invoice');
    }
}
