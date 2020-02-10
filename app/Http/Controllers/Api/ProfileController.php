<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Socialize;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect;

class ProfileController extends Controller {

    public function __construct() {
        
    }

    public function getAvatar(Request $request) {
        return view('api.avatar');
    }

    public function postAvatar(Request $request) {  
        $mobile_token = $request->input('mobile_token');
        $binary = base64_decode($request['binary']);
        $image_ext = $request->input('image_ext');
        if ($mobile_token && $binary && $image_ext) {
            $user = User::where('mobile_token', $mobile_token)->first();
            if ($user) {
                $newfilename = $user->id . '.' . $image_ext;
                 $path = public_path().DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$newfilename ;
                 if(file_put_contents($path, $binary)){
                    $data['avatar'] = $newfilename;
                    \DB::table('tb_users')->where('mobile_token', $request->input('mobile_token'))->update($data);
                           $response = array () ;
                           $response["status"] = "success";
                           $response["fileName"] = $newfilename;
                           $response["filePath"] =  url('/uploads/users/'.$newfilename);       
                    return response()->json(['status' => 'success','response'=>$response]);
                }else{
                     return response()->json(['status' => 'failed']);
                }
            }else{
                  return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        }else{
             return response()->json(['status' => 'failed', 'message' => 'You are missing required fields']);
        }
        
    }
	public function postAvatar2(Request $request) {
        	$rules = array(
                 'avatar' => 'image|required',
                 'mobile_token'=>'required'
        );  
		
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
        	$mobile_token = $request->input('mobile_token');
            $user = User::where('mobile_token', $mobile_token)->first();
            if ($user) {
               	$file = $request->file('avatar');
                $destinationPath = './uploads/users/';
                $extension = $file->getClientOriginalExtension(); 
			    $newfilename = $user->id . '.' . $extension;
                $uploadSuccess = $request->file('avatar')->move($destinationPath, $newfilename);
                 if($uploadSuccess){
                    $data['avatar'] = $newfilename;
                    \DB::table('tb_users')->where('mobile_token', $request->input('mobile_token'))->update($data);
                           $response = array () ;
                           $response["status"] = "success";
                           $response["fileName"] = $newfilename;
                           $response["filePath"] =  url($destinationPath.$newfilename);       
                    return response()->json(['status' => 'success','response'=>$response]);
                }else{
                     return response()->json(['status' => 'failed']);
                }
            }else{
                  return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        }else{
             return response()->json(['status' => 'failed', 'message' => $validator->errors()->first()]);
        }
        
    }

    public function getUsername(Request $request) {
        return view('api.username');
    }

    public function postUsername(Request $request) {
        $mobile_token = $request->input('mobile_token');
        $user_name = $request->input('username');
        if ($mobile_token && $user_name) {
            $user = User::where('mobile_token', $mobile_token)->first();
            if ($user) {
                $rules = array(
                    'username' => 'unique:tb_users,username,' . $user->id,
                );

                $validator = Validator::make($request->all(), $rules);
                if ($validator->passes()) {
                    $user->username = $user_name;
                    $user->save();
                    return response()->json([ 'status' => 'success']);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'the username is used before!']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

}
