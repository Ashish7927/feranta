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
            $data['AllVendor'] = $this->AdminModel->getAllVendor();
            $data['AllDriver'] = $this->AdminModel->getAllDriver();


            return view('admin/vehicle_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {
            $vendor_id = $this->request->getPost('vendor_id');
            $no_of_sit = $this->request->getPost('no_of_sit');
            $redg_no = $this->request->getPost('redg_no');
            $model_name = $this->request->getPost('model_name');
            $vehicle_type = $this->request->getPost('vehicle_type');

            $data = [
                'type_id' => $vehicle_type,
                'model_name' => $model_name,
                'regd_no' => $redg_no,
                'no_of_sit' => $no_of_sit,
                'vendor_id' => $vendor_id,
                'status' => 0
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

            $Countstate = $this->db->query("SELECT * FROM vehicle_details  where regd_no='" . $redg_no . "' and id!= " . $id)->getResult();

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
            $details = $this->AdminModel->getSingleData('vehicle_details', $id);
            if(($state_status == 1 || $state_status == '1') && $details->driver_id == ''){
                return redirect()->to('vehicle');
            }

            $data = [
                'status'  => $state_status,
            ];

            $this->AdminModel->UpdateRecordById('vehicle_details', $id, $data);
            return redirect()->to('vehicle');
        } else {
            return redirect()->to('Admin/');
        }
    }

    function updateDriver()
    {
        if ($this->session->get('user_id')) {
            $user_id=$this->session->get('user_id');
            $vehicleId = $this->request->getPost('vehicleId');
            $driver_id = $this->request->getPost('driver_id');
            $vehicleDetails = $this->AdminModel->getSingleData('vehicle_details', $vehicleId);
            if ($vehicleDetails) {

                $checkDriverStatus = $this->AdminModel->driverVehicleData($driver_id, $vehicleId);
                $success = 0;
                $message = '';
                if (!empty($checkDriverStatus) &&  count($checkDriverStatus) > 0) {
                    if ($checkDriverStatus[0]->status == 2 || $checkDriverStatus[0]->status == 3) {
                        $success = 1;
                    } else if ($checkDriverStatus[0]->status == 1) {
                        $message = 'Already assign!';
                    } else {
                        $message = 'Already requested!';
                    }
                } else {
                    $success = 1;
                }

                if ($success == 1) {
                    if ($vehicleDetails->driver_id != '' && $vehicleDetails->driver_id != $driver_id) {
                        $data = [
                            'status'  => 3,
                            'updated_by'=>$user_id
                        ];
                        $this->AdminModel->updateDriverRemoved($vehicleDetails->driver_id,$vehicleId, $data);
                        
                    }
                    
                    $data = [
                        'driver_id' => $driver_id,
                        'vehicle_id' => $vehicleId,
                        'owner_id' => $vehicleDetails->vendor_id,
                        'updated_by' => $this->session->get('user_id'),
                        'status' => 0
                    ];

                    $this->AdminModel->InsertRecord('driver_vehicle_mapping', $data);

                    $data = [
                        'driver_id'  => $driver_id,
                        'status' => 0
                    ];
                    $this->AdminModel->UpdateRecordById('vehicle_details', $vehicleId, $data);
                    $message = 'Assigned successfully!';
                }
            } else {
                $message = 'some thing went wrong!';
            }
            return redirect()->to('vehicle')->with('message', $message);
        } else {
            return redirect()->to('admin/');
        }
    }

    function driverVehicle()
    {
        if ($this->session->get('user_id')) {

            $user_id = $this->session->get('user_id');
            $userDetails = $this->AdminModel->getSingleData('user', $user_id);
            if ($userDetails->user_type == 4) {
                $data['allDriverVehicle'] = $this->AdminModel->getDriverVehicle();
            } elseif ($userDetails->user_type == 3) {
                $data['allDriverVehicle'] = $this->AdminModel->getDriverVehicle();
            } else {
                $data['allDriverVehicle'] = $this->AdminModel->getDriverVehicle();
            }

            return view('admin/driver_vehicle', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function acceptRequest($id)
    {
        if ($this->session->get('user_id')) {
            $user_id = $this->session->get('user_id');
            $details = $this->AdminModel->getSingleData('driver_vehicle_mapping', $id);
            $data = [
                'status'  => 1,
                'updated_by'=>$user_id
            ];
            $this->AdminModel->UpdateRecordById('driver_vehicle_mapping', $id, $data);
            $data = [
                'status' => 1
            ];
            $this->AdminModel->UpdateRecordById('vehicle_details',$details->vehicle_id, $data);

            $message = 'Request Accepted successfully!';
            return redirect()->to('vehicle/driver-vehicle')->with('message', $message);
        } else {
            return redirect()->to('admin/');
        }
    }

    function rejectRequest($id)
    {
        if ($this->session->get('user_id')) {

            $user_id = $this->session->get('user_id');
            $data = [
                'status'  => 2,
                'updated_by'=>$user_id
            ];
            $this->AdminModel->UpdateRecordById('driver_vehicle_mapping', $id, $data);
            $message = 'Request Rejected successfully!';
            return redirect()->to('vehicle/driver-vehicle')->with('message', $message);

        } else {
            return redirect()->to('admin/');
        }
    }

    function leaveVehicle($id)
    {
        if ($this->session->get('user_id')) {
            $user_id = $this->session->get('user_id');
            $details = $this->AdminModel->getSingleData('driver_vehicle_mapping', $id);
            $data = [
                'status'  => 3,
                'updated_by'=>$user_id
            ];
            $this->AdminModel->UpdateRecordById('driver_vehicle_mapping', $id, $data);

            $data = [
                'driver_id'  => '',
                'status' => 0
            ];
            $this->AdminModel->UpdateRecordById('vehicle_details',$details->vehicle_id, $data);

            $message = 'Leave the vehice successfully!';
            return redirect()->to('vehicle/driver-vehicle')->with('message', $message);
        } else {
            return redirect()->to('admin/');
        }
    }
}
