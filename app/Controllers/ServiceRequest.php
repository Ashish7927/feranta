<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class ServiceRequest extends BaseController
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

            $data['AllServiceRequest'] = $this->AdminModel->getAllBookingRequest();

            return view('admin/servicerequest_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function status()
    {
        if ($this->session->get('user_id')) {
            $id  = $this->request->getPost('id');
            $state_status = $this->request->getPost('state_status');
            $requestDetails = $this->AdminModel->getSingleData('service_request', $id);
            $serviceDetails = $this->AdminModel->getSingleData('service_details', $requestDetails->service_id);
            if ($state_status == 1) {

                $data = [
                    'status'  => 1,
                ];
                $this->AdminModel->UpdateRecordById('service_request', $id, $data);
                $data = [
                    'vehicle_id'  => $serviceDetails->vehicle_id,
                    'driver_id'  => $requestDetails->driver_id,
                    'status'  => 1
                ];
                $this->AdminModel->UpdateRecordById('service_bookings', $serviceDetails->booking_id, $data);
                $data = [
                    'status'  => 2,
                ];
                $this->db->query("UPDATE service_request SET status = 2 WHERE booking_id = $serviceDetails->booking_id AND status = 0 ");
            } else {

                $data = [
                    'status'  => 3,
                ];
                $this->AdminModel->UpdateRecordById('service_request', $id, $data);

                $resuestall = $this->AdminModel->getAllrequestStatuswise($serviceDetails->booking_id, 0);
                if (empty($resuestall) || count($resuestall) == 0) {
                    $data = [
                        'status'  => 3
                    ];
                    $this->AdminModel->UpdateRecordById('service_bookings', $serviceDetails->booking_id, $data);
                }
            }

            return redirect()->to('service-request');
        } else {
            return redirect()->to('Admin/');
        }
    }
}
