<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Socialize;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

    // use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request) {
        return Validator::make($request->all(), [
                    'username' => 'required|max:255',
                    'mobile_token' => 'required|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function getLogin() {
        return view('api.auth.login');
    }

    public function postLogin(Request $request) {

        
        $validator = Validator::make($request->all(), [
                    'username' => 'required',
                    'mobile_token' => 'required',
                    'password' => 'required',
        ]);
        if ($validator->passes()) {
            $remember = (!is_null($request->get('remember')) ? 'true' : 'false' );

            if (\Auth::attempt(array('username' => $request->input('username'), 'password' => $request->input('password')), $remember)) {
                if (\Auth::check()) {
                    $row = User::find(\Auth::user()->id);

                    if ($row->active == '0') {
                        // inactive 
                        \Auth::logout();
                        return response()->json(['status' => 'failed', 'message' => 'Your account is not active']);
                    }
                    if ($row->active == '2') {
                        // BLocked users
                        \Auth::logout();
                        return response()->json(['error' => 'Your account is Blocked']);
                    }

                    $userData = User::where('mobile_token', '=', $request->input('mobile_token'));
                    if ($userData->count() > 0) {
                        $userData = $userData->get();
                        if ($row->mobile_token != $userData[0]->mobile_token) {
                            \Auth::logout();
                            return response()->json(['status' => 'failed', 'message' => 'This mobile is registered to another account']);
                        }
                    }
                    if ($row->mobile_token == '' || $row->mobile_token == NULL || $row->mobile_token == $request->input('mobile_token')) {
                        \Auth::logout();
                       
                        \DB::table('tb_users')->where('id', '=', $row->id)->update(array('mobile_token' => $request->input('mobile_token'), 'last_login' => date("Y-m-d H:i:s"), 'is_login' => '1',"mobile_type"=>$request->input('mobile_type')));
                        $data['status'] = "success";
                        $data['user'] = \DB::table('tb_employees')->where('tb_users.id', '=', $row->id)->join('tb_users', 'tb_users.employee_id', '=', 'tb_employees.id')->select('tb_employees.id', 'fname', 'lname', 'phone', 'job', 'date_of_birth', 'tb_users.email', 'tb_users.avatar')->first();
                        $data['avtar_path'] = url() . '/uploads/users/';
                        return response()->json($data);

                        // to handle mobile chat login
                        session_start();
                        $_SESSION['userid'] = $row->id;
                        
                    } else {
                        \Auth::logout();
                        return response()->json(['status' => 'failed', 'message' => 'You are using wrong device']);
                    }
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'You username / password in correct']);
            }
        } else {

            return response()->json(['status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

    public function postLogout(Request $request) {
        //\Auth::logout();
        \DB::table('tb_users')->where('mobile_token', '=', $request->input('mobile_token'))->update(array('is_login' => '0'));
        return response()->json(['status' => 'success']);
    }

    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

}
