<?php
namespace App\Models;

use CodeIgniter\Model;

class SalesInoviceModel extends Model
{
    protected $db;

    public function __construct()
    {   
        $this->db = \Config\Database::connect();
    }

    public function get_products_clients_si()
    {
        try {
            $productsQuery = "SELECT * FROM products WHERE archive = 0";
            $clientsQuery = "SELECT * FROM clients WHERE archive = 0";
            $sales_invoice_query = "SELECT 
                    id,
                    client_name,
                    client_term,
                    si_status,
                    si_date
                FROM
                    sales_invoice
                ORDER BY id DESC
                LIMIT 500";

            $products = $this->db->query($productsQuery)->getResult();
            $clients = $this->db->query($clientsQuery)->getResult();
            $sales_invoice = $this->db->query($sales_invoice_query)->getResult();

            return ['products' => $products, 'clients' => $clients, 'sales_invoice' => $sales_invoice];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function insert_sales_invoice($data)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "INSERT INTO sales_invoice (
                client_id,
                client_name,
                client_tin,
                client_term,
                client_address,
                client_business_name,
                vatable_sales,
                vat_exempt_sales,
                zero_rated,
                vat_amount,
                total_amount_due,
                freight_cost,
                total_amount,
                si_status,
                creator_id,
                updater_id,
                archive,
                si_date
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)";

            $this->db->query($query, $data);

            $this->db->transComplete(); // Complete Transaction

            if ($this->db->transStatus() === false) {
                // Transaction failed, rollback
                $this->db->transRollback();
                return 'failed';
            } else {
                // Transaction successful, commit
                $this->db->transCommit();
                $creator_id = $data[14]; // Assuming creator_id is the 11th element in the $data array
                $lastInsertQuery = $this->db->query("SELECT id FROM sales_invoice WHERE creator_id = ? ORDER BY created_at DESC LIMIT 1", [$creator_id])->getResult();
                return $lastInsertQuery; // Return the last inserted ID and result
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            $this->db->transRollback();
            return $e->getMessage();
        }
    }

    public function insert_sales_invoice_items($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "INSERT INTO sales_invoice_items_list (
                si_id,
                si_item_code,
                si_item_price,
                si_item_qty,
                si_item_vat,
                si_item_vat_check,
                si_item_vatable_sales,
                si_unique_id,
                creator_id,
                updater_id,
                archive
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

            $this->db->query($query, $params);

            $this->db->transComplete(); // Complete Transaction

            if ($this->db->transStatus() === false) {
                // Transaction failed, rollback
                $this->db->transRollback();
                return 'failed';
            } else {
                // Transaction successful, commit
                $this->db->transCommit();
                $unique_id = $params[7]; // Assuming unique_id is the 8th element in the $params array
                $lastInsertQuery = $this->db->query("SELECT id FROM sales_invoice_items_list WHERE si_unique_id = ? ORDER BY created_at DESC LIMIT 1", [$unique_id])->getResult();
                return $lastInsertQuery; // Return the last inserted ID and result
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $e->getMessage();
        }
    }

