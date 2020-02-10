<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Config;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Validator, Input, Redirect ; 
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest');
    }
	public function getEmail()
    {
        \DB::table('tb_config')->where('cnf_id',1)->select('cnf_appname');
        return view('api.auth.password');
    }

	public function postRequest( Request $request)
	{

		
	}	
	
	
	
	public function postEmail(Request $request)
    {
       $rules = array(
			'email'=>'required|email'
		);	
		
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {	
	
			$user =  User::where('email','=',$request->input('email'));
			if($user->count() >=1)
			{
				$user = $user->get();
				$user = $user[0];
				$cnf  = \DB::table('tb_config')->where('cnf_id', '1')->first();
				//\DB::select('select * tb_config  where cnf_id = ?', [1]);
				//return print_r($cnf);
				$token = Hash::make(date('Y-m-d H:i:s'));
				$data = array('token'=>$token);	
				$to = $request->input('email');
				$subject = "[ " .$cnf->cnf_appname." ] REQUEST PASSWORD RESET "; 			
				$message = view('api.emails.password', $data);
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: '.$cnf->cnf_appname.' <'.$cnf->cnf_email.'>' . "\r\n";
					mail($to, $subject, $message, $headers);				
			
				
				$affectedRows = User::where('email', '=',$user->email)
								->update(array('reminder' => $token));
								
				return response()->json(['status'=>'success','Reset Email sent to your email, please check your email.']);
					
				
			} else {
				return response()->json(['status'=>'fail','message' => 'This email address is not registered']);
			}

		}  else {
			return response()->json(['status'=>'fail','message'=>$validator->errors()->first()]);
		}	 
    }
	
}
