<?php

namespace App\Controllers;

use App\Models\DeliveryReceiptModel;

class DeliveryReceiptController extends BaseController
{
    protected $deliveryReceiptModel;
    public function __construct()
    {
        $this->deliveryReceiptModel = new DeliveryReceiptModel();
    }

    public function index()
    {
        $session = session();
        $login = $session->get('login');
        if($login != 1) {
            return redirect()->to(base_url('login'));
        }
        return view('delivery_receipts/delivery_receipts');
    }

    public function get_products_clients_dr() {
        $result = $this->deliveryReceiptModel->get_products_clients_dr();
        
        if (is_string($result)) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $result]);
        }

        return json_encode($result);
    }

    public function save_draft() {
        $session = session();
        $user_id = $session->get('user_id');

        $data = $this->request->getJSON(true);

        // Validate data
        if (empty($data['summary']) || empty($data['customer']) || empty($data['items'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid data. Please fill in all required fields.']);
        }

        // Extract summary data
        $summaryData = $data['summary'];
        $subTotal = $summaryData['subTotal'];
        $totalAmount = $summaryData['totalAmount'];
        $freightCost = $summaryData['freightCost'];
        $dr_status = $summaryData['dr_status'];

        // Extract customer data
        $customerDetail = $data['customer'];
        $customerId = $customerDetail['id'];
        $customerName = $customerDetail['name'];
        $customerTin = $customerDetail['tin'];
        $customerTerms = $customerDetail['terms'];
        $customeraddress = $customerDetail['address'];
        $customerbusiness = $customerDetail['business'];
        $customerdate = $customerDetail['date'];

        // Extract items data
        $items = $data['items'];

        $params = [
            $customerId,
            $customerName,
            $customerTin,
            $customerTerms,
            $customeraddress,
            $customerbusiness,
            $subTotal,
            $freightCost,
            $totalAmount,
            $dr_status,
            $user_id,
            $user_id,
            $customerdate
        ];

        $insertResult = $this->deliveryReceiptModel->insert_delivery_receipt($params);

        if (is_array($insertResult) && !empty($insertResult)) {
            $insertId = $insertResult[0]->id; // Access the ID from the result

            foreach ($items as $item) {
                $params = [
                    $insertId,
                    $item['item_code'],
                    $item['item_price'],
                    $item['item_qty'],
                    $item['unique_id'],
                    $user_id,
                    $user_id
                    
                ];
                $lastItemResult = $this->deliveryReceiptModel->insert_delivery_receipt_items($params);

                if (isset($item['item_discount'])) {
                    $dr_item_id = $lastItemResult[0]->id; // Get the last inserted ID for the item
                    $save_complete = $this->deliveryReceiptModel->insert_delivery_receipt_items_discounts($item['item_discount'], $dr_item_id, $user_id);
                }
            }

            return json_encode(['delivery_id' => $insertId, 'delivery' => $save_complete]);
        } else {
            return json_encode(['delivery' => $insertResult]);
        }
    }

    public function update_draft() {
        $session = session();
        $user_id = $session->get('user_id');

        $data = $this->request->getJSON(true);

        // Validate data
        if (empty($data['summary']) || empty($data['customer']) || empty($data['items'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid data. Please fill in all required fields.']);
        }

        // Extract summary data
        $summaryData = $data['summary'];
        $totalAmount = $summaryData['totalAmount'];
        $vatableSales = $summaryData['vatableSales'];
        $vatAmount = $summaryData['vatAmount'];
        $totalAmountDue = $summaryData['totalAmountDue'];
        $vatExemptSales = $summaryData['vatExemptSales'];
        $zeroRated = $summaryData['zeroRated'];
        $freightCost = $summaryData['freightCost'];
        $si_status = $summaryData['si_status'];

        // Extract customer data
        $customerDetail = $data['customer'];
        $customerTerms = $customerDetail['terms'];
        $customerDate = $customerDetail['date'];

        // Extract items data
        $items = $data['items'];

        // Extract need to archives id
        $archives = $data['archive_items'];

        $params = [
            $customerTerms,
            $vatableSales,
            $vatExemptSales,
            $zeroRated,
            $vatAmount,
            $totalAmountDue,
            $freightCost,
            $totalAmount,
            $si_status,
            $user_id,
            $customerDate,
            $data['si_id'] // Add the sales invoice ID for updating
        ];

        

        $updateResult = $this->deliveryReceiptModel->update_sales_invoice($params);
        
        if ($updateResult === 'success') {
            foreach ($items as $item) { 
                if($item['id'] === 0) {
                    $params = [
                        $data['si_id'],
                        $item['item_code'],
                        $item['item_price'],
                        $item['item_qty'],
                        $item['item_vat'],
                        $item['item_vat_check'],
                        $item['item_vatable_sales'],
                        $item['unique_id'],
                        $user_id,
                        $user_id
                    ];
                    $lastItemResult = $this->deliveryReceiptModel->insert_sales_invoice_items($params);
    
                    if (isset($item['item_discount'])) {
                        $si_item_id = $lastItemResult[0]->id; // Get the last inserted ID for the item
                        $this->deliveryReceiptModel->insert_sales_invoice_items_discounts($item['item_discount'], $si_item_id, $user_id);
                    }
                }
                else {
                    $params = [
                        $item['item_code'],
                        $item['item_price'],
                        $item['item_qty'],
                        $item['item_vat'],
                        $item['item_vat_check'],
                        $item['item_vatable_sales'],
                        $user_id,
                        $item['id']
                    ];
                    $result = $this->deliveryReceiptModel->update_sales_invoice_items($params);

                    if (isset($item['item_discount'])) {
                        $si_item_id = $item['id'];
                        $this->deliveryReceiptModel->update_sales_invoice_items_discounts($item['item_discount'], $si_item_id, $user_id);
                    }
                }

            }

            if (!empty($archives)) {
                foreach($archives as $archive) {
                    $params = [
                        $user_id,
                        1,
                        $archive['id'],
                    ];
                    $this->deliveryReceiptModel->archive_sales_invoice_items($params);
                }
               
            }
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'failed', 'message' => $updateResult]);
        }
    }

    function get_delivery_receipt_by_id() {
        $id = $this->request->getJSON(true);

        $result = $this->deliveryReceiptModel->get_delivery_receipt_by_id($id);

        if (is_string($result)) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $result]);
        }

        if (!empty($result) && $result[0]->si_status === 'printed') {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Cannot edit a printed invoice.']);
        }
        

        $salesInvoice = [];
        $items = [];

        foreach ($result as $row) {
            if (empty($salesInvoice)) {
                $salesInvoice = [
                    'id' => $row->id,
                    'client_id' => $row->client_id,
                    'client_name' => $row->client_name,
                    'client_tin' => $row->client_tin,
                    'client_term_name' => $row->client_term,
                    'client_address' => $row->client_address,
                    'client_business_name' => $row->client_business_name,
                    'si_date' => $row->si_date,
                    'si_status' => $row->si_status,
                    'freight_cost' => $row->freight_cost,
                    'items' => []
                ];
            }

            $itemId = $row->si_unique_id;
            if (!isset($items[$itemId])) {
                $items[$itemId] = [
                    'si_item_id' => (int) $row->si_item_id,
                    'product_id' => $row->product_id,
                    'si_item_code' => $row->si_item_code,
                    'si_item_price' => $row->si_item_price,
                    'si_item_qty' => $row->si_item_qty,
                    'si_item_vat' => $row->si_item_vat,
                    'si_item_vat_check' => $row->si_item_vat_check,
                    'si_item_vatable_sales' => $row->si_item_vatable_sales,
                    'si_unique_id' => (int) $row->si_unique_id,
                    'discounts' => []
                ];
            }

            if ($row->discount_label) {
                $items[$itemId]['discounts'][] = [
                    'label' => $row->discount_label,
                    'discount' => $row->discount
                ];
            }
        }

        $salesInvoice['items'] = array_values($items);

        return json_encode($salesInvoice);
    }

    function print_si() {
        $session = session();
        $user_id = $session->get('user_id');

        $id = $this->request->getJSON(true);

        $params = [
            $user_id,
            $id
        ];

        $result = $this->deliveryReceiptModel->print_sales_invoice($params);

        if ($result === 'success') {
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'failed']);
        }
    }
}
