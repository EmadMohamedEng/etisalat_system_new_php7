<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Subscribers;
use Validator,
    Input,
    Redirect;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
// use PDF;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;

use Symfony\Component\HttpFoundation\Response;   // note to add this 

abstract class Controller extends BaseController {

    use DispatchesJobs,
        ValidatesRequests;

    public function __construct() {


        $this->middleware('ipblocked');

        $driver = config('database.default');
        $database = config('database.connections');

        $this->db = $database[$driver]['database'];
        $this->dbuser = $database[$driver]['username'];
        $this->dbpass = $database[$driver]['password'];
        $this->dbhost = $database[$driver]['host'];


        if (\Auth::check() == true) {

            if (!\Session::get('gid')) {

                \Session::put('uid', \Auth::user()->id);
                \Session::put('gid', \Auth::user()->group_id);
                \Session::put('eid', \Auth::user()->email);
                \Session::put('ll', \Auth::user()->last_login);
                \Session::put('fid', \Auth::user()->first_name . ' ' . \Auth::user()->last_name);
                \Session::put('themes', 'sximo-light-blue');
            }
        }

        if (!\Session::get('themes')) {
            \Session::put('themes', 'sximo');
        }


        if (defined('CNF_MULTILANG') && CNF_MULTILANG == 1) {

            $lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
            \App::setLocale($lang);
        }
        $data = array(
            'last_activity' => strtotime(Carbon::now())
        );
        \DB::table('tb_users')->where('id', \Session::get('uid'))->update($data);
    }

