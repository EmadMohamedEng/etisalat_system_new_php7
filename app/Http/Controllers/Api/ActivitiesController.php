<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\Branches;
use App\Models\Projects;
use App\Models\Projectsemployees;
use App\Models\Reasons;
use App\Models\Exceptions;
use App\Models\Payroll;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect;

class ActivitiesController extends Controller {

    public function __construct() {
        date_default_timezone_set("Africa/Cairo");
    }

    public function getAll() {
        return view('api.all');
    }

    public function getLastActivity() {
        return view('api.last-activity');
    }

    public function postLastActivity(Request $request) {

        $mobile_token = $request->input('mobile_token');
        $ip = $request->input('ip');
        $network_name = $request->input('network_name');


        if ($mobile_token && $ip && $network_name) {
            $user = User::where('mobile_token', $mobile_token)->first();

            if ($user) {
                $emp_id = $user->employee_id;
                $branch = Branches::where(['ip_address' => $ip, 'network_name' => $network_name])->first();
                $activity = Activities::where('employee_id', $emp_id)->orderBy('id', 'desc')->first();
                if ($branch) {
                    if ($activity) { //  there is  previous activity
                        $date = date("d/m/Y", strtotime($activity->time));
                        $time = date("H:i A", strtotime($activity->time));

                        if ($activity->type == 1) {
                            $type = "Check In";
                            $next = "Check Out";
                        } else {
                            $type = "Check Out";
                            $next = "Check In";
                        }

                        $response_activity = [
                            'type' => $type,
                            'date' => $date,
                            'next' => $next,
                            'time' => $time,
                            'status' => $activity->status->title,
                            'location' => $activity->location,
                        ];
                    } else {  // there is no previous activity for that employee 
                        $response_activity = [
                            'type' => Null,
                            'date' => Null,
                            'next' => Null,
                            'time' => Null,
                            'status' => Null,
                            'location' => Null,
                        ];
                    }
                } else {
                    if ($activity) { //  there is  previous activity
                        $date = date("d/m/Y", strtotime($activity->time));
                        $time = date("H:i A", strtotime($activity->time));

                        if ($activity->type == 1) {
                            $type = "Check In";
                            $next = "Check Out";
                        } else {
                            $type = "Check Out";
                            $next = "Check In";
                        }

                        $response_activity = [
                            'type' => $type,
                            'date' => $date,
                            'next' => $next,
                            'time' => $time,
                            'status' => $activity->status->title,
                            'location' => $activity->location,
                        ];
                    } else {  // there is no previous activity for that employee 
                        $response_activity = [
                            'type' => Null,
                            'date' => Null,
                            'next' => Null,
                            'time' => Null,
                            'status' => Null,
                            'location' => Null,
                        ];
                    }

                    return response()->json(['status' => 'failed', 'lastAttendance' => $response_activity, 'message' => 'access denied. You must check in / out from your ip and network']);
                }



                return response()->json(['status' => 'success', 'lastAttendance' => $response_activity]);
            } else {

                return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

    public function getCheck() {
        return view('api.checkinout');
    }

    public function postCheck(Request $request) {

        // date_default_timezone_set("Africa/Cairo");

        $mobile_token = $request->input('mobile_token');
        $ip = $request->input('ip');
        $network_name = $request->input('network_name');


        if ($mobile_token && $ip && $network_name) {

            $config = \DB::table('tb_config')->where('cnf_id', 1)->first();

            // from setting
            $check_in_office = $config->cnf_start_hour;
            $check_out_office = $config->cnf_end_hour;
            $tolerance = $config->cnf_tolerance;


            $current_date = date("Y-m-d");
            $check_state = "";


            $check_in_out_hour = date('H:i');
            $check_in_out_dateTime = date('Y-m-d H:i:s');


            $tolerance_miutes = $tolerance . ':00'; // from setting
            $tolerance_miutes_timeStamp = $tolerance . ' minutes'; // from setting

            $time_stamp_plus = strtotime('+' . $tolerance . '  minutes', strtotime($check_in_out_dateTime));
            $check_in_out_tolerance_plus = date('Y-m-d H:i:s', $time_stamp_plus);


            $time_stamp_minus = strtotime('-' . $tolerance . '  minutes', strtotime($check_in_out_dateTime));
            $check_in_out_tolerance_minus = date('Y-m-d H:i:s', $time_stamp_minus);

            $time1 = strtotime($check_in_office);
            $time2 = strtotime($check_out_office);
            $endTimePlus = date("H:i", strtotime('+' . $tolerance_miutes_timeStamp, $time1));
            $endTimeMinus = date("H:i", strtotime('-' . $tolerance_miutes_timeStamp, $time2));

            $user = User::where('mobile_token', $mobile_token)->first();

            if ($user) {
                $emp_id = $user->employee_id;
                $branch = Branches::where(['ip_address' => $ip, 'network_name' => $network_name])->first();
                $activity = Activities::where('employee_id', $emp_id)->orderBy('id', 'desc')->first();

                $today_job_for_employee = \DB::select(\DB::raw("SELECT * FROM tb_project_employees WHERE DATE(tb_project_employees.job_start_date) = '{$current_date}'   AND  employees_ids IN ($emp_id)"));

                if ($today_job_for_employee) { // current employee is sea and has job today
                    //   print_r($today_job_for_employee[0]); die;
                    $project_employee = $today_job_for_employee[0];
                    $check_in_job_time = $today_job_for_employee[0]->job_start_date;
                    $check_out_job_time = $today_job_for_employee[0]->job_end_date;

                    // make new check in or check out for today
                    $check_activity = new Activities();
                    $check_activity->employee_id = $emp_id;
                    $project_id = $check_activity->project_id = $today_job_for_employee[0]->project_id;
                    $job_id = $check_activity->job_id = $today_job_for_employee[0]->job_id;
                    $check_activity->time = $check_in_out_dateTime; // check out


                    $time_stamp_plus = strtotime('+' . $tolerance . '  minutes', strtotime($check_in_job_time));
                    $check_in_job_tolerance_plus = date('Y-m-d H:i:s', $time_stamp_plus);

                    $time_stamp_minus = strtotime('-' . $tolerance . '  minutes', strtotime($check_out_job_time));
                    $check_out_job_tolerance_minus = date('Y-m-d H:i:s', $time_stamp_minus);


                    if ($branch) {
                        $location = $branch->name;
                        if ($activity) { //  there is  previous activity
                            $last_date = date("d/m/Y", strtotime($activity->time));
                            $last_time = date("H:i A", strtotime($activity->time));
                            if ($activity->type == 1) {
                                $type = "Check In";
                                $next = "Check Out";
                            } else {
                                $type = "Check Out";
                                $next = "Check In";
                            }

                            $response_activity = [
                                'type' => $type,
                                'date' => $last_date,
                                'time' => $last_time,
                                'next' => $next,
                                'status' => $activity->status->title,
                                'location' => $branch->location,
                            ];

                            $activityType = $activity->type;
                            $check_status = $this->makeCheckinOutSea($project_id, $job_id, $emp_id, $activityType, $check_in_out_dateTime, $check_in_job_tolerance_plus, $check_out_job_tolerance_minus, $location);
                        } else {  // there is no previous activity for that employee = check in for the first time 
                            //  $response_activity = [];
                            $response_activity = [
                                'type' => Null,
                                'date' => Null,
                                'time' => Null,
                                'next' => Null,
                                'status' => Null,
                                'location' => Null,
                            ];
                            // make check in for the first time 
                            $activityType = 2;

                            $check_status = $this->makeCheckinOutSea($project_id, $job_id, $emp_id, $activityType, $check_in_out_dateTime, $check_in_job_tolerance_plus, $check_out_job_tolerance_minus, $location);
                        }
                    } else {

                        return response()->json(['status' => 'failed', 'message' => 'access denied. You must check in / out from your ip and network']);
                    }
                } else { // current employee is office  and has no job today 
                    if ($branch) {
                        $location = $branch->name;
                        if ($activity) { //  there is  previous activity
                            // print_r($activity) ; die;
                            if ($activity->type == 1) {
                                $type = "Check In";
                                $next = "Check Out";
                            } else {
                                $type = "Check Out";
                                $next = "Check In";
                            }

                            $last_date = date("d/m/Y", strtotime($activity->time));
                            $last_time = date("H:i A", strtotime($activity->time));


                            $response_activity = [
                                'type' => $type,
                                'date' => $last_date,
                                'time' => $last_time,
                                'next' => $next,
                                'status' => $activity->status->title,
                                'location' => $activity->location,
                            ];



                            //    $chek_in_out_numbers = \DB::select(\DB::raw("SELECT * FROM tb_activities WHERE  DATE(tb_activities.time) = '{$current_date}'  AND employee_id = {$emp_id}"));
                            // make new check in or check out for today
                            // $activityType   $endTimeMinus    $endTimePlus   $check_in_out_hour
                            $activityType = $activity->type;

                            $check_status = $this->makeCheckinOut($emp_id, $activityType, $endTimeMinus, $endTimePlus, $check_in_out_hour, $check_in_out_dateTime, $check_in_office, $location);
                        } else {  // there is no previous activity for that employee = check in for the first time 
                            // $response_activity = [];
                            $response_activity = [
                                'type' => Null,
                                'date' => Null,
                                'time' => Null,
                                'next' => Null,
                                'status' => Null,
                                'location' => Null,
                            ];


                            // make check in for the first time 
                            $activityType = 2;
                            $check_status = $this->makeCheckinOut($emp_id, $activityType, $endTimeMinus, $endTimePlus, $check_in_out_hour, $check_in_out_dateTime, $check_in_office, $location);
                        }
                    } else {

                        return response()->json(['status' => 'failed', 'message' => 'access denied. You must check in / out from your ip and network']);
                    }
                }


                return response()->json(['status' => 'success', 'lastAttendance' => $response_activity, 'check_status' => $check_status]);
            } else {

                return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

    // ===================         check in out for office  ===============================//
    protected function makeCheckinOut($emp_id, $activityType, $endTimeMinus, $endTimePlus, $check_in_out_hour, $check_in_out_dateTime, $check_in_office, $location) {
      //  echo $activityType ; die;
        $check_activity = new Activities();
        $check_activity->employee_id = $emp_id;
        $check_activity->project_id = Null;
        $check_activity->job_id = Null;
        $check_activity->time = $check_in_out_dateTime; // check out
        $check_activity->location = $location; // check out


        if ($activityType == 1) {  // the employee will make  new check out 
            $check_activity->type = 2; // check out
            if ($check_in_out_hour >= $endTimeMinus) { // check out in time  or  check out late 
                $check_activity->activity_status_id = 2;  // auto approved to check out 
                $check_activity->save();
                $reason_array = array();
                $reason_array[] = array("id" => NULL, "title" => NULL);
                $check_status = [
                    'type' => "Check Out",
                    'status' => "normal",
                    'reasons' => $reason_array,
                    'exceptionId' => NULL,
                ];
            } elseif ($check_in_out_hour < $endTimeMinus) {  //  check out early
                $check_activity->activity_status_id = 1;  // pending
                $check_activity->save();
                // make check out exception 
                $exception = new Exceptions();
                $exception->employee_id = $emp_id;
                $exception->activity_id = $check_activity->id;
                $exception->type_id = 2;
                $exception->save();


                $reasons = Reasons::where('type_id', 2)->select('id', 'title')->get();  //return reasons for check out type
                $check_activity->activity_status_id = 1;  //  check out  status is pending
                $check_status = [
                    'type' => "exception",
                    'status' => "check out early",
                    'reasons' => $reasons,
                    'exceptionId' => $exception->id,
                ];
            }
        } elseif ($activityType == 2) { //  // the employee will make new check in
            $check_activity->type = 1; // check in
            if ($check_in_out_hour <= $endTimePlus || $check_in_out_hour <= $check_in_office) {
                $check_activity->activity_status_id = 2;  // auto approved
                $check_activity->save();
                $reason_array = array();
                $reason_array[] = array("id" => NULL, "title" => NULL);
                $check_status = [
                    'type' => "Check In",
                    'status' => "normal",
                    'reasons' => $reason_array,
                    'exceptionId' => NULL,
                ];
            } elseif ($check_in_out_hour > $endTimePlus) {  //  check in late and 
                $check_activity->activity_status_id = 1;  // pending
                $check_activity->save();
                // make check out exception 
                $exception = new Exceptions();
                $exception->employee_id = $emp_id;
                $exception->activity_id = $check_activity->id;
                $exception->type_id = 1;
                $exception->save();

                $reasons = Reasons::where('type_id', 1)->select('id', 'title')->get();  //return reasons for check in type
                $check_activity->activity_status_id = 1;
                $check_status = [
                    'type' => "exception",
                    'status' => "check in late",
                    'reasons' => $reasons,
                    'exceptionId' => $exception->id,
                ];
            }
        }

        return $check_status;
    }

    // ===================         check in out for sea  ===============================//
    protected function makeCheckinOutSea($project_id, $job_id, $emp_id, $activityType, $check_in_out_dateTime, $check_in_job_tolerance_plus, $check_out_job_tolerance_minus, $location) {
        $check_activity = new Activities();
        $check_activity->employee_id = $emp_id;
        $check_activity->project_id = $project_id;
        $check_activity->job_id = $job_id;
        $check_activity->time = $check_in_out_dateTime; // check out
        $check_activity->location = $location; // check out


        if ($activityType == 1) {  // the employee will make  new check out 
            $check_activity->type = 2; // check out
            if ($check_in_out_dateTime >= $check_out_job_tolerance_minus) { // check out in time  or  check out late 
                $check_activity->activity_status_id = 2;  // auto approved to check out 
                $check_activity->save();
                $reason_array = array();
                $reason_array[] = array("id" => NULL, "title" => NULL);
                $check_status = [
                    'type' => "Check Out",
                    'status' => "normal",
                    'reasons' => $reason_array,
                    'exceptionId' => NULL,
                ];
            } elseif ($check_in_out_dateTime < $check_out_job_tolerance_minus) {  //  check out early
                $check_activity->activity_status_id = 1;  // pending
                $check_activity->save();

                // make check out exception 
                $exception = new Exceptions();
                $exception->employee_id = $emp_id;
                $exception->activity_id = $check_activity->id;
                $exception->type_id = 2;  // check out
                $exception->save();

                $reasons = Reasons::where('type_id', 2)->select('id', 'title')->get();  //return reasons for check out type
                $check_activity->activity_status_id = 1;  //  check out  status is pending
                $check_status = [
                    'type' => "check out early",
                    'status' => "exception",
                    'reasons' => $reasons,
                    'exceptionId' => $exception->id,
                ];
            }
        } elseif ($activityType == 2) { //  // the employee will make new check in
            $check_activity->type = 1; // check in
            if ($check_in_out_dateTime <= $check_in_job_tolerance_plus) {
                $activity->activity_status_id = 2;  // auto approved
                $check_activity->save();
                $reason_array = array();
                $reason_array[] = array("id" => NULL, "title" => NULL);
                $check_status = [
                    'type' => "Check In",
                    'status' => "normal",
                    'reasons' => $reason_array,
                    'exceptionId' => NULL,
                ];
            } elseif ($check_in_out_dateTime > $check_in_job_tolerance_plus) {  //  check in late and 
                $check_activity->activity_status_id = 1;
                $check_activity->save();

                // make check out exception 
                $exception = new Exceptions();
                $exception->employee_id = $emp_id;
                $exception->activity_id = $check_activity->id;
                $exception->type_id = 1;  // check in
                $exception->save();

                $reasons = Reasons::where('type_id', 1)->select('id', 'title')->get();  //return reasons for check in type

                $check_status = [
                    'type' => "check in late",
                    'status' => "exception",
                    'reasons' => $reasons,
                    'exceptionId' => $exception->id,
                ];
            }
        }

        return $check_status;
    }

    //================ let Employee submit reason  with notes when there is exception ====================================//
    public function getException() {
        return view('api.exception');
    }

    public function postException(Request $request) {
        //   date_default_timezone_set("Africa/Cairo");
        $mobile_token = $request->input('mobile_token');
        $exception_id = $request->input('exception_id');
        $reason_id = $request->input('reason_id');
        $employee_notes = $request->input('employee_notes');

        if ($mobile_token && $exception_id && $reason_id) {
            $user = User::where('mobile_token', $mobile_token)->first();
            if ($user) {
                $emp_id = $user->employee_id;
                // $exception =  Exceptions::findOrFail($exception_id) ;
                $exception = Exceptions::where(['id' => $exception_id, 'employee_id' => $emp_id])->first();
                if ($exception) {
                    $exception->reason_id = $reason_id;
                    $exception->employee_notes = $employee_notes;
                    if ($exception->save()) {
                        return response()->json(['status' => 'success']);
                    } else {
                        return response()->json(['status' => 'error']);
                    }
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'there is no exception']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

    //================ get Employee attendance ====================================//
    public function getAttendance() {
        return view('api.attendance');
    }

    public function postAttendance(Request $request) {
      //    $currentMonthName =  date("F") ; 
          $month_back = (!is_null($request->input('month_back')) ? $request->input('month_back') : 0);
         $current_date = date("Y-m",  strtotime("-{$month_back} month"));  // get current month or back in months by month_back
         $currentMonthName = date("F",  strtotime("-{$month_back} month"));  // get current month or back in months by month_back
        $mobile_token = $request->input('mobile_token');
        if ($mobile_token) {
            $user = User::where('mobile_token', $mobile_token)->first();
            if ($user) {
                $emp_id = $user->employee_id;   

                $activities = \DB::select(\DB::raw("SELECT  tb_activities.* ,  tb_projects.name  project_name  ,  tb_project_jobs.name  job_name  ,  tb_activity_status.title  activity_status  FROM tb_activities  LEFT JOIN  tb_projects  ON tb_projects.id = tb_activities.project_id   LEFT JOIN  tb_project_jobs  ON tb_project_jobs.id = tb_activities.job_id    LEFT JOIN  tb_activity_status  ON tb_activity_status.id = tb_activities.activity_status_id   WHERE tb_activities.employee_id = {$emp_id}  AND DATE(tb_activities.time) REGEXP '{$current_date}' "));  // return direct objects





                if ($activities) {
                	$month_activity['month']=$currentMonthName;
					$month_activity['data']=$activities;
					$data[]=$month_activity;
                    return response()->json(['status' => 'success','activities'=>$data]);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'There is no activities']);
                }
            } else {
                return response()->json([ 'status' => 'failed', 'message' => 'access denied']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

    //================ get Employee salary ====================================//
    public function getSalary() {
        return view('api.salary');
    }

    public function postSalary(Request $request) {
        //   date_default_timezone_set("Africa/Cairo");
        $mobile_token = $request->input('mobile_token');

        if ($mobile_token) {
            $user = User::where('mobile_token', $mobile_token)->first();
            if ($user) {
                $emp_id = $user->employee_id;
                //    $payrolls = Payroll::where([ 'employee_id' => $emp_id])->get();

                $payrolls = \DB::select(\DB::raw("SELECT  tb_employees_payroll.* ,  tb_employees.fname  employee_fname  ,  tb_employees.lname  employee_lname  ,  tb_departments.name  department_name  FROM tb_employees_payroll  LEFT JOIN  tb_employees  ON tb_employees.id = tb_employees_payroll.employee_id   LEFT JOIN  tb_departments  ON tb_departments.id = tb_employees_payroll.department_id     WHERE tb_employees_payroll.employee_id = {$emp_id}"));  // return direct objects




                if ($payrolls) {
                    return response()->json(['status' => 'success', 'payrolls' => $payrolls]);
                } else {
                    return response()->json([ 'status' => 'success', 'message' => 'There is no payrolls']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        } else {
            return response()->json([ 'status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

    //================ get Employee salary ====================================//
   /* public function getChatLogin() {
        return view('api.chat-login');
    }*/

    public function getChatLogin() {
        //   date_default_timezone_set("Africa/Cairo");
         $mobile_token = Input::get('mobile_token', '');
        //$mobile_token =$mobile_token; //$request->input('mobile_token');
		//die($mobile_token.'-------------');
        if ($mobile_token) {
            $user = User::where('mobile_token', $mobile_token)->first();
            if ($user) {
                //  return response()->json(['status' => 'success', 'userId' => $user->id]);
                //   $chat_url = url('/') . 'chat/cometchat_popout.php';
              $chat_url = url('/') . 'chat/extensions/mobilewebapp/index.php?cookiePrefix=cc_';
                $chat_url = str_replace('public', '', $chat_url);
                session_start();
                $_SESSION['userid'] = $user->id;
                return Redirect::to($chat_url);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'access denied']);
            }
        } else {
            return response()->json([ 'status' => 'failed', 'message' => 'You are missing required fields']);
        }
    }

}