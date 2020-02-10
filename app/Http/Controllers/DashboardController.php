<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Redirect;

class DashboardController extends Controller {

    public function __construct() {
        parent::__construct();

        // to set arabic language the default after login
        /*
          $lang = "ar";
          \App::setLocale($lang);

          \Session::put('lang', $lang);
          return Redirect::back();
         */
    }

    public function getIndex(Request $request) {
        $this->data['total_user'] = \DB::table('tb_users')->count();
        $this->data['total_groups'] = \DB::table('tb_groups')->count();
      
        return view('dashboard.index', $this->data);
    }

    public function postResettoken(Request $request) {
        $data = array();
        $data['mobile_token'] = '';
        \DB::table('tb_users')->where('id', $request->input('id'))->update($data);

        echo "true";
    }

}
