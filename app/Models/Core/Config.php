<?php namespace App\Models\Core;

use App\Models\Sximo;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Config extends Sximo  {
	
	protected $table = 'tb_config';
	protected $primaryKey = 'cnf_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_config.* FROM tb_config  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_config.cnf_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
