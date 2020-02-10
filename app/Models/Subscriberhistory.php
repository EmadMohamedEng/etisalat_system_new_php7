<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class subscriberhistory extends Sximo  {
	
	protected $table = 'tb_susbcribers_history';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_susbcribers_history.* FROM tb_susbcribers_history  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_susbcribers_history.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
