<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class AdminModel extends Model
{
	protected $table = 'user';


	function Settingdata()
	{
		$builder = $this->db->table('settingg');
		$builder->select('*');
		$builder->where('settingg_id', 1);
		return $builder->get()->getResult();
	}

	function userdata($user_id)
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('id', $user_id);
		return $builder->get()->getResult();
	}

	function Customerdata()
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		return $builder->get()->getResult();
	}


	function UpdateSetting($data, $settingid)
	{
		$query = $this->db->table('settingg')->update($data, array('settingg_id' => $settingid));
		return $query;
	}

	function UpdateProfile($data, $user_id)
	{
		$query = $this->db->table('user')->update($data, array('id' => $user_id));
		return $query;
	}

	function GetAllCustomer($user_type)
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('user.user_type', $user_type);
		return $builder->get()->getResult();
	}
	function Singlevendor($vendor_id)
	{
		$builder = $this->db->table('user');
		$builder->select('user.*, state.state_name, city.city_name');
		$builder->join('state', 'state.state_id = user.state_id','left');
		$builder->join('city', 'city.city_id = user.city_id','left');
		$builder->where('user.id', $vendor_id);
		return $builder->get()->getResult();
	}

	function adduser($data)
	{
		$query = $this->db->table('user')->insert($data);
		return $query;
	}
	function deleteuser($user_id)
	{
		$query = $this->db->table('user')->delete(array('id' => $user_id));
		return $query;
	}
	function UserStatusActive($data, $user_id)
	{
		$query = $this->db->table('user')->update($data, array('id' => $user_id));
		return $query;
	}

	function updateUser($data, $id)

	{
		$query = $this->db->table('user')->update($data, array('id' => $id));
		return $query;
	}

	function GetAllstate()
	{
		$builder = $this->db->table('state');
		$builder->select('*');
		return $builder->get()->getResult();
	}

	function Addstate($data)
	{
		$query = $this->db->table('state')->insert($data);
		return $query;
	}

	function Deletestate($stateId)
	{
		$query = $this->db->table('state')->delete(array('state_id' => $stateId));
		return $query;
	}
	function Editstate($data, $stateid)
	{
		$query = $this->db->table('state')->update($data, array('state_id' => $stateid));
		return $query;
	}

	function GetAllcity()
	{
		$builder = $this->db->table('city');
		$builder->select('*');
		return $builder->get()->getResult();
	}

	function GetAllpincode()
	{
		$builder = $this->db->table('pincode');
		$builder->select('*');
		return $builder->get()->getResult();
	}


	function Getcity($state_id)
	{
		$builder = $this->db->table('city');
		$builder->select('*');
		$builder->where('state_id', $state_id);
		return $builder->get()->getResult();
	}

	function bannerdata()
	{
		$builder = $this->db->table('banner');
		$builder->select('*');
		$builder->orderBy('orderby', 'ASC');
		return $builder->get()->getResult();
	}
	function addbanner($data)
	{

		$query = $this->db->table('banner')->insert($data);
		return $query;
	}

	function DeleteBanner($BannerId)
	{
		$query = $this->db->table('banner')->delete(array('banner_id' => $BannerId));
		return $query;
	}
	function single_bannerdata($banner_id)
	{
		$builder = $this->db->table('banner');
		$builder->select('*');
		$builder->where('banner_id', $banner_id);
		return $builder->get()->getResult();
	}
	function Editbanner($data, $banner_id)
	{
		$query = $this->db->table('banner')->update($data, array('banner_id' => $banner_id));
		return $query;
	}
	function getAllCms()
	{
		$builder = $this->db->table('cms');
		$builder->select('*');
		return $builder->get()->getResult();
	}
	function AddPages($data)
	{
		$query = $this->db->table('cms')->insert($data);
		return $query;
	}

	function DeleteCsm($pageId)
	{
		$query = $this->db->table('cms')->delete(array('id' => $pageId));
		return $query;
	}
	function single_page($page_id)
	{
		$builder = $this->db->table('cms');
		$builder->select('*');
		$builder->where('id', $page_id);
		return $builder->get()->getResult();
	}

	function UpdatePages($data, $pageId)
	{
		$query = $this->db->table('cms')->update($data, array('id' => $pageId));
		return $query;
	}
	function gallery($center_id)
	{
		$builder = $this->db->table('center_gallery');
		$builder->select('*');
		$builder->where('center_id', $center_id);
		return $builder->get()->getResult();
	}
	function getcategory()
	{
		$builder = $this->db->table('category');
		$builder->select('*');
		return $builder->get()->getResult();
	}
	function addCategory($data)
	{
		$query = $this->db->table('category')->insert($data);
		return $query;
	}
	function DeleteCategory($cat_id)
	{
		$query = $this->db->table('category')->delete(array('cat_id' => $cat_id));
		return $query;
	}
	function catsingle_data($cat_id)
	{
		$builder = $this->db->table('category');
		$builder->select('*');
		$builder->where('cat_id', $cat_id);
		return $builder->get()->getResult();
	}

	function updateCategory($data, $cid)
	{
		$query = $this->db->table('category')->update($data, array('cat_id' => $cid));
		return $query;
	}

	function Product_Category($pro_id)
	{
		$builder = $this->db->table('product_category ');
		$builder->select('*');
		$builder->where('product_id', $pro_id);
		return $builder->get()->getResult();
	}
	function insertgalleryt($data3)
	{ {
			$query = $this->db->table('gallery')->insert($data3);
			return $query;
		}
	}

	function Updateproduct($data, $data1, $productid)
	{
		$query = $this->db->table('product')->update($data, array('product_id' => $productid));
		$query = $this->db->table('product_category')->delete(array('product_id' => $productid));


		foreach ($data1 as $data1) {
			$inserteddata = [
				'product_id' => $productid,
				'category_id' => $data1['category_id'],
			];


			$query = $this->db->table('product_category')->insert($inserteddata);
		}
		return $query;
	}
	function Allproduct()
	{
		$builder = $this->db->table('product');
		$builder->select('*');
		$builder->where('approve', 1);
		return $builder->get()->getResult();
	}

	function Pendingproduct()
	{
		$builder = $this->db->table('product');
		$builder->select('*');
		$builder->where('approve', 0);
		return $builder->get()->getResult();
	}

	function Allproductdata($product_id)
	{
		$builder = $this->db->table('product');
		$builder->select('*');
		$builder->where('product_id', $product_id);
		return $builder->get()->getResult();
	}
	function allBrands()
	{
		$builder = $this->db->table('brands');
		$builder->select('*');
		return $builder->get()->getResult();
	}


	function addbrand($data)
	{
		$query = $this->db->table('brands')->insert($data);
		return $query;
	}
	function brandstatus($data, $brand_id)
	{
		$query = $this->db->table('brands')->update($data, array('brands_id' => $brand_id));
		return $query;
	}
	function DeleteBrand($brabdId)
	{
		$query = $this->db->table('brands')->delete(array('brands_id' => $brabdId));
		return $query;
	}
	function EditBrand($data, $brandId)
	{
		$query = $this->db->table('brands')->update($data, array('brands_id' => $brandId));
		return $query;
	}
	function Gallerydata($pro_id)
	{
		$builder = $this->db->table('gallery');
		$builder->select('*');
		$builder->where('product_id', $pro_id);
		return $builder->get()->getResult();
	}
	function GetCupon()
	{
		$builder = $this->db->table('coupon_code');
		$builder->select('*');
		return $builder->get()->getResult();
	}

	function AddCuponCode($data)
	{
		$query = $this->db->table('coupon_code')->insert($data);
		return $query;
	}

	function EditCuponCode($data, $cupn_id)
	{
		$query = $this->db->table('coupon_code')->update($data, array('coupon_code_id' => $cupn_id));
		return $query;
	}

	function deletecupon($cuponId)
	{
		$query = $this->db->table('coupon_code')->delete(array('coupon_code_id' => $cuponId));
		return $query;
	}

	function orderdtl()
	{
		$builder = $this->db->table('orders');
		$builder->select('*');
		$builder->groupBy('order_id');
		return $builder->get()->getResult();
	}

	function IteamDetails($order_id)
	{
		$builder = $this->db->table('orders');
		$builder->select('*');
		$builder->where('order_id', $order_id);
		return $builder->get()->getResult();
	}

	function getsingleaddress($addre_id)
	{
		$builder = $this->db->table('address');
		$builder->select('*');
		$builder->where('address_id', $addre_id);
		return $builder->get()->getResult();
	}

	function get_attribute_data($product_id)
	{
		$builder = $this->db->table('attribute');
		$builder->select('attribute_id, attribute_name');
		$builder->where('product_id', $product_id);
		return $builder->get()->getResult();
	}

	function get_variation_data($product_id)
	{
		$builder = $this->db->table('variation');
		$builder->select('variation_id, variation_name, variation_price, attribute_id');
		$builder->where('product_id', $product_id);
		return $builder->get()->getResult();
	}

	function Shipping()
	{
		$builder = $this->db->table('shipping');
		$builder->select('*');
		return $builder->get()->getResult();
	}
	function Getpin($cityDiv)
	{
		$builder = $this->db->table('pincode');
		$builder->select('*');
		$builder->where('city_id', $cityDiv);
		return $builder->get()->getResult();
	}


	public function AddProduct($data)
	{
		// Insert data into the 'products' table
		$this->db->table('product')->insert($data);

		// Return the last insert ID
		return $this->db->insertID();
	}

	function single_product_data($pro_id)
	{
		$builder = $this->db->table('product');
		$builder->select('*');
		$builder->where('product_id', $pro_id);
		return $builder->get()->getResult();
	}
	function getselectedcategory($pro_id)
	{
		$builder = $this->db->table(' product_category');
		$builder->select('*');
		$builder->where('product_id', $pro_id);
		$builder->join('category', 'category.cat_id = product_category.category_id');
		return $builder->get()->getResult();
	}

	function checkVehicleStatus($boarding_time, $vehicle_id)
	{
		$builder = $this->db->table('service_details');
		$builder->select('id');
		$builder->where('vehicle_id', $vehicle_id);
		$builder->where('boarding_date <=', $boarding_time);
		$builder->where('arrival_datetime >=', $boarding_time);
		return $builder->get()->getResult();
	}


	function getAllVehicle()
	{
		$builder = $this->db->table('vehicle_details');
		$builder->select('vehicle_details.*,vehicle_types.type_name,user.full_name');
		$builder->join('vehicle_types', 'vehicle_types.id = vehicle_details.type_id','left');
		$builder->join('user', 'user.id = vehicle_details.vendor_id');
		return $builder->get()->getResult();
	}

	function getAllService()
	{
		$builder = $this->db->table('service_details');
		$builder->select('service_details.*,vehicle.type_id,vehicle.model_name,vehicle.regd_no,vehicle.no_of_sit,user.full_name,driver.full_name as driver_name');
		$builder->join('vehicle_details vehicle', 'vehicle.id = service_details.vehicle_id','left');
		$builder->join('user', 'user.id = service_details.vendor_id','left');
		$builder->join('user driver', 'driver.id = service_details.driver_id','left');
		return $builder->get()->getResult();
	}

	function GetAllRecord($tableName)
	{
		$builder = $this->db->table($tableName);
		$builder->select('*');
		return $builder->get()->getResult();
	}

	function getAllActiveRecord($tableName)
	{
		$builder = $this->db->table($tableName);
		$builder->select('*');
		$builder->where('status', 1);
		return $builder->get()->getResult();
	}


	function InsertRecord($tableName, $data)
	{
		$query = $this->db->table($tableName)->insert($data);
		return $query;
	}

	function DeleteRecordById($tableName, $id)
	{
		$query = $this->db->table($tableName)->delete(array('id' => $id));
		return $query;
	}

	function UpdateRecordById($tableName, $id, $data,)
	{
		$query = $this->db->table($tableName)->update($data, array('id' => $id));
		return $query;
	}

	function getAllVendor()
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('status', 1);
		$builder->where('user_type', 3);
		return $builder->get()->getResult();
	}

	function getOwnVehicleList($user_id)
	{
		$builder = $this->db->table('vehicle_details');
		$builder->select('*');
		$builder->where('status', 1);
		$builder->where('vendor_id', $user_id);
		return $builder->get()->getResult();
	}

	function getAllDriver()
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('status', 1);
		$builder->where('user_type', 4);
		$builder->orWhere('is_driver', 1);
		return $builder->get()->getResult();
	}

	function driverVehicleData($driver_id, $vehicleId)
	{
		$builder = $this->db->table('driver_vehicle_mapping');
		$builder->select('*');
		$builder->where('driver_id', $driver_id);
		$builder->where('vehicle_id', $vehicleId);
		return $builder->get()->getResult();
	}

	function GetAllUser()
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('user_type', 3);
		$builder->orWhere('user_type', 4);
		return $builder->get()->getResult();
	}

	function getSingleData($table, $id, $column_name = 'id')
	{
		$query = $this->db->query("SELECT * FROM $table  where $column_name = $id");
		return $query->getRow();
	}

	function getDriverVehicle()
	{
		$builder = $this->db->table('driver_vehicle_mapping');
		$builder->select('driver_vehicle_mapping.*,vehicle.model_name,vehicle.regd_no,driver.full_name as drivername,driver.email,driver.contact_no,owner.full_name');
		$builder->join('vehicle_details vehicle', 'vehicle.id = driver_vehicle_mapping.vehicle_id');
		$builder->join('user driver', 'driver.id = driver_vehicle_mapping.driver_id');
		$builder->join('user owner', 'owner.id = driver_vehicle_mapping.owner_id');
		return $builder->get()->getResult();
	}

	function updateDriverRemoved($driver_id, $vehicleId, $data)
	{
		$query = $this->db->table('driver_vehicle_mapping')->update($data, array('driver_id' => $driver_id, 'vehicle_id' => $vehicleId));
		return $query;
	}

	function getSingleLastData($table, $id)
	{
		$query = $this->db->query("SELECT * FROM $table  where vehicle_id = $id ORDER BY id DESC LIMIT 1");
		return $query->getRow();
	}

	function getAllRates()
	{
		$builder = $this->db->table('service_rate');
		$builder->select('service_rate.*,vehicle_types.type_name,state.state_name');
		$builder->join('vehicle_types', 'vehicle_types.id = service_rate.type_id');
		$builder->join('state', 'state.state_id = service_rate.state_id');
		return $builder->get()->getResult();
	}

	function checkServiceAvailbility($type, $from_location, $to_location)
	{
		$builder = $this->db->table('vehicle_details');
		$builder->select('id');
		$builder->where('type_id', $type);
		$VehicleIds = $builder->get()->getResultArray();

		$arr = array_map(function ($value) {
			return $value['id'];
		}, $VehicleIds);

		$builder = $this->db->table('service_details');
		$builder->select('service_details.*,vehicle.driver_id');
		$builder->where('service_details.from_city', $from_location);
		$builder->where('service_details.to_city', $to_location);
		$builder->whereIn('service_details.vehicle_id', $arr);
		$builder->join('vehicle_details vehicle', 'vehicle.id = service_details.vehicle_id');
		return $builder->get()->getResult();
	}

	function checkServicRate($state_id, $type_id)
	{
		$builder = $this->db->table('service_rate');
		$builder->select('*');
		$builder->where('state_id', $state_id);
		$builder->where('type_id', $type_id);
		$builder->where('status', 1);
		return $builder->get()->getRow();
	}

	public function InsertService($data)
	{
		// Insert data into the 'products' table
		$this->db->table('service_bookings')->insert($data);

		// Return the last insert ID
		return $this->db->insertID();
	}

	function getAllBookingRequest()
	{
		$builder = $this->db->table('service_request');
		$builder->select('service_request.*,booking.user_id,booking.booking_type,booking.fare,booking.from_location,booking.to_location,user.full_name,service.vehicle_id,vehicle.regd_no');
		$builder->join('service_bookings booking', 'booking.id = service_request.booking_id');
		$builder->join('user user', 'user.id = booking.user_id');
		$builder->join('service_details service', 'service.id = service_request.service_id');
		$builder->join('vehicle_details vehicle', 'vehicle.id = service.vehicle_id');
		return $builder->get()->getResult();
	}

	function getAllrequestStatuswise($booking_id, $status)
	{
		$builder = $this->db->table('service_request');
		$builder->select('*');
		$builder->where('booking_id', $booking_id);
		$builder->where('status', $status);
		return $builder->get()->getResult();
	}

	function getAllBookingData()
	{
		$builder = $this->db->table('service_bookings');
		$builder->select('service_bookings.*,type.type_name,vehicle.regd_no,vehicle.model_name,user.full_name,user.contact_no');
		$builder->join('vehicle_types type', 'type.id = service_bookings.vehicle_type');
		$builder->Join('vehicle_details vehicle', 'vehicle.id = service_bookings.vehicle_id', 'left');
		$builder->join('user user', 'user.id = service_bookings.driver_id', 'left');
		return $builder->get()->getResult();
	}

	function checkUserPahone($phone)
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('contact_no', $phone);
		return $builder->get()->getResult();
	}

	function getRateStatewise($state_id)
	{
		$builder = $this->db->table('service_rate');
		$builder->select('service_rate.*,vehicle_types.type_name');
		$builder->join('vehicle_types', 'vehicle_types.id = service_rate.type_id');
		$builder->where('service_rate.state_id', $state_id);
		$builder->where('service_rate.status', 1);
		return $builder->get()->getResult();
	}

	function getVehicleDriverData($driver_id)
	{
		$builder = $this->db->table('driver_vehicle_mapping');
		$builder->select('driver_vehicle_mapping.*,vehicle_details.type_id');
		$builder->join('vehicle_details', 'vehicle_details.id = driver_vehicle_mapping.vehicle_id');
		$builder->where('driver_vehicle_mapping.driver_id', $driver_id);
		$builder->where('driver_vehicle_mapping.status', 1);
		$builder->orderBy('id', 'DESC');
		return $builder->get()->getRow();
	}

	public function InsertServiceDetails($data)
	{
		// Insert data into the 'products' table
		$this->db->table('service_details')->insert($data);

		// Return the last insert ID
		return $this->db->insertID();
	}

	function checkUserPahoneDriver($phone)
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('contact_no', $phone);
		$builder->where('user_type', 4);
		return $builder->get()->getResult();
	}

	function getDriverwiseBookingRequest($driver_id)
	{
		$builder = $this->db->table('service_request');
		$builder->select('service_request.*,booking.user_id,booking.booking_type,booking.fare,booking.from_location,user.full_name,booking.to_location,service.vehicle_id,vehicle.regd_no');
		$builder->join('service_bookings booking', 'booking.id = service_request.booking_id');
		$builder->join('user user', 'user.id = booking.user_id');
		$builder->join('service_details service', 'service.id = service_request.service_id');
		$builder->join('vehicle_details vehicle', 'vehicle.id = service.vehicle_id');
		$builder->where('service_request.driver_id', $driver_id);
		return $builder->get()->getResult();
	}

	function checkDriverStatus($service_id)
	{
		$builder = $this->db->table('vehicle_location_status');
		$builder->select('*');
		$builder->where('service_id', $service_id);
		return $builder->get()->getResult();
	}

	function getBookingData($booking_id)
	{
		$builder = $this->db->table('service_bookings');
		$builder->select('service_bookings.*,type.type_name,vehicle.regd_no,vehicle.model_name,user.full_name,user.contact_no');
		$builder->join('vehicle_types type', 'type.id = service_bookings.vehicle_type', 'left');
		$builder->Join('vehicle_details vehicle', 'vehicle.id = service_bookings.vehicle_id', 'left');
		$builder->join('user user', 'user.id = service_bookings.driver_id', 'left');
		$builder->where('service_bookings.id',$booking_id);
		return $builder->get()->getResult();
	}

	function getAllDriverService($driver_id)
	{
		$builder = $this->db->table('service_details');
		$builder->select('service_details.*,vehicle.type_id,vehicle.model_name,vehicle.regd_no,vehicle.no_of_sit,user.full_name,booking.from_location,booking.to_location,booking.booking_type,booking.id as bookingid');
		$builder->join('vehicle_details vehicle', 'vehicle.id = service_details.vehicle_id');
		$builder->join('user', 'user.id = service_details.driver_id');
		$builder->join('service_bookings booking', 'booking.service_id = service_details.id','left');
		$builder->where('service_details.driver_id',$driver_id);
		return $builder->get()->getResult();
	}

	function getAllCustomerBookingData($customer_id)
	{
		$builder = $this->db->table('service_bookings');
		$builder->select('service_bookings.*,type.type_name,vehicle.regd_no,vehicle.model_name,user.full_name,user.contact_no');
		$builder->join('vehicle_types type', 'type.id = service_bookings.vehicle_type');
		$builder->Join('vehicle_details vehicle', 'vehicle.id = service_bookings.vehicle_id', 'left');
		$builder->join('user user', 'user.id = service_bookings.driver_id', 'left');
		$builder->where('service_bookings.user_id',$customer_id);
		$builder->orderBy('service_bookings.id','DESC');
		return $builder->get()->getResult();
	}

	function getAllDriverNotification($user_id)
	{
		$builder = $this->db->table('notifications');
		$builder->select('*');
		$builder->where('user_id',$user_id);
		return $builder->get()->getResult();
	}

	function getOngoingDriverService($driver_id)
	{
		$builder = $this->db->table('service_details');
		$builder->select('service_details.*,vehicle.type_id,vehicle.model_name,vehicle.regd_no,vehicle.no_of_sit,user.full_name,booking.from_location,booking.to_location,booking.booking_type,booking.id as bookingid');
		$builder->join('vehicle_details vehicle', 'vehicle.id = service_details.vehicle_id');
		$builder->join('user', 'user.id = service_details.driver_id');
		$builder->join('service_bookings booking', 'booking.service_id = service_details.id','left');
		$builder->where('service_details.driver_id',$driver_id);
		$builder->where('service_details.status',1);
		return $builder->get()->getResult();
	}


	function getAllUserList($member_id)
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('created_by',$member_id);
		$builder->orderBy('id','DESC');
		return $builder->get()->getResult();
	}

	function getDriverwiseLiftRequest($driver_id)
	{
		$builder = $this->db->table('lift_request');
		$builder->select('lift_request.*,booking.user_id,booking.booking_type,booking.from_location,user.full_name,booking.to_location,booking.origin_lat,booking.origin_lng,booking.destination_lat,booking.destination_lng');
		$builder->join('service_bookings booking', 'booking.id = lift_request.booking_id');
		$builder->join('user user', 'user.id = booking.user_id');
		$builder->where('lift_request.driver_id', $driver_id);
		return $builder->get()->getResult();
	}

	function getBookingwiseLiftRequest($booking_id)
	{
		$builder = $this->db->table('lift_request');
		$builder->select('lift_request.*,user.full_name,user.email,user.contact_no,user.profile_image,vehicle.model_name,vehicle.regd_no,vehicle.vehicle_make,vehicle.no_of_sit');
		$builder->join('user user', 'user.id = lift_request.driver_id');
		$builder->join('vehicle_details vehicle', 'vehicle.id = lift_request.vehicle_id');
		$builder->where('lift_request.booking_id', $booking_id);
		return $builder->get()->getResult();
	}

	function checkUserPahoneOwner($phone)
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('contact_no', $phone);
		$builder->where('user_type', 3);
		return $builder->get()->getResult();
	}

	function getOwnerwiseVehicleList($owner_id)
	{
		$builder = $this->db->table('vehicle_details');
		$builder->select('*');
		$builder->where('vendor_id', $owner_id);
		return $builder->get()->getResult();
	}

	function getAllDriverList()
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		$builder->where('user_type', 4);
		return $builder->get()->getResult();
	}

	function getAllCustomerLiftBookingData($customer_id)
	{
		$builder = $this->db->table('service_bookings');
		$builder->select('service_bookings.*,type.type_name,vehicle.regd_no,vehicle.model_name,user.full_name,user.contact_no');
		$builder->join('vehicle_types type', 'type.id = service_bookings.vehicle_type','left');
		$builder->Join('vehicle_details vehicle', 'vehicle.id = service_bookings.vehicle_id', 'left');
		$builder->join('user user', 'user.id = service_bookings.driver_id', 'left');
		$builder->where('service_bookings.booking_type','lift');
		$builder->where('service_bookings.user_id',$customer_id);
		$builder->orderBy('service_bookings.id','DESC');
		return $builder->get()->getResult();
	}

	function GetAllMember()
	{
		$builder = $this->db->table('user');
		$builder->select('user.*,franchises.franchise_name');
		$builder->join('franchises', 'franchises.id = user.franchise_id', 'left');
		$builder->Where('user_type', 2);
		return $builder->get()->getResult();
	}

	function getMemebrCheckinCheckoutList($member_id)
	{
		$builder = $this->db->table('members_checkin');
		$builder->select('*');
		$builder->Where('member_id', $member_id);
		return $builder->get()->getResult();
	}

	public function InsertFranchise($data)
	{
		// Insert data into the 'products' table
		$this->db->table('franchises')->insert($data);

		// Return the last insert ID
		return $this->db->insertID();
	}

	public function GetAllFranchises()
	{
		$builder = $this->db->table('franchises');
		$builder->select('franchises.*,user.id as user_id,user.user_name,user.password');
		$builder->join('user', 'user.franchise_id = franchises.id AND user.is_admin = 1', 'left');
		return $builder->get()->getResult();
	}

	public function GetFranchiseUser($franchise_id)
	{
		$builder = $this->db->table('user');
		$builder->select('user.*,u.id as uid');
		$builder->join('user u', "u.id = user.created_by AND u.franchise_id = ".$franchise_id);
		$builder->where('user.user_type', 3);
		$builder->orWhere('user.user_type', 4);
		return $builder->get()->getResult();
	}

	function GetFranchiseMember($franchise_id)
	{
		$builder = $this->db->table('user');
		$builder->select('user.*,franchises.franchise_name');
		$builder->join('franchises', 'franchises.id = user.franchise_id', 'left');
		$builder->Where('user.user_type', 2);
		$builder->Where('user.franchise_id', $franchise_id);
		return $builder->get()->getResult();
	}

	function getFranchiseVehicle($franchise_id)
	{
		$builder = $this->db->table('vehicle_details');
		$builder->select('vehicle_details.*,vehicle_types.type_name,user.full_name,user.created_by');
		$builder->join('vehicle_types', 'vehicle_types.id = vehicle_details.type_id','left');
		$builder->join('user', 'user.id = vehicle_details.vendor_id');
		$builder->join('user u', "u.id = user.created_by AND u.franchise_id = ".$franchise_id);

		return $builder->get()->getResult();
	}

	function getFranchiseDriverVehicle($franchise_id)
	{
		$builder = $this->db->table('driver_vehicle_mapping');
		$builder->select('driver_vehicle_mapping.*,vehicle.model_name,vehicle.regd_no,driver.full_name as drivername,driver.email,driver.contact_no,owner.full_name,owner.created_by');
		$builder->join('vehicle_details vehicle', 'vehicle.id = driver_vehicle_mapping.vehicle_id');
		$builder->join('user driver', 'driver.id = driver_vehicle_mapping.driver_id');
		$builder->join('user owner', 'owner.id = driver_vehicle_mapping.owner_id');
		$builder->join('user u', "u.id = owner.created_by AND u.franchise_id = ".$franchise_id);
		return $builder->get()->getResult();
	}

	function getFranchiseOwner($franchise_id)
	{
		$builder = $this->db->table('user');
		$builder->select('user.*');
		$builder->join('user u', "u.id = user.created_by AND u.franchise_id = ".$franchise_id);
		$builder->where('user.status', 1);
		$builder->where('user.user_type', 3);

		return $builder->get()->getResult();
	}
	
}
