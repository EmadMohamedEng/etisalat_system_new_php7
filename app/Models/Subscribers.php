<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class subscribers extends Sximo  {
	
	protected $table = 'tb_susbcribers';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_susbcribers.* FROM tb_susbcribers  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_susbcribers.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
