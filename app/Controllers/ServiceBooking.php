<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class ServiceBooking extends BaseController
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
            $data['vehicleType'] = $this->AdminModel->getAllActiveRecord('vehicle_types');
            $data['cities'] = $this->AdminModel->GetAllcity();
            $data['allBooking'] = $this->AdminModel->getAllBookingData();

            return view('admin/servicebooking_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {
            $user_id = $this->session->get('user_id');
            $booking_type = $this->request->getPost('booking_type');
            $boarding_date = $this->request->getPost('boarding_date');
            $vehicle_type = $this->request->getPost('vehicle_type');
            $from_location = $this->request->getPost('from_location');
            $to_location = $this->request->getPost('to_location');
            $success = 0;
            if ($booking_type == 'cab') {
                $checkAvailbility = $this->AdminModel->checkServiceAvailbility($vehicle_type, $from_location, $to_location);
                if (!empty($checkAvailbility) && count($checkAvailbility) > 0) {
                    $success = 1;
                    $service_rate = $checkAvailbility[0]->service_rate;
                    $totalfare = $checkAvailbility[0]->full_fare;
                } else {
                    return redirect()->to('service-booking')->with('message', 'Sorry! No service availble on this root');
                }
            } elseif ($booking_type == 'sharing') {
                $checkAvailbility = $this->AdminModel->checkServiceAvailbility($vehicle_type, $from_location, $to_location);
                if (!empty($checkAvailbility) && count($checkAvailbility) > 0) {
                    $success = 1;
                    $service_rate = $checkAvailbility[0]->service_rate;
                    $totalfare = $checkAvailbility[0]->fare_per_sit;
                } else {
                    return redirect()->to('service-booking')->with('message', 'Sorry! No service availble on this root');
                }
            } elseif ($booking_type == 'future_cab') {
                $success = 0;
            } else {
                return redirect()->to('service-booking')->with('message', 'Booking Registration Failed!');
            }

            if ($success == 1) {
                $data = [
                    'user_id' => $user_id,
                    'booking_type' => $booking_type,
                    'vehicle_type' => $vehicle_type,
                    'from_location' => $from_location,
                    'to_location' => $to_location,
                    'boarding_date' => $boarding_date,
                    'service_rate' => $service_rate,
                    'fare' => $totalfare,
                    'vehicle_id' => '',
                    'driver_id' => '',
                    'status' => 0,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'updated_at' => date('Y-m-d H:i:s')

                ];

                $booking_id = $this->AdminModel->InsertService($data);

                foreach ($checkAvailbility as $service) {

                    $data = [
                        'booking_id' => $booking_id,
                        'service_id' => $service->id,
                        'driver_id' => $service->driver_id,
                        'status' => 0
                    ];
                    $this->AdminModel->InsertRecord('service_request', $data);
                }

                return redirect()->to('service-booking')->with('message', 'Booking register successfully!');
            } else {
                return redirect()->to('service-booking')->with('service-booking', 'Something went wrong!');
            }
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
            return redirect()->to('service-booking');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('user_id')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('service_details', $id);
            return redirect()->to('service-booking');
        } else {
            return redirect()->to('admin/');
        }
    }

    function status()
    {
        if ($this->session->get('user_id')) {
            $id  = $this->request->getPost('state_id');
            $state_status = $this->request->getPost('state_status');

            if($state_status == 0){
                $data = [
                    'status'  => 2,
                ];
                $this->AdminModel->UpdateRecordById('service_bookings', $id, $data);

                $this->db->query("UPDATE service_request SET status = 2 WHERE booking_id = $id ");
                // $this->db->query("UPDATE service_request SET status = 2 WHERE booking_id = $id AND status = 0 ");

            }else{
                $data = [
                    'status'  => 4,
                ];
                $this->AdminModel->UpdateRecordById('service_bookings', $id, $data);
            }

            return redirect()->to('service-booking');
        } else {
            return redirect()->to('Admin/');
        }
    }
}
