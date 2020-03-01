<?php namespace App\Http\Controllers\core;

use App\Http\Controllers\controller;
use App\Models\Core\Groups;
use App\Models\Core\Users;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input;
use Redirect;
use Validator;

class UsersController extends Controller
{

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'users';
    static $per_page = '10';

    public function __construct()
    {
        parent::__construct();
        // $this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Users();
        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });
        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'core/users',
            'return' => self::returnUrl(),

        );

        $lang = \Session::get('lang');
        \App::setLocale($lang);
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
        $filter = (!is_null($request->input('search')) ? '' : '');
        $filter .= " AND tb_users.group_id >= '" . \Session::get('gid') . "'";

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
        $pagination->setPath('users');

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
        return view('core.users.index', $this->data);
    }

    public function getUpdate(Request $request, $id = null)
    {

        $userId = \Auth::user()->id;
        if ($userId != 1) {
            $groups = Groups::where('group_id', '!=', '1')->pluck('name', 'group_id');
        } else {
            $groups = Groups::pluck('name', 'group_id');
        }

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
            $this->data['row'] = $this->model->getColumnTable('tb_users');
        }

        $this->data['id'] = $id;
        $this->data['groups'] = $groups;
        return view('core.users.form', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_users');
        }
        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('core.users.view', $this->data);
    }

    public function getResetLimit($id = null)
    {

        if ($this->access['is_detail'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        if ($id) {
            $sql = "UPDATE tb_users SET messages_send = 0   WHERE id ={$id} ";
            \DB::statement($sql);
        }
        return Redirect::back()->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');

    }

    public function postSave(Request $request, $id = 0)
    {

        // $rules = $this->validateForm();
        $rules = array();
        if ($request->input('id') == '') {
            $rules['password'] = 'required|between:6,25';
            $rules['password_confirmation'] = 'required|between:6,25';
            $rules['email'] = 'required|email|unique:tb_users';
            $rules['username'] = 'required|unique:tb_users';
            $rules['file'] = 'tb_users';

        } else {
            if ($request->input('password') != '') {
                $rules['password'] = 'required|between:6,25';
                $rules['password_confirmation'] = 'required|between:6,25';
            }
            $rules['username'] = 'required|unique:tb_users,username,' . $request->input('id');
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_users');

            if ($request->input('id') == '') {
                $data['password'] = \Hash::make(Input::get('password'));
            } else {
                if (Input::get('password') != '') {
                    $data['password'] = \Hash::make(Input::get('password'));
                }
            }

            $this->model->insertRow($data, $request->input('id'));
            if (!is_null($request->input('apply'))) {
                $return = 'core/users/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'core/users?return=' . self::returnUrl();
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');

        } else {

            return Redirect::to('core/users/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                ->withErrors($validator)->withInput();
        }

    }

    public function postResettoken(Request $request)
    {
        // echo "fffffffff" ; die;
        $data = array();
        $data['mobile_token'] = '';
        \DB::table('tb_users')->where('id', $request->input('id'))->update($data);
        return true;
    }

    public function getResettoken($id)
    {
        $this->data['user_id'] = $id;
        return view('core.users.resettoken', $this->data);
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

            // redirect
            return Redirect::to('core/users')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');

        } else {
            return Redirect::to('core/users')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }

    }

    public function getBlast()
    {
        $this->data = array(
            'groups' => Groups::all(),
            'pageTitle' => 'Blast Email',
            'pageNote' => 'Send email to users',
        );
        return view('core.users.blast', $this->data);
    }

    public function postDoblast(Request $request)
    {

        $rules = array(
            'subject' => 'required',
            'message' => 'required|min:10',
            'groups' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            if (!is_null($request->input('groups'))) {
                $groups = $request->input('groups');
                for ($i = 0; $i < count($groups); $i++) {
                    if ($request->input('uStatus') == 'all') {
                        $users = \DB::table('tb_users')->where('group_id', '=', $groups[$i])->get();
                    } else {
                        $users = \DB::table('tb_users')->where('active', '=', $request->input('uStatus'))->where('group_id', '=', $groups[$i])->get();
                    }
                    $count = 0;
                    foreach ($users as $row) {

                        $to = $row->email;
                        $subject = $request->input('subject');
                        $message = $request->input('message');
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: ' . CNF_APPNAME . ' <' . CNF_EMAIL . '>' . "\r\n";
                        mail($to, $subject, $message, $headers);

                        $count = ++$count;
                    }

                }
                return Redirect::to('core/users/blast')->with('messagetext', 'Total ' . $count . ' Message has been sent')->with('msgstatus', 'success');

            }
            return Redirect::to('core/users/blast')->with('messagetext', 'No Message has been sent')->with('msgstatus', 'info');

        } else {

            return Redirect::to('core/users/blast')->with('messagetext', 'The following errors occurred')->with('msgstatus', 'error')
                ->withErrors($validator)->withInput();

        }

    }

    // to reset all vacations for all employess = users
    public function resetVacations()
    {

        $users = Users::all();
        if ($users) {
            foreach ($users as $user) {
                $user->vacations_number_per_year = 0;
                $user->save();
            }
            return Redirect::to('core/users')->with('messagetext', 'All vacations for all employees has been reset successfully')->with('msgstatus', 'success');

        }

    }

}
