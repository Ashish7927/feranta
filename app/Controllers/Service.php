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
            $remark = $this->request->getPost('remark');

            $origin = $this->AdminModel->getSingleData('city', $from_city, 'city_id');
            $destination = $this->AdminModel->getSingleData('city', $to_city, 'city_id');
            $vehicleDetails = $this->AdminModel->getSingleData('vehicle_details', $vehicle);
            $checkServicRate = $this->AdminModel->checkServicRate($origin->state_id, $vehicleDetails->type_id);
            if (!empty($checkServicRate)) {
                // Set up API key and other parameters
                $apiKey = 'AIzaSyAX9w0uT7e_Ohjm_FHv7dHNOjvoFdeDe04';


                // Make API request
                $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin->city_name}&destinations={$destination->city_name}&key={$apiKey}";
                $response = file_get_contents($url);

                // Parse API response
                $data = json_decode($response, true);

                // Check if response is successful
                if ($data['status'] == 'OK') {
                    $distance = $data['rows'][0]['elements'][0]['distance']['value'];
                    $km = round($distance / 100);
                    $full_fare = $km * $checkServicRate->full_fare;
                    $fare_per_sit = $km * $checkServicRate->fare_per_share;
                    $serviceRate = $checkServicRate->id;
                } else {
                    return redirect()->to('service')->with('message', $data['error_message']);
                }
            } else {
                $full_fare = 0;
                $fare_per_sit = 0;
                $serviceRate = 0;
            }


            $data = [
                'vehicle_id' => $vehicle,
                'boarding_date' => $boarding_date,
                'arrival_datetime' => $arrival_datetime,
                'from_city' => $from_city,
                'to_city' => $to_city,
                'service_rate' => $serviceRate,
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
            $remark = $this->request->getPost('remark');


            $origin = $this->AdminModel->getSingleData('city', $from_city, 'city_id');
            $destination = $this->AdminModel->getSingleData('city', $to_city, 'city_id');
            $vehicleDetails = $this->AdminModel->getSingleData('vehicle_details', $vehicle);
            $checkServicRate = $this->AdminModel->checkServicRate($origin->state_id, $vehicleDetails->type_id);
            if (!empty($checkServicRate)) {
                // Set up API key and other parameters
                $apiKey = 'AIzaSyAX9w0uT7e_Ohjm_FHv7dHNOjvoFdeDe04';


                // Make API request
                $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin->city_name}&destinations={$destination->city_name}&key={$apiKey}";
                $response = file_get_contents($url);

                // Parse API response
                $data = json_decode($response, true);

                // Check if response is successful
                if ($data['status'] == 'OK') {
                    $distance = $data['rows'][0]['elements'][0]['distance']['value'];
                    $km = round($distance / 100);
                    $full_fare = $km * $checkServicRate->full_fare;
                    $fare_per_sit = $km * $checkServicRate->fare_per_share;
                    $serviceRate = $checkServicRate->id;
                } else {
                    return redirect()->to('service')->with('message', $data['error_message']);
                }
            } else {
                $full_fare = 0;
                $fare_per_sit = 0;
                $serviceRate = 0;
            }




            // Check Booking, if no booking then only can update else not! 
            // if (count($Countstate) == 0) {

            $data = [
                'vehicle_id' => $vehicle,
                'vehicle_type' => $vehicleDetails->type_id,
                'boarding_date' => $boarding_date,
                'arrival_datetime' => $arrival_datetime,
                'from_city' => $from_city,
                'to_city' => $to_city,
                'service_rate' => $serviceRate,
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
        foreach ($allvehicles as $vehicles) {
            echo '<option value="' . $vehicles->id . '">' . $vehicles->model_name . '</option>';
        }
    }
}
