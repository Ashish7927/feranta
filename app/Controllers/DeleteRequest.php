<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class DeleteRequest extends BaseController
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
            $data['Allstate'] = $this->AdminModel->GetAllRecord('delete_requests');

            return view('admin/delete_request_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'details' => $this->request->getPost('details')
            ];

            $this->AdminModel->InsertRecord('delete_requests', $data);
            return redirect()->to('delete-request');
        } else {
            return redirect()->to('admin/');
        }
    }

    function edit($id)
    {
        if ($this->session->get('user_id')) {

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'details' => $this->request->getPost('details')
            ];

            $this->AdminModel->UpdateRecordById('delete_requests', $id, $data);
            return redirect()->to('delete-request');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('user_id')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('delete_requests', $id);
            return redirect()->to('delete-request');
        } else {
            return redirect()->to('admin/');
        }
    }
}
