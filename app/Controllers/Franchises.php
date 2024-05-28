<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class Franchises extends BaseController
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
            $data['allstate'] = $this->AdminModel->GetAllstate();
            $data['allcity'] = $this->AdminModel->GetAllcity();
            $data['franchises'] = $this->AdminModel->GetAllRecord('franchises');

            return view('admin/franchise_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {

            $data = [
                'franchise_name' => $this->request->getPost('franchise_name'),
                'email' => $this->request->getPost('email'),
                'contact' => $this->request->getPost('contact'),
                'address' => $this->request->getPost('address'),
                'state' => $this->request->getPost('state'),
                'city' => $this->request->getPost('city'),
                'status' => 1

            ];

            $this->AdminModel->InsertRecord('franchises', $data);
            return redirect()->to('franchises');
        } else {
            return redirect()->to('admin/');
        }
    }

    function edit($id)
    {
        if ($this->session->get('user_id')) {

            $state = $this->request->getPost('franchise_name');
            $Countstate = $this->db->query("SELECT * FROM franchises  where franchise_name='$state' and id!='$id' ")->getResult();

            if (count($Countstate) == 0) {
                $data = [
                    'franchise_name' => $this->request->getPost('franchise_name'),
                    'email' => $this->request->getPost('email'),
                    'contact' => $this->request->getPost('contact'),
                    'address' => $this->request->getPost('address'),
                    'state' => $this->request->getPost('state'),
                    'city' => $this->request->getPost('city')

                ];
                $this->AdminModel->UpdateRecordById('franchises', $id, $data);
            } else {
                $this->session->setFlashdata('msg', 'Franchise Already  exist.');
                $this->session->setFlashdata('uid', $id);
            }
            return redirect()->to('franchises');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('franchiseid')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('franchises', $id);
            return redirect()->to('franchises');
        } else {
            return redirect()->to('admin/');
        }
    }

    function status()
    {
        if ($this->session->get('user_id')) {
            $id  = $this->request->getPost('franchise_id');
            $state_status = $this->request->getPost('state_status');

            $data = [
                'status'  => $state_status,
            ];

            $this->AdminModel->UpdateRecordById('franchises', $id, $data);
            return redirect()->to('franchises');
        } else {
            return redirect()->to('Admin/');
        }
    }
}
