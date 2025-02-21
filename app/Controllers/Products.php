<?php

namespace App\Controllers;

use App\Models\CoreModel;

class Products extends BaseController
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
        return view('products/products');
    }

    public function get_table_products()
    {
        $products = $this->coreModel->get_products();
        return json_encode($products);
    }

    public function save_product()
    {
        $session = session();
        $user_id = $session->get('user_id');

        $data = $this->request->getJSON(true);

        $product_name = $data['product_name'];
        $product_item = $data['product_item'];
        $product_unit = $data['product_unit'];
        $product_weight = $data['product_weight'];
        $product_price = $data['product_price'];

        $result = $this->coreModel->check_product_exists($product_name, $product_item);
        if (is_string($result)) {
            return json_encode(['status' => 'error', 'message' => $result]);
        }
        if ($result[0]->count > 0) {
            return json_encode(['status' => 'exists', 'message' => 'Product already exists']);
        }

        $params = [
            $product_name,
            $product_item,
            $product_unit,
            $product_weight,
            $product_price,
            $user_id,
            $user_id
        ];

        $insert = $this->coreModel->insert_product($params);
        if (!$insert) {
            return json_encode(['status' => 'error', 'message' => 'Failed to save product']);
        }
        return json_encode(['status' => 'success', 'message' => 'Product saved successfully']);
    }

    public function edit_product()
    {
        $session = session();
        $user_id = $session->get('user_id');

        $data = $this->request->getJSON(true);
        
        $product_name = $data['product_name'];
        $product_name_attr = $data['product_name_attr'];
        $product_unit = $data['product_unit'];
        $product_item = $data['product_item'];
        $product_weight = $data['product_weight'];
        $product_price = $data['product_price'];

        // Check if product name or item already exists
        $result = $this->coreModel->edit_check_product_exists($product_name, $product_item);
        if(!empty($result)) {
            if(count($result) > 1) {
                return json_encode(['status' => 'error', 'message' => 'Product or Item code already exists']);
            }
            if($result[0]->id !== $product_name_attr) {
                return json_encode(['status' => 'error', 'message' => 'Product or Item code already exists']);
            }
        }

        $params = [
            $product_name,
            $product_item,
            $product_unit,
            $product_weight,
            $product_price,
            $user_id,
            $product_name_attr
        ];

        $update = $this->coreModel->update_product($params);
        if (!$update) {
            return json_encode(['status' => 'error', 'message' => 'Failed to update product']);
        }
        return json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
    }
}
