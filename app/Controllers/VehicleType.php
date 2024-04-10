<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class VehicleType extends BaseController
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
            $data['Allstate'] = $this->AdminModel->GetAllRecord('vehicle_types');

            return view('admin/vehicle-type_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {
            $state = $this->request->getPost('statename');
            $data = [
                'type_name' => $state,
                'status' => 1

            ];

            $this->AdminModel->InsertRecord('vehicle_types', $data);
            return redirect()->to('vehicle-type');
        } else {
            return redirect()->to('admin/');
        }
    }

    function edit($id)
    {
        if ($this->session->get('user_id')) {

            $state = $this->request->getPost('statename');
            $Countstate = $this->db->query("SELECT * FROM vehicle_types  where type_name='$state' and id!='$id' ")->getResult();

            if (count($Countstate) == 0) {
                $data = [
                    'type_name' => $state
                ];
                $this->AdminModel->UpdateRecordById('vehicle_types', $id, $data);
            } else {
                $this->session->setFlashdata('msg', 'Vehicle Type Already  exist.');
                $this->session->setFlashdata('uid', $id);
            }
            return redirect()->to('vehicle-type');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('user_id')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('vehicle_types', $id);
            return redirect()->to('vehicle-type');
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

            $this->AdminModel->UpdateRecordById('vehicle_types', $id, $data);
            return redirect()->to('vehicle-type');
        } else {
            return redirect()->to('Admin/');
        }
    }
}
