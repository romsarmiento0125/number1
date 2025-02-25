<?php
namespace App\Models;

use CodeIgniter\Model;

class CoreModel extends Model
{
    protected $db;

    public function __construct()
    {   
        $this->db = \Config\Database::connect();
    }

    public function user_login($username)
    {
        try {
            $query = "SELECT * FROM users WHERE username = ? AND archive = 0";
            return $this->db->query($query, [$username])->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_clients()
    {
        try {
            $query = "SELECT * FROM clients LIMIT 1000";
            return $this->db->query($query)->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function check_client_exists($client_name)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM clients WHERE client_name = ?";
            return $this->db->query($query, [$client_name])->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function insert_client($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "INSERT INTO clients (
                client_name,
                client_tin,
                client_address,
                client_business_name,
                client_term,
                creator_id,
                updater_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $this->db->query($query, $params);

            $this->db->transComplete(); // Complete Transaction

            if ($this->db->transStatus() === false) {
                // Transaction failed, rollback
                $this->db->transRollback();
                return 'failed';
            } else {
                // Transaction successful, commit
                $this->db->transCommit();
                return 'success';
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            $this->db->transRollback();
            return $e->getMessage();
        }
    }

    public function update_client($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "UPDATE clients SET 
                client_name = ?,
                client_tin = ?,
                client_address = ?,
                client_business_name = ?,
                client_term = ?,
                updater_id = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = ?";

            $this->db->query($query, $params);

            $this->db->transComplete(); // Complete Transaction

            if ($this->db->transStatus() === false) {
                // Transaction failed, rollback
                $this->db->transRollback();
                return 'failed';
            } else {
                // Transaction successful, commit
                $this->db->transCommit();
                return 'success';
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            $this->db->transRollback();
            return $e->getMessage();
        }
    }

    public function get_products()
    {
        try {
            $query = "SELECT * FROM products LIMIT 1000";
            return $this->db->query($query)->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function check_product_exists($product_name, $product_item)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM products WHERE (product_name = ? OR product_item = ?)";
            return $this->db->query($query, [$product_name, $product_item])->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit_check_product_exists($product_name, $product_item)
    {
        try {
            $query = "SELECT id FROM products WHERE (product_name = ? OR product_item = ?)";
            return $this->db->query($query, [$product_name, $product_item])->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function insert_product($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "INSERT INTO products (
                product_name,
                product_item,
                product_unit,
                product_weight,
                product_price,
                creator_id,
                updater_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $this->db->query($query, $params);

            $this->db->transComplete(); // Complete Transaction

            if ($this->db->transStatus() === false) {
                // Transaction failed, rollback
                $this->db->transRollback();
                return ['status' => 'failed', 'message' => 'Transaction failed'];
            } else {
                // Transaction successful, commit
                $this->db->transCommit();
                return ['status' => 'success', 'message' => 'Product added successfully'];
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            $this->db->transRollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function update_product($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "UPDATE products SET 
                product_name = ?,
                product_item = ?,
                product_unit = ?,
                product_weight = ?,
                product_price = ?,
                updater_id = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = ?";

            $this->db->query($query, $params);

            $this->db->transComplete(); // Complete Transaction

            if ($this->db->transStatus() === false) {
                // Transaction failed, rollback
                $this->db->transRollback();
                return ['status' => 'failed', 'message' => 'Transaction failed'];
            } else {
                // Transaction successful, commit
                $this->db->transCommit();
                return ['status' => 'success', 'message' => 'Product updated successfully'];
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            $this->db->transRollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function get_receipt_data($id)
    {
        try {
            $query = "SELECT 
                        c.client_name,
                        c.client_tin,
                        c.client_address,
                        c.client_business_name,
                        si.client_term AS client_term,
                        si.updated_at AS si_date,
                        si.vatable_sales,
                        si.vat_exempt_sales,
                        si.vat_amount,
                        si.total_amount_due,
                        si.freight_cost,
                        si_items.si_item_qty,
                        CONCAT(p.product_name,
                                ' ( ',
                                p.product_item,
                                ' )') AS product_name,
                        si_items.si_item_price AS unit_price,
                        (si_items.si_item_price * si_items.si_item_qty) AS amount,
                        si_items.id AS item_id,
                        si_items_discount.discount_label,
                        si_items_discount.discount
                    FROM sales_invoice si
                    LEFT JOIN sales_invoice_items_list si_items ON si.id = si_items.si_id
                    LEFT JOIN sales_invoice_items_list_discount si_items_discount ON si_items.id = si_items_discount.si_item_id
                    INNER JOIN products p ON si_items.si_item_code =  p.product_item
                    INNER JOIN clients c ON si.client_id = c.id
                    WHERE si.id = ?";
            return $this->db->query($query, [$id])->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}