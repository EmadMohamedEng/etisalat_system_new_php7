<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class months extends Sximo  {
	
	protected $table = 'tb_months';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_months.* FROM tb_months  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_months.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