    function postComboselect(Request $request) {

        if ($request->ajax() == true && \Auth::check() == true) {
            $param = explode(':', $request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
            $rows = $this->model->postComboselect($param, $limit, $parent);
            $items = array();

            $fields = explode("|", $param[2]);

            foreach ($rows as $row) {
                $value = "";
                foreach ($fields as $item => $val) {
                    if ($val != "")
                        $value .= $row->$val . " ";
                }
                $items[] = array($row->$param['1'], $value);
            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG' => " Ops .. Cant access the page !"));
        }
    }

    function postComboselect2(Request $request) {

        if ($request->ajax() == true && \Auth::check() == true) {
            $param = explode(':', $request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
            $rows = $this->model->postComboselect2($param, $limit, $parent);
            $items = array();

            $fields = explode("|", $param[2]);

            foreach ($rows as $row) {
                $value = "";
                foreach ($fields as $item => $val) {
                    if ($val != "")
                        $value .= $row->$val . " ";
                }
                $items[] = array($row->$param['1'], $value);
            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG' => " Ops .. Cant access the page !"));
        }
    }

    function postComboselect3(Request $request) {

        if ($request->ajax() == true && \Auth::check() == true) {
            $param = explode(':', $request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
            $rows = $this->model->postComboselect3($param, $limit, $parent);
            $items = array();

            $fields = explode("|", $param[2]);

            foreach ($rows as $row) {
                $value = "";
                foreach ($fields as $item => $val) {
                    if ($val != "")
                        $value .= $row->$val . " ";
                }
                $items[] = array($row->$param['1'], $value);
            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG' => " Ops .. Cant access the page !"));
        }
    }

    function postComboselect4(Request $request) {

        if ($request->ajax() == true && \Auth::check() == true) {
            $param = explode(':', $request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
            $rows = $this->model->postComboselect4($param, $limit, $parent);
            $items = array();

            $fields = explode("|", $param[2]);

            foreach ($rows as $row) {
                $value = "";
                foreach ($fields as $item => $val) {
                    if ($val != "")
                        $value .= $row->$val . " ";
                }
                $items[] = array($row->$param['1'], $value);
            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG' => " Ops .. Cant access the page !"));
        }
    }

    function postComboselect5(Request $request) {

        if ($request->ajax() == true && \Auth::check() == true) {
            $param = explode(':', $request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
            $rows = $this->model->postComboselect5($param, $limit, $parent);
            $items = array();

            $fields = explode("|", $param[2]);

            foreach ($rows as $row) {
                $value = "";
                foreach ($fields as $item => $val) {
                    if ($val != "")
                        $value .= $row->$val . " ";
                }
                $items[] = array($row->$param['1'], $value);
            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG' => " Ops .. Cant access the page !"));
        }
    }

    function postComboselect6(Request $request) {

        if ($request->ajax() == true && \Auth::check() == true) {
            $param = explode(':', $request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
            $rows = $this->model->postComboselect6($param, $limit, $parent);
            $items = array();

            $fields = explode("|", $param[2]);

            foreach ($rows as $row) {
                $value = "";
                foreach ($fields as $item => $val) {
                    if ($val != "")
                        $value .= $row->$val . " ";
                }
                $items[] = array($row->$param['1'], $value);
            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG' => " Ops .. Cant access the page !"));
        }
    }

    function postComboselect7(Request $request) {

        if ($request->ajax() == true && \Auth::check() == true) {
            $param = explode(':', $request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->input('limit')) ? $request->input('limit') : null);
            $rows = $this->model->postComboselect7($param, $limit, $parent);
            $items = array();

            $fields = explode("|", $param[2]);

            foreach ($rows as $row) {
                $value = "";
                foreach ($fields as $item => $val) {
                    if ($val != "")
                        $value .= $row->$val . " ";
                }
                $items[] = array($row->$param['1'], $value);
            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG' => " Ops .. Cant access the page !"));
        }
    }

    public function getCombotable(Request $request) {
        if (Request::ajax() == true && Auth::check() == true) {
            $rows = $this->model->getTableList($this->db);
            $items = array();
            foreach ($rows as $row)
                $items[] = array($row, $row);
            return json_encode($items);
        } else {
            return json_encode(array('OMG' => "  Ops .. Cant access the page !"));
        }
    }

    public function getCombotablefield(Request $request) {
        if ($request->input('table') == '')
            return json_encode(array());
        if (Request::ajax() == true && Auth::check() == true) {


            $items = array();
            $table = $request->input('table');
            if ($table != '') {
                $rows = $this->model->getTableField($request->input('table'));
                foreach ($rows as $row)
                    $items[] = array($row, $row);
            }
            return json_encode($items);
        } else {
            return json_encode(array('OMG' => "  Ops .. Cant access the page !"));
        }
    }

    function postMultisearch(Request $request) {
        $model_name = "";
        if ($request->input('model_name') !== Null) {
            $model_name = $request->input('model_name');
            $this->module = $model_name;
        }

        $post = $_POST;
        $items = '';
        foreach ($post as $item => $val):
            if ($_POST[$item] != '' and $item != '_token' and $item != 'md' && $item != 'id'):
                $items .= $item . ':' . trim($val) . '|';
            endif;

        endforeach;
        return Redirect::to($this->module . '?search=' . substr($items, 0, strlen($items) - 1) . '&md=' . Input::get('md'));
    }

    function buildSearch() {
        $keywords = '';
        $fields = '';
        $param = '';
        $allowsearch = $this->info['config']['forms'];
        foreach ($allowsearch as $as)
            $arr[$as['field']] = $as;
        if ($_GET['search'] != '') {
            $type = explode("|", $_GET['search']);
            if (count($type) >= 1) {
                foreach ($type as $t) {
                    $keys = explode(":", $t);

                    if (in_array($keys[0], array_keys($arr))):
                        if ($arr[$keys[0]]['type'] == 'select' || $arr[$keys[0]]['type'] == 'radio') {
                            $param .= " AND " . $arr[$keys[0]]['alias'] . "." . $keys[0] . " = '" . $keys[1] . "' ";
                        } else {
                            $param .= " AND " . $arr[$keys[0]]['alias'] . "." . $keys[0] . " REGEXP '" . $keys[1] . "' ";
                        }
                    endif;
                }
            }
        }
        return $param;
    }

    function inputLogs(Request $request, $note = NULL) {
        $data = array(
            'module' => $request->segment(1),
            'task' => $request->segment(2),
            'user_id' => Session::get('uid'),
            'ipaddress' => $request->getClientIp(),
            'note' => $note
        );
        \DB::table('tb_logs')->insert($data);
        ;
    }

    function validateForm() {
        $forms = $this->info['config']['forms'];
        $rules = array();
        foreach ($forms as $form) {
            if ($form['required'] == '' || $form['required'] != '0') {
                $rules[$form['field']] = 'required';
            } elseif ($form['required'] == 'alpa') {
                $rules[$form['field']] = 'required|alpa';
            } elseif ($form['required'] == 'alpa_num') {
                $rules[$form['field']] = 'required|alpa_num';
            } elseif ($form['required'] == 'alpa_dash') {
                $rules[$form['field']] = 'required|alpa_dash';
            } elseif ($form['required'] == 'email') {
                $rules[$form['field']] = 'required|email';
            } elseif ($form['required'] == 'numeric') {
                $rules[$form['field']] = 'required|numeric';
            } elseif ($form['required'] == 'date') {
                $rules[$form['field']] = 'required|date';
            } else if ($form['required'] == 'url') {
                $rules[$form['field']] = 'required|active_url';
            } else {
                
            }
        }
        return $rules;
    }

    function validatePost($table) {
        $request = new Request;
        ///	return json_encode($_POST);	

        $str = $this->info['config']['forms'];
        $data = array();
        foreach ($str as $f) {
            $field = $f['field'];
            if ($f['view'] == 1) {


                if ($f['type'] == 'textarea_editor' || $f['type'] == 'textarea') {
                    $content = (isset($_POST[$field]) ? $_POST[$field] : '');
                    $data[$field] = $content;
                } else {


                    if (isset($_POST[$field])) {
                        $data[$field] = $_POST[$field];
                    }
                    // if post is file or image		


                    if ($f['type'] == 'file') {

                        $files = '';
                        if (isset($f['option']['image_multiple']) && $f['option']['image_multiple'] == 1) {

                            if (isset($_POST['curr' . $field])) {
                                $curr = '';
                                for ($i = 0; $i < count($_POST['curr' . $field]); $i++) {
                                    $files .= $_POST['curr' . $field][$i] . ',';
                                }
                            }

                            if (!is_null(Input::file($field))) {

                                $destinationPath = '.' . $f['option']['path_to_upload'];
                                foreach ($_FILES[$field]['tmp_name'] as $key => $tmp_name) {
                                    $file_name = $_FILES[$field]['name'][$key];
                                    $file_tmp = $_FILES[$field]['tmp_name'][$key];
                                    if ($file_name != '') {
                                        move_uploaded_file($file_tmp, $destinationPath . '/' . $file_name);
                                        $files .= $file_name . ',';
                                    }
                                }

                                if ($files != '')
                                    $files = substr($files, 0, strlen($files) - 1);
                            }
                            $data[$field] = $files;
                        } else {


                            if (!is_null(Input::file($field))) {

                                $file = Input::file($field);


                                if ($this->module == "users") {
                                    $destinationPath = $f['option']['path_to_upload'];
                                } else {
                                    $destinationPath = '.' . $f['option']['path_to_upload'];
                                }




                                $filename = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension(); //if you need extension of the file
                                $rand = rand(1000, 100000000);
                                $newfilename = strtotime(date('Y-m-d H:i:s')) . '-' . $rand . '.' . $extension;


                                $uploadSuccess = $file->move($destinationPath, $newfilename);
                                if ($f['option']['resize_width'] != '0' && $f['option']['resize_width'] != '') {
                                    if ($f['option']['resize_height'] == 0) {
                                        $f['option']['resize_height'] = $f['option']['resize_width'];
                                    }
                                    $orgFile = $destinationPath . '/' . $newfilename;
                                    \SiteHelpers::cropImage($f['option']['resize_width'], $f['option']['resize_height'], $orgFile, $extension, $orgFile);
                                }

                                if ($uploadSuccess) {
                                    $data[$field] = $newfilename;
                                }
                            } else {
                                unset($data[$field]);
                            }
                        }
                    }


                    // if post is checkbox	
                    if ($f['type'] == 'checkbox') {
                        if (!is_null($_POST[$field])) {
                            $data[$field] = implode(",", $_POST[$field]);
                        }
                    }
                    // if post is date						
                    if ($f['type'] == 'date') {
                        $data[$field] = date("Y-m-d", strtotime($request->input($field)));
                    }

                    // if post is seelct multiple						
                    if ($f['type'] == 'select') {
                        //echo '<pre>'; print_r( $_POST[$field] ); echo '</pre>'; 
                        if (isset($f['option']['select_multiple']) && $f['option']['select_multiple'] == 1) {
                            $multival = (is_array($_POST[$field]) ? implode(",", $_POST[$field]) : $_POST[$field]);
                            $data[$field] = $multival;
                        } else {
                            $data[$field] = $_POST[$field];
                        }
                    }
                }
            }
        }
        $global = (isset($this->access['is_global']) ? $this->access['is_global'] : 0 );

        if ($global == 0)
            $data['entry_by'] = \Session::get('uid');

        return $data;
    }

    function postFilter(Request $request) {
        $module = $this->module;
        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : '');
        $order = (!is_null($request->input('order')) ? $request->input('order') : '');
        $rows = (!is_null($request->input('rows')) ? $request->input('rows') : '');
        $md = (!is_null($request->input('md')) ? $request->input('md') : '');
        $trash = (!is_null($request->input('check_trash')) ? '/trashed' : '');

        $filter = '';
        if ($trash != '')
            $filter .= $trash;
        $filter .= '?';
        if ($sort != '')
            $filter .= '&sort=' . $sort;
        if ($order != '')
            $filter .= '&order=' . $order;
        if ($rows != '')
            $filter .= '&rows=' . $rows;
        if ($md != '')
            $filter .= '&md=' . $md;



        return Redirect::to($this->data['pageModule'] . $filter);
    }

    function injectPaginate() {

        $sort = (isset($_GET['sort']) ? $_GET['sort'] : '');
        $order = (isset($_GET['order']) ? $_GET['order'] : '');
        $rows = (isset($_GET['rows']) ? $_GET['rows'] : '');
        $search = (isset($_GET['search']) ? $_GET['search'] : '');

        $appends = array();
        if ($sort != '')
            $appends['sort'] = $sort;
        if ($order != '')
            $appends['order'] = $order;
        if ($rows != '')
            $appends['rows'] = $rows;
        if ($search != '')
            $appends['search'] = $search;

        return $appends;
    }

    function returnUrl() {
        $pages = (isset($_GET['page']) ? $_GET['page'] : '');
        $sort = (isset($_GET['sort']) ? $_GET['sort'] : '');
        $order = (isset($_GET['order']) ? $_GET['order'] : '');
        $rows = (isset($_GET['rows']) ? $_GET['rows'] : '');
        $search = (isset($_GET['search']) ? $_GET['search'] : '');

        $appends = array();
        if ($pages != '')
            $appends['page'] = $pages;
        if ($sort != '')
            $appends['sort'] = $sort;
        if ($order != '')
            $appends['order'] = $order;
        if ($rows != '')
            $appends['rows'] = $rows;
        if ($search != '')
            $appends['search'] = $search;

        $url = "";
        foreach ($appends as $key => $val) {
            $url .= "&$key=$val";
        }
        return $url;
    }

    public function getRemovecurrentfiles(Request $request) {
        $id = $request->input('id');
        $field = $request->input('field');
        $file = $request->input('file');
        if (file_exists('./' . $file) && $file != '') {
            if (unlink('.' . $file)) {
                \DB::table($this->info['table'])->where($this->info['key'], $id)->update(array($field => ''));
            }
            return Response::json(array('status' => 'success'));
        } else {
            return Response::json(array('status' => 'error'));
        }
    }

    function getDownload_old(Request $request) {

        if ($this->access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $info = $this->model->makeInfo($this->module);
        //===================== Take param master detail if any==================================//
        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query 
        // Filter Search for query
        //  echo $request->input('search') ; die;
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');


        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getRows($params);
        $fields = $info['config']['grid'];
        $rows = $results['rows'];

        $content = $this->data['pageTitle'];
        $content .= '<table border="1">';
        $content .= '<tr>';
        foreach ($fields as $f) {
            if ($f['download'] == '1') {
                if ($f['view'] == '1') {
                    $content .= '<th style="background:#f9f9f9;">' . $f['label'] . '</th>';
                }
            }
        }
        $content .= '</tr>';

        foreach ($rows as $row) {
            $content .= '<tr>';
            foreach ($fields as $f) {
                if ($f['download'] == '1'):
                    if ($f['view'] == '1'):


                        if ($f['field'] == 'type' AND $row->$f['field'] == 1) {
                            $content .= '<td>' . \Lang::get('core.check in') . '</td>';
                        } elseif ($f['field'] == 'type' AND $row->$f['field'] == 2) {
                            $content .= '<td>' . \Lang::get('core.check out') . '</td>';
                        } else {
                            $conn = (isset($f['conn']) ? $f['conn'] : array() );
                            $content .= '<td>' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';
                        }


                    endif;
                endif;
            }
            $content .= '</tr>';
        }
        $content .= '</table>';

        @header('Content-Type: application/ms-excel');
        @header('Content-Length: ' . strlen($content));
        @header('Content-disposition: inline; filename="' . $title . ' ' . date("d/m/Y") . '.xls"');

        echo $content;
        exit;
    }

    function getDownloadchunck(Request $request) {

        $doc = new \PHPExcel();

        // Get the default active first sheet
        $sheet = $doc->getActiveSheet();


        $sheet->setTitle('Users');

        // Add headings

        $sheet->getCell('A1')->setValue('phone');
        $sheet->getCell('B1')->setValue('Status');
        $sheet->getCell('C1')->setValue('Date');

        // Start at row 2
        $rowPointer = 2;

        // Get all users  باقة العفاسي الدينية 
        $userQuery = Subscribers::where('ServiceName', 'like', '%باقة العفاسي الدينية%')->where('NewStatus', '=', 0);
        // print_r($userQuery); die;


        $totalRecords = $userQuery->count();

        $userQuery->chunk(100, function($users) use($sheet, &$rowPointer, $totalRecords) {
            // Iterate over users
            foreach ($users as $index => $user) {
                //   $this->report("Writing User to row " . $rowPointer . "/" . $totalRecords);
                $this->writeUserToSheet($rowPointer, $user, $sheet);


                // Move on to the next row
                $rowPointer++;
            }
        });



        $objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');



// We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
        header('Content-Disposition: attachment; filename="file.xls"');
// Write file to the browser
        $objWriter->save('php://output');
    }

    function writeUserToSheet($index, $user, $sheet) {

        $sheet->setCellValue('A' . $index, substr($user->phone, 1));  // to remove heading 2
        $sheet->setCellValue('B' . $index, ($user->NewStatus) == 0 ? "active" : "not active");
        $sheet->setCellValue('C' . $index, $user->created_at);

        // etc
    }

    function getDownloadchunck2(Request $request) {
         set_time_limit(0);
        // ini_set('max_execution_time', 9999999999999999999999999999999999999);
      //    ini_set('memory_limit', -1);

        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
        // echo   $filter ; die;

        $doc = new \PHPExcel();
        // Get the default active first sheet
        $sheet = $doc->getActiveSheet();

        $sheet->setTitle('Users');

        // Add headings
        //  $sheet->getCell('A1')->setValueExplicit('ID');
        $sheet->getCell('A1')->setValue('phone');
        $sheet->getCell('B1')->setValue('Status');
        $sheet->getCell('C1')->setValue('Date');

        // Start at row 2
        $rowPointer = 2;
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');  // AND tb_susbcribers.ServiceName REGEXP 'باقة العفاسي الدينية' 
        // laravel chunk query
        // https://stackoverflow.com/questions/28691898/how-to-chunk-results-from-a-custom-query-with-laravel-5

        $sqlCount = "SELECT count(*) as total  FROM tb_susbcribers WHERE 1 = 1  " . $filter;
        $resultCount = \DB::connection('mysql')->select($sqlCount);
        $total = $resultCount[0]->total;

        for ($i = 0; $i <= $total; $i +=10000) {
            
             $objWorkSheet = $doc->createSheet($rowPointer-1); //Setting index when creating
            // Rename sheet
              $objWorkSheet->setTitle("$rowPointer-1");
              
             

            $sql = "SELECT phone , NewStatus , created_at  FROM tb_susbcribers WHERE 1 = 1  " . $filter . " LIMIT  " . $i . " , 10000";
            // echo $sql ; echo "<hr>" ;


            $result = \DB::connection('mysql')->select($sql);
            foreach ($result as $user) {
                // a bunch of code...
                $this->writeUserToSheet2($rowPointer, $user, $objWorkSheet);
                $rowPointer++;
            }
               
        }


           $objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
           
           


// We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
        header('Content-Disposition: attachment; filename="file.xls"');
// Write file to the browser
        $objWriter->save('php://output');
    }

    function writeUserToSheet2($index, $user, $sheet) {
        //  $sheet->setCellValue('A' . $index, $user->id);
        $sheet->setCellValue('A' . $index, substr($user->phone, 1));  // to remove heading 2
        $sheet->setCellValue('B' . $index, ($user->NewStatus) == 0 ? "active" : "not active");
        $sheet->setCellValue('C' . $index, $user->created_at);
        // etc
    }

    function getDownloadchunck3(Request $request) {
        
        
 // Get all users  باقة العفاسي الدينية 
        $userQuery = Subscribers::where('ServiceName', 'like', '%باقة العفاسي الدينية%')->where('NewStatus', '=', 0)->get();
        // print_r($userQuery); die;
        $totalRecords = $userQuery->count();
        $resArr = $userQuery->toArray();
    //    print_r($resArr); die;

        $writer = WriterFactory::create(Type::CSV); 

        $filePath = public_path() . "/test.csv";
        $writer->openToFile($filePath);

        /*
         *    [id] => 14
            [MSISDN] => 123
            [phone] => 012254524
            [TSTAMP] => 20150311120215
            [Price] => 123
            [NextRenwal] => 20150113151130
            [ServiceID] => 210000001
            [ServiceName] => باقة العفاسي الدينية 
            [PreviousStatus] => 1
            [NewStatus] => 0
            [Channel] => channelID123
            [entry_by] => 1
            [created_at] => 2017-05-19 23:13:56
            [updated_at] => 2017-05-27 00:09:39
        )
         */
        $singleRow = ['id', 'MSISDN' , 'phone', 'TSTAMP' , 'Price' ,'NextRenwal', 'ServiceID' , 'ServiceName', 'PreviousStatus' , 'NewStatus' , 'Channel', 'entry_by' , 'created_at', 'updated_at'  ]; // heading
        $writer->addRow($singleRow); // add a row at a time
        $writer->addRows($resArr); // add a row at a time

        $writer->close();
        
         return response()->download($filePath);
        
        
        
    }
    
    
    
    
      function getDownloadchunck4(Request $request) {
         set_time_limit(0);
        // ini_set('max_execution_time', 9999999999999999999999999999999999999);
      //    ini_set('memory_limit', -1);

        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
        // echo   $filter ; die;

        $doc = new \PHPExcel();
        // Get the default active first sheet
        $sheet = $doc->getActiveSheet();

        $sheet->setTitle('Users');

        // Add headings
        //  $sheet->getCell('A1')->setValueExplicit('ID');
        $sheet->getCell('A1')->setValue('phone');
        $sheet->getCell('B1')->setValue('Status');
        $sheet->getCell('C1')->setValue('Date');

        // Start at row 2
        $rowPointer = 2;
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');  // AND tb_susbcribers.ServiceName REGEXP 'باقة العفاسي الدينية' 
        // laravel chunk query
        // https://stackoverflow.com/questions/28691898/how-to-chunk-results-from-a-custom-query-with-laravel-5

        $sqlCount = "SELECT count(*) as total  FROM tb_susbcribers WHERE 1 = 1  " . $filter;
        $resultCount = \DB::connection('mysql')->select($sqlCount);
        $total = $resultCount[0]->total;

        for ($i = 0; $i <= $total; $i +=10000) {
            $count = $rowPointer-1 ;
             $objWorkSheet = $doc->createSheet($count); //Setting index when creating
            // Rename sheet
              $objWorkSheet->setTitle("$rowPointer-1");
              
              $objWorkSheet->getCell('A1')->setValue('phone');
             $objWorkSheet->getCell('B1')->setValue('Status');
             $objWorkSheet->getCell('C1')->setValue('Date');
              
             

            $sql = "SELECT phone , NewStatus , created_at  FROM tb_susbcribers WHERE 1 = 1  " . $filter . " LIMIT  " . $i . " , 10000";
            // echo $sql ; echo "<hr>" ;


            $result = \DB::connection('mysql')->select($sql);
            foreach ($result as $user) {
                // a bunch of code...
                $this->writeUserToSheet4($rowPointer, $user, $objWorkSheet);
                $rowPointer++;
            }
               
        }


           $objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
           
           


// We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
        header('Content-Disposition: attachment; filename="file.xls"');
// Write file to the browser
        $objWriter->save('php://output');
    }

    function writeUserToSheet4($index, $user, $sheet) {
        //  $sheet->setCellValue('A' . $index, $user->id);
        $sheet->setCellValue('A' . $index, substr($user->phone, 1));  // to remove heading 2
        $sheet->setCellValue('B' . $index, ($user->NewStatus) == 0 ? "active" : "not active");
        $sheet->setCellValue('C' . $index, $user->created_at);
        // etc
    }

    
    
    
    
    
    

    function getDownload(Request $request) {
        $today = date("Y-m-d");
        if ($this->access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');


        $info = $this->model->makeInfo($this->module);
        //===================== Take param master detail if any==================================//
        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query 
        // Filter Search for query
        //  echo $request->input('search') ; die;
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        //   echo $filter ; die;  // AND tb_susbcribers.ServiceName REGEXP 'باقة العفاسي الدينية'  AND tb_susbcribers.NewStatus REGEXP '0' 

        $page = "";  // to get all result as this   $page = $request->input('page', 1); get result from first page only 
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getRows($params);
        $fields = $info['config']['grid'];
        $rows = $results['rows'];
        $label_arr = array();

        $content = $this->data['pageTitle'];

        $arr2 = array();
        foreach ($rows as $row) {
            foreach ($fields as $f) {
                if ($f['download'] == '1') {
                    // if ($f['view'] == '1') {
                    // fix 0 , 1 for manager_approved to be read as No , Yes 
                    if ($f['field'] == 'manager_approved' && $row->$f['field'] === 1) {
                        $row->$f['field'] = 'Yes';
                    } elseif ($f['field'] == 'manager_approved' && $row->$f['field'] === 0) {
                        $row->$f['field'] = 'No';
                    }

                    $conn = (isset($f['conn']) ? $f['conn'] : array() );
                    $arr2[$f['label']] = \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn);
                    // }
                }
            }
            $arr3[] = $arr2;
        }

        // print_r($arr3); die ;
        \Excel::create($this->data['pageTitle'] . '-' . date("d/m/Y"), function($excel) use($arr3) {

            $excel->sheet('Sheetname', function($sheet) use($arr3) {

                $sheet->fromArray($arr3);
            });
        })->download('xlsx');
    }

    function getDownloadsample(Request $request) {

        /* $info = $this->model->makeInfo($this->module);

          $fields = $info['config']['grid'];

          $content = $this->data['pageTitle'];
          $content .= '<table border="1">';
          $content .= '<tr>';
          foreach ($fields as $f) {
          if ($f['download'] == '1')
          $content .= '<th style="background:#f9f9f9;">' . $f['label'] . '</th>';
          }
          $content .= '</tr>';


          @header('Content-Type: application/ms-excel');
          @header('Content-Length: ' . strlen($content));
          @header('Content-disposition: inline; filename="' . 'sample_payroll_sheet' . ' ' . date("d/m/Y") . '.xls"');

          echo $content;
          exit;
         */
        \Excel::create('sample_phone_book_sheet' . '-' . date("d/m/Y"), function ($excel) {
            $excel->sheet('phones', function ($sheet) {
                $info = $this->model->makeInfo($this->module);
                $fields = $info['config']['grid'];

                $arr = array();
                foreach ($fields as $f) {
                    if ($f['label'] != 'Id' AND $f['label'] != 'Entry By' AND $f['label'] != 'Phone Group' AND $f['label'] != 'Created At'
                            AND $f['label'] != 'Updated At' AND $f['label'] != 'First Name' AND $f['label'] != 'Last Name' AND $f['label'] != 'Phone Group Id') {
                        $arr[$f['label']] = $f['label'];
                    }
                }

                $sheet->setSize('A1', 25, 18);

                $sheet->row(1, $arr);
                $sheet->freezeFirstRow();
                $sheet->cell('A1', function ($cell) {
                    
                });
            });
        })->download('xlsx');
    }

    /*     * **   view html that will be printed in pdf   ***** */

    function getPdf(Request $request) {

        $today = date("Y-m-d");
        $ids_arr = array();
        \Session::put('id_arr', $ids_arr);
        if ($this->access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');


        $info = $this->model->makeInfo($this->module);
        //===================== Take param master detail if any==================================//
        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        // handle the report type by adding conditions 
        // handle the report type by adding conditions 
        if ($request->input('model_name') !== NULL) {
            if ($request->input('model_name') == "officedaily") {
                $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NULL   AND  tb_activities.job_id IS NULL   ";
            } elseif ($request->input('model_name') == "seadaily") {
                $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NOT NULL   AND  tb_activities.job_id IS NOT NULL   ";
            }
        }


        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getRows($params);
        $fields = $info['config']['grid'];
        $rows = $results['rows'];


        $config = \DB::table('tb_config')->where('cnf_id', 1)->first();
        $all = array();
        $all['company_name'] = $config->cnf_appname;
        $all['email'] = $config->cnf_email;
        $all['logo'] = $config->cnf_logo;
        // $all['title'] =$this->info['note'];
        $all['title'] = \Lang::get('core.' . $this->data['pageTitle']);
        //  echo   $all['title']  ; die ;
        $all['fields'] = $fields;
        return view('pdf')->with('all', $all)->with('rows', $rows);
    }

    /*     * **   print html to pdf that come from view pdf   ***** */

    function getPdf2(Request $request) {

        $today = date("Y-m-d");
        if ($this->access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $info = $this->model->makeInfo($this->module);
        //===================== Take param master detail if any==================================//
        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        // handle the report type by adding conditions 
        if ($request->input('model_name') !== NULL) {
            if ($request->input('model_name') == "officedaily") {
                $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NULL   AND  tb_activities.job_id IS NULL   ";
            } elseif ($request->input('model_name') == "seadaily") {
                $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NOT NULL   AND  tb_activities.job_id IS NOT NULL   ";
            }
        }


        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getRows($params);
        $fields = $info['config']['grid'];
        $rows = $results['rows'];


        $config = \DB::table('tb_config')->where('cnf_id', 1)->first();
        $all = array();
        $all['company_name'] = $config->cnf_appname;
        $all['email'] = $config->cnf_email;
        $all['logo'] = $config->cnf_logo;
        $all['title'] = $this->info['note'];
        $all['fields'] = $fields;


        $contents = \View::make('pdf_print')->with('all', $all)->with('rows', $rows);






        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($contents);
        $filename = 'report-' . $this->data['pageTitle'] . '-' . date("d/m/Y") . '.pdf';
        return $pdf->download($filename);
        exit;
    }

    function getMakepdf(Request $request) {
        $today = date("Y-m-d");
        if ($this->access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $info = $this->model->makeInfo($this->module);
        //===================== Take param master detail if any==================================//
        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        // handle the report type by adding conditions 
        if ($request->input('model_name') !== NULL) {
            if ($request->input('model_name') == "officedaily") {
                $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NULL   AND  tb_activities.job_id IS NULL   ";
            } elseif ($request->input('model_name') == "jobdaily") {
                $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NOT NULL   AND  tb_activities.job_id IS NOT NULL   ";
            } elseif ($request->input('model_name') == "absencedaysreport") {
                $filter .= " AND tb_activities.activity_status_id = 4 ";  // absence  = 4 in activity_status
            }
        }




        $page = "";
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getRows($params);
        $fields = $info['config']['grid'];
        $rows = $results['rows'];



        $config = \DB::table('tb_config')->where('cnf_id', 1)->first();
        $all = array();
        $all['company_name'] = $config->cnf_appname;
        $all['email'] = $config->cnf_email;
        $all['logo'] = $config->cnf_logo;
        $all['title'] = \Lang::get('core.' . $this->data['pageTitle']);
        $all['fields'] = $fields;

        $ids_arr = \Session::get('id_arr');
        $dir = "ltr";
        $textAlign = "";
        $alignTitle = "text-align: right";
        if (\Session::get('lang') == 'ar') {
            $dir = "rtl";
            $textAlign = "right";
            $alignTitle = "text-align: left";
        }


        //  $contents = \View::make('pdf_print')->with('all', $all)->with('rows', $rows);
        //  echo $contents ; die ;


        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf::SetTitle($all['title']);

        // set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = $dir;
        $lg['a_meta_language'] = 'ar';
        $lg['w_page'] = 'page';
        // set some language-dependent strings (optional)
        $pdf::setLanguageArray($lg);
        $pdf::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf::SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf::setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf::setFontSubsetting(true);
        $pdf::SetFont('freeserif', '', 12);
        $pdf::AddPage();
        $content = '';
        $content .= '<div>
            <div >
                <div >
                    <table >
                        <tr>
                            <td>
                                <table >
                                    <tr>
                                     <td  >
                                            <img src="sximo/images/' . $all['logo'] . '" width="70px" />  
                                        </td>
                                       
                                       
                                    </tr>
                                </table>

                            </td>
                        </tr>




                        <tr>
                            <td ><h2  style="text-align: center"> ' . $all['title'] . ' </h2></td>
                        </tr>

                        <tr>
                            <td>';




        $count = 0;

        $content .= ' <br><br><br><table  style="border-collapse: collapse" cellspacing="4" cellpadding="2"  >';
        $content .= '<tr><th   bgcolor="#f3f3f3"  style="text-align:center;"><b>' . \Lang::get('core.No') . '</b></th>';
        foreach ($all['fields'] as $f) {
            if ($f['download'] == '1') {
                if ($f['view'] == '1') {
                    $content .= '<th    bgcolor="#f3f3f3"  style="text-align:center;" ><b>' . \Lang::get('core.' . $f["label"]) . '</b></th>';
                }
            }
        }
        $content .= '</tr>';


        foreach ($rows as $row) {

            if ($count % 2 == 0) { // even
                $background = '#FFFFFF';
            } else {
                $background = '#F0F8FF';
            }
            $content .= '<tr   style="text-align:center;"   bgcolor="' . $background . '"><td>' . ($count + 1) . '</td>';
            foreach ($all['fields'] as $f) {
                if ($f['download'] == '1'):
                    if ($f['view'] == '1'):


                        $conn = (isset($f['conn']) ? $f['conn'] : array() );
                        $content .= '<td>' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';


                    endif;
                endif;
            }
            $content .= '</tr>';
            $count++;
        }


        $content .= '</table>';

        $content .= ' <table style="width:100%;padding: 40px;">
                                    <tr>
                             <td   style="text-align: left">
                                         ' . \Lang::get('core.Created by') . ' : ' . \Auth::user()->username . '
                                        </td>   
                                            <td   style="text-align: right">
                                          ' . \Lang::get('core.Report Date') . ' : ' . date("Y-m-d") . '
                                        </td> 

';

        $content .= ' </tr>
                                </table>


                            </td>
                        </tr>
                        
                    </table>

                </div>
            </div>
        </div>';

        $pdf::writeHTML($content, true, false, true, false, '');
        $pdf::lastPage();
        $filename = 'report-' . $this->info['note'] . '-' . date("d/m/Y") . '.pdf';
        $pdf::Output($filename);
    }

    function getMakepdfvacation(Request $request) {
        $today = date("Y-m-d");
        if ($this->access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $info = $this->model->makeInfo($this->module);
        //===================== Take param master detail if any==================================//
        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        // handle the report type by adding conditions 
        if ($request->input('id') !== NULL) {
            $currentId = $request->input('id');
            $filter .= "  AND  id = {$currentId}";
        }




        $page = "";
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getRows($params);
        $fields = $info['config']['grid'];
        $rows = $results['rows'];



        $config = \DB::table('tb_config')->where('cnf_id', 1)->first();
        $all = array();
        $all['company_name'] = $config->cnf_appname;
        //   $all['email'] = $config->cnf_email;
        $all['logo'] = $config->cnf_logo;
        $all['title'] = \Lang::get('core.' . $this->data['pageTitle']);
        $all['fields'] = $fields;

        $dir = "ltr";
        $textAlign = "";
        $alignTitle = "text-align: right";

        //  $contents = \View::make('pdf_print')->with('all', $all)->with('rows', $rows);
        //  echo $contents ; die ;


        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf::SetTitle($all['title']);

        // set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = $dir;
        $lg['a_meta_language'] = 'ar';
        $lg['w_page'] = 'page';
        // set some language-dependent strings (optional)
        $pdf::setLanguageArray($lg);
        $pdf::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf::SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf::setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf::setFontSubsetting(true);
        $pdf::SetFont('freeserif', '', 12);
        $pdf::AddPage();
        $content = '';
        $content .= '<div>
            <div >
                <div >
                    <table >
                    

                        <tr>
                            <td>
                                <table >
                                    <tr>
                                     <td style="text-align: right" >
                                            <img src="sximo/images/' . $all['logo'] . '" width="200px" />  
                                        </td>
                                    </tr>
                                    

                                </table>

                            </td>
                        </tr>




                        <tr>
                            <td ><h2  style="text-align: left"> ' . $all['title'] . ' From </h2></td>
                        </tr>

                        </table>';




        $count = 0;

        //   $content .= ' <br><br><br><table   style="width:100%;padding: 40px;"    style="border-collapse: collapse"  >';


        $content .= '<br><hr>';
        foreach ($rows as $row) {


            foreach ($all['fields'] as $f) {
                if ($f['field'] != 'id') {  // to remove id from print form view 
                    if ($f['download'] == '1') {
                        //  echo $row->$f['field'].'-------------'.$f['field'].'<br>' ;
                        if ($f['field'] == 'manager_approved' && $row->$f['field'] === 1) {
                            $row->$f['field'] = 'Yes';
                        } elseif ($f['field'] == 'manager_approved' && $row->$f['field'] === 0) {
                            $row->$f['field'] = 'No';
                        } elseif ($f['field'] == 'peroid') {
                            if ($row->$f['field'] == 1) {
                                $row->$f['field'] = $row->$f['field'] . ' Day';
                            } elseif ($row->$f['field'] > 1) {
                                $row->$f['field'] = $row->$f['field'] . ' Day(s)';
                            }
                        }

                        $conn = (isset($f['conn']) ? $f['conn'] : array() );
                        $content .= '<p  style="text-align: left"   ><b>' . \Lang::get('core.' . $f["label"]) . " : </b> " . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</p>';
                    }
                }
            }



            $content .= '</br>';
            $count++;
        }


        $content .= '<br><hr>';

        $content .= ' <table style="width:100%;padding: 40px;">
                                    <tr>
                             <td   style="text-align: left"><b>
                                         ' . \Lang::get('core.Created by') . ' : </b> ' . \Auth::user()->username . '
                                        </td>   
                                            <td   style="text-align: right"><b>
                                          ' . \Lang::get('core.Report Date') . ' : </b> ' . date("Y-m-d") . '
                                        </td> 

';

        $content .= ' </tr>
                                </table>


                           

                </div>
            </div>
        </div>';

        $pdf::writeHTML($content, true, false, true, false, '');
        $pdf::lastPage();
        $filename = 'report-' . $this->info['note'] . '-' . date("d/m/Y") . '.pdf';
        $pdf::Output($filename);
    }

    public function postDownloadsheet(Request $request) {
        $today = date("Y-m-d");
        $current_controller = "dashboard";
        if (\SiteHelpers::getCurrentController()) {
            $current_controller = \SiteHelpers::getCurrentController();
        }


        $ids_arr = array();
        \Session::put('id_arr', $ids_arr);
        $ids_arr = $request->input('id');
        // print_r($ids_arr); die ;
        if (!is_null($request->input('download'))) { //  selected download excel 
            if ($ids_arr) {
                \Session::put('id_arr', $ids_arr);
                if ($this->access['is_excel'] == 0)
                    return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');


                $info = $this->model->makeInfo($this->module);
                //===================== Take param master detail if any==================================//
                $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
                $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
                // End Filter sort and order for query 
                // Filter Search for query
                //  echo $request->input('search') ; die;
                $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
                // handle the report type by adding conditions 
                if ($request->input('model_name') !== NULL) {
                    if ($request->input('model_name') == "officedaily") {
                        $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NULL   AND  tb_activities.job_id IS NULL   ";
                    } elseif ($request->input('model_name') == "jobdaily") {
                        $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NOT NULL   AND  tb_activities.job_id IS NOT NULL   ";
                    } elseif ($request->input('model_name') == "absencedaysreport") {
                        $filter .= " AND tb_activities.activity_status_id = 4 ";  // absence  = 4 in activity_status
                    }
                }


                $page = "";
                $params = array(
                    'page' => $page,
                    'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
                    'sort' => $sort,
                    'order' => $order,
                    'params' => $filter,
                    'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
                );
                // Get Query 
                $results = $this->model->getRows($params);
                $fields = $info['config']['grid'];
                $rows = $results['rows'];
                $label_arr = array();

                $content = $this->info['note'];
                ;

                $arr2 = array();
                foreach ($rows as $row) {
                    if (in_array($row->id, $ids_arr)) {
                        foreach ($fields as $f) {
                            if ($f['download'] == '1') {
                                if ($f['view'] == '1') {
                                    $conn = (isset($f['conn']) ? $f['conn'] : array() );
                                    $arr2[$f['label']] = \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn);
                                }
                            }
                        }
                        $arr3[] = $arr2;
                    }
                }

                \Excel::create($this->data['pageTitle'] . '-' . date("d/m/Y"), function($excel) use($arr3) {

                    $excel->sheet('Sheetname', function($sheet) use($arr3) {

                        $sheet->fromArray($arr3);
                    });
                })->download('xlsx');
            } else {
                return Redirect::to($current_controller)->with('messagetext', 'No Items Selected')->with('msgstatus', 'error');
            }
        } elseif (!is_null($request->input('download_pdf'))) { // download as pdf the selected rows
            if ($ids_arr) {
                \Session::put('id_arr', $ids_arr);
                if ($this->access['is_excel'] == 0)
                    return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

                $info = $this->model->makeInfo($this->module);
                //===================== Take param master detail if any==================================//
                $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
                $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
                // End Filter sort and order for query 
                // Filter Search for query
                //  echo $request->input('search') ; die;
                $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
                // handle the report type by adding conditions 
                if ($request->input('model_name') !== NULL) {
                    if ($request->input('model_name') == "officedaily") {
                        $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NULL   AND  tb_activities.job_id IS NULL   ";
                    } elseif ($request->input('model_name') == "jobdaily") {
                        $filter .= " AND tb_activities.time REGEXP  '{$today}'  AND  tb_activities.project_id IS NOT NULL   AND  tb_activities.job_id IS NOT NULL   ";
                    } elseif ($request->input('model_name') == "absencedaysreport") {
                        $filter .= " AND tb_activities.activity_status_id = 4 ";  // absence  = 4 in activity_status
                    }
                }



                $page = $request->input('page', 1);
                $params = array(
                    'page' => $page,
                    'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
                    'sort' => $sort,
                    'order' => $order,
                    'params' => $filter,
                    'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
                );
                // Get Query 
                $results = $this->model->getRows($params);
                $fields = $info['config']['grid'];
                $rows = $results['rows'];


                $config = \DB::table('tb_config')->where('cnf_id', 1)->first();
                $all = array();
                $all['company_name'] = $config->cnf_appname;
                $all['email'] = $config->cnf_email;
                $all['logo'] = $config->cnf_logo;
                $all['title'] = \Lang::get('core.' . $this->data['pageTitle']);
                $all['fields'] = $fields;
                //  return view('pdf')->with('all', $all)->with('rows', $rows)->with('ids_arr', $ids_arr);
                $ids_arr = \Session::get('id_arr');

                $dir = "ltr";
                $textAlign = "";
                $alignTitle = "text-align: right";
                if (\Session::get('lang') == 'ar') {
                    $dir = "rtl";
                    $textAlign = "right";
                    $alignTitle = "text-align: left";
                }


                $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf::SetTitle($all['title']);

                // set some language dependent data:
                $lg = Array();
                $lg['a_meta_charset'] = 'UTF-8';
                $lg['a_meta_dir'] = $dir;
                $lg['a_meta_language'] = 'ar';
                $lg['w_page'] = 'page';
                // set some language-dependent strings (optional)
                $pdf::setLanguageArray($lg);
                $pdf::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf::SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);
                $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                $pdf::setImageScale(PDF_IMAGE_SCALE_RATIO);
                $pdf::setFontSubsetting(true);
                $pdf::SetFont('freeserif', '', 12);
                $pdf::AddPage();
                $content = '';
                $content .= '<div>
            <div >
                <div >
                    <table >
                        <tr>
                            <td>
                                <table >
                                    <tr>
                                     <td  >
                                            <img src="sximo/images/' . $all['logo'] . '" width="70px" />  
                                        </td>
                                        <td   style="' . $alignTitle . ' ">
                                            <p>  ' . \Lang::get('core.Company') . ':' . $all['company_name'] . ' </p>
                                            <p  >' . \Lang::get('core.Email') . ':' . $all['email'] . '</p>
                                        </td>
                                       
                                    </tr>
                                </table>

                            </td>
                        </tr>




                        <tr>
                            <td ><h2  style="text-align: center"> ' . $all['title'] . ' </h2></td>
                        </tr>

                        <tr>
                            <td>';




                $count = 0;

                $content .= ' <br><br><br><table  style="border-collapse: collapse" cellspacing="4" cellpadding="2"  >';
                $content .= '<tr><th   bgcolor="#f3f3f3"  style="text-align:center;"><b>' . \Lang::get('core.No') . '</b></th>';

                foreach ($all['fields'] as $f) {
                    if ($f['download'] == '1') {
                        if ($f['view'] == '1') {
                            $content .= '<th    bgcolor="#f3f3f3"  style="text-align:center;" ><b>' . \Lang::get('core.' . $f["label"]) . '</b></th>';
                        }
                    }
                }
                $content .= '</tr>';
                if ($ids_arr) {
                    foreach ($rows as $row) {
                        if (in_array($row->id, $ids_arr)) {
                            if ($count % 2 == 0) { // even
                                $background = '#FFFFFF';
                            } else {
                                $background = '#F0F8FF';
                            }
                            $content .= '<tr   style="text-align:center;"   bgcolor="' . $background . '"><td>' . ($count + 1) . '</td>';

                            foreach ($all['fields'] as $f) {
                                if ($f['download'] == '1'):
                                    if ($f['view'] == '1'):


                                        $conn = (isset($f['conn']) ? $f['conn'] : array() );
                                        $content .= '<td>' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';


                                    endif;
                                endif;
                            }
                            $content .= '</tr>';
                            $count++;
                        }
                    }
                }else {
                    foreach ($rows as $row) {
                        if ($count % 2 == 0) { // even
                            $background = '#FFFFFF';
                        } else {
                            $background = '#F0F8FF';
                        }
                        $content .= '<tr   style="text-align:center;"   bgcolor="' . $background . '">';

                        foreach ($all['fields'] as $f) {
                            if ($f['download'] == '1'):
                                if ($f['view'] == '1'):


                                    $conn = (isset($f['conn']) ? $f['conn'] : array() );
                                    $content .= '<td    >' . \SiteHelpers::gridDisplay($row->$f['field'], $f['field'], $conn) . '</td>';


                                endif;
                            endif;
                        }
                        $content .= '</tr>';
                        $count++;
                    }
                }

                $content .= '</table>';

                $content .= ' <table style="width:100%;padding: 40px;">
                                    <tr>
                             <td   style="text-align: left">
                                         ' . \Lang::get('core.Created by') . ':' . \Auth::user()->username . '
                                        </td>   
                                            <td   style="text-align: right">
                                          ' . \Lang::get('core.Report Date') . ':' . date("Y-m-d") . '
                                        </td> 

';

                $content .= ' </tr>
                                </table>


                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin: 0 14px;">
                                    <h4 style="margin-top: 40px;"> ' . \Lang::get('core.Manager Signature') . ' : </h4>
                                    <!-- <img src="sximo/images/signature.jpg" width="200px" style="margin-top: 10px;"/>  -->
                                </div>

                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>';

                $pdf::writeHTML($content, true, false, true, false, '');
                $pdf::lastPage();
                $filename = 'report-' . $this->info['note'] . '-' . date("d/m/Y") . '.pdf';
                $pdf::Output($filename);
            } else {
                return Redirect::to($current_controller)->with('messagetext', 'No Items Selected')->with('msgstatus', 'error');
            }
        } else { /// multi remove 
            // echo "remove"  ; die ;
            if ($this->access['is_remove'] == 0)
                return Redirect::to('dashboard')
                                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
            // delete multipe rows 

            $arr = $request->input('id');
            // print_r($arr) ;die ;
            if (count($request->input('id')) >= 1) {
                $this->model->destroy($request->input('id'));

                \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
                // redirect
                return Redirect::to(\URL::previous())
                                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
            } else {
                return Redirect::to(\URL::previous())
                                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
            }
        }
    }

    function detailview($model, $detail, $id) {

        $info = $model->makeInfo($detail['module']);
        $params = array(
            'params' => " And `" . $detail['key'] . "` ='" . $id . "'",
            'global' => 0
        );
        $results = $model->getRows($params);
        $data['rowData'] = $results['rows'];
        $data['tableGrid'] = $info['config']['grid'];
        $data['tableForm'] = $info['config']['forms'];

        return $data;
    }

    function detailviewsave($model, $request, $detail, $id) {

        \DB::table($detail['table'])->where($detail['key'], $request[$detail['key']])->delete();
        $info = $model->makeInfo($detail['module']);
        $str = $info['config']['forms'];
        $data = array($detail['master_key'] => $id);
        $total = count($request['counter']);
        for ($i = 0; $i < $total; $i++) {
            foreach ($str as $f) {
                $field = $f['field'];
                if ($f['view'] == 1) {
                    //echo 'bulk_'.$field[$i]; echo '<br />';
                    if (isset($request['bulk_' . $field][$i])) {
                        $data[$f['field']] = $request['bulk_' . $field][$i];
                    }
                }
            }

            \DB::table($detail['table'])->insert($data);
        }
    }

    function postPrint(Request $request) {
        $all = array();



        $employee_id = $request->input('employee_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $results = \DB::select(\DB::raw(" SELECT * , DATE(tb_activities.time) date ,GROUP_CONCAT(time SEPARATOR ',') time_diff FROM tb_activities WHERE employee_id = {$employee_id} AND ( DATE(tb_activities.time ) BETWEEN '{$start_date}' AND '{$end_date}')  GROUP BY DATE(tb_activities.time) "));

        $employee = \DB::table('tb_employees')->where('id', $employee_id)->first();
        $config = \DB::table('tb_config')->where('cnf_id', 1)->first();

        $all['employee_id'] = $employee_id;
        $all['employee_name'] = $employee->fname . $employee->lname;
        $all['start_date'] = $start_date;
        $all['end_date'] = $end_date;
        $all['company_name'] = $config->cnf_appname;
        $all['email'] = $config->cnf_email;
        $all['logo'] = $config->cnf_logo;
        $all['results'] = $results;
        $all['title'] = \Lang::get('core.Total Days hours Attendance report');


        /* old padf
          $contents = \View::make('activities.result_pdf')->with('all', $all);
          // echo $contents ; die ;
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($contents);
          $filename = 'Total Days/hours Attendance report- ' . date("d/m/Y") . '.pdf';
          return $pdf->download($filename);
          exit;
         */

        $dir = "ltr";

        if (\Session::get('lang') == 'ar') {
            $dir = "rtl";
        }


        $contents = \View::make('activities.result_pdf')->with('all', $all);

        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf::SetTitle($all['title']);

        // set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = $dir;
        $lg['a_meta_language'] = 'ar';
        $lg['w_page'] = 'page';
        // set some language-dependent strings (optional)
        $pdf::setLanguageArray($lg);
        $pdf::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf::SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf::setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf::setFontSubsetting(true);
        $pdf::SetFont('freeserif', '', 12);
        //  $pdf::SetFont('dejavusans', '', 10);
        $pdf::AddPage();


        $pdf::writeHTML($contents, true, false, true, false, '');
        $pdf::lastPage();
        $filename = 'report-' . $this->info['note'] . '-' . date("d/m/Y") . '.pdf';
        $pdf::Output($filename);
    }

    // Trashing Part Start//
    public function getTrashed(Request $request) {
        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query 
        // Filter Search for query		
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');


        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'table' => 'tb_' . $this->module,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getTrashed($params);

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
        $pagination->setPath('trashed');

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
        // paginator for trash page
        $this->data['check_trash'] = 1;
        // Master detail link if any 
        $this->data['subgrid'] = (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
        // Render into template
        return view('trashed', $this->data);
    }

    public function postDelete(Request $request) {
        $db_table = $this->info['table'];
        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows 
        if (count($request->input('id')) >= 1) {
            //$this->model->destroy($request->input('id'));
            foreach ($request->input('id') as $Id) {
                \DB::table($db_table)->where('id', '=', $Id)->update(array('trashed' => 1, 'deleted_at' => date("Y-m-d H:i:s")));
            }


            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to($this->module)
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to($this->module)
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    public function getRestore($id = null) {


        if ($id == '') {
            return Redirect::to('trashed')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        if ($this->access['is_remove'] == 0) {
            return Redirect::to('trashed')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }


        \DB::table('tb_' . $this->module)->where('id', '=', $id)->update(array('trashed' => 0, 'deleted_at' => null));


        return Redirect::to($this->module . '/trashed')
                        ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
    }

    public function postPermanentdelete(Request $request) {

        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows 
        if (count($request->input('id')) >= 1) {
            foreach ($request->input('id') as $Id) {
                \DB::table('tb_' . $this->module)->where('id', '=', $Id)->delete();
            }

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('trashed')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to($this->module . '/trashed')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    // Trashing Part end//
}
