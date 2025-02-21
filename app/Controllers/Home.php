<?php

namespace App\Controllers;

use App\Models\CoreModel;

class Home extends BaseController
{
    protected $coreModel;
    public function __construct()
    {
        $this->coreModel = new CoreModel();
    }
    
    public function index()
    {
        $session = session();
        $login = $session->get('login');
        if($login != 1) {
            return redirect()->to(base_url('login'));
        }
        return view('home/home');
    }

    public function si_receipt($id)
    {
        $session = session();
        $login = $session->get('login');
        if($login != 1) {
            return redirect()->to(base_url('login'));
        }
        $result = $this->coreModel->get_receipt_data($id);

        $salesInvoice = [];
        $items = [];
        $discounts = [];

        foreach ($result as $row) {
            if (empty($salesInvoice)) {
                $salesInvoice = [
                    'client_name' => $row->client_name,
                    'client_tin' => $row->client_tin,
                    'client_address' => $row->client_address,
                    'client_business_name' => $row->client_business_name,
                    'client_term' => $row->client_term,
                    'si_date' => $row->si_date,
                    'vatable_sales' => $row->vatable_sales,
                    'vat_exempt_sales' => $row->vat_exempt_sales,
                    'vat_amount' => $row->vat_amount,
                    'total_amount_due' => $row->total_amount_due,
                    'freight_cost' => $row->freight_cost,
                    'items' => []
                ];
            }

            $itemId = $row->item_id;
            if (!isset($items[$itemId])) {
                $items[$itemId] = [
                    'si_item_qty' => $row->si_item_qty,
                    'product_name' => $row->product_name,
                    'unit_price' => $row->unit_price,
                    'amount' => $row->amount,
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

        $data = [
            'result' => json_encode($salesInvoice)
        ];


        $data['hide_header'] = true;
        return view('receipts/sales_invoice_receipts', $data);
    }
}
