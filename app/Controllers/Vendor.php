<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\VendorModel;
use App\Models\AdminModel;

class Vendor extends BaseController
{
	private $session = null;
	public function __construct()
	{

		$db = db_connect();
		$this->db = db_connect();

		$this->VendorModel = new VendorModel($db);
		$this->AdminModel = new AdminModel($db);
		$this->session = session();
		helper(['form', 'url', 'validation']);
	}
	
		public function index()
	{
		return view('vendor/login');
	}
	
	function loginAuth()
	{

		$session = session();
		$VendorModel = new VendorModel();
		$username = $this->request->getVar('username');
		$password = base64_encode(base64_encode($this->request->getVar('password')));

		$data = $VendorModel->where('user_name', $username)->first();

		//echo "<pre>";
		//Print_r ($data);exit;
		if ($data) {
			$pass = $data['password'];
			$status = $data['status'];
			$user_type= $data['user_type'];
			//$authenticatePassword = password_verify($password, $pass);

			if ($pass == $password and $status == 1 and $user_type == 3) {
				$ses_data = [
					'vendor_id' => $data['id'],
					'fullname' => $data['full_name'],
					'email' => $data['email'],
					'isLoggedIn' => TRUE
				];
				$session->set($ses_data);
				return redirect()->to('Vendor/Dashboard');
			} else {
				$session->setFlashdata('msg', 'Password is incorrect.');
				return redirect()->to('Vendor/');
			}
		} else {
			$session->setFlashdata('msg', 'username does not exist.');
			return redirect()->to('Vendor/');
		}
	}
	function profile()
	{

		if ($this->session->get('vendor_id')) {

			$vendor_id = $this->session->get('vendor_id');

			$data['setting'] = $this->VendorModel->Settingdata();
			$data['singleuser'] = $this->VendorModel->userdata($vendor_id);


			return view('vendor/profile_vw', $data);
		} else {
			return redirect()->to('Vendor/');
		}
	}
	function pro()
	{

		if ($this->session->get('vendor_id')) {

			$vendor_id = $this->session->get('vendor_id');

			$data['setting'] = $this->VendorModel->Settingdata();
			$data['singleuser'] = $this->VendorModel->userdata($vendor_id);


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

				$this->VendorModel->UpdateProfile($data, $vendor_id);

				return redirect()->to('Vendor/profile');
			} else {
				$data['validation'] = $this->validator;
				return view('vendor/profile_vw', $data);
			}
		} else {
			return redirect()->to('Vendor/');
		}
	}
	
	
	public function Logout()
	{
		$session = session();
		$session->destroy();
		return redirect()->to('Vendor/');
	}
	function dashboard()
	{

		if ($this->session->get('vendor_id')) {

			$vendor_id = $this->session->get('vendor_id');

			$data['setting'] = $this->VendorModel->Settingdata();
			$data['singleuser'] = $this->VendorModel->userdata($vendor_id);

			return view('vendor/dashboard_vw', $data);
		} else {
			return redirect()->to('vendor/');
		}
	}

	 function Product()
	{
		if($this->session->get('vendor_id')){
			
		$vendor_id= $this->session->get('vendor_id');
			
		$data['setting']=$this->VendorModel->Settingdata();
		$data['singleuser']=$this->VendorModel->userdata($vendor_id);
		$data['product_data']=$this->VendorModel->VendorAllproduct($vendor_id);
		$data['Allproduct_data']=$this->VendorModel->Allproduct();
		
				return view('vendor/Product_vw',$data);          
			}else{
				return redirect()->to('vendor/');
			}
	}
	
function PendingProduct()
	{
		if($this->session->get('vendor_id')){
			
		$vendor_id= $this->session->get('vendor_id');
			
		$data['setting']=$this->VendorModel->Settingdata();
		$data['singleuser']=$this->VendorModel->userdata($vendor_id);
		$data['product_data']=$this->VendorModel->Pendingproduct($vendor_id);
		
				return view('vendor/Pending_Product_vw',$data);          
			}else{
				return redirect()->to('admin/');
			}
	}

