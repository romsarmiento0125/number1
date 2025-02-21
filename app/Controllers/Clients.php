<?php

namespace App\Controllers;

use App\Models\CoreModel;

class Clients extends BaseController
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
        return view('clients/clients');
    }

    public function get_table_clients()
    {
        $clients = $this->coreModel->get_clients();
        return json_encode($clients);
    }

    public function save_client()
    {
        $session = session();
        $user_id = $session->get('user_id');

        $client_name = $this->request->getPost('client_name');
        $client_tin = $this->request->getPost('client_tin');
        $client_business_name = $this->request->getPost('client_business_name');
        $client_term = $this->request->getPost('client_term');
        $client_address = $this->request->getPost('client_address');

        $result = $this->coreModel->check_client_exists($client_name);
        if (is_string($result)) {
            return json_encode(['status' => 'error', 'message' => $result]);
        }
        if ($result[0]->count > 0) {
            return json_encode(['status' => 'exists', 'message' => 'Client already exists']);
        }

        $params = [
            $client_name,
            $client_tin,
            $client_address,
            $client_business_name,
            $client_term,
            $user_id,
            $user_id
        ];

        $insert = $this->coreModel->insert_client($params);
        if ($insert === 'success') {
            return json_encode(['status' => 'success', 'message' => 'Client added successfully']);
        } else {
            return json_encode(['status' => 'error', 'message' => $insert]);
        }
    }

    public function edit_client()
    {
        $session = session();
        $user_id = $session->get('user_id');
        
        $client_name = $this->request->getPost('client_name');
        $client_name_attr = $this->request->getPost('client_name_attr');
        $client_tin = $this->request->getPost('client_tin');
        $client_business_name = $this->request->getPost('client_business_name');
        $client_term = $this->request->getPost('client_term');
        $client_address = $this->request->getPost('client_address');

        $params = [
            $client_name,
            $client_tin,
            $client_address,
            $client_business_name,
            $client_term,
            $user_id,
            $client_name_attr
        ];

        $update = $this->coreModel->update_client($params);
        if ($update === 'success') {
            return json_encode(['status' => 'success', 'message' => 'Client updated successfully']);
        } else {
            return json_encode(['status' => 'error', 'message' => $update]);
        }
    }
}
