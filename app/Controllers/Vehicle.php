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
            if ($this->session->get('user_type') == 2) {

                $data['Allstate'] = $this->AdminModel->getFranchiseVehicle($this->session->get('franchise_id'));
            } else {
                $data['Allstate'] = $this->AdminModel->getAllVehicle();
            }

            $data['vehicleType'] = $this->AdminModel->getAllActiveRecord('vehicle_types');
            $data['AllVendor'] = $this->AdminModel->getAllVendor();
            $data['AllDriver'] = $this->AdminModel->getAllDriver();


            return view('admin/vehicle_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function create()
    {
        if ($this->session->get('user_id')) {

            $user_id = $this->session->get('user_id');

            $data['vehicleType'] = $this->AdminModel->getAllActiveRecord('vehicle_types');
            if ($this->session->get('user_type') == 2) {
                $data['AllVendor'] = $this->AdminModel->getFranchiseOwner($this->session->get('franchise_id'));
            } else {
                $data['AllVendor'] = $this->AdminModel->getAllVendor();
            }

            return view('admin/add_vehicle_vw', $data);
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


            $file = $this->request->getFile('insurance_img');
            if ($file->isValid() && !$file->hasMoved()) {
                $insurance_img = $file->getRandomName();
                $file->move('uploads/', $insurance_img);
            } else {
                $insurance_img = "";
            }

            $file1 = $this->request->getFile('fit_doc');
            if ($file1->isValid() && !$file1->hasMoved()) {
                $fit_doc = $file1->getRandomName();
                $file1->move('uploads/', $fit_doc);
            } else {
                $fit_doc = "";
            }

            $pollurion_doc = $this->request->getFile('pollurion_doc');
            if ($pollurion_doc->isValid() && !$pollurion_doc->hasMoved()) {
                $pollurion_doc1 = $pollurion_doc->getRandomName();
                $pollurion_doc->move('uploads/', $pollurion_doc1);
            } else {
                $pollurion_doc1 = "";
            }

            $file3 = $this->request->getFile('permit_doc');
            if ($file3->isValid() && !$file3->hasMoved()) {
                $permit_doc = $file3->getRandomName();
                $file3->move('uploads/', $permit_doc);
            } else {
                $permit_doc = "";
            }

            $rc_copy = $this->request->getFile('rc_copy');
            if ($rc_copy->isValid() && !$rc_copy->hasMoved()) {
                $rc_copy_doc = $rc_copy->getRandomName();
                $rc_copy->move('uploads/', $rc_copy_doc);
            } else {
                $rc_copy_doc = "";
            }


            $data = [
                'type_id' => $vehicle_type,
                'model_name' => $model_name,
                'regd_no' => $redg_no,
                'no_of_sit' => $no_of_sit,
                'vendor_id' => $vendor_id,

                'vehicle_make' => $this->request->getPost('vehicle_make'),
                'vehicle_body' => $this->request->getPost('vehicle_body'),
                'engine_no' => $this->request->getPost('engine_no'),
                'chassis_no' => $this->request->getPost('chassis_no'),
                'manufacture_yr' => $this->request->getPost('manufacture_yr'),
                'vehicle_cc' => $this->request->getPost('vehicle_cc'),
                'insurance_date_from' => $this->request->getPost('insurance_date_from'),
                'insurance_date_to' => $this->request->getPost('insurance_date_to'),
                'insurance_img' => $insurance_img,
                'fit_expr' => $this->request->getPost('fit_expr'),
                'fit_doc' => $fit_doc,
                'polution_exp_date' => $this->request->getPost('polution_exp_date'),
                'pollurion_doc' => $pollurion_doc1,
                'permit_expr_date' => $this->request->getPost('permit_expr_date'),
                'permit_doc' => $permit_doc,
                'rc_no' => $this->request->getPost('rc_no'),
                'rc_copy' => $rc_copy_doc,
                'booking_type' => $this->request->getPost('booking_type'),
                'status' => 0,
                'lift_vehicle_type' => $this->request->getPost('lift_vehicle_type'),
                'added_by' => $this->session->get('user_id')
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

            $data['vehicleType'] = $this->AdminModel->getAllActiveRecord('vehicle_types');
            if ($this->session->get('user_type') == 2) {
                $data['AllVendor'] = $this->AdminModel->getFranchiseOwner($this->session->get('franchise_id'));
            } else {
                $data['AllVendor'] = $this->AdminModel->getAllVendor();
            }
            $data['vehicle'] = $this->AdminModel->getSingleData('vehicle_details', $id);

            return view('admin/edit_vehicle_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }


    function update($id)
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
                    'no_of_sit' => $no_of_sit,
                    'vehicle_make' => $this->request->getPost('vehicle_make'),
                    'vehicle_body' => $this->request->getPost('vehicle_body'),
                    'engine_no' => $this->request->getPost('engine_no'),
                    'chassis_no' => $this->request->getPost('chassis_no'),
                    'manufacture_yr' => $this->request->getPost('manufacture_yr'),
                    'vehicle_cc' => $this->request->getPost('vehicle_cc'),
                    'insurance_date_from' => $this->request->getPost('insurance_date_from'),
                    'insurance_date_to' => $this->request->getPost('insurance_date_to'),
                    'fit_expr' => $this->request->getPost('fit_expr'),
                    'polution_exp_date' => $this->request->getPost('polution_exp_date'),
                    'permit_expr_date' => $this->request->getPost('permit_expr_date'),
                    'booking_type' => $this->request->getPost('booking_type'),
                    'lift_vehicle_type' => $this->request->getPost('lift_vehicle_type'),
                    'rc_no' => $this->request->getPost('rc_no')
                ];

                $file = $this->request->getFile('insurance_img');
                if ($file->isValid() && !$file->hasMoved()) {
                    $insurance_img = $file->getRandomName();
                    $file->move('uploads/', $insurance_img);
                    $data['insurance_img'] = $insurance_img;
                }

                $file1 = $this->request->getFile('fit_doc');
                if ($file1->isValid() && !$file1->hasMoved()) {
                    $fit_doc = $file1->getRandomName();
                    $file1->move('uploads/', $fit_doc);
                    $data['fit_doc'] = $fit_doc;
                }

                $pollurion_doc = $this->request->getFile('pollurion_doc');
                if ($pollurion_doc->isValid() && !$pollurion_doc->hasMoved()) {
                    $pollurion_doc1 = $pollurion_doc->getRandomName();
                    $pollurion_doc->move('uploads/', $pollurion_doc1);
                    $data['pollurion_doc'] = $pollurion_doc1;
                }

                $file3 = $this->request->getFile('permit_doc');
                if ($file3->isValid() && !$file3->hasMoved()) {
                    $permit_doc = $file3->getRandomName();
                    $file3->move('uploads/', $permit_doc);
                    $data['permit_doc'] = $permit_doc;
                }

                $rc_copy = $this->request->getFile('rc_copy');
                if ($rc_copy->isValid() && !$rc_copy->hasMoved()) {
                    $rc_copy_doc = $rc_copy->getRandomName();
                    $rc_copy->move('uploads/', $rc_copy_doc);
                    $data['rc_copy'] = $rc_copy_doc;
                }

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
            $driverStatus = $this->AdminModel->getSingleLastData('driver_vehicle_mapping', $id);

            if ((($state_status == 1 || $state_status == '1') && $details->driver_id == '') || (!empty($driverStatus) && $driverStatus->status == 0)) {

                return redirect()->to('vehicle')->with('message', "You can't active your vehicle untill a driver assigned!");
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
            $owner_id = $this->session->get('user_id');

            $vehicle_id = $this->request->getPost('vehicleId');
            $driver_id = $this->request->getPost('driver_id');

            $driverotp = $this->request->getPost('driverotp');
            $driverStatus = $this->request->getPost('driverStatus');

            $vehicleDetails = $this->AdminModel->getSingleData('vehicle_details', $vehicle_id);
            if ($vehicleDetails) {

                if ($driverotp == '' && $driverStatus != 'Requested') {

                    $driverDetails = $this->AdminModel->getSingleData('user', $driver_id);

                    if ($driverDetails->license_type == 'mcwg' && ($vehicleDetails->lift_vehicle_type == 1  || $vehicleDetails->booking_type != 2)) {
                        $message = 'Driver have not a valid license for assign such vehicle!';
                    } else {

                        if ($vehicleDetails->driver_id != '' && $vehicleDetails->driver_id != $driver_id) {
                            $data = [
                                'status'  => 3,
                                'updated_by' => $owner_id
                            ];
                            $this->AdminModel->updateDriverRemoved($vehicleDetails->driver_id, $vehicle_id, $data);
                        }

                        $this->db->query("UPDATE driver_vehicle_mapping SET status = 2, updated_by = $owner_id WHERE vehicle_id = $vehicle_id AND status = 0; ");

                        $otp = rand(100000, 999999);
                        $data = [
                            'driver_id' => $driver_id,
                            'vehicle_id' => $vehicle_id,
                            'owner_id' => $owner_id,
                            'updated_by' => $owner_id,
                            'status' => 0,
                            'otp' => $otp
                        ];

                        $this->AdminModel->InsertRecord('driver_vehicle_mapping', $data);

                        $message = 'Otp send to driver!';
                    }
                } else {

                    $otp = $driverotp;
                    $getRequestId = $this->db->query("SELECT * FROM driver_vehicle_mapping WHERE driver_id = $driver_id AND vehicle_id = $vehicle_id AND status = 0;")->getRow();

                    if (!empty($getRequestId)) {

                        if ($getRequestId->otp == $otp) {
                            $data = [
                                'status' => 1,
                                'updated_by' => $owner_id
                            ];
                            $this->AdminModel->UpdateRecordById('driver_vehicle_mapping', $vehicle_id, $data);

                            $data = [
                                'status' => 1,
                                'driver_id' => $driver_id
                            ];
                            $this->AdminModel->UpdateRecordById('vehicle_details', $vehicle_id, $data);

                            $message = 'Otp matched & vehicle assign to driver successfully!';
                        } else {
                            $message = 'Invalid OTP!!';
                        }
                    } else {

                        $message = 'Invalid Request!';
                    }
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

            if ($this->session->get('user_type') == 2) {

                $data['allDriverVehicle'] = $this->AdminModel->getFranchiseDriverVehicle($this->session->get('franchise_id'));
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
                'updated_by' => $user_id
            ];
            $this->AdminModel->UpdateRecordById('driver_vehicle_mapping', $id, $data);
            $data = [
                'status' => 1
            ];
            $this->AdminModel->UpdateRecordById('vehicle_details', $details->vehicle_id, $data);

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
                'updated_by' => $user_id
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
                'updated_by' => $user_id
            ];
            $this->AdminModel->UpdateRecordById('driver_vehicle_mapping', $id, $data);

            $data = [
                'driver_id'  => '',
                'status' => 0
            ];
            $this->AdminModel->UpdateRecordById('vehicle_details', $details->vehicle_id, $data);

            $message = 'Leave the vehice successfully!';
            return redirect()->to('vehicle/driver-vehicle')->with('message', $message);
        } else {
            return redirect()->to('admin/');
        }
    }
}