function Add_product()
	{
		if($this->session->get('vendor_id')){
			
			$vendor_id= $this->session->get('vendor_id');
			$pname=$this->request->getPost('pname');
			$product_type=$this->request->getPost('product_type');
			
			$data = [
				'product_name' =>$pname,
				'product_type' =>1,			
				'status' =>0,
				'createdby'=>$vendor_id,
				'approve'=>0,
			];

			$insert_id = $this->AdminModel->AddProduct($data);
			
			return redirect()->to('vendor/Edit_product/'.$insert_id);

				}else{
					return redirect()->to('Vendor/');
				}	
	}	
	
function Edit_product()
	{
		if($this->session->get('vendor_id')){
			$data['setting']=$this->AdminModel->Settingdata();
			$vendor_id= $this->session->get('vendor_id');
		    $data['singleuser']=$this->AdminModel->userdata($vendor_id);
			$pro_id = $this->request->uri->getSegment(3);
			$data['product_data']=$this->AdminModel->single_product_data($pro_id);
			$data['category_data']=$this->AdminModel->getcategory();
			$data['Product_Category']=$this->AdminModel->Product_Category($pro_id);
			
			$data['attribute'] = $this->AdminModel->get_attribute_data($pro_id);
            $data['variations'] = $this->AdminModel->get_variation_data($pro_id);
	
			$data['allBrands']=$this->AdminModel->allBrands();
			$data['allGallery']=$this->AdminModel->Gallery($pro_id);
			
		
			return view('vendor/edit_Product_vw',$data);
		}else{
			return redirect()->to('vendor/');
		}

	}
function update_product()
{
    if ($this->session->get('vendor_id')) {
		$session = session();
        $productid = $this->request->getPost('productid');
        $product_name = $this->request->getPost('product_name');
        $description = $this->request->getPost('description');
        $saleperprice = $this->request->getPost('saleperprice');
        $regperprice = $this->request->getPost('regperprice');
        $brand = $this->request->getPost('brand');
        $p_cat = $this->request->getPost('p_cat[]');
        $gallery = $this->request->getFileMultiple('images');
        $file = $this->request->getFile('img');
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
				'prodType'=>$this->request->getPost('productType'),
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
		
		$session->setFlashdata('msg', 'This Product is Process For Approval.');
        return redirect()->to('Vendor/Edit_product/' . $productid);
    } else {
        return redirect()->to('Vendor/');
    }
}

function Add_product_price()
	{
		if($this->session->get('vendor_id')){
			$pro_id= $this->request->getPost('selectproduct');
		return redirect()->to('vendor/Edit_ProductPrice/'.$pro_id);
		}else{
			return redirect()->to('vendor/');
		}

	}
	
function Edit_ProductPrice()
	{
		
		if($this->session->get('vendor_id')){
			
			$pro_id = $this->request->uri->getSegment(3);

			$data['setting']=$this->AdminModel->Settingdata();
			$vendor_id= $this->session->get('vendor_id');
		    $data['singleuser']=$this->AdminModel->userdata($vendor_id);
			
			$data['product_data']=$this->AdminModel->single_product_data($pro_id);
			$data['category_data']=$this->AdminModel->getcategory();
			$data['Product_Category']=$this->AdminModel->Product_Category($pro_id);
			
			$data['attribute'] = $this->AdminModel->get_attribute_data($pro_id);
            $data['variations'] = $this->AdminModel->get_variation_data($pro_id);
	
			$data['allBrands']=$this->AdminModel->allBrands();
			$data['allGallery']=$this->AdminModel->Gallery($pro_id);
			$data['allvariationpricedata']=$this->VendorModel->pricevariationdata($pro_id, $vendor_id);
			$data['allpricedata']=$this->VendorModel->pricedata($pro_id, $vendor_id);
			
			
			
		
			return view('vendor/Add_product_price_vw',$data);
		}else{
			return redirect()->to('Vendor/');
		}

		
	
	}
	
	
