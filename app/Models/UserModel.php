<?php 
namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class UserModel extends Model {

		protected $table = 'user';
	function Settingdata()
		{
			 $builder = $this->db->table('settingg');
			 $builder->select('*');
			 $builder->where('settingg_id', 1);               
			 return $builder->get()->getResult();
		}
function Cmsdata($cms_id)
	{
		$builder = $this->db->table('cms');
		$builder->select('*');
		$builder->where('id', $cms_id);
		return $builder->get()->getResult();
	}
	function BlogdataHome()
	{
		$builder = $this->db->table('blog');
		$builder->select('*');
		$builder->limit(3);
		$builder->orderBy('blog_id', 'DESC');
		return $builder->get()->getResult();
	}
		function Allblogdata()
	{
		$builder = $this->db->table('blog');
		$builder->select('*');
		$builder->orderBy('blog_id', 'DESC');
		return $builder->get()->getResult();
	}
	function single_Blog($Blog_id)
	{
		$builder = $this->db->table('blog');
		$builder->select('*');
		$builder->where('blog_id', $Blog_id);
		return $builder->get()->getResult();
	}
	
	function BannerdataHome()
	{
		$builder = $this->db->table('banner');
		$builder->select('*');               
		return $builder->get()->getResult();
	}
	
	function category_data($parent_id)
	{
		$builder = $this->db->table('category');
		$builder->select('*');  
		$builder->where('category.parent_id', 0);
		return $builder->get()->getResult();
		
		}
		
	function brand_data()
	{
	    $builder = $this->db->table('brands');
		$builder->select('*');  
		$builder->where('status', 1);
		return $builder->get()->getResult();
	}
	    
	
		
	function offer_data()
	{
		$builder = $this->db->table('coupon_code');
		$builder->select('*');               
		return $builder->get()->getResult();
		
		}
		
		
function Product_Data($cat_id)
{
    $builder = $this->db->table('product_category');
    $builder->select('*');
    $builder->join('product', 'product.product_id = product_category.product_id', 'right');
    $builder->join('brands', 'brands.brands_id = product.brands_id', 'left');
    $builder->join(' product_price', ' product_price.product_id = product.product_id', 'left');
    if($cat_id!="0"){
    $builder->where('category_id', $cat_id);
    }
    return $builder->get()->getResult();
}

	function user_data($id)
		{
			$builder = $this->db->table('user');
			 $builder->select('*');
			 $builder->where('id', $id);               
			 return $builder->get()->getResult();
		}
		function orderdtl($id)
	{
		$builder = $this->db->table('orders');
		 $builder->select('*'); 
		 $builder->where('user_id', $id);
		 $builder->groupBy('order_id');
		 return $builder->get()->getResult();
		 
		}
	 function UpdateProfile($data,$user_id)
		{
		$query = $this->db->table('user')->update($data, array('id' => $user_id));
        return $query;
		}
		
	function single_product ($product_price_id)
	{
	    $builder = $this->db->table('product_price');
			 $builder->select('*');
			 $builder->where('product_price_id', $product_price_id);  
			 $builder->join('product', 'product.product_id = product_price.product_id', 'left');
             $builder->join('brands', 'brands.brands_id = product.brands_id', 'left');
			 
			 return $builder->get()->getResult();
	}
	
	function Productgallery($pro_id)
	{
		$builder = $this->db->table('gallery');
		$builder->select('*');
		$builder->where('product_id', $pro_id);
		return $builder->get()->getResult();
	}
	
		public function getAttributes($product_id) {
    $query = $this->db->query("SELECT * FROM attribute WHERE product_id = $product_id");
    return $query->getResult();
}

public function getVariations($product_id) {
    $query = $this->db->query("SELECT * FROM variation WHERE product_id = $product_id");
    return $query->getResult();
}
			 
	
}