    public function insert_sales_invoice_items_discounts($discounts, $si_item_id, $user_id)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "INSERT INTO sales_invoice_items_list_discount (
                si_item_id,
                discount_label,
                discount,
                creator_id,
                updater_id,
                archive
            ) VALUES (?, ?, ?, ?, ?, 0)";

            foreach ($discounts as $discount) {
                if (empty($discount['label']) || $discount['discount'] == 0) {
                    continue; // Skip if label is blank or discount is 0
                }
                $params = [
                    $si_item_id,
                    $discount['label'],
                    $discount['discount'],
                    $user_id,
                    $user_id
                ];
                $this->db->query($query, $params);
            }

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
            $this->db->transRollback();
            return $e->getMessage();
        }
    }

    public function update_sales_invoice($data)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "UPDATE sales_invoice SET 
                client_term = ?,
                vatable_sales = ?,
                vat_exempt_sales = ?,
                zero_rated = ?,
                vat_amount = ?,
                total_amount_due = ?,
                freight_cost = ?,
                total_amount = ?,
                si_status = ?,
                updater_id = ?,
                si_date = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = ? AND archive = 0";

            $this->db->query($query, $data);

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

    public function update_sales_invoice_items($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "UPDATE sales_invoice_items_list SET 
                si_item_code = ?,
                si_item_price = ?,
                si_item_qty = ?,
                si_item_vat = ?,
                si_item_vat_check = ?,
                si_item_vatable_sales = ?,
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
                return 'success'; // Return the last inserted ID and result
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $e->getMessage();
        }
    }

    public function update_sales_invoice_items_discounts($discounts, $si_item_id, $user_id)
    {
        try {
            $this->db->transStart(); // Start Transaction

            // First, delete existing discounts for the item
            $deleteQuery = "DELETE FROM sales_invoice_items_list_discount WHERE si_item_id = ?";
            $this->db->query($deleteQuery, $si_item_id);

            // Then, insert the new discounts
            $insertQuery = "INSERT INTO sales_invoice_items_list_discount (
                si_item_id,
                discount_label,
                discount,
                creator_id,
                updater_id,
                archive
            ) VALUES (?, ?, ?, ?, ?, 0)";

            foreach ($discounts as $discount) {
                if (empty($discount['label']) || $discount['discount'] == 0) {
                    continue; // Skip if label is blank or discount is 0
                }
                $params = [
                    $si_item_id,
                    $discount['label'],
                    $discount['discount'],
                    $user_id,
                    $user_id
                ];
                $ins = $this->db->query($insertQuery, $params);
            }

            $this->db->transComplete(); // Complete Transaction

            if ($this->db->transStatus() === false) {
                // Transaction failed, rollback
                $this->db->transRollback();
                return 'failed';
                // return $params;
            } else {
                // Transaction successful, commit
                $this->db->transCommit();
                return 'success';
                // return $params;
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Exception while updating sales invoice: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function archive_sales_invoice_items($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "UPDATE sales_invoice_items_list SET 
                updater_id = ?,
                archive = ?,
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
                return 'success'; // Return the last inserted ID and result
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $e->getMessage();
        }
    }

    public function get_sales_invoice_by_id($id)
    {
        try {
            $query = "SELECT 
                        si.id AS id,
                        si.client_id AS client_id,
                        si.client_name AS client_name,
                        si.client_tin AS client_tin,
                        si.client_term AS client_term,
                        si.client_address AS client_address,
                        si.client_business_name AS client_business_name,
                        si.si_status AS si_status,
                        si.freight_cost AS freight_cost,
                        p.id AS product_id,
                        si_items.id AS si_item_id, 
                        si_items.si_item_code, 
                        si_items.si_item_price, 
                        si_items.si_item_qty, 
                        si_items.si_item_vat, 
                        si_items.si_item_vat_check, 
                        si_items.si_item_vatable_sales, 
                        si_items.si_unique_id,
                        si_items_discount.discount_label, 
                        si_items_discount.discount,
                        si.si_date
                    FROM sales_invoice si
                    LEFT JOIN sales_invoice_items_list si_items ON si.id = si_items.si_id
                    LEFT JOIN sales_invoice_items_list_discount si_items_discount ON si_items.id = si_items_discount.si_item_id
                    INNER JOIN products p ON si_items.si_item_code =  p.product_item
                    WHERE si.id = ? AND si.archive = 0 AND si_items.archive = 0";
            return $this->db->query($query, [$id])->getResult();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function print_sales_invoice($params)
    {
        try {
            $this->db->transStart(); // Start Transaction

            $query = "UPDATE sales_invoice SET 
                si_status = 'printed',
                updater_id = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = ? AND archive = 0";

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
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}