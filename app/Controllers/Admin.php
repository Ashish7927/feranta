<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class Admin extends BaseController
{
	public function __construct()
	{
		$db = db_connect();
		$this->db = db_connect();

		$this->AdminModel = new AdminModel(db_connect());
		$this->session = session();
		helper(['form', 'url', 'validation']);
	}
	public function index()
	{

		if ($this->session->get('user_id')) {

			return redirect()->to('admin/dashboard');
		} else {
			return view('admin/login');
		}
	}
	function loginAuth()
	{

		$session = session();
		$AdminModel = new AdminModel();
		$username = $this->request->getVar('username');
		$password = base64_encode(base64_encode($this->request->getVar('password')));
		$data = $AdminModel->where('user_name', $username)->first();

		if ($data) {
			$pass = $data['password'];
			$status = $data['status'];
			$user_type = $data['user_type'];
			//$authenticatePassword = password_verify($password, $pass);

			if ($pass == $password) {

				if ($user_type == 1 || ($user_type == 2 && $data['is_admin'] == 1)) {
					if ($status = 1) {
						$ses_data = [
							'user_id' => $data['id'],
							'fullname' => $data['full_name'],
							'email' => $data['email'],
							'user_type' => $data['user_type'],
							'franchise_id' => $data['franchise_id'],
							'isLoggedIn' => TRUE
						];
						$session->set($ses_data);
						return redirect()->to('admin/dashboard');
					} else {
						$session->setFlashdata('msg', 'Your Account is Inactive, Contact to Admin!');
						return redirect()->to('admin/');
					}
				} else {
					$session->setFlashdata('msg', 'Invalid Request');
					return redirect()->to('admin/');
				}
			} else {
				$session->setFlashdata('msg', 'Password is incorrect.');
				return redirect()->to('admin/');
			}
		} else {
			$session->setFlashdata('msg', 'username does not exist.');
			return redirect()->to('admin/');
		}
	}
	function profile()
	{

		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);


			return view('admin/profile_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function pro()
	{

		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);


			$rules = [
				'fullname' => 'required|min_length[3]',
				'email' => 'required|valid_email',
				'contact' => 'required|numeric|max_length[10]',
				'username' => 'required|min_length[5]',
				'password' => 'required|min_length[6]',

			];

			if ($this->validate($rules)) {
				$fullname = $this->request->getPost('fullname');
				$email = $this->request->getPost('email');
				$contact = $this->request->getPost('contact');
				$username = $this->request->getPost('username');
				$password = base64_encode(base64_encode($this->request->getVar('password')));

				$file = $this->request->getFile('img');
				if ($file->isValid() && !$file->hasMoved()) {
					$imagename = $file->getRandomName();
					$file->move('uploads/', $imagename);
				} else {
					$imagename = "";
				}

				if ($imagename != '') {
					$data = [
						'full_name' => $fullname,
						'email' => $email,
						'contact_no' => $contact,
						'user_name' => $username,
						'password' => $password,
						'profile_image' => $imagename,
					];
				} else {
					$data = [
						'full_name' => $fullname,
						'email' => $email,
						'contact_no' => $contact,
						'user_name' => $username,
						'password' => $password,
					];
				}

				$this->AdminModel->UpdateProfile($data, $user_id);

				return redirect()->to('admin/profile');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/profile_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}
	function setting()
	{

		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			return view('admin/Setting_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function updatesetting()
	{
		$settingid = $this->request->getPost('settingid');
		$title = $this->request->getPost('title');
		$tagline = $this->request->getPost('tagline');
		$desc = $this->request->getPost('desc');
		$facebook = $this->request->getPost('facebook');
		$tweeter = $this->request->getPost('tweeter');
		$google = $this->request->getPost('google');
		$linkdin = $this->request->getPost('linkdin');
		$instagram = $this->request->getPost('instagram');
		$file = $this->request->getFile('img');
		if ($file->isValid() && !$file->hasMoved()) {
			$imagename = $file->getRandomName();
			$file->move('uploads/', $imagename);
		} else {
			$imagename = "";
		}
		if ($imagename != '') {
			$data = [
				'title' => $title,
				'tagline' => $tagline,
				'description' => $desc,
				'facebook' => $facebook,
				'tweeter' => $tweeter,
				'google' => $google,
				'linkdin' => $linkdin,
				'instagram' => $instagram,
				'logo' => $imagename
			];
		} else {

			$data = [
				'title' => $title,
				'tagline' => $tagline,
				'description' => $desc,
				'facebook' => $facebook,
				'tweeter' => $tweeter,
				'google' => $google,
				'linkdin' => $linkdin,
				'instagram' => $instagram

			];
		}
		//echo "<pre>";
		//print_r($data);exit;

		$this->AdminModel->UpdateSetting($data, $settingid);
		return redirect()->to('admin/Setting');
	}
	public function Logout()
	{
		$session = session();
		$session->destroy();
		return redirect()->to('/admin');
	}
	function dashboard()
	{

		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			return view('admin/dashboard_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}


	public function Customer()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['customer'] = $this->AdminModel->GetAllCustomer(5);

			return view('admin/customer_vw', $data);
		} else {
			return redirect()->to('Admin/');
		}
	}
	function Insertcustomer()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['customer'] = $this->AdminModel->GetAllCustomer(4);


			$rules = [
				'customername' => 'required|min_length[3]',
				'customercontno' => 'required|numeric|exact_length[10]|is_unique[user.contact_no]',
			];

			if ($this->validate($rules)) {
				$customername = $this->request->getPost('customername');
				$customeremail = $this->request->getPost('customeremail');
				$customercontno = $this->request->getPost('customercontno');
				$data = [
					'full_name' => $customername,
					'email' => $customeremail,
					'contact_no' => $customercontno,
					'user_type' => 4,


				];

				$this->db->table('user')->insert($data);
				return redirect()->to('Admin/Customer');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/customer_vw', $data);
			}
		} else {
			return redirect()->to('Admin/');
		}
	}
	function Editcustomer()
	{
		if ($this->session->get('user_id')) {
			$customerid = $this->request->getPost('customerid');
			$customername = $this->request->getPost('customername');
			$customeremail = $this->request->getPost('customeremail');
			$customercontno = $this->request->getPost('customercontno');
			$data = [
				'full_name' => $customername,
				'email' => $customeremail,
				'contact_no' => $customercontno,
				'user_type' => 4,
			];
			$this->db->table('user')->update($data, array('id' => $customerid));
			return redirect()->to('Admin/Customer');
		} else {
			return redirect()->to('Admin/');
		}
	}
	function statuscustomer()
	{
		if ($this->session->get('user_id')) {
			$customer_id = $this->request->getPost('customer_id');
			$customer_status = $this->request->getPost('customer_status');

			$data = [
				'status' => $customer_status,
			];

			$this->db->table('user')->update($data, array('id' => $customer_id));
			return redirect()->to('Admin/Customer');
		} else {
			return redirect()->to('Admin/');
		}
	}
	function deletecustomer()
	{
		$custid = $this->request->getPost('user_id');
		$this->db->table('user')->delete(array('id' => $custid));
		return redirect()->to('Admin/Customer');
	}




	function Subadmin()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['allsubadmin'] = $this->AdminModel->GetAllCustomer(2);

			return view('admin/sub_admin_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function addsubadmin()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['allsubadmin'] = $this->AdminModel->GetAllCustomer(2);
			$rules = [
				'name' => 'required|min_length[3]',
				'email' => 'required|valid_email|is_unique[user.email]',
				'contact' => 'required|numeric|max_length[10]|is_unique[user.contact_no]',
				'username' => 'required|max_length[10]|is_unique[user.user_name]',
				'password' => 'required|min_length[6]',
			];

			if ($this->validate($rules)) {
				$file = $this->request->getFile('img');
				if ($file->isValid() && !$file->hasMoved()) {
					$imagename = $file->getRandomName();
					$file->move('uploads/', $imagename);
				} else {
					$imagename = "";
				}


				$data = [
					'full_name' => $this->request->getVar('name'),
					'email'  => $this->request->getVar('email'),
					'user_name'  => $this->request->getVar('username'),
					'contact_no'  => $this->request->getVar('contact'),
					'password'  => base64_encode(base64_encode($this->request->getVar('password'))),
					'profile_image'  => $imagename,
					'status'  => 1,
					'user_type'  => 1
				];

				$this->AdminModel->adduser($data);
				return redirect()->to('admin/Subadmin');
			} else {
				$data['validation'] = $this->validator;
				echo view('admin/sub_admin_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}
	function deleteSubadmin()
	{
		if ($this->session->get('user_id')) {
			$user_id = $this->request->getVar('user_id');
			$this->AdminModel->deleteuser($user_id);
			return redirect()->to('admin/Subadmin');
		} else {
			return redirect()->to('admin/');
		}
	}
	function statusBlock()
	{
		$user_id = $this->request->uri->getSegment(3);
		$data = [
			'status'  => 0
		];
		$this->AdminModel->UserStatusActive($data, $user_id);
		redirect('/', 'refresh');
	}
	function statusActive()
	{
		$user_id = $this->request->uri->getSegment(3);
		$data = [
			'status'  => 1
		];
		$this->AdminModel->UserStatusActive($data, $user_id);
		return redirect()->to('admin/Subadmin');
	}
	function editsubadmin()
	{
		if ($this->session->get('user_id')) {

			$id = $this->request->getPost('id');
			$name = $this->request->getPost('name');
			$email = $this->request->getPost('email');
			$contact = $this->request->getPost('contact');
			$username = $this->request->getPost('username');
			$password = base64_encode(base64_encode($this->request->getVar('password')));

			$CountEmail = $this->db->query("SELECT * FROM user  where email='$email' and id!='$id' ")->getResult();
			$CountContact = $this->db->query("SELECT * FROM user  where contact_no='$contact' and id!='$id' ")->getResult();
			$CountUsername = $this->db->query("SELECT * FROM user  where user_name='$username' and id!='$id' ")->getResult();
			if (count($CountEmail) == 0) {
				if (count($CountContact) == 0) {

					if (count($CountUsername) == 0) {
						$file = $this->request->getFile('img');
						if ($file->isValid() && !$file->hasMoved()) {
							$imagename = $file->getRandomName();
							$file->move('uploads/', $imagename);
						} else {
							$imagename = "";
						}


						if ($imagename) {
							$data = [
								'full_name' => $name,
								'email'  => $email,
								'user_name'  => $username,
								'contact_no'  => $contact,
								'password'  => $password,
								'profile_image'  => $imagename,
								'status'  => 1,
								'user_type'  => 1
							];
						} else {

							$data = [
								'full_name' => $name,
								'email'  => $email,
								'user_name'  => $username,
								'contact_no'  => $contact,
								'password'  => $password,
								'status'  => 1,
								'user_type'  => 1
							];
						}

						$this->AdminModel->updateUser($data, $id);
						return redirect()->to('admin/Subadmin');
					} else {
						$this->session->setFlashdata('msg', 'Username  Already  exist.');
						$this->session->setFlashdata('uid', $id);
					}
				} else {
					$this->session->setFlashdata('msg', 'Contact Number  Already  exist.');
					$this->session->setFlashdata('uid', $id);
				}
			} else {
				$this->session->setFlashdata('msg', 'Email Already  exist.');
				$this->session->setFlashdata('uid', $id);
			}


			return redirect()->to('admin/Subadmin');
		} else {
			return redirect()->to('admin/');
		}
	}
	function role()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');
			//	if ($this->session->get('user_type')!=1 AND $this->session->get('user_type')!=2 ){return redirect()->to('admin/');}

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['allsubadmin'] = $this->AdminModel->GetAllCustomer(2);

			$id = $this->request->getVar('id');
			$role = $this->request->getVar('role[]');

			$job = implode(',', $role);

			$data = [
				'roles' => $job,
			];

			$this->db->table('user')->update($data, array('id' => $id));

			return redirect()->to('admin/Subadmin');
		} else {
			return redirect()->to('Admin/');
		}
	}


	function State()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['Allstate'] = $this->AdminModel->GetAllstate();


			return view('admin/state_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function addstate()
	{
		if ($this->session->get('user_id')) {
			$state = $this->request->getPost('statename');
			$data = [
				'state_name' => $state

			];

			$this->AdminModel->AddState($data);
			return redirect()->to('admin/State');
		} else {
			return redirect()->to('admin/');
		}
	}

	function editstate()
	{
		if ($this->session->get('user_id')) {
			$stateid = $this->request->getPost('stateid');
			$state = $this->request->getPost('statename');

			$Countstate = $this->db->query("SELECT * FROM state  where state_name='$state' and state_id!='$stateid' ")->getResult();

			if (count($Countstate) == 0) {
				$data = [
					'state_name' => $state
				];
				$this->AdminModel->Editstate($data, $stateid);
			} else {
				$this->session->setFlashdata('msg', 'State Already  exist.');
				$this->session->setFlashdata('uid', $stateid);
			}
			return redirect()->to('admin/State');
		} else {
			return redirect()->to('admin/');
		}
	}
	function deletestate()
	{
		$stateid = $this->request->getPost('user_id');
		$this->db->table('state')->delete(array('state_id' => $stateid));
		return redirect()->to('Admin/State');
	}

	function statusstate()
	{
		if ($this->session->get('user_id')) {
			$state_id  = $this->request->getPost('state_id');
			$state_status = $this->request->getPost('state_status');

			$data = [
				'state_status'  => $state_status,
			];

			$this->db->table('state')->update($data, array('state_id' => $state_id));
			return redirect()->to('Admin/State');
		} else {
			return redirect()->to('Admin/');
		}
	}

	function Pincode()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['Allstate'] = $this->AdminModel->GetAllstate();
			$data['city'] = $this->AdminModel->GetAllcity();
			$data['pincode'] = $this->AdminModel->GetAllpincode();

			return view('admin/pincode_vw', $data);
		} else {
			return redirect()->to('Admin/');
		}
	}
	function getcity()
	{
		$state_id = $this->request->getVar('state_id');
		$city = $this->db->query("SELECT * FROM city  where state_id='$state_id'  ")->getResult();

?>
		<select name="" class="form-control">
			<option>- Select -</option>
			<?php foreach ($city as $cityy) { ?>
				<option value="<?= $cityy->city_id ?>"><?= $cityy->city_name ?></option>
			<?php } ?>
		</select>
	<?php

	}


	function addpincode()
	{

		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['Allstate'] = $this->AdminModel->GetAllstate();
			$data['city'] = $this->AdminModel->GetAllcity();
			$data['pincode'] = $this->AdminModel->GetAllpincode();

			$rules = [
				'pincode' => 'required|min_length[6]|max_length[6]|is_unique[pincode.pincode]',
				'state_id' => 'required',
				'city_id' => 'required',
			];
			if ($this->validate($rules)) {
				$data = [
					'state_id' => $this->request->getVar('state_id'),
					'city_id' => $this->request->getVar('city_id'),

					'pincode' => $this->request->getVar('pincode'),
				];

				$this->db->table('pincode')->insert($data);
				return redirect()->to('Admin/Pincode');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/pincode_vw', $data);
			}
		} else {
			return redirect()->to('Admin/');
		}
	}

	function editpincode()
	{

		if ($this->session->get('user_id')) {

			$pin_id = $this->request->getVar('pin_id');
			$state_id = $this->request->getVar('state_id');
			$city_id = $this->request->getVar('city_id');
			$pincode = $this->request->getVar('pincode');

			$countpincode = $this->db->query("SELECT * FROM pincode  where pincode='$pincode' and pin_id!='$pin_id' ")->getResult();
			if (count($countpincode) == 0) {
				$data = [

					'state_id' => $state_id,
					'city_id' => $city_id,
					'pincode' => $pincode,
				];

				$this->db->table('pincode')->update($data, array('pin_id' => $pin_id));
				return redirect()->to('Admin/Pincode');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/pincode_vw', $data);
			}
		} else {
			return redirect()->to('Admin/');
		}
	}

	function deletepincode()
	{
		$pin_id = $this->request->getPost('user_id');
		$this->db->table('pincode')->delete(array('pin_id' => $pin_id));
		return redirect()->to('Admin/Pincode');
	}


	function statuspincode()
	{
		if ($this->session->get('user_id')) {
			$pin_id  = $this->request->getPost('pin_id');
			$pin_status = $this->request->getPost('pin_status');

			$data = [
				'status'  => $pin_status,
			];

			$this->db->table('pincode')->update($data, array('pin_id' => $pin_id));
			return redirect()->to('Admin/Pincode');
		} else {
			return redirect()->to('Admin/');
		}
	}

	function City()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['Allstate'] = $this->AdminModel->GetAllstate();
			$data['city'] = $this->AdminModel->GetAllcity();


			return view('admin/city_vw.php', $data);
		} else {
			return redirect()->to('Admin/');
		}
	}

	function addcity()
	{

		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['Allstate'] = $this->AdminModel->GetAllstate();
			$data['city'] = $this->AdminModel->GetAllcity();

			$rules = [
				'cityname' => 'required|is_unique[city.city_name]',
			];
			if ($this->validate($rules)) {
				$data = [
					'state_id' => $this->request->getVar('state_id'),
					'city_name' => $this->request->getVar('cityname')

				];
				$this->db->table('city')->insert($data);
				return redirect()->to('Admin/City');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/city_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}

	function editcity()
	{

		if ($this->session->get('user_id')) {
			$state_id = $this->request->getVar('state_id');
			$cityname = $this->request->getVar('cityname');
			$city_id = $this->request->getVar('city_id');

			$countcity = $this->db->query("SELECT * FROM city  where city_name='$cityname' and city_id!='$city_id' ")->getResult();
			if (count($countcity) == 0) {
				$data = [

					'state_id' => $state_id,
					'city_name' => $cityname,
				];
				$this->db->table('city')->update($data, array('city_id' => $city_id));
				return redirect()->to('Admin/City');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/city_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}

	function statuscity()
	{
		if ($this->session->get('user_id')) {
			$city_id  = $this->request->getPost('city_id');
			$city_status = $this->request->getPost('city_status');

			$data = [
				'status'  => $city_status,
			];

			$this->db->table('city')->update($data, array('city_id' => $city_id));
			return redirect()->to('Admin/City');
		} else {
			return redirect()->to('Admin/');
		}
	}



	function deletecity()
	{
		$cityid = $this->request->getPost('user_id');
		$this->db->table('city')->delete(array('city_id' => $cityid));
		return redirect()->to('admin/City');
	}

	// function Banner()
	// {
	// 	if ($this->session->get('user_id')) {

	// 		$user_id = $this->session->get('user_id');

	// 		$data['setting'] = $this->AdminModel->Settingdata();
	// 		$data['singleuser'] = $this->AdminModel->userdata($user_id);
	// 		$data['banner_data'] = $this->AdminModel->bannerdata();


	// 		return view('admin/banner_vw', $data);
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }
	// function addbanner()
	// {
	// 	if ($this->session->get('user_id')) {

	// 		$title = $this->request->getPost('title');
	// 		$subtitle = $this->request->getPost('subtitle');
	// 		$url = $this->request->getPost('url');
	// 		$description = $this->request->getPost('description');
	// 		$ban_type = $this->request->getPost('ban_type');
	// 		$orderby = $this->request->getPost('orderby');
	// 		$file = $this->request->getFile('img');


	// 		if ($file->isValid() && !$file->hasMoved()) {
	// 			$imagename = $file->getRandomName();
	// 			$file->move('uploads/', $imagename);
	// 		} else {
	// 			$imagename = "";
	// 		}

	// 		$data = [
	// 			'banner_title' => $title,
	// 			'banner_subtitle' => $subtitle,
	// 			'urrl' => $url,
	// 			'description' => $description,
	// 			'type' => $ban_type,
	// 			'orderby' => $orderby,
	// 			'image' => $imagename

	// 		];

	// 		$this->AdminModel->addbanner($data);
	// 		return redirect()->to('admin/Banner');
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }

	// function Delete_Banner()
	// {
	// 	if ($this->session->get('user_id')) {

	// 		$BannerId = $this->request->getPost('user_id');

	// 		$this->AdminModel->DeleteBanner($BannerId);

	// 		return redirect()->to('/admin/Banner');
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }
	// function edit_banner()
	// {
	// 	if ($this->session->get('user_id')) {

	// 		$user_id = $this->session->get('user_id');

	// 		$data['setting'] = $this->AdminModel->Settingdata();
	// 		$data['singleuser'] = $this->AdminModel->userdata($user_id);

	// 		$banner_id = $this->request->uri->getSegment(3);
	// 		$data['single_banner_data'] = $this->AdminModel->single_bannerdata($banner_id);


	// 		return view('admin/banner_edit_vw', $data);
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }
	// function Update_Banner()
	// {
	// 	if ($this->session->get('user_id')) {

	// 		$banner_id = $this->request->getPost('EditId');
	// 		$title = $this->request->getPost('title');
	// 		$subtitle = $this->request->getPost('subtitle');
	// 		$url = $this->request->getPost('url');
	// 		$description = $this->request->getPost('description');
	// 		$ban_type = $this->request->getPost('ban_type');
	// 		$orderby = $this->request->getPost('orderby');
	// 		$file = $this->request->getFile('img');

	// 		if ($file->isValid() && !$file->hasMoved()) {
	// 			$imagename = $file->getRandomName();
	// 			$file->move('uploads/', $imagename);
	// 		} else {
	// 			$imagename = "";
	// 		}
	// 		if ($imagename != '') {
	// 			$data = [
	// 				'banner_title' => $title,
	// 				'banner_subtitle' => $subtitle,
	// 				'urrl' => $url,
	// 				'description' => $description,
	// 				'type' => $ban_type,
	// 				'orderby' => $orderby,
	// 				'image' => $imagename

	// 			];
	// 		} else {
	// 			$data = [
	// 				'banner_title' => $title,
	// 				'banner_subtitle' => $subtitle,
	// 				'urrl' => $url,
	// 				'description' => $description,
	// 				'type' => $ban_type,
	// 				'orderby' => $orderby,
	// 			];
	// 		}
	// 		$this->AdminModel->Editbanner($data, $banner_id);
	// 		return redirect()->to('admin/edit_banner/' . $banner_id);
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }

	function Cms_management()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['allcms'] = $this->AdminModel->getAllCms();


			return view('admin/cms_management_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function Add_page()
	{
		if ($this->session->get('user_id')) {

			$pageName = $this->request->getPost('pageName');
			$pageDetails = $this->request->getPost('pageDetails');
			$pageTitle = $this->request->getPost('pageTitle');
			$KeyWord = $this->request->getPost('KeyWord');
			$PageDescription = $this->request->getPost('PageDescription');



			$file = $this->request->getFile('img');
			if ($file->isValid() && !$file->hasMoved()) {
				$imagename = $file->getRandomName();
				$file->move('uploads/', $imagename);
			} else {
				$imagename = "";
			}

			$data = [
				'page_name' => $pageName,
				'details' => $pageDetails,
				'image' => $imagename,
				'page_title' => $pageTitle,
				'page_keyword' => $KeyWord,
				'page_description' => $PageDescription,

			];

			$this->AdminModel->AddPages($data);

			return redirect()->to('/admin/Cms_management');
		} else {
			return redirect()->to('admin/');
		}
	}

	function Delete_page()
	{
		if ($this->session->get('user_id')) {

			$pageId = $this->request->getPost('user_id');
			$this->AdminModel->DeleteCsm($pageId);

			return redirect()->to('/admin/Cms_management');
		} else {
			return redirect()->to('admin/');
		}
	}
	function Edit_cms()
	{
		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			$page_id = $this->request->uri->getSegment(3);
			$data['singleCsm'] = $this->AdminModel->single_page($page_id);



			if ($page_id == 1) {
				return view('admin/contactus_vw', $data);
			} else {
				return view('admin/edit_cms_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}

	function UpdateCsm()
	{
		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);


			$pageTitle = $this->request->getPost('pageTitle');
			$KeyWord = $this->request->getPost('KeyWord');
			$PageDescription = $this->request->getPost('PageDescription');



			$pageId = $this->request->getPost('cmsid');
			$pageName = $this->request->getPost('pageName');
			$pageDetails = $this->request->getPost('pageDetails');
			$address = $this->request->getPost('address');
			$email = $this->request->getPost('email');
			$contact = $this->request->getPost('contact');

			$file = $this->request->getFile('img');
			if ($file->isValid() && !$file->hasMoved()) {
				$imagename = $file->getRandomName();
				$file->move('uploads/', $imagename);
			} else {
				$imagename = "";
			}
			if ($imagename != '') {
				$data = [
					'page_name' => $pageName,
					'details' => $pageDetails,
					'address' => $address,
					'email' => $email,
					'phone' => $contact,
					'image' => $imagename,

					'page_title' => $pageTitle,
					'page_keyword' => $KeyWord,
					'page_description' => $PageDescription,

				];
			} else {

				$data = [
					'page_name' => $pageName,
					'details' => $pageDetails,
					'address' => $address,
					'email' => $email,
					'phone' => $contact,

					'page_title' => $pageTitle,
					'page_keyword' => $KeyWord,
					'page_description' => $PageDescription,

				];
			}

			$this->AdminModel->UpdatePages($data, $pageId);


			return redirect()->to('/admin/Edit_cms/' . $pageId);
		} else {
			return redirect()->to('admin/');
		}
	}

	function GetAreaAjax()
	{
		$city_id = $this->request->getPost('city_id');
		$area_dtl = $this->AdminModel->GetArea($city_id);
	?>
		<option>- Select -</option>
		<?php foreach ($area_dtl as $areaa) { ?>

			<option value="<?= $areaa->area_id ?>"><?= $areaa->areaname ?></option>
		<?php } ?>
	<?php
	}
	function GetcityAjax()
	{
		$state_id = $this->request->getPost('state_id');
		$city_dtl = $this->AdminModel->Getcity($state_id);
	?>
		<option>- Select -</option>
		<?php foreach ($city_dtl as $cityy) { ?>

			<option value="<?= $cityy->city_id ?>"><?= $cityy->city_name ?></option>
		<?php } ?>
	<?php
	}
	function GetpinAjax()
	{
		$cityDiv = $this->request->getPost('cityDiv');
		$pin_dtl = $this->AdminModel->Getpin($cityDiv);
	?>
		<option>- Select -</option>
		<?php foreach ($pin_dtl as $pinn) { ?>

			<option value="<?= $pinn->pin_id ?>"><?= $pinn->pincode ?></option>
		<?php } ?>
<?php
	}

	function getDriverData()
	{
		$driver_id = $this->request->getPost('driver_id');
		$vehicleId = $this->request->getPost('vehicleId');
		if ($vehicleId != '') {
			$driverStatus = $this->db->query("SELECT * FROM driver_vehicle_mapping  where vehicle_id = $vehicleId and driver_id = $driver_id  ORDER BY id DESC LIMIT 1")->getRow();
		}
		$userdata = $this->AdminModel->userdata($driver_id);
		$data['userdata'] = $userdata[0];
		$data['status'] = isset($driverStatus) && !empty($driverStatus) ? $driverStatus->status : '';
		return json_encode($data);
	}

	function Category()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['category_data'] = $this->AdminModel->getcategory();


			return view('admin/category_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function addcategory()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['category_data'] = $this->AdminModel->getcategory();

			$rules = [
				'catname' => 'required|is_unique[category.cat_name]',
			];

			if ($this->validate($rules)) {

				$catname = $this->request->getPost('catname');
				$p_cat = $this->request->getPost('p_cat');
				$file = $this->request->getFile('img');

				if ($file->isValid() && !$file->hasMoved()) {
					$imagename = $file->getRandomName();
					$file->move('uploads/', $imagename);
				} else {
					$imagename = "";
				}


				$data = [
					'cat_name' => $catname,
					'parent_id' => $p_cat,
					'status' => 1,
					'type' => 1,
					'cat_img' => $imagename
				];

				$this->AdminModel->addCategory($data);
				return redirect()->to('admin/category');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/category_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}

	function deletecategory()
	{
		if ($this->session->get('user_id')) {

			$cat_id = $this->request->getPost('cat_id');
			$this->AdminModel->DeleteCategory($cat_id);

			return redirect()->to('/admin/category');
		} else {
			return redirect()->to('admin/');
		}
	}

	function EditCategory()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['category_data'] = $this->AdminModel->getcategory();
			$cat_id = $this->request->uri->getSegment(3);
			$data['catsingle_data'] = $this->AdminModel->catsingle_data($cat_id);




			return view('admin/edit_category_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function edit_category()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['category_data'] = $this->AdminModel->getcategory();
			$cat_id = $this->request->uri->getSegment(3);
			$data['catsingle_data'] = $this->AdminModel->catsingle_data($cat_id);


			$cid = $this->request->getPost('cid');
			$catname = $this->request->getPost('catname');
			$p_cat = $this->request->getPost('p_cat');
			$file = $this->request->getFile('img');

			if ($file->isValid() && !$file->hasMoved()) {
				$imagename = $file->getRandomName();
				$file->move('uploads/', $imagename);
			} else {
				$imagename = "";
			}

			if ($imagename != "") {
				$data = [
					'cat_name' => $catname,
					'parent_id' => $p_cat,
					'type' => 1,
					'cat_img' => $imagename
				];
			} else {
				$data = [
					'cat_name' => $catname,
					'type' => 1,
					'parent_id' => $p_cat
				];
			}


			$this->AdminModel->updateCategory($data, $cid);
			return redirect()->to('admin/EditCategory/' . $cid);
		} else {
			return redirect()->to('admin/');
		}
	}

	function catstatusBlock()
	{
		$brand_id = $this->request->uri->getSegment(3);
		$data = [
			'status' => 0,
		];
		$this->db->table('category')->update($data, array('cat_id' => $brand_id));
		return redirect()->to('admin/Category');
	}
	function catstatusActive()
	{
		$brand_id = $this->request->uri->getSegment(3);
		$data = [
			'status' => 1,
		];
		$this->db->table('category')->update($data, array('cat_id' => $brand_id));
		return redirect()->to('admin/Category');
	}


	function Brand_management()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['allBrands'] = $this->AdminModel->allBrands();

			return view('admin/brand_management_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function AddBrand()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['allBrands'] = $this->AdminModel->allBrands();

			$rules = [
				'brandname' => 'required|is_unique[brands.brands_name]',
			];

			if ($this->validate($rules)) {

				$brandname = $this->request->getPost('brandname');
				$file = $this->request->getFile('img');

				if ($file->isValid() && !$file->hasMoved()) {
					$imagename = $file->getRandomName();
					$file->move('uploads/', $imagename);
				} else {
					$imagename = "";
				}


				$data = [
					'brands_name' => $brandname,
					'status' => 1,
					'images' => $imagename
				];

				$this->AdminModel->addbrand($data);
				return redirect()->to('admin/Brand_management');
			} else {
				$data['validation'] = $this->validator;
				return view('admin/brand_management_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}
	function EditBrand()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['allBrands'] = $this->AdminModel->allBrands();

			$brandname = $this->request->getPost('brandname');
			$brandId = $this->request->getPost('brandId');
			$file = $this->request->getFile('img');

			if ($file->isValid() && !$file->hasMoved()) {
				$imagename = $file->getRandomName();
				$file->move('uploads/', $imagename);
			} else {
				$imagename = "";
			}

			if ($imagename != "") {
				$data = [
					'brands_name' => $brandname,
					'images' => $imagename
				];
			} else {
				$data = [
					'brands_name' => $brandname,

				];
			}


			$this->AdminModel->EditBrand($data, $brandId);
			return redirect()->to('admin/Brand_management');
		} else {
			return redirect()->to('admin/');
		}
	}
	function brandstatusBlock()
	{
		$brand_id = $this->request->uri->getSegment(3);
		$data = [
			'status' => 0,
		];
		$this->AdminModel->brandstatus($data, $brand_id);
		return redirect()->to('admin/Brand_management');
	}
	function brandstatusActive()
	{
		$brand_id = $this->request->uri->getSegment(3);
		$data = [
			'status' => 1,
		];
		$this->AdminModel->brandstatus($data, $brand_id);
		return redirect()->to('admin/Brand_management');
	}
	function deleteBrand()
	{
		if ($this->session->get('user_id')) {

			$brabdId = $this->request->getPost('user_id');
			$this->AdminModel->DeleteBrand($brabdId);

			return redirect()->to('/admin/Brand_management');
		} else {
			return redirect()->to('admin/');
		}
	}
	// function Manage_coupon()
	// {
	// 	if ($this->session->get('user_id')) {
	// 		$user_id = $this->session->get('user_id');

	// 		$data['setting'] = $this->AdminModel->Settingdata();
	// 		$data['singleuser'] = $this->AdminModel->userdata($user_id);
	// 		$data['allCupons'] = $this->AdminModel->GetCupon();
	// 		$data['AllCity'] = $this->AdminModel->GetAllcity();


	// 		return view('admin/manage_coupon', $data);
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }

	// function AddCuopon()
	// {
	// 	if ($this->session->get('user_id')) {

	// 		$user_id = $this->session->get('user_id');

	// 		$data['setting'] = $this->AdminModel->Settingdata();
	// 		$data['singleuser'] = $this->AdminModel->userdata($user_id);
	// 		$data['allCupons'] = $this->AdminModel->GetCupon();



	// 		$rules = [
	// 			'cocode' => 'required|is_unique[coupon_code.code]'
	// 		];
	// 		if ($this->validate($rules)) {
	// 			$file = $this->request->getFile('img');

	// 			if ($file->isValid() && !$file->hasMoved()) {
	// 				$imagename = $file->getRandomName();
	// 				$file->move('uploads/', $imagename);
	// 			} else {
	// 				$imagename = "";
	// 			}


	// 			$data = [
	// 				'name' => $this->request->getPost('coname'),
	// 				'code' => $this->request->getPost('cocode'),
	// 				'discount_type' => $this->request->getPost('cotype'),
	// 				'discount_value' => $this->request->getPost('disvalue'),
	// 				'valid_uo_to' => $this->request->getPost('validate'),
	// 				'used_up_to' => $this->request->getPost('noofuse'),
	// 				//'city_id' => $this->request->getPost('city'),
	// 				'no_of_use_user' => $this->request->getPost('noofuseperuser'),
	// 				'price_cart' => $this->request->getPost('priceapplay'),
	// 				'img' => $imagename
	// 			];

	// 			$this->AdminModel->AddCuponCode($data);

	// 			return redirect()->to('admin/Manage_coupon');
	// 		} else {
	// 			$data['validation'] = $this->validator;
	// 			echo view('admin/manage_coupon', $data);
	// 		}
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }

	// function EditCuopon()
	// {
	// 	if ($this->session->get('user_id')) {

	// 		$cupn_id = $this->request->getPost('cuoponID');
	// 		$file = $this->request->getFile('img');

	// 		if ($file->isValid() && !$file->hasMoved()) {
	// 			$imagename = $file->getRandomName();
	// 			$file->move('uploads/', $imagename);
	// 		} else {
	// 			$imagename = "";
	// 		}

	// 		if ($imagename != "") {
	// 			$data = [
	// 				'name' => $this->request->getPost('coname'),
	// 				'code' => $this->request->getPost('cocode'),
	// 				'discount_type' => $this->request->getPost('cotype'),
	// 				'discount_value' => $this->request->getPost('disvalue'),
	// 				'valid_uo_to' => $this->request->getPost('validate'),
	// 				'used_up_to' => $this->request->getPost('noofuse'),
	// 				//'city_id' => $this->request->getPost('city'),
	// 				'no_of_use_user' => $this->request->getPost('noofuseperuser'),
	// 				'price_cart' => $this->request->getPost('priceapplay'),
	// 				'img' => $imagename
	// 			];
	// 		} else {
	// 			$data = [
	// 				'name' => $this->request->getPost('coname'),
	// 				'code' => $this->request->getPost('cocode'),
	// 				'discount_type' => $this->request->getPost('cotype'),
	// 				'discount_value' => $this->request->getPost('disvalue'),
	// 				'valid_uo_to' => $this->request->getPost('validate'),
	// 				'used_up_to' => $this->request->getPost('noofuse'),
	// 				//'city_id' => $this->request->getPost('city'),
	// 				'no_of_use_user' => $this->request->getPost('noofuseperuser'),
	// 				'price_cart' => $this->request->getPost('priceapplay'),
	// 			];
	// 		}

	// 		$this->AdminModel->EditCuponCode($data, $cupn_id);

	// 		return redirect()->to('admin/Manage_coupon');
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }

	// function deleteCupon()
	// {

	// 	if ($this->session->get('user_id')) {
	// 		$cupon_id = $this->request->getPost('user_id');
	// 		$this->db->table('coupon_code')->delete(array('coupon_code_id' => $cupon_id));
	// 		return redirect()->to('admin/Manage_coupon');
	// 	} else {
	// 		return redirect()->to('admin/');
	// 	}
	// }


	function Vendor()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			// if(){

			// }

			if ($this->session->get('user_type') == 2) {

				$data['allvendor'] = $this->AdminModel->GetFranchiseUser($this->session->get('franchise_id'));
			} else {
				$data['allvendor'] = $this->AdminModel->GetAllUser();
			}
			return view('admin/vendor_vw.php', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function Addvendor()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['franchises'] = $this->AdminModel->GetAllRecord('franchises');
			$data['allstate'] = $this->AdminModel->GetAllstate();
			$data['allcity'] = $this->AdminModel->GetAllcity();
			$data['pincode'] = $this->AdminModel->GetAllpincode();
			$data['franchise_id'] = $this->session->get('franchise_id');

			$data['allbloodgroup'] = $this->AdminModel->GetAllRecord('blood_group');
			$data['allditrict'] = $this->AdminModel->GetAllRecord('districts');
			$data['allblock'] = $this->AdminModel->GetAllRecord('blocks');
			return view('admin/add_vendor_vw.php', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function Editvendor()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			$vendor_id = $this->request->uri->getSegment(3);
			$data['franchises'] = $this->AdminModel->GetAllRecord('franchises');
			$data['Singlevendor'] = $this->AdminModel->Singlevendor($vendor_id);

			$data['allstate'] = $this->AdminModel->GetAllstate();
			$data['allcity'] = $this->AdminModel->GetAllcity();
			$data['pincode'] = $this->AdminModel->GetAllpincode();
			$data['franchise_id'] = $this->session->get('franchise_id');
			$data['allbloodgroup'] = $this->AdminModel->GetAllRecord('blood_group');
			$data['allditrict'] = $this->AdminModel->GetAllRecord('districts');
			$data['allblock'] = $this->AdminModel->GetAllRecord('blocks');
			return view('admin/edit_vendor_vw.php', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function Insertvendor()
	{
		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			$data['allstate'] = $this->AdminModel->GetAllstate();
			$data['allcity'] = $this->AdminModel->GetAllcity();
			$data['pincode'] = $this->AdminModel->GetAllpincode();

			$data['allvendor'] = $this->AdminModel->GetAllCustomer(3);

			$rules = [
				'name' => 'required|min_length[3]',
				'email' => 'required|valid_email|is_unique[user.email]',
				'username' => 'required|is_unique[user.user_name]',
				'contact' => 'required|numeric|max_length[10]|is_unique[user.contact_no]',
				'password' => 'required|min_length[6]',
				'state' => 'required',
				'city' => 'required',
				'adharno' => 'required'
			];

			if ($this->validate($rules)) {

				$file = $this->request->getFile('img');

				if ($file->isValid() && !$file->hasMoved()) {
					$imagename = $file->getRandomName();
					$file->move('uploads/', $imagename);
				} else {
					$imagename = "";
				}

				$file1 = $this->request->getFile('frontimg');

				if ($file1->isValid() && !$file1->hasMoved()) {
					$imagename1 = $file1->getRandomName();
					$file1->move('uploads/', $imagename1);
				} else {
					$imagename1 = "";
				}
				$file2 = $this->request->getFile('backimg');

				if ($file2->isValid() && !$file2->hasMoved()) {
					$imagename2 = $file2->getRandomName();
					$file2->move('uploads/', $imagename2);
				} else {
					$imagename2 = "";
				}

				$license_img = $this->request->getFile('license_img');

				if ($license_img->isValid() && !$license_img->hasMoved()) {
					$license_img1 = $license_img->getRandomName();
					$license_img->move('uploads/', $license_img1);
				} else {
					$license_img1 = "";
				}

				$cheque = $this->request->getFile('cheque');

				if ($cheque->isValid() && !$cheque->hasMoved()) {
					$cheque_name = $cheque->getRandomName();
					$cheque->move('uploads/', $cheque_name);
				} else {
					$cheque_name = "";
				}

				$data = [
					'full_name' => $this->request->getVar('name'),
					'email'  => $this->request->getVar('email'),
					'user_name'  => $this->request->getVar('username'),
					'contact_no'  => $this->request->getVar('contact'),
					'alter_cnum'  => $this->request->getVar('altcontact'),
					'state_id'  => $this->request->getVar('state'),
					'city_id'  => $this->request->getVar('city'),
					'address1'  => $this->request->getVar('address1'),
					'address2'  => $this->request->getVar('address2'),
					'adhar_no'  => $this->request->getVar('adharno'),
					'password'  => base64_encode(base64_encode($this->request->getVar('password'))),
					'profile_image'  => $imagename,

					'adhar_font'  => $imagename1,
					'adhar_back'  => $imagename2,
					'franchise_id' => $this->request->getVar('franchise_id'),
					'user_type'  => $this->request->getVar('role'),
					'license_no'  => $this->request->getVar('license_no'),
					'license_type'  => $this->request->getVar('license_type'),
					'license_img'  => $license_img1,
					'status' => 1,
					'ac_name'  => $this->request->getVar('ac_name'),
					'bank_name'  => $this->request->getVar('bank_name'),
					'acc_no'  => $this->request->getVar('acc_no'),
					'ifsc'  => $this->request->getVar('ifsc'),
					'exp_year'  => $this->request->getVar('exp_year'),
					'block'  => $this->request->getVar('block'),
					'ditrict'  => $this->request->getVar('ditrict'),
					'pin'  => $this->request->getVar('pin'),
					'father_name'  => $this->request->getVar('father_name'),

					'license_expire_date'  => $this->request->getVar('license_expire_date'),
					'mother_name'  => $this->request->getVar('mother_name'),
					'nominee_name'  => $this->request->getVar('nominee_name'),
					'nominee_rltn'  => $this->request->getVar('nominee_rltn'),
					'nominee_add'  => $this->request->getVar('nominee_add'),
					'nominee_dob'  => $this->request->getVar('nominee_dob'),


					'spouse_name'  => $this->request->getVar('spouse_name'),
					'blood_group'  => $this->request->getVar('blood_group'),
					'dob'  => $this->request->getVar('dob'),
					'cheque'  => $cheque_name,
					'branch_name'  => $this->request->getVar('branch_name'),
					'created_by'  => $user_id

				];

				if ($this->request->getVar('is_driver') == 1) {
					$data['is_driver']  = $this->request->getVar('is_driver');
				}
				//print_r($data);exit;

				$this->AdminModel->adduser($data);
				if ($this->request->getVar('role') == 2 || $this->request->getVar('role') == '2') {
					return redirect()->to('member-tracking');
				} else {
					return redirect()->to('admin/Vendor');
				}
			} else {

				$user_id = $this->session->get('user_id');

				$data['setting'] = $this->AdminModel->Settingdata();
				$data['singleuser'] = $this->AdminModel->userdata($user_id);
				$data['franchises'] = $this->AdminModel->GetAllRecord('franchises');
				$data['allstate'] = $this->AdminModel->GetAllstate();
				$data['allcity'] = $this->AdminModel->GetAllcity();
				$data['pincode'] = $this->AdminModel->GetAllpincode();
				$data['franchise_id'] = $this->session->get('franchise_id');

				$data['allbloodgroup'] = $this->AdminModel->GetAllRecord('blood_group');
				$data['allditrict'] = $this->AdminModel->GetAllRecord('districts');
				$data['allblock'] = $this->AdminModel->GetAllRecord('blocks');

				$data['validation'] = $this->validator;
				echo view('admin/add_vendor_vw', $data);
			}
		} else {
			return redirect()->to('admin/');
		}
	}
	function Updatevendor()
	{
		if ($this->session->get('user_id')) {

			$id = $this->request->getPost('id');
			$name = $this->request->getPost('name');
			$email = $this->request->getPost('email');
			$contact = $this->request->getPost('contact');
			$altcontact = $this->request->getPost('altcontact');
			$state = $this->request->getPost('state');
			$city = $this->request->getPost('city');

			$address1 = $this->request->getPost('address1');
			$address2 = $this->request->getPost('address2');

			$adharno = $this->request->getPost('adharno');

			$username = $this->request->getPost('username');
			$password = base64_encode(base64_encode($this->request->getVar('password')));


			$CountEmail = $this->db->query("SELECT * FROM user  where email='$email' and id!='$id' ")->getResult();
			$CountContact = $this->db->query("SELECT * FROM user  where contact_no='$contact' and id!='$id' ")->getResult();
			$CountUsername = $this->db->query("SELECT * FROM user  where user_name='$username' and id!='$id' ")->getResult();
			if (count($CountEmail) == 0) {
				if (count($CountContact) == 0) {

					if (count($CountUsername) == 0) {

						$file = $this->request->getFile('img');

						if ($file->isValid() && !$file->hasMoved()) {
							$imagename = $file->getRandomName();
							$file->move('uploads/', $imagename);
						} else {
							$imagename = "";
						}

						$file1 = $this->request->getFile('frontimg');

						if ($file1->isValid() && !$file1->hasMoved()) {
							$imagename1 = $file1->getRandomName();
							$file1->move('uploads/', $imagename1);
						} else {
							$imagename1 = "";
						}
						$file2 = $this->request->getFile('backimg');

						if ($file2->isValid() && !$file2->hasMoved()) {
							$imagename2 = $file2->getRandomName();
							$file2->move('uploads/', $imagename2);
						} else {
							$imagename2 = "";
						}

						$file3 = $this->request->getFile('license_img');

						if ($file3->isValid() && !$file3->hasMoved()) {
							$imagename3 = $file3->getRandomName();
							$file3->move('uploads/', $imagename3);
						} else {
							$imagename3 = "";
						}

						$cheque = $this->request->getFile('cheque');

						if ($cheque->isValid() && !$cheque->hasMoved()) {
							$cheque_name = $cheque->getRandomName();
							$cheque->move('uploads/', $cheque_name);
						} else {
							$cheque_name = "";
						}

						$data = [
							'full_name' => $name,
							'email'  => $email,
							'user_name'  => $username,
							'contact_no'  => $contact,
							'password'  => $password,
							'alter_cnum'  => $altcontact,
							'state_id'  => $state,
							'city_id'  => $city,
							'adhar_no'  => $adharno,
							'address1'  => $address1,
							'address2'  => $address2,
							'status'  => 1,
							'user_type'  => $this->request->getVar('role'),
							'license_no'  => $this->request->getVar('license_no'),
							'license_type'  => $this->request->getVar('license_type'),
							'is_driver' => $this->request->getVar('is_driver'),
							'ac_name'  => $this->request->getVar('ac_name'),
							'bank_name'  => $this->request->getVar('bank_name'),
							'acc_no'  => $this->request->getVar('acc_no'),
							'ifsc'  => $this->request->getVar('ifsc'),

							'block'  => $this->request->getVar('block'),
							'ditrict'  => $this->request->getVar('ditrict'),
							'pin'  => $this->request->getVar('pin'),
							'father_name'  => $this->request->getVar('father_name'),

							'license_expire_date'  => $this->request->getVar('license_expire_date'),
							'mother_name'  => $this->request->getVar('mother_name'),
							'nominee_name'  => $this->request->getVar('nominee_name'),
							'nominee_rltn'  => $this->request->getVar('nominee_rltn'),
							'nominee_add'  => $this->request->getVar('nominee_add'),
							'nominee_dob'  => $this->request->getVar('nominee_dob'),

							'spouse_name'  => $this->request->getVar('spouse_name'),
							'blood_group'  => $this->request->getVar('blood_group'),
							'dob'  => $this->request->getVar('dob'),
							'branch_name'  => $this->request->getVar('branch_name'),

							'exp_year'  => $this->request->getVar('exp_year'),
							'franchise_id' => $this->request->getVar('franchise_id')
						];

						if ($imagename != "") {
							$data['profile_image']  = $imagename;
						}
						if ($imagename1 != "") {

							$data['adhar_font']  = $imagename1;
						}
						if ($imagename2 != "") {

							$data['adhar_back']  = $imagename1;
						}

						if ($imagename3 != "") {

							$data['license_img']  = $imagename3;
						}

						if ($cheque_name != "") {

							$data['cheque']  = $cheque_name;
						}

						$this->AdminModel->updateUser($data, $id);


						if ($this->request->getVar('role') == 2 || $this->request->getVar('role') == '2') {
							return redirect()->to('member-tracking');
						} else {
							return redirect()->to('admin/Editvendor/' . $id);
						}
					} else {
						$this->session->setFlashdata('msg', 'Username  Already  exist.');
						$this->session->setFlashdata('uid', $id);
						return redirect()->back()->withInput()->with('message', 'Username  Already  exist.');
					}
				} else {
					$this->session->setFlashdata('msg', 'Contact Number  Already  exist.');
					$this->session->setFlashdata('uid', $id);
					return redirect()->back()->withInput()->with('message', 'Contact Number  Already  exist.');
				}
			} else {
				$this->session->setFlashdata('msg', 'Email Already  exist.');
				$this->session->setFlashdata('uid', $id);
				return redirect()->back()->withInput()->with('message', 'Email Already  exist.');
			}
		} else {
			return redirect()->to('admin/');
		}
	}


	function Product()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['product_data'] = $this->AdminModel->Allproduct();

			return view('admin/Product_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function PendingProduct()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['product_data'] = $this->AdminModel->Pendingproduct();

			return view('admin/Pending_Product_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}


	function Add_product()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');
			$pname = $this->request->getPost('pname');
			$product_type = $this->request->getPost('product_type');

			$data = [
				'product_name' => $pname,
				'product_type' => 1,
				'status' => 0,
				'createdby' => $user_id
			];

			$insert_id = $this->AdminModel->AddProduct($data);

			return redirect()->to('admin/Edit_product/' . $insert_id);
		} else {
			return redirect()->to('admin/');
		}
	}

	function Edit_product()
	{
		if ($this->session->get('user_id')) {
			$data['setting'] = $this->AdminModel->Settingdata();
			$user_id = $this->session->get('user_id');
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$pro_id = $this->request->uri->getSegment(3);
			$data['product_data'] = $this->AdminModel->single_product_data($pro_id);
			$data['category_data'] = $this->AdminModel->getcategory();
			$data['Product_Category'] = $this->AdminModel->Product_Category($pro_id);

			$data['attribute'] = $this->AdminModel->get_attribute_data($pro_id);
			$data['variations'] = $this->AdminModel->get_variation_data($pro_id);

			$data['allBrands'] = $this->AdminModel->allBrands();
			$data['allGallery'] = $this->AdminModel->Gallery($pro_id);


			return view('admin/edit_Product_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}
	function update_product()
	{
		if ($this->session->get('user_id')) {
			$productid = $this->request->getPost('productid');
			$product_name = $this->request->getPost('product_name');
			$description = $this->request->getPost('description');
			$saleperprice = $this->request->getPost('saleperprice');
			$regperprice = $this->request->getPost('regperprice');
			$stock = $this->request->getPost('stock');
			$brand = $this->request->getPost('brand');
			$p_cat = $this->request->getPost('p_cat[]');
			$gallery = $this->request->getFileMultiple('images');
			$file = $this->request->getFile('img');
			$city = $this->request->getPost('city_id');
			$school = $this->request->getPost('school_id');
			$class = $this->request->getPost('class_id');
			if ($file->isValid() && !$file->hasMoved()) {
				$imagename = $file->getRandomName();
				$file->move('uploads/', $imagename);
			} else {
				$imagename = "";
			}


			$data = [
				'product_name' => $product_name,
				'description' => $description,
				'brands_id' => $brand,
				'prodType' => $this->request->getPost('productType'),
			];
			if ($imagename != "") {
				$data = [
					'primary_image' => $imagename
				];
			}


			$data1 = array();
			if ($p_cat != null) {
				for ($i = 0; $i < count($p_cat); $i++) {
					array_push($data1, array('category_id' => $p_cat[$i]));
				}
			}

			if ($this->request->getFileMultiple('images')) {
				foreach ($this->request->getFileMultiple('images') as $file) {
					if ($file->isValid() && !$file->hasMoved()) {
						$galname = $file->getRandomName();
						$file->move('uploads/', $galname);
					} else {
						$galname = "";
					}

					$data3 = [
						'image' => $galname,
						'product_id'  => $productid
					];
					if ($galname != "") {
						$this->AdminModel->insertgalleryt($data3);
					}
				}
			}

			$this->AdminModel->updateProduct($data, $data1, $productid);
			return redirect()->to('admin/Edit_product/' . $productid);
		} else {
			return redirect()->to('admin/');
		}
	}

	function deleteGallery()
	{
		if ($this->session->get('user_id')) {
			$gallery_id = $this->request->getPost('user_id');
			$product_id = $this->request->getPost('product_id');

			$query = $this->db->table('gallery')->delete(array('gallery_id' => $gallery_id));
			return redirect()->to('admin/Edit_product/' . $product_id);
		} else {
			return redirect()->to('admin/');
		}
	}

	function deleteProduct()
	{
		if ($this->session->get('user_id')) {

			$Product_id = $this->request->getPost('user_id');
			$this->db->table('product')->delete(array('product_id' => $Product_id));
			return redirect()->to('/admin/Product');
		} else {
			return redirect()->to('admin/');
		}
	}


	public function InsertAttribute()
	{
		$attribute = $this->request->getPost('attribute');
		$variation = $this->request->getPost('variation');
		$productID = $this->request->getPost('productID');

		// Validate and sanitize input (assuming attribute and variation are text fields)
		$attribute = filter_var($attribute, FILTER_SANITIZE_STRING);
		$variation = filter_var($variation, FILTER_SANITIZE_STRING);

		// Insert attribute
		$attribute_data = [
			'attribute_name' => $attribute,
			'product_id' => $productID
		];

		if (!$this->db->table('attribute')->insert($attribute_data)) {
			// Handle insertion error
			return 'Failed to insert attribute';
		}

		$attribute_id = $this->db->insertID();

		// Insert variations
		$variation_array = explode("|", $variation);

		foreach ($variation_array as $key => $value) {
			$variation_data = [
				'variation_name' => $value,
				'attribute_id' => $attribute_id,
				'product_id' => $productID
			];
			if (!$this->db->table('variation')->insert($variation_data)) {
				// Handle insertion error
				return 'Failed to insert variation';
			}
		}

		// Display table with attribute and variations
		$attributes = $this->db->table('attribute')->where('product_id', $productID)->get()->getResult();
		foreach ($attributes as $attribute) {
			echo '<table class="table">';
			echo '<thead><tr><th colspan="3">' . $attribute->attribute_name . '</th></tr></thead>';
			echo '<tbody>';

			$variations = $this->db->table('variation')->where('attribute_id', $attribute->attribute_id)->get()->getResult();
			foreach ($variations as $variation) {
				echo '<tr>';
				echo '<td>' . $variation->variation_name . '</td>';
				echo '<td>' . $variation->variation_price . '</td>';
				echo '<td><a href="javascript:void(0);" onClick="deleteRecord(\'' . $variation->variation_id . '\');" class="btn btn-danger">Delete</a></td>';
				echo '</tr>';
			}
			echo '</tbody></table>';
		}
	}

	function approveproduct()
	{
		if ($this->session->get('user_id')) {

			$Product_id = $this->request->getPost('product_id');
			$status = $this->request->getPost('status');

			$data = [
				'approve' => $status,
			];

			$this->db->table('product')->update($data, array('product_id' => $Product_id));
			return redirect()->to('/admin/PendingProduct');
		} else {
			return redirect()->to('admin/');
		}
	}

	function productstatus()
	{
		if ($this->session->get('user_id')) {

			$Product_id = $this->request->getPost('product_id');
			$status = $this->request->getPost('status');

			$data = [
				'status' => $status,
			];

			$this->db->table('product')->update($data, array('product_id' => $Product_id));
			return redirect()->to('/admin/Product');
		} else {
			return redirect()->to('admin/');
		}
	}


	public function delete_variation()
	{
		$variation_id = $this->request->getPost('variation_id');
		$attribute_id = $this->db->table('variation')->where('variation_id', $variation_id)->get()->getRow()->attribute_id;
		$this->db->table('variation')->where('variation_id', $variation_id)->delete();

		$variation_count = $this->db->table('variation')->where('attribute_id', $attribute_id)->countAllResults();
		if ($variation_count == 0) {
			$this->db->table('attribute')->where('attribute_id', $attribute_id)->delete();
		}

		return true;
	}


	function Blog()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');

			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);
			$data['blog_data'] = $this->AdminModel->getAllBlog();



			return view('admin/blog_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function Addblog()
	{
		if ($this->session->get('user_id')) {

			$fullname = $this->request->getPost('fullname');
			$author_name = $this->request->getPost('author_name');
			$date = $this->request->getPost('date');
			$details = $this->request->getPost('details');
			$p_cat = $this->request->getPost('p_cat');
			$file = $this->request->getFile('img');
			if ($file->isValid() && !$file->hasMoved()) {
				$imagename = $file->getRandomName();
				$file->move('uploads/', $imagename);
			} else {
				$imagename = "";
			}

			$data = [
				'title' => $fullname,
				'name' => $author_name,
				'date' => $date,
				'message' => $details,
				'category' => $p_cat,
				'image' => $imagename,
			];

			$this->AdminModel->AddBlog($data);

			return redirect()->to('/admin/Blog');
		} else {
			return redirect()->to('admin/');
		}
	}

	function deleteblog()
	{
		if ($this->session->get('user_id')) {

			$blog_id = $this->request->getPost('blog_id');

			$this->AdminModel->DeleteBlog($blog_id);

			return redirect()->to('/admin/blog');
		} else {
			return redirect()->to('admin/');
		}
	}

	function view_edit()
	{
		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			$blog_id = $this->request->uri->getSegment(3);
			$data['blog_details'] = $this->AdminModel->singleBlog($blog_id);




			return view('admin/editblog_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function edit_blog()
	{
		if ($this->session->get('user_id')) {
			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			$blog_id = $this->request->uri->getSegment(3);
			$data['blog_details'] = $this->AdminModel->singleBlog($blog_id);




			$blog_id = $this->request->getPost('blog_id');
			$title = $this->request->getPost('title');
			$name = $this->request->getPost('name');
			$date = $this->request->getPost('date');
			$p_cat = $this->request->getPost('p_cat');
			$details = $this->request->getPost('details');
			$file = $this->request->getFile('img');

			if ($file->isValid() && !$file->hasMoved()) {
				$imagename = $file->getRandomName();
				$file->move('uploads/', $imagename);
			} else {
				$imagename = "";
			}
			if ($imagename != '') {
				$data = [
					'title' => $title,
					'name' => $name,
					'date' => $date,
					'category' => $p_cat,
					'message' => $details,
					'image' => $imagename

				];
			} else {

				$data = [
					'title' => $title,
					'name' => $name,
					'date' => $date,
					'category' => $p_cat,
					'message' => $details


				];
			}



			$this->AdminModel->UpdateBlog($data, $blog_id);


			return redirect()->to('/admin/view_edit/' . $blog_id);
			return view('admin/editblog_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function deletevendor()
	{
		if ($this->session->get('user_id')) {
			$id = $this->request->getPost('user_id');
			$this->AdminModel->DeleteRecordById('user', $id);
			return redirect()->to('admin/Vendor');
		} else {
			return redirect()->to('admin/');
		}
	}

	function driverSubscription()
	{
		if ($this->session->get('user_id')) {

			$user_id = $this->session->get('user_id');
			$data['setting'] = $this->AdminModel->Settingdata();
			$data['singleuser'] = $this->AdminModel->userdata($user_id);

			$data['priceDetails'] =  $this->AdminModel->getSingleData('driver_subscription', 1);

			if ($this->session->get('user_type') == 2) {
				$data['allvendor'] = $this->AdminModel->getFranchisisLiftDriver($this->session->get('franchise_id'));
			} else {
				$data['allvendor'] = $this->AdminModel->getAllLiftDriver();
			}

			return view('admin/lift_driver_vw', $data);
		} else {
			return redirect()->to('admin/');
		}
	}

	function updateSubscriptionPrice()
	{
		if ($this->session->get('user_id')) {
			$price = $this->request->getPost('price');
			$validity = $this->request->getPost('validity');

			$data = [
				'price' => $price,
				'validity' => $validity,
				'updated_at' => date('Y-m-d H:i:s')

			];

			$this->AdminModel->UpdateRecordById('driver_subscription', 1, $data);
			return redirect()->to('driver-subscription');
		} else {
			return redirect()->to('admin/');
		}
	}

	function getSubscrptionData()
	{
		if ($this->session->get('user_id')) {
			$driver_id = $this->request->getPost('driver_id');
			$Listdata = $this->AdminModel->getDriverSubscriptionData($driver_id);
			$html = '';
			$i = 1;
			foreach ($Listdata as $data) {
				if($data->status == 1){
					$status = 'Active';
				}else{
					$status = 'Expire';
				}
				$html .= "<tr>
              <th>$i</th>
              <th>$data->amount</th>
              <th>$data->validity Days</th>
              <th>$data->recharge_date</th>
              <th>$data->expiry_date</th>
              <th>$status</th>";
				$i++;
			}

			echo $html;
		} else {
			return redirect()->to('admin/');
		}
	}

	

	function renewSubscription($id)
	{
		if ($this->session->get('user_id')) {

			$subscriptionData = $this->AdminModel->getSingleData('driver_subscription', 1);
			$validity = $subscriptionData->validity;
			$expireDate = Date('y:m:d', strtotime("+$validity days"));

			$data = [
				'driver_id' => $id,
				'amount' => $subscriptionData->price,
				'validity' => $subscriptionData->validity,
				'status' => 1,
				'recharge_date' => date('Y-m-d'),
				'expiry_date' => $expireDate,
				'created_by'=> $this->session->get('user_id')
			];

			$this->AdminModel->InsertRecord('driver_subscription_history',$data);

			return redirect()->to('driver-subscription');
		} else {
			return redirect()->to('admin/');
		}
	}
}
