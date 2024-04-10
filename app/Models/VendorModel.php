<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class VendorModel extends Model
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
	function Allproduct()
	{
		$builder = $this->db->table('product');
		$builder->select('*');
		$builder->where('status', 1);
		$builder->where('approve', 1);
		return $builder->get()->getResult();
	}
	
public function VendorAllproduct($vendor_id)
{
    $builder = $this->db->table('product_price');
    $builder->select('product.*,brands.brands_name, product_price.vstatus, product_price.product_price_id, product_price.sale_price, product_price.regular_price as price');
    $builder->where('product_price.vendor_id', $vendor_id);
    $builder->join('product', 'product.product_id = product_price.product_id', 'left');
    $builder->join('brands', 'brands.brands_id = product.brands_id', 'left');
    return $builder->get()->getResult();
}



	function Pendingproduct($vendor_id)
	{
		$builder = $this->db->table('product');
		$builder->select('*');
		$builder->where('createdby', $vendor_id);
		return $builder->get()->getResult();
	}
	function pricevariationdata($pro_id, $vendor_id)
	{
		$builder = $this->db->table('price_varition');
		$builder->select('*');
		$builder->where('product_id', $pro_id);
		$builder->where('vendor_id', $vendor_id);
		
		return $builder->get()->getResult();
	}
	function pricedata($pro_id, $vendor_id)
	{
		$builder = $this->db->table('product_price');
		$builder->select('*');
		$builder->where('product_id', $pro_id);
		$builder->where('vendor_id', $vendor_id);
		
		return $builder->get()->getResult();
	}




}
