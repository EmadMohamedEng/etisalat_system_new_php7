<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use App\News;
use Illuminate\Http\Request;
use Validator, Input, Redirect ; 


class DemoController extends Controller {

	public function __construct()
	{
		
		
		
	}
	public function postAppStatus(Request $request)
	{	
			$data['status']="success";
			$data['is_demo']="yes";
		return response()->json($data);
	}
	public function getAppStatus()
	{
			$data['status']="success";
			$data['is_demo']="yes";
		return response()->json($data);
		
	}	
}