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
            $data['franchises'] = $this->AdminModel->GetAllFranchises();
            return view('admin/franchise_vw', $data);
        } else {
            return redirect()->to('admin/');
        }
    }

    function add()
    {
        if ($this->session->get('user_id')) {

            $email = $this->request->getPost('email');
            $contact = $this->request->getPost('contact');
            $username = $this->request->getPost('username');

            $CountEmail = $this->db->query("SELECT * FROM user  where email='$email'")->getResult();
            $CountContact = $this->db->query("SELECT * FROM user  where contact_no='$contact'")->getResult();
            $CountUsername = $this->db->query("SELECT * FROM user  where user_name='$username'")->getResult();

            if (count($CountEmail) != 0) {
                return redirect()->back()->withInput()->with('message', 'Email  Already  exist.');
            } else {
                if (count($CountContact) != 0) {
                    return redirect()->back()->withInput()->with('message', 'Contact No  Already  exist.');
                } else {

                    if (count($CountUsername) != 0) {
                        return redirect()->back()->withInput()->with('message', 'Username  Already  exist.');
                    } else {




                        $data = [
                            'franchise_name' => $this->request->getPost('franchise_name'),
                            'email' => $this->request->getPost('email'),
                            'contact' => $this->request->getPost('contact'),
                            'address' => $this->request->getPost('address'),
                            'pincode' => $this->request->getPost('pincode'),
                            'state' => $this->request->getPost('state'),
                            'city' => $this->request->getPost('city'),
                            'status' => 1

                        ];

                        $franchise_id = $this->AdminModel->InsertFranchise($data);

                        $data = [
                            'full_name' => $this->request->getPost('franchise_name'),
                            'email' => $this->request->getPost('email'),
                            'contact_no' => $this->request->getPost('contact'),
                            'address1' => $this->request->getPost('address'),
                            'state_id' => $this->request->getPost('state'),
                            'city_id' => $this->request->getPost('city'),
                            'user_name' => $this->request->getPost('username'),
                            'password' => base64_encode(base64_encode($this->request->getVar('password'))),
                            'user_type' => 2,
                            'franchise_id' => $franchise_id,
                            'is_admin' => 1,
                            'status' => 1

                        ];

                        $this->AdminModel->InsertRecord('user', $data);

                        return redirect()->to('franchises');
                    }
                }
            }
        } else {
            return redirect()->to('admin/');
        }
    }

    function edit($id)
    {
        if ($this->session->get('user_id')) {

            $email = $this->request->getPost('email');
            $contact = $this->request->getPost('contact');
            $username = $this->request->getPost('username');

            $state = $this->request->getPost('franchise_name');
            $Countstate = $this->db->query("SELECT * FROM franchises  where franchise_name='$state' and id!='$id' ")->getResult();

            if (count($Countstate) == 0) {

                $CountEmail = $this->db->query("SELECT * FROM user  where email='$email' and id!='$id' ")->getResult();
                $CountContact = $this->db->query("SELECT * FROM user  where contact_no='$contact' and id!='$id' ")->getResult();
                $CountUsername = $this->db->query("SELECT * FROM user  where user_name='$username' and id!='$id' ")->getResult();
                if (count($CountEmail) != 0) {
                    return redirect()->back()->withInput()->with('msg', 'Email  Already  exist.');
                } else {
                    if (count($CountContact) != 0) {
                        return redirect()->back()->withInput()->with('msg', 'Contact No  Already  exist.');
                    } else {

                        if (count($CountUsername) != 0) {
                            return redirect()->back()->withInput()->with('msg', 'Username  Already  exist.');
                        } else {
                            $data = [
                                'franchise_name' => $this->request->getPost('franchise_name'),
                                'email' => $this->request->getPost('email'),
                                'contact' => $this->request->getPost('contact'),
                                'address' => $this->request->getPost('address'),
                                'pincode' => $this->request->getPost('pincode'),
                                'state' => $this->request->getPost('state'),
                                'city' => $this->request->getPost('city')

                            ];
                            $this->AdminModel->UpdateRecordById('franchises', $id, $data);

                            $data1 = [
                                'full_name' => $this->request->getPost('franchise_name'),
                                'email' => $this->request->getPost('email'),
                                'contact_no' => $this->request->getPost('contact'),
                                'address1' => $this->request->getPost('address'),
                                'state_id' => $this->request->getPost('state'),
                                'city_id' => $this->request->getPost('city'),
                                'user_name' => $this->request->getPost('username'),
                                'password' => base64_encode(base64_encode($this->request->getVar('password')))
                            ];
                            $user_id = $this->request->getPost('francise_user_id');
                            $this->AdminModel->UpdateRecordById('user', $user_id, $data1);
                        }
                    }
                }
            } else {
                $this->session->setFlashdata('msg', 'Franchise Name Already  exist.');
                $this->session->setFlashdata('uid', $id);
            }
            return redirect()->to('franchises');
        } else {
            return redirect()->to('admin/');
        }
    }

    function delete()
    {
        if ($this->session->get('user_id')) {
            $id = $this->request->getPost('id');
            $this->AdminModel->DeleteRecordById('franchises', $id);

            $this->db->query("DELETE FROM `user` WHERE `franchise_id` = $id ");
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

            $this->db->query("UPDATE user SET status = $state_status  WHERE franchise_id = $id AND is_admin = 1;");

            return redirect()->to('franchises');
        } else {
            return redirect()->to('Admin/');
        }
    }

    function memberTracking()
    {
        if ($this->session->get('user_id')) {

            $data['member_track'] = $this->AdminModel->GetAllRecord('members_checkin');

            if ($this->session->get('user_type') == 2) {

                $data['allvendor'] = $this->AdminModel->GetFranchiseMember($this->session->get('franchise_id'));
            } else {
                $data['allvendor'] = $this->AdminModel->GetAllMember();
            }
            return view('admin/member_track_vw', $data);
        } else {
            return redirect()->to('Admin/');
        }
    }

    function getAttendanceData()
    {
        $member_id = $this->request->getPost('member_id');
        $Listdata = $this->AdminModel->getMemebrCheckinCheckoutList($member_id);
        $html = '';
        $i = 1;
        foreach ($Listdata as $data) {
            $html .= "<tr>
              <th>$i</th>
              <th>$data->type</th>
              <th>$data->date</th>
              <th>$data->time</th>
              <th>$data->location</th>
              <th><img src='" . base_url() . "/uploads/" . $data->image . "' class='img-circle' width='50px'></th>
              </tr>";
            $i++;
        }

        echo $html;
    }
}
