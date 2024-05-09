<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class SeviceRate extends BaseController
{
    public function __construct()
    {
        $db = db_connect();
        $this->db = db_connect();
        $this->AdminModel = new AdminModel(db_connect());
        $this->session = session();
        helper(['form', 'url', 'validation']);
    }


    function index()
    {
        if ($this->session->get('user_id')) {

            $user_id = $this->session->get('user_id');

            $data['Allstate'] = $this->AdminModel->GetAllstate();
            $data['vehicleTypes'] = $this->AdminModel->GetAllRecord('vehicle_types');
            $data['AllServiceRate'] = $this->AdminModel->getAllRates();

            return view('admin/servicerate_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {
            $user_id =$this->session->get('user_id');
            $state_id = $this->request->getPost('state_id');
            $type_id = $this->request->getPost('type_id');
            $max_no_share = $this->request->getPost('max_no_share');
            $full_fare = $this->request->getPost('full_fare');
            $fare_per_share = $this->request->getPost('fare_per_share');
            $remark = $this->request->getPost('remark');

            $data = [
                'state_id' => $state_id,
                'type_id' => $type_id,
                'max_no_share' => $max_no_share,
                'full_fare' => $full_fare,
                'fare_per_share' => $fare_per_share,
                'remark' => $remark,
                'status' => 1,
                'updated_by' => $user_id
            ];

            $this->AdminModel->InsertRecord('service_rate', $data);
            return redirect()->to('service-rate');
        } else {
            return redirect()->to('admin/');
        }
    }

    function edit($id)
    {
        if ($this->session->get('user_id')) {

            $user_id =$this->session->get('user_id');
            $state_id = $this->request->getPost('state_id');
            $type_id = $this->request->getPost('type_id');
            $max_no_share = $this->request->getPost('max_no_share');
            $full_fare = $this->request->getPost('full_fare');
            $fare_per_share = $this->request->getPost('fare_per_share');
            $remark = $this->request->getPost('remark');

            $data = [
                'state_id' => $state_id,
                'type_id' => $type_id,
                'max_no_share' => $max_no_share,
                'full_fare' => $full_fare,
                'fare_per_share' => $fare_per_share,
                'remark' => $remark,
                'updated_by' => $user_id
            ];

            $this->AdminModel->UpdateRecordById('service_rate', $id, $data);

            return redirect()->to('service-rate');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('user_id')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('service_rate', $id);
            return redirect()->to('service-rate');
        } else {
            return redirect()->to('admin/');
        }
    }

    function status()
    {
        if ($this->session->get('user_id')) {
            $id  = $this->request->getPost('id');
            $state_status = $this->request->getPost('state_status');

            $data = [
                'status'  => $state_status,
            ];
            
            $this->AdminModel->UpdateRecordById('service_rate', $id, $data);
            return redirect()->to('service-rate');
        } else {
            return redirect()->to('Admin/');
        }
    }
}
