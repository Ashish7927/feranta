<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Home extends BaseController
{
	private $session = null;
	public function __construct()
	{

		$db = db_connect();
		$this->db = db_connect();

		$this->UserModel = new UserModel($db);
		$this->session = session();
		helper(['form', 'url', 'validation']);
	}
		public function index()
	{
	    $data['setting'] = $this->UserModel->Settingdata();
		$data['cms_data'] = $this->UserModel->Cmsdata(2);
		$data['Allblog'] = $this->UserModel->BlogdataHome();
		$data['contactus_data'] = $this->UserModel->Cmsdata(1);
		$data['banner'] = $this->UserModel->BannerdataHome();
		$data['category_data'] = $this->UserModel->category_data(0);
		$data['offer_data'] = $this->UserModel->offer_data();
		$data['brand_data'] = $this->UserModel->brand_data();
		
		return view('frontend/index', $data);
	}
	
	
	
	public function About()
    {
		$data['setting'] = $this->UserModel->Settingdata();
		$data['cms_data'] = $this->UserModel->Cmsdata(3);
        $data['contactus_data'] = $this->UserModel->Cmsdata(1);
		$data['category_data'] = $this->UserModel->category_data(0);
		$data['brand_data'] = $this->UserModel->brand_data();
        
		return view('user/about_vw', $data);
    }
	
	public function TermCondition()
    {
		$data['setting'] = $this->UserModel->Settingdata();
		$data['cms_data'] = $this->UserModel->Cmsdata(5);
    	$data['contactus_data'] = $this->UserModel->Cmsdata(1);
    		$data['category_data'] = $this->UserModel->category_data(0);
		$data['brand_data'] = $this->UserModel->brand_data();

		return view('user/about_vw', $data);
    }
	
	public function Privacypolicy()
    {
		$data['setting'] = $this->UserModel->Settingdata();
		$data['cms_data'] = $this->UserModel->Cmsdata(4);
    	$data['contactus_data'] = $this->UserModel->Cmsdata(1);
    	$data['category_data'] = $this->UserModel->category_data(0);
		$data['brand_data'] = $this->UserModel->brand_data();

		return view('user/about_vw', $data);
    }
    	public function Faq()
    {
		$data['setting'] = $this->UserModel->Settingdata();
		$data['cms_data'] = $this->UserModel->Cmsdata(4);
    	$data['contactus_data'] = $this->UserModel->Cmsdata(6);
    	$data['category_data'] = $this->UserModel->category_data(0);
		$data['brand_data'] = $this->UserModel->brand_data();

		return view('user/about_vw', $data);
    }
     	public function Contactus()
    {
		$data['setting'] = $this->UserModel->Settingdata();
		$data['cms_data'] = $this->UserModel->Cmsdata(1);
    	$data['contactus_data'] = $this->UserModel->Cmsdata(1);
    	$data['category_data'] = $this->UserModel->category_data(0);
		$data['brand_data'] = $this->UserModel->brand_data();


		return view('user/contact_us', $data);
    }
    	function Blog()
	{
		$data['setting'] = $this->UserModel->Settingdata();

		$data['Allblog'] = $this->UserModel->BlogdataHome();
		$data['cms'] = $this->UserModel->Cmsdata(6);
			$data['contact_us'] = $this->UserModel->Cmsdata(1);
		return view('user/blog_vw', $data);
	}
	
	function single_blog()
{
	  $data['setting']=$this->UserModel->Settingdata();

	  $Blog_id = $this->request->uri->getSegment(2);
	  $data['singleBlog']=$this->UserModel->single_Blog($Blog_id);
	  $data['Allblog']=$this->UserModel->Allblogdata();
	  
	
		 
	  return view('user/single_blog_vw',$data);
	}
	
function Shop()
{
	$cat_id = $this->request->uri->getSegment(2);
	$data['product_data'] = $this->UserModel->Product_Data($cat_id);
	$data['setting'] = $this->UserModel->Settingdata();
	$data['cms_data'] = $this->UserModel->Cmsdata(3);
    $data['contactus_data'] = $this->UserModel->Cmsdata(1);
    $data['category_data'] = $this->UserModel->category_data(0);
	$data['brand_data'] = $this->UserModel->brand_data();
	$data['singlecat']= $this->db->query("SELECT * FROM category  where cat_id='$cat_id'")->getResult(); ;

    // echo "<pre>";
    // print_r($data['product_data']);
	
	return view('user/shop', $data);
}

	
function Single_product()
{
    
    $product_id = $this->request->uri->getSegment(2);
	$data['product_data'] = $this->UserModel->single_product($product_id);
	$data['setting'] = $this->UserModel->Settingdata();
	$data['cms_data'] = $this->UserModel->Cmsdata(3);
    $data['contactus_data'] = $this->UserModel->Cmsdata(1);
    $data['category_data'] = $this->UserModel->category_data(0);
	$data['brand_data'] = $this->UserModel->brand_data();
	$data['ProductGallery'] = $this->UserModel->Productgallery($product_id);
	$data['attribute'] = $this->UserModel->getAttributes($product_id);
	$data['variation'] = $this->UserModel->getVariations($product_id);


    // echo "<pre>";
    // print_r($data['product_data']);
	
	return view('user/single_product_vw', $data);
    
}



function register()
    {

    $data['setting'] = $this->UserModel->Settingdata();
	$data['cms_data'] = $this->UserModel->Cmsdata(3);
    $data['contactus_data'] = $this->UserModel->Cmsdata(1);
    $data['category_data'] = $this->UserModel->category_data(0);
	$data['brand_data'] = $this->UserModel->brand_data();



        
        return view('user/register_vw', $data);
    }
    
public function userregistration()
    {
    
     $session = session();  
    $data['setting'] = $this->UserModel->Settingdata();
	$data['cms_data'] = $this->UserModel->Cmsdata(3);
    $data['contactus_data'] = $this->UserModel->Cmsdata(1);
    $data['category_data'] = $this->UserModel->category_data(0);
	$data['brand_data'] = $this->UserModel->brand_data();
	
	

       $rules = [
                'fname'     => 'required',
                'contact'   => 'required|numeric|min_length[10]|is_unique[user.contact_no]',
                'email'     => 'required|valid_email|is_unique[user.email]',
                'username'  => 'required|min_length[5]|is_unique[user.user_name]',
                'password'  => 'required|min_length[5]',
            ];


       

         if ($this->validate($rules)) {

            $data = [
                'full_name' => $this->request->getVar('fname'),
                'contact_no'=> $this->request->getVar('contact'),
                'email'     => $this->request->getVar('email'),
                'user_name' => $this->request->getVar('username'),
                'password'  => base64_encode(base64_encode($this->request->getVar('password'))),
                'status' => 1,
                'user_type' => 4
            ];


            $this->db->table('user')->insert($data);
             return redirect()->to('/Register');
        } else {
            
        $data['validation'] = $this->validator;
        $session->setFlashdata('tab', 'activetab');
        return view('user/register_vw', $data);
        }
    }
    
    
     function Login_auth()
    {
    
    $session = session();
    $UserModel = new UserModel();
    $username = $this->request->getVar('username');
    $password = base64_encode(base64_encode($this->request->getVar('password')));

    $CountUser = $this->db->query("SELECT * FROM user  where user_name='$username' AND password='$password' AND status=1 AND user_type=4")->getResult();

    if (count($CountUser) >= 1) {
        // Fetch user data from $CountUser
        $user = $CountUser[0]; // Assuming the first user in the result is the one you want
        // echo"<pre>";
        // print_r($user);exit;
        $ses_data = [
            'cust_id' => $user->id, // Use the correct field name for the user ID
            'fullname' => $user->full_name, // Use the correct field name for the full name
            'email' => $user->email, // Use the correct field name for the email
            'isLoggedIn' => TRUE
        ];

        $session->set($ses_data);
        return redirect()->to('/Profile');
    } else {
        $session->setFlashdata('msg', 'Password is incorrect.');
        return redirect()->to('/Register');
    }
}


public function profile()
	{

		if ($this->session->get('cust_id')) {

			$cust_id = $this->session->get('cust_id');
			$userModel = new UserModel();
			$data['setting'] = $this->UserModel->Settingdata();
			$data['cms_data'] = $this->UserModel->Cmsdata(3);
			$data['contactus_data'] = $this->UserModel->Cmsdata(1);
			$data['singleuser'] = $this->UserModel->user_data($cust_id);
			$data['Orderdtls'] = $this->UserModel->orderdtl($cust_id);
			$data['category_data'] = $this->UserModel->category_data(0);
        	$data['brand_data'] = $this->UserModel->brand_data();



			return view('user/user_dashboard_vw', $data);
		} else {
			return redirect()->to('Home');
		}
	}
	
	function pro()
	{

		if ($this->session->get('cust_id')) {

			$cust_id = $this->session->get('cust_id');
			$session = session();

			$data['setting'] = $this->UserModel->Settingdata();
			$data['cms_data'] = $this->UserModel->Cmsdata(3);
			$data['contactus_data'] = $this->UserModel->Cmsdata(1);
			$data['singleuser'] = $this->UserModel->user_data($cust_id);
			$data['Orderdtls'] = $this->UserModel->orderdtl($cust_id);
			$data['category_data'] = $this->UserModel->category_data(0);
        	$data['brand_data'] = $this->UserModel->brand_data();

			$rules = [
				'fullname' => 'required|min_length[3]',
				'email' => 'required|valid_email',
				'contact' => 'required|numeric|max_length[10]',
				'password' => 'required|min_length[3]',

			];

			if ($this->validate($rules)) {
				$fullname = $this->request->getPost('fullname');
				$email = $this->request->getPost('email');
				$contact = $this->request->getPost('contact');
				$password = base64_encode(base64_encode($this->request->getVar('password')));

				$file = $this->request->getFile('img');
				if ($file->isValid() && !$file->hasMoved()) {
					$imagename = $file->getRandomName();
					$file->move('uploads/', $imagename);
				} else {
					$imagename = "";
				}
				$CountContact = $this->db->query("SELECT * FROM user  where contact_no='$contact' and id!='$cust_id' and user_type='4' ")->getResult();
				$CountCont = $this->db->query("SELECT * FROM user  where contact_no='$contact' and id='$cust_id'  and user_type='4' ")->getResult();
               
                
                 // echo count($CountCont);exit;  
                if (count($CountCont) == 1) {    
    				if ($imagename != '') {
    					$udata = [
    						'full_name' => $fullname,
    						'email' => $email,
    						'contact_no' => $contact,
    						'password' => $password,
    						'profile_image' => $imagename,
    					];
    				} else {
    					$udata = [
    						'full_name' => $fullname,
    						'email' => $email,
    						'contact_no' => $contact,
    						'password' => $password,
    					];
						
			$this->UserModel->UpdateProfile($udata, $cust_id);
				return redirect()->to('Home/Profile');
    	}
                
				
				
                }else{
                    $this->session->setFlashdata('msgt', 'Contact Number  Already  exist.');
					$this->session->setFlashdata('uid', $cust_id);
					return redirect()->to('Home/Profile');
					
                }



				$this->UserModel->UpdateProfile($data, $cust_id);

				return redirect()->to('Home/Profile');
			} else {
				$data['validation'] = $this->validator;
				return view('user/user_dashboard_vw', $data);
			}
		} else {
			return redirect()->to('Home/');
		}
	}
	



}

