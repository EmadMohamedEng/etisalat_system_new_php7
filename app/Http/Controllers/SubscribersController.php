<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscriberhistory;
use App\Models\Subscribers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input;
use Redirect;
use Validator;

class SubscribersController extends Controller
{

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'subscribers';
    static $per_page = '100';

    public function __construct()
    {

        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Subscribers();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });
        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'subscribers',
            'return' => self::returnUrl(),
        );
    }

    public function getIndex(Request $request)
    {

        if ($this->access['is_view'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query
        // Filter Search for query
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0),
        );
        // Get Query
        $results = $this->model->getRows($params);

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
        $pagination->setPath('subscribers');

        $this->data['rowData'] = $results['rows'];
        // Build Pagination
        $this->data['pagination'] = $pagination;
        // Build pager number and append current param GET
        $this->data['pager'] = $this->injectPaginate();
        // Row grid Number
        $this->data['i'] = ($page * $params['limit']) - $params['limit'];
        // Grid Configuration
        $this->data['tableGrid'] = $this->info['config']['grid'];
        $this->data['tableForm'] = $this->info['config']['forms'];
        $this->data['colspan'] = \SiteHelpers::viewColSpan($this->info['config']['grid']);
        // Group users permission
        $this->data['access'] = $this->access;
        // Detail from master if any
        // Master detail link if any
        $this->data['subgrid'] = (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
        // Render into template
        return view('subscribers.index', $this->data);
    }

    public function getUpdate(Request $request, $id = null)
    {

        if ($id == '') {
            if ($this->access['is_add'] == 0) {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
            }

        }

        if ($id != '') {
            if ($this->access['is_edit'] == 0) {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
            }

        }

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_susbcribers');
        }

        $this->data['id'] = $id;
        return view('subscribers.form', $this->data);
    }

    public function getShow($id = null)
    {

        if ($this->access['is_detail'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_susbcribers');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('subscribers.view', $this->data);
    }

    public function postSave(Request $request)
    {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_subscribers');

            $id = $this->model->insertRow2($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'subscribers/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'subscribers?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('subscribers/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                ->withErrors($validator)->withInput();
        }
    }

    public function postDelete(Request $request)
    {

        if ($this->access['is_remove'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        // delete multipe rows
        if (count($request->input('id')) >= 1) {
            $this->model->destroy($request->input('id'));

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('subscribers')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('subscribers')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    //  notifyclient.php
    public function notifyclient(Request $request)
    {

        error_reporting(0); // to disable error notice for Undefined index for array  $post_array

        $string = file_get_contents('php://input');
        //   echo $string ; die;

        $start = '<ns1:MSISDN>';
        $end = '</ns1:MSISDN>';

        $request_array = array(
            'MSISDN' => ['start' => '<ns1:MSISDN>', 'end' => '</ns1:MSISDN>'],
            'TSTAMP' => ['start' => '<ns1:TSTAMP>', 'end' => '</ns1:TSTAMP>'],
            'Price' => ['start' => '<ns1:Price>', 'end' => '</ns1:Price>'],
            'NextRenwal' => ['start' => '<ns1:NextRenwal>', 'end' => '</ns1:NextRenwal>'],
            'ServiceID' => ['start' => '<ns1:ServiceID>', 'end' => '</ns1:ServiceID>'],
            'ServiceName' => ['start' => '<ns1:ServiceName>', 'end' => '</ns1:ServiceName>'],
            'PreviousStatus' => ['start' => '<ns1:PreviousStatus>', 'end' => '</ns1:PreviousStatus>'],
            'NewStatus' => ['start' => '<ns1:NewStatus>', 'end' => '</ns1:NewStatus>'],
            'Channel' => ['start' => '<ns1:Channel>', 'end' => '</ns1:Channel>'],
        );

        $post_array = array();
        foreach ($request_array as $key => $value) {
            $start = $value['start'];
            $end = $value['end'];

            $startpos = strpos($string, $start) + strlen($start);
            if (strpos($string, $start) !== false) {
                $endpos = strpos($string, $end, $startpos);
                if (strpos($string, $end, $startpos) !== false) {
                    $post_array[$key] = substr($string, $startpos, $endpos - $startpos);
                } else {
                    $post_array[$key] = "";
                }
            }
        }

        $MSISDN = $post_array['MSISDN'];
        $TSTAMP = $post_array['TSTAMP'];
        $Price = $post_array['Price'];
        $NextRenwal = $post_array['NextRenwal'];
        $ServiceID = $post_array['ServiceID'];
        $ServiceName = $post_array['ServiceName'];
        $PreviousStatus = $post_array['PreviousStatus'];
        $NewStatus = $post_array['NewStatus'];
        $Channel = $post_array['Channel'];

        date_default_timezone_set("Africa/Cairo"); // set date time zone  to egypt

        if (isset($MSISDN) && $MSISDN != "") { //
            $ServiceID = "5657";

            $Subscriber = Subscribers::where('MSISDN', '=', $MSISDN)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();

            if ($Subscriber) {

            } else { // create new
                $Subscriber = new Subscribers();
                $currentTime = date("Y-m-d H:i:s", strtotime('-1 hour'));
                $Subscriber->created_at = $currentTime;
            }

            // decrypt cipher text from etisalat
            $method = "aes-128-cbc"; // in java   AES+Base64
            $encryption_key = '0111145789facbed';
            $iv = str_repeat(chr(0), 16); //  in java  =    AES/CBC/PKCS5Padding    // chr(0) = ""
            $encrypted = $MSISDN;
            $decrypted = openssl_decrypt($encrypted, $method, $encryption_key, 0, $iv);

            $currentTime = date("Y-m-d H:i:s", strtotime('-1 hour'));
            $Subscriber->MSISDN = $MSISDN;
            $Subscriber->phone = $decrypted;
            $Subscriber->TSTAMP = $TSTAMP;
            $Subscriber->Price = $Price;
            $Subscriber->NextRenwal = $NextRenwal;
            $Subscriber->ServiceID = $ServiceID;
            $Subscriber->ServiceName = $ServiceName;
            $Subscriber->PreviousStatus = $PreviousStatus;
            $Subscriber->NewStatus = $NewStatus;
            $Subscriber->Channel = $Channel;
            $updateTime = date("Y-m-d H:i:s", strtotime('-1 hour'));
            $Subscriber->updated_at = $updateTime;
            $Subscriber->save();

            // store history
            $subscriberhistory = new Subscriberhistory();
            $subscriberhistory->created_at = $currentTime;
            $subscriberhistory->MSISDN = $MSISDN;
            $subscriberhistory->phone = $decrypted;
            $subscriberhistory->TSTAMP = $TSTAMP;
            $subscriberhistory->Price = $Price;
            $subscriberhistory->NextRenwal = $NextRenwal;
            $subscriberhistory->ServiceID = $ServiceID;
            $subscriberhistory->ServiceName = $ServiceName;
            $subscriberhistory->PreviousStatus = $PreviousStatus;
            $subscriberhistory->NewStatus = $NewStatus;
            $subscriberhistory->Channel = $Channel;
            $subscriberhistory->updated_at = $updateTime;
            $subscriberhistory->save();

            if ($Subscriber) {
                //  $output = "true";
                $output = $Subscriber->id;
            } else {
                $output = "false";
            }
        } else {
            $output = "false";
        }

        $result = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/">
        <soap:Header/>
        <soap:Body>
        <tem:StatusNotificationResponse>
        <tem:StatusNotificationResult>' . $output . '</tem:StatusNotificationResult>
        </tem:StatusNotificationResponse>
        </soap:Body>
        </soap:Envelope>';

        echo $result;
    }

    // check susbcription
    // 1= active  , 2= not_active  , 3=  not_subscribed , 4= login from wifi
    public function checksub(Request $request)
    {
        $ServiceID = "5657";
        $result = "";
        $phoneCipher = $request->get('param');
        $ServiceName = "باقة العفاسي الدينية";

        if (isset($phoneCipher) && $phoneCipher != "") {

            $Subscriber = Subscribers::where('MSISDN', '=', $phoneCipher)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();
            if ($Subscriber) {
                if ($Subscriber->NewStatus == 0) { // active
                    $result = 1; // active
                } else {
                    $result = 2; //   not_active
                }
            } else {
                $result = 3; // not_subscribed
            }
        } else {
            $result = 4; //  login from wifi
        }

        return $result;
    }

    // check phone
    // 1= active  , 2= not_active  , 3=  not_subscribed , 4= phone not entered
    public function checkphone(Request $request)
    {
        $ServiceID = "5657";
        $ServiceName = "باقة العفاسي الدينية";
        $result = "";
        $phone = $request->get('phone');

        //  echo $phoneCipher ; die;

        if (isset($phone) && $phone != "") {
            $Subscriber = Subscribers::where('phone', '=', $phone)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();

            if ($Subscriber) {
                if ($Subscriber->NewStatus == 0) { // active
                    $result = 1; // active
                } else {
                    $result = 2; //   not_active
                }
            } else {
                $result = 3; // not_subscribed
            }
        } else {
            $result = 4; // phone not entered
        }

        return $result;
    }

    // get phone by cipher
    public function getPhone(Request $request)
    {

        $ServiceID = "5657";
        $result = "";
        $phoneCipher = $request->get('param');
        $ServiceName = "باقة العفاسي الدينية";

        if (isset($phoneCipher) && $phoneCipher != "") {
            $Subscriber = Subscribers::where('MSISDN', '=', $phoneCipher)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();

            if ($Subscriber) {

                $result = $Subscriber->phone;
                $result = substr($result, 1); // to remove  2 from phone
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }

        return $result;
    }

    // this add or update subscriber
    public function addUpdateSubscriber(Request $request)
    {
        $ServiceID = "5657";
        $ServiceName = "باقة العفاسي الدينية";
        $result = "";
        $phone = $request->get('phone');

        date_default_timezone_set("Africa/Cairo"); // set date time zone  to egypt
        $currentTime = date("Y-m-d H:i:s", strtotime('-1 hour'));

        // encrypt phone
        $method = "aes-128-cbc"; // in java   AES+Base64
        $encryption_key = '0111145789facbed';
        $iv = str_repeat(chr(0), 16); //  in java  =    AES/CBC/PKCS5Padding    // chr(0) = ""
        $encrypted = openssl_encrypt($phone, $method, $encryption_key, 0, $iv);

        if (isset($phone) && $phone != "") {
            $Subscriber = Subscribers::where('phone', '=', $phone)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();
            $vcode = rand(pow(10, 4), pow(10, 5) - 1);

            if ($Subscriber) { // update
                $Subscriber->subs_web = 1;
                $Subscriber->vcode = $vcode;
                $Subscriber->bin_created_time = $currentTime;
                $Subscriber->bin_end_time = date("Y-m-d H:i:s");
                $Subscriber->save();
            } else { // create new subscriber
                $Subscriber = new Subscribers();
                $Subscriber->phone = $phone;
                $Subscriber->MSISDN = $encrypted;
                $Subscriber->ServiceID = $ServiceID;
                $Subscriber->ServiceName = $ServiceName;
                $Subscriber->NewStatus = 1; // not active
                $Subscriber->created_at = $currentTime;
                $Subscriber->updated_at = $currentTime;
                // add Vcode
                $Subscriber->subs_web = 1;
                $Subscriber->vcode = $vcode;
                $Subscriber->bin_created_time = $currentTime;
                $Subscriber->bin_end_time = date("Y-m-d H:i:s");
                $Subscriber->save();
            }

            $result = $vcode; // vcode is created
        } else {
            $result = 0; // phone not entered
        }

        return $result;
    }

    // this add or update subscriber
    public function checkVcode(Request $request)
    {
        $ServiceID = "5657";
        $ServiceName = "باقة العفاسي الدينية";
        $result = array();
        $phone = $request->get('phone');
        $vcode = $request->get('vcode');

        date_default_timezone_set("Africa/Cairo"); // set date time zone  to egypt
        $currentTime = date("Y-m-d H:i:s", strtotime('-1 hour'));

        if (isset($phone) && $phone != "") {
            $Subscriber = Subscribers::where('phone', '=', $phone)->where('ServiceID', '=', $ServiceID)->where('vcode', '=', $vcode)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();

            if ($Subscriber) { // vcode is verified
                $result = $Subscriber;
            }
        }

        return $Subscriber;
    }

    // make subscriber login
    public function setActiveWebLogin(Request $request)
    {
        $ServiceID = "5657";
        $ServiceName = "باقة العفاسي الدينية";
        $result = "";
        $phone = $request->get('phone');

        if (isset($phone) && $phone != "") {
            $Subscriber = Subscribers::where('phone', '=', $phone)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();
            if ($Subscriber) {
                $Subscriber->login = 1;
                $Subscriber->save();
                $result = 1;
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }

        return $result;
    }

    // make subscriber login
    public function webAppLogin(Request $request)
    {
        $ServiceID = "5657";
        $ServiceName = "باقة العفاسي الدينية";
        $result = "";
        $phone = $request->get('phone');

        if (isset($phone) && $phone != "") {
            $Subscriber = Subscribers::where('phone', '=', $phone)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();
            if ($Subscriber) {
                if ($Subscriber->login == 1) {
                    $result = 2; //  already login
                } else {
                    $Subscriber->login = 1;
                    $Subscriber->save();
                    $result = 1; // not login
                }
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }

        return $result;
    }

    // make subscriber logout
    public function setActiveWebLogout(Request $request)
    {
        $ServiceID = "5657";
        $ServiceName = "باقة العفاسي الدينية";
        $result = "";
        $phone = $request->get('phone');

        if (isset($phone) && $phone != "") {
            $Subscriber = Subscribers::where('phone', '=', $phone)->where('ServiceID', '=', $ServiceID)->where('ServiceName', 'LIKE', '%' . $ServiceName . '%')->first();
            if ($Subscriber) {
                $Subscriber->login = 0;
                $Subscriber->save();
                $result = 1;
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }

        return $result;
    }

    public function checkExists(Request $request)
    {
        ini_set('max_execution_time', 60000000000);
        ini_set('memory_limit', '-1');

        $phones = $request->get('phones');

        $ServiceName = "باقة العفاسي الدينية";
        $count = \DB::select("SELECT count(*) AS count FROM tb_susbcribers WHERE phone  IN('" . implode("','", $phones) . "') AND ServiceName = '" . $ServiceName . "' ");
        return $count[0]->count;
    }

    // get random for first two weeks
    public function randomActiveSubscriber(Request $request)
    {
        ini_set('max_execution_time', 60000000000);
        ini_set('memory_limit', '-1');
        $ServiceName = "باقة العفاسي الدينية";
        $result = \DB::select("SELECT phone  FROM tb_susbcribers WHERE  NewStatus = 0    AND ServiceName = '" . $ServiceName . "'   AND created_at BETWEEN '2017-05-27 00:00:00.000000' AND '2017-06-10 00:00:00.000000'  ORDER BY RAND() LIMIT 1 ");

        if (isset($result[0]->phone)) {
            $randomPhone = $result[0]->phone;
            $request->session()->flash('success', $randomPhone);
            return Redirect::to('subscribers');
        } else {
            return Redirect::to('subscribers')
                ->with('messagetext', 'Empty result')->with('msgstatus', 'error');
        }
    }

    public function updateSubscribers()
    {

        ini_set('max_execution_time', 60000000000);
        ini_set('memory_limit', '-1');

        $subject = 'Etisalat sync for  :' . Carbon::now()->format('Y-m-d');
        $email = 'emad@ivas.com.eg';
        $this->sendMail($subject, $email);

        \DB::table('tb_susbcribers')->truncate();
        $offset = 0;
        $lmt = 10000;
        while (true) {
            $subscribers = \DB::connection('updateSource')->select("SELECT * FROM tb_susbcribers LIMIT " . $offset . "," . $lmt . ";");
            // return $subscribers;
            if (count($subscribers) == 0) {
                break;
            }
            $query = "INSERT INTO tb_susbcribers (id, phone,MSISDN,TSTAMP,Price,NextRenwal,ServiceID,ServiceName,PreviousStatus,NewStatus,Channel,entry_by,vcode,bin_created_time,bin_end_time,subs_web,login,created_at,updated_at) VALUES";
            $tuple = " ('%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'),";
            $values = "";
            foreach ($subscribers as $subscriber) {
                $c1 = $subscriber->id;
                $c2 = $subscriber->phone;
                $c3 = $subscriber->MSISDN;
                $c4 = $subscriber->TSTAMP;
                $c5 = $subscriber->Price;
                $c6 = $subscriber->NextRenwal;
                $c7 = $subscriber->ServiceID;
                $c8 = $subscriber->ServiceName;
                $c9 = $subscriber->PreviousStatus;
                $c10 = $subscriber->NewStatus;
                $c11 = $subscriber->Channel;
                $c12 = $subscriber->entry_by;
                $c13 = $subscriber->vcode;
                $c14 = $subscriber->bin_created_time;
                $c15 = $subscriber->bin_end_time;
                $c16 = $subscriber->subs_web;
                $c17 = $subscriber->login;
                $c18 = $subscriber->created_at;
                $c19 = $subscriber->updated_at;

                $values .= sprintf($tuple, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19);
            }
            
            if (!$values == "") {
                $query = $query . $values;
                $query = rtrim($query, ","); // Remove trailing comma
                \DB::insert($query);
            }
            $offset += $lmt;

        }

        echo "Database updated successfully";

    }

    public function sendMail($subject, $email)
    {

        $message = '<!DOCTYPE html>
					<html lang="en-US">
						<head>
							<meta charset="utf-8">
						</head>
						<body>
							<h2> Etisalat sync for :' . Carbon::now()->format('Y-m-d') . '</h2>



						</body>
					</html>';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $email;

        @mail($email, $subject, $message, $headers);
    }

}
