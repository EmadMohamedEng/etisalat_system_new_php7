<?php

namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Phones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input;
use Redirect;
use Validator;

class PhonesController extends Controller
{

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'phones';
    static $per_page = '10';

    public function __construct()
    {

        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Phones();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });
        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'phones',
            'return' => self::returnUrl(),
        );
    }

    public function fromFileForm(Request $request, $id = null)
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
            $this->data['row'] = $this->model->getColumnTable('tb_phones');
        }

        $this->data['id'] = $id;
        return view('phones.phoneFromFile', $this->data);
    }

    public function newSubscriberDownload()
    {
        ini_set('max_execution_time', 60000000000);
        ini_set('memory_limit', '-1');

        // create directory that have a name include the current date
        $date = Carbon::now();
        $directory = str_replace('-', '_', str_replace(' ', '_', str_replace(':', '_', $date->toDateTimeString())));
        $directory_name = 'subscribers_' . $directory . '_' . \Auth::user()->id;
        $offset = 0;
        $lmt = 1000000;
        $i = 0;
        $subscribers_ = \DB::select('SELECT SUBSTRING(phone, 3,10) as phone  FROM `tb_susbcribers` WHERE `ServiceName` LIKE "باقة العفاسي الدينية" ');
        $subscribers_ = array_map(create_function('$o', 'return $o->phone;'), $subscribers_);
        // return ['phone'];
        while (true) {
            $phones = \DB::select('SELECT phone FROM `tb_phones` WHERE phone NOT IN ("' . implode('","', $subscribers_) . '")  LIMIT ' . $offset . ',' . $lmt . ';');
            if (count($phones) == 0) {
                break;
            }
            $content = "phone_number\n";
            foreach ($phones as $phone) {
                $content .= $phone->phone . "\r\n";
            }
            $file_name = 'file_' . $i . '.txt';
            \Storage::disk('local')->append($directory_name . '/' . $file_name, $content);
            $i++;
            $offset += $lmt;
        }
        $files = storage_path('app/' . $directory_name);
        \Zipper::make(storage_path('app/' . $directory_name . '.zip'))->add($files)->close();

        return response()->download(storage_path('app/' . $directory_name . '.zip'));

        //          return $phones;
        //       $phones_ = array_chunk($phones, 100000);

        //       $i = 0;
        //          foreach ($phones_ as $phoness) {
        //              $content = "phone_number\n";
        //              foreach ($phoness as $phone) {
        //               $content .= $phone->phone."\r\n";
        //           }
        //           $file_name = 'file_'.$i.'.txt';
        //           \Storage::disk('local')->append($directory_name.'/'.$file_name, $content);
        //           $i++;
        //          }
        //          $files = storage_path('app/'.$directory_name);
        // \Zipper::make(storage_path('app/'.$directory_name.'.zip'))->add($files)->close();

        //       return response()->download(storage_path('app/'.$directory_name.'.zip'));

    }

    public function saveFromFile(Request $request)
    {
        ini_set('max_execution_time', 60000000000);
        ini_set('memory_limit', '-1');

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'phones' => 'required|mimes:txt',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('phones')) {

            $file = fopen($request->file('phones'), "r");

            if ($file == false) {
                echo ("Error in opening file");
                exit();
            }

            $i = 0;
            $content = array();
            while (!feof($file)) {
                $line = fgets($file);
                $i++;
                array_push($content, $line);
            }

            $j = 0;
            //  array_shift($content);
            $content_ = array_chunk($content, 10000);
            foreach ($content_ as $chunk) {
                $query = "INSERT INTO tb_phones (phone, category_id,created_at,updated_at) VALUES";
                $tuple = " ('%s', '%s','%s','%s'),";
                $values = "";
                foreach ($chunk as $nmbr) {
                    $n = trim($nmbr);
                    $c = $request->category_id;
                    $cd = date("Y-m-d H:i:s");
                    $ud = date("Y-m-d H:i:s");

                    if ($n != "") { // to remove last line that has space
                        $values .= sprintf($tuple, $n, $c, $cd, $ud);
                    }
                }
                if ($values != "") {
                    $query = $query . $values;
                    $query = rtrim($query, ","); // Remove trailing comma
                    // echo $query;
                    // die();
                    // Use the query...
                    \DB::insert($query);
                }
            }
            fclose($file);
        }
        $request->session()->flash('success', 'Inserted Successfully');

        return back();
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
        $pagination->setPath('phones');

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
        return view('phones.index', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_phones');
        }

        $this->data['id'] = $id;
        return view('phones.form', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_phones');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('phones.view', $this->data);
    }

    public function postSave(Request $request)
    {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_phones');

            $id = $this->model->insertRow2($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'phones/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'phones?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('phones/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('phones')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('phones')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
