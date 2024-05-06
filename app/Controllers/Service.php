<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class Service extends BaseController
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

            $data['Allstate'] = $this->AdminModel->getAllService();
            $data['vehicles'] = $this->AdminModel->getOwnVehicleList($user_id);
            $data['cities'] = $this->AdminModel->GetAllcity();
            $data['AllVendor'] = $this->AdminModel->getAllVendor();

            return view('admin/service_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {
            $vendor_id = $this->request->getPost('vendor_id');
            $vehicle = $this->request->getPost('vehicle');
            $boarding_date = $this->request->getPost('boarding_date');
            $arrival_datetime = $this->request->getPost('arrival_datetime');
            $from_city = $this->request->getPost('from_city');
            $to_city = $this->request->getPost('to_city');
            $full_fare = $this->request->getPost('full_fare');
            $fare_per_sit = $this->request->getPost('fare_per_sit');
            $remark = $this->request->getPost('remark');

            $data = [
                'vehicle_id' => $vehicle,
                'boarding_date' => $boarding_date,
                'arrival_datetime' => $arrival_datetime,
                'from_city' => $from_city,
                'to_city' => $to_city,
                'full_fare' => $full_fare,
                'fare_per_sit' => $fare_per_sit,
                'remark' => $remark,
                'vendor_id' => $vendor_id,
                'status' => 1
            ];

            $this->AdminModel->InsertRecord('service_details', $data);
            return redirect()->to('service');
        } else {
            return redirect()->to('admin/');
        }
    }

    function edit($id)
    {
        if ($this->session->get('user_id')) {

            $vehicle = $this->request->getPost('vehicle');
            $boarding_date = $this->request->getPost('boarding_date');
            $arrival_datetime = $this->request->getPost('arrival_datetime');
            $from_city = $this->request->getPost('from_city');
            $to_city = $this->request->getPost('to_city');
            $full_fare = $this->request->getPost('full_fare');
            $fare_per_sit = $this->request->getPost('fare_per_sit');
            $remark = $this->request->getPost('remark');

            // Check Booking, if no booking then only can update else not! 
            // if (count($Countstate) == 0) {

            $data = [
                'vehicle_id' => $vehicle,
                'boarding_date' => $boarding_date,
                'arrival_datetime' => $arrival_datetime,
                'from_city' => $from_city,
                'to_city' => $to_city,
                'full_fare' => $full_fare,
                'fare_per_sit' => $fare_per_sit,
                'remark' => $remark
            ];

            $this->AdminModel->UpdateRecordById('service_details', $id, $data);
            // } else {
            //     $this->session->setFlashdata('msg', 'Vehicle Type Already  exist.');
            //     $this->session->setFlashdata('uid', $id);
            // }
            return redirect()->to('service');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('user_id')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('service_details', $id);
            return redirect()->to('service');
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

            $this->AdminModel->UpdateRecordById('service_details', $id, $data);
            return redirect()->to('service');
        } else {
            return redirect()->to('Admin/');
        }
    }

    function checkVehicleStatus()
    {
        $boarding_time = $this->request->getVar('boarding_time');
        $vehicle_id = $this->request->getVar('vehicle_id');

        $checkVehicleStatus = $this->AdminModel->checkVehicleStatus($boarding_time, $vehicle_id);
        if (!empty($checkVehicleStatus) && $checkVehicleStatus != '') {
            echo 1;
        } else {
            echo 0;
        }
    }

    function getVehicleList()
    {
        $vendor_id = $this->request->getVar('vendor_id');
        $allvehicles =  $this->AdminModel->getOwnVehicleList($vendor_id);
        echo '<option value="">-- Select Vehicle --</option>';
        foreach($allvehicles as $vehicles)
        {
            echo '<option value="'.$vehicles->id.'">'.$vehicles->model_name.'</option>';
        }
    }
}