function product_price()
	{
		if($this->session->get('vendor_id')){
		
		$vendor_id= $this->session->get('vendor_id');
		$product_id= $this->request->getPost('productid');
		$regularprice= $this->request->getPost('regularprice');
		$salesprice= $this->request->getPost('salesprice');
		
		
		$file = $this->request->getFile('img');
        if ($file->isValid() && !$file->hasMoved()) {
            $imagename = $file->getRandomName();
            $file->move('uploads/', $imagename);
        } else {
            $imagename = "";
        }

      
		 $data= [
                'vendor_id' => $vendor_id,
                'product_id' => $product_id,
                'regular_price' => $regularprice,
				'sale_price'=>$salesprice,
            ];
		   if ($imagename != "") {
            $data+= [
                'image' => $imagename
            ];
		}

		$countproduct = $this->db->query("SELECT * FROM product_price  where vendor_id='$vendor_id' and product_id='$product_id' ")->getResult();
		if(count($countproduct)==0){
		$this->db->table('product_price')->insert($data);
		}else{
			foreach ($countproduct as $prpr){}
			$this->db->table('product_price')->update($data, array('product_price_id' => $prpr->product_price_id));
			}
		return redirect()->to('Vendor/Edit_ProductPrice/'.$product_id);
		}else{
			return redirect()->to('Vendor/');
		}
		
		}
		
function product_variationprice()
	{
		if($this->session->get('vendor_id')){
		$session = session();
		
		$vendor_id= $this->session->get('vendor_id');
		$product_id= $this->request->getPost('productid');
		$regularprice= $this->request->getPost('regularprice');
		$salesprice= $this->request->getPost('salesprice');
		$variation= $this->request->getPost('variation[]');
		$variation = $this->request->getPost('variation');
        $variation_string = implode(',', $variation); 
		
		
		$countproduct = $this->db->query("SELECT * FROM price_varition  where variation_value='$variation_string' ")->getResult();
		if(count($countproduct)!=0){
			$session->setFlashdata('msg', 'this product variation is already added');
			return redirect()->to('Vendor/Edit_ProductPrice/'.$product_id);
			}

		
		
		$file = $this->request->getFile('img');
        if ($file->isValid() && !$file->hasMoved()) {
            $imagename = $file->getRandomName();
            $file->move('uploads/', $imagename);
        } else {
            $imagename = "";
        }

       
		 $data= [
                'vendor_id' => $vendor_id,
                'product_id' => $product_id,
                'regular_price' => $regularprice,
				'sale_price'=>$salesprice,
				'variation_value'=>$variation_string,
            ];
		 
		 if ($imagename != "") {
            $data+= [
                'image' => $imagename
            ];
		}
		$this->db->table('price_varition')->insert($data);
		
		return redirect()->to('Vendor/Edit_ProductPrice/'.$product_id);
		}else{
			return redirect()->to('Vendor/');
		}
		
		}
		
public function delete_variationprice() {
  $variation_id = $this->request->getPost('variation_id');
  $this->db->table('price_varition')->where('price_varition_id', $variation_id)->delete();
  return true;
}

function vendorprice()
{
	if($this->session->get('vendor_id')){
			
			 $Product_id=$this->request->getPost('p_id');
			 $status=$this->request->getPost('status');
			
			 $data = [
					'vstatus' => $status,
				];
			 
            $this->db->table('product_price')->update($data, array('product_price_id' => $Product_id));	
			return redirect()->to('/vendor/Product');
			}else{
            return redirect()->to('admin/');
          }
		  
	}
	
public function deleteProduct() {
  $variation_id = $this->request->getPost('user_id');
  $this->db->table('product_price')->where('product_price_id', $variation_id)->delete();
 return redirect()->to('/vendor/Product');
}
	
}

