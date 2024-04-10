<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class Vehicle extends BaseController
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

            $data['Allstate'] = $this->AdminModel->getAllVehicle();
            $data['vehicleType'] = $this->AdminModel->getAllActiveRecord('vehicle_types');


            return view('admin/vehicle_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {
            $user_id = $this->session->get('user_id');
            $no_of_sit = $this->request->getPost('no_of_sit');
            $redg_no = $this->request->getPost('redg_no');
            $model_name = $this->request->getPost('model_name');
            $vehicle_type = $this->request->getPost('vehicle_type');

            $data = [
                'type_id' => $vehicle_type,
                'model_name' => $model_name,
                'regd_no' => $redg_no,
                'no_of_sit' => $no_of_sit,
                'vendor_id' => $user_id,
                'status' => 1
            ];

            $this->AdminModel->InsertRecord('vehicle_details', $data);
            return redirect()->to('vehicle');
        } else {
            return redirect()->to('admin/');
        }
    }

    function edit($id)
    {
        if ($this->session->get('user_id')) {

            $user_id = $this->session->get('user_id');
            $no_of_sit = $this->request->getPost('no_of_sit');
            $redg_no = $this->request->getPost('redg_no');
            $model_name = $this->request->getPost('model_name');
            $vehicle_type = $this->request->getPost('vehicle_type');

            $Countstate = $this->db->query("SELECT * FROM vehicle_details  where regd_no='".$redg_no."' and id!= ".$id)->getResult();

            if (count($Countstate) == 0) {

                $data = [
                    'type_id' => $vehicle_type,
                    'model_name' => $model_name,
                    'regd_no' => $redg_no,
                    'no_of_sit' => $no_of_sit
                ];
                $this->AdminModel->UpdateRecordById('vehicle_details', $id, $data);
            } else {
                $this->session->setFlashdata('msg', 'Vehicle Type Already  exist.');
                $this->session->setFlashdata('uid', $id);
            }
            return redirect()->to('vehicle');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('user_id')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('vehicle_details', $id);
            return redirect()->to('vehicle');
        } else {
            return redirect()->to('admin/');
        }
    }

    function status()
    {
        if ($this->session->get('user_id')) {
            $id  = $this->request->getPost('state_id');
            $state_status = $this->request->getPost('state_status');

            $data = [
                'status'  => $state_status,
            ];

            $this->AdminModel->UpdateRecordById('vehicle_details', $id, $data);
            return redirect()->to('vehicle');
        } else {
            return redirect()->to('Admin/');
        }
    }
}
