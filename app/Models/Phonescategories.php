<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class phonescategories extends Sximo  {
	
	protected $table = 'tb_phone_category';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_phone_category.* FROM tb_phone_category  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_phone_category.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
