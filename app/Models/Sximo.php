<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sximo extends Model
{

    public static function getRows($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_by ='" . \Session::get('uid') . "'";
        }

        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }
    public static function getTrashed($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . "WHERE {$table}.trashed = 1" . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . " WHERE {$table}.trashed = 1 " . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }
    public static function getRows2($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_by ='" . \Session::get('uid') . "'";
        }

        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

    public static function getRows3($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$table}.status {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.notified_id ='" . \Session::get('uid') . "'";
        }

        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

    public static function getRows4($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        $params .= " AND {$table}.parent =0";
        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

    public static function getRows5($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'employee_id' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($employee_id != '') {
            $employee = explode(":", $employee_id);
            if ($employee[0] == 'employees_ids' && $employee[1] != '') {
                $params = "AND {$table}.employees_ids =" . $employee[1] . " OR {$table}.employees_ids LIKE '" . $employee[1] . ",%' OR {$table}.employees_ids LIKE '%," . $employee[1] . ",%' OR {$table}.employees_ids LIKE '%," . $employee[1] . "'";
            }
        }
        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

    public static function getRows6($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'employee_id' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;

        if ($employee_id != '') {
            $employee = explode(":", $employee_id);
            //    echo $employee[0] .'  '.$employee[1];
            //    die;
            if ($employee[0] == 'no_employees' && $employee[1] != '') {
                $params = "AND {$table}.no_employees =" . $employee[1] . " OR {$table}.no_employees LIKE '" . $employee[1] . ",%' OR {$table}.no_employees LIKE '%," . $employee[1] . ",%' OR {$table}.no_employees LIKE '%," . $employee[1] . "'";
            }

        }

        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);
    }

    public static function getRow($id)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        $result = \DB::select(
            self::querySelect() .
            self::queryWhere() .
            " AND " . $table . "." . $key . " = '{$id}' " .
            self::queryGroup()
        );
        if (count($result) <= 0) {
            $result = array();
        } else {

            $result = $result[0];
        }
        return $result;
    }

    public function insertRow($data, $id)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;
        date_default_timezone_set("Africa/Cairo");
        if ($id == null) {

            // Insert Here
            if (isset($data['createdOn'])) {
                $data['createdOn'] = date("Y-m-d H:i:s");
            }

            if (isset($data['updatedOn'])) {
                $data['updatedOn'] = date("Y-m-d H:i:s");
            }

            $id = \DB::table($table)->insertGetId($data);

        } else {
            // Update here
            // update created field if any
            if (isset($data['createdOn'])) {
                unset($data['createdOn']);
            }

            if (isset($data['updatedOn'])) {
                $data['updatedOn'] = date("Y-m-d H:i:s");
            }

            \DB::table($table)->where($key, $id)->update($data);
        }
        return $id;
    }

    public function insertRow2($data, $id)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;
        date_default_timezone_set("Africa/Cairo");
        if ($id == null) {

            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['entry_by'] = \Session::get('uid');
            $id = \DB::table($table)->insertGetId($data);

        } else {

            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['entry_by'] = \Session::get('uid');
            \DB::table($table)->where($key, $id)->update($data);
        }
        return $id;
    }

    public function insertRow3($data, $id)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;
        date_default_timezone_set("Africa/Cairo");
        if ($id == null) {

            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            $id = \DB::table($table)->insertGetId($data);

        } else {

            $data['updated_at'] = date("Y-m-d H:i:s");
            \DB::table($table)->where($key, $id)->update($data);
        }
        return $id;
    }

    public function updateVacation($data, $id)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;
        date_default_timezone_set("Africa/Cairo");
        if ($id == null) {

            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            $id = \DB::table($table)->insertGetId($data);

        } else {

            $data['updated_at'] = date("Y-m-d H:i:s");
            \DB::table($table)->where($key, $id)->update($data);
        }
        return $id;
    }

    public function updateModel($data, $id)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;
        date_default_timezone_set("Africa/Cairo");
        if ($id == null) {

            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            $id = \DB::table($table)->insertGetId($data);

        } else {

            $data['updated_at'] = date("Y-m-d H:i:s");
            \DB::table($table)->where($key, $id)->update($data);
        }
        return $id;
    }

    public static function makeInfo($id)
    {
        $row = \DB::table('tb_module')->where('module_name', $id)->get();
        $data = array();
        foreach ($row as $r) {
            $data['id'] = $r->module_id;
            $data['title'] = $r->module_title;
            $data['note'] = $r->module_note;
            $data['table'] = $r->module_db;
            $data['key'] = $r->module_db_key;
            $data['config'] = \SiteHelpers::CF_decode_json($r->module_config);
            $field = array();
            foreach ($data['config']['grid'] as $fs) {
                foreach ($fs as $f) {
                    $field[] = $fs['field'];
                }

            }
            $data['field'] = $field;

        }
        return $data;

    }

    public static function postComboselect($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);

        if (count($limit) >= 3) {
            $table = $params[0];
            $condition = $limit[0] . " `" . $limit[1] . "` " . $limit[2] . " " . $limit[3] . " ";
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->get();
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition . " AND " . $parent[0] . " = '" . $parent[1] . "'");
            } else {
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition);
            }
        } else {

            $table = $params[0];
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->get();
            } else {
                $row = \DB::table($table)->get();
            }
        }

        return $row;
    }

    public static function postComboselecttrashed($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);

        if (count($limit) >= 3) {
            $table = $params[0];
            $condition = $limit[0] . " `" . $limit[1] . "` " . $limit[2] . " " . $limit[3] . " ";
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('trashed', '<>', '1')->get();
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition . " AND " . $parent[0] . " = '" . $parent[1] . "'")->where('trashed', '<>', '1');
            } else {
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition)->where('trashed', '<>', '1');
            }
        } else {

            $table = $params[0];
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('trashed', '<>', '1')->get();
            } else {
                $row = \DB::table($table)->where('trashed', '<>', '1')->get();
            }
        }

        return $row;
    }

    public static function postComboselect2($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);

        if (count($limit) >= 3) {
            $table = $params[0];
            $condition = $limit[0] . " `" . $limit[1] . "` " . $limit[2] . " " . $limit[3] . " ";
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('status', 1)->get();
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition . " AND " . $parent[0] . " = '" . $parent[1] . "'");
            } else {
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition);
            }
        } else {

            $table = $params[0];
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('status', 1)->get();
            } else {
                $row = \DB::table($table)->get();
            }
        }

        return $row;
    }

    public static function postComboselect3($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);

        $table = $params[0];
        if (count($parent) >= 2) {
            $row = \DB::table($table)->where($parent[0], $parent[1])->get();
        } else {
            $row = \DB::table($table)->join('tb_departments', 'tb_departments.id', '=', $table . '.department_id')->select('fname', 'lname', 'name', 'tb_employees.id as id')->get();
        }
        return $row;
    }

    public static function postComboselect4($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);

        if (count($limit) >= 3) {
            $table = $params[0];
            $condition = $limit[0] . " `" . $limit[1] . "` " . $limit[2] . " " . $limit[3] . " ";
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->get();
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition . " AND " . $parent[0] . " = '" . $parent[1] . "'");
            } else {
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition);
            }
        } else {

            $table = $params[0];
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('status', 1)->orWhere('status', 0)->get();
            } else {
                $row = \DB::table($table)->where('status', 1)->orWhere('status', 0)->get();
            }
        }

        return $row;
    }

    public static function postComboselect5($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);
        $current_employee = \DB::table('tb_employees')->where('user_id', \Auth::user()->id)->value('id');
        if (count($limit) >= 3) {
            $table = $params[0];
            $condition = $limit[0] . " `" . $limit[1] . "` " . $limit[2] . " " . $limit[3] . " ";
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('status', 1)->get();
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition . " AND " . $parent[0] . " = '" . $parent[1] . "'");
            } else {
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition);
            }
        } else {

            $table = $params[0];
            if (count($parent) >= 2) {
                $row = \DB::table($table)
                    ->join('tb_project_employees', 'tb_project_employees.job_id', '=', 'tb_project_jobs.id')
                    ->join('tb_departments', 'tb_project_employees.department_id', '=', 'tb_departments.id')
                    ->where($table . '.' . $parent[0], $parent[1])
                    ->where('status', 1)
                    ->where('tb_departments.manager', $current_employee)
                    ->select('tb_project_jobs.id', 'tb_project_jobs.name')
                    ->groupby('tb_project_employees.job_id')
                    ->get();
            } else {
                $row = \DB::table($table)->get();
            }
        }

        return $row;
    }

    public static function postComboselect6($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);

        if (count($limit) >= 3) {
            $table = $params[0];
            $condition = $limit[0] . " `" . $limit[1] . "` " . $limit[2] . " " . $limit[3] . " ";
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('user_id', '<>', \Auth::user()->id)->get();
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition . " AND " . $parent[0] . " = '" . $parent[1] . "'");
            } else {
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition);
            }
        } else {

            $table = $params[0];
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('user_id', '<>', \Auth::user()->id)->get();
            } else {
                $row = \DB::table($table)->get();
            }
        }

        return $row;
    }

    public static function postComboselect7($params, $limit = null, $parent = null)
    {
        $limit = explode(':', $limit);
        $parent = explode(':', $parent);

        if (count($limit) >= 3) {
            $table = $params[0];
            $condition = $limit[0] . " `" . $limit[1] . "` " . $limit[2] . " " . $limit[3] . " ";
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('access_inquiry', 1)->get();
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition . " AND " . $parent[0] . " = '" . $parent[1] . "'");
            } else {
                $row = \DB::select("SELECT * FROM " . $table . " " . $condition);
            }
        } else {

            $table = $params[0];
            if (count($parent) >= 2) {
                $row = \DB::table($table)->where($parent[0], $parent[1])->where('access_inquiry', 1)->get();
            } else {
                $row = \DB::table($table)->where('access_inquiry', 1)->get();
            }
        }

        return $row;
    }

    public static function getColoumnInfo($result)
    {
        $pdo = \DB::getPdo();
        $res = $pdo->query($result);
        $i = 0;
        $coll = array();
        while ($i < $res->columnCount()) {
            $info = $res->getColumnMeta($i);
            $coll[] = $info;
            $i++;
        }
        return $coll;

    }

    public function validAccess($id)
    {

        $row = \DB::table('tb_groups_access')->where('module_id', '=', $id)
            ->where('group_id', '=', \Session::get('gid'))
            ->get();

        if (count($row) >= 1) {
            $row = $row[0];
            if ($row->access_data != '') {
                $data = json_decode($row->access_data, true);
            } else {
                $data = array();
            }
            return $data;

        } else {
            return false;
        }

    }

    public static function getColumnTable($table)
    {
        $columns = array();
        foreach (\DB::select("SHOW COLUMNS FROM $table") as $column) {
            //print_r($column);
            $columns[$column->Field] = '';
        }

        return $columns;
    }

    public static function getTableList($db)
    {
        $t = array();
        $dbname = 'Tables_in_' . $db;
        foreach (\DB::select("SHOW TABLES FROM {$db}") as $table) {
            $t[$table->$dbname] = $table->$dbname;
        }
        return $t;
    }

    public static function getTableField($table)
    {
        $columns = array();
        foreach (\DB::select("SHOW COLUMNS FROM $table") as $column) {
            $columns[$column->Field] = $column->Field;
        }

        return $columns;
    }
    public static function getJobabsencerows($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        /********** Get Employees in Jobs  **********/
        $employees_in_jobs = \DB::select("SELECT tb_project_employees.employees_ids  as ids FROM tb_project_employees where CURDATE()  BETWEEN DATE(tb_project_employees.job_start_date )  AND DATE(tb_project_employees.job_end_date ) ");
        //    print_r($employees_in_jobs); die;
        $employees_in_job_string = $employees_logged_in_string = $absent_employees_string = '';
        foreach ($employees_in_jobs as $jobrow) {
            $employees_in_job_string .= $jobrow->ids . ',';
        }
        $employees_in_job_string = trim($employees_in_job_string, ',');

        $employees_logged_in = \DB::select("SELECT tb_activities.employee_id  as ids FROM tb_activities  JOIN tb_project_employees ON tb_activities.job_id= tb_project_employees.job_id  where  DATE(tb_activities.time) BETWEEN DATE(tb_project_employees.job_start_date) AND DATE(tb_project_employees.job_end_date)  AND (tb_activities.activity_status_id =1 OR tb_activities.activity_status_id =2 OR tb_activities.activity_status_id =3) Group by tb_activities.employee_id ");
        //    print_r($employees_logged_in); die;
        foreach ($employees_logged_in as $jobrow) {
            $employees_logged_in_string .= $jobrow->ids . ',';
        }
        $employees_logged_in_string = trim($employees_logged_in_string, ',');

        if (empty($employees_logged_in_string)) {$employees_logged_in_string = '0';}
        if (empty($employees_in_job_string)) {$employees_in_job_string = '0';}

        $absent_employees = \DB::select("SELECT id  FROM tb_employees where id IN (" . $employees_in_job_string . ")  AND id NOT IN (" . $employees_logged_in_string . ") ");

        foreach ($absent_employees as $absentrow) {
            $absent_employees_string .= $absentrow->id . ',';
        }
        $absent_employees_string = trim($absent_employees_string, ',');

        /********** Get Employees in Jobs  **********/

        if (empty($absent_employees_string)) {$absent_employees_string = '0';}

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        //$params .= " AND {$table}.id IN (".$absent_employees_string.")";
        // End Update permission global / own access new ver 1.1

        $rows = array();
        //    $result = \DB::select( self::querySelect() . self::queryWhere(). "     {$params} ". self::queryGroup() ." {$orderConditional}  {$limitConditional} ");
        $result = \DB::select("SELECT tb_employees.id, tb_employees.fname, tb_employees.lname, tb_project_jobs.name  as jobname FROM tb_employees  , tb_project_employees , tb_project_jobs Where tb_project_employees.job_id = tb_project_jobs.id AND tb_employees.id IN (" . $absent_employees_string . ") AND CURDATE() BETWEEN DATE(tb_project_employees.job_start_date) AND DATE(tb_project_employees.job_end_date)  GROUP BY tb_employees.id {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

    public static function getOfficeabsencerows($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        /********** Get Employees in Jobs  **********/
        $employees_in_jobs = \DB::select("SELECT tb_project_employees.employees_ids  as ids FROM tb_project_employees where CURDATE()  BETWEEN DATE(tb_project_employees.job_start_date )  AND DATE(tb_project_employees.job_end_date ) ");
        //    print_r($employees_in_jobs); die;
        $employees_in_job_string = $employees_logged_in_string = $absent_employees_string = '';
        foreach ($employees_in_jobs as $jobrow) {
            $employees_in_job_string .= $jobrow->ids . ',';
        }
        $employees_in_job_string = trim($employees_in_job_string, ',');

        $employees_logged_in = \DB::select("SELECT tb_activities.employee_id  as ids FROM tb_activities where  DATE(tb_activities.time) = CURDATE() ");
        foreach ($employees_logged_in as $jobrow) {
            $employees_logged_in_string .= $jobrow->ids . ',';
        }
        $employees_logged_in_string = trim($employees_logged_in_string, ',');

        if (empty($employees_logged_in_string)) {$employees_logged_in_string = '0';}
        if (empty($employees_in_job_string)) {$employees_in_job_string = '0';}

        $absent_employees = \DB::select("SELECT id  FROM tb_employees where id NOT IN (" . $employees_in_job_string . ")  AND id NOT IN (" . $employees_logged_in_string . ")");
        foreach ($absent_employees as $absentrow) {
            $absent_employees_string .= $absentrow->id . ',';
        }
        $absent_employees_string = trim($absent_employees_string, ',');
        /********** Get Employees in Jobs  **********/
        if (empty($absent_employees_string)) {$absent_employees_string = '0';}

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        $params .= " AND {$table}.id IN (" . $absent_employees_string . ")";
        // End Update permission global / own access new ver 1.1

        $rows = array();
        //    $result = \DB::select( self::querySelect() . self::queryWhere(). "     {$params} ". self::queryGroup() ." {$orderConditional}  {$limitConditional} ");
        $result = \DB::select("SELECT tb_employees.id, tb_employees.fname, tb_employees.lname  FROM tb_employees  WHERE tb_employees.id IN (" . $absent_employees_string . ") GROUP BY tb_employees.id {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

    public static function getAbsentdaysrows($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        $params .= " AND {$table}.activity_status_id =4 ";
        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

    public static function getLeavedaysrows($args)
    {
        $table = with(new static )->table;
        $key = with(new static )->primaryKey;

        extract(array_merge(array(
            'page' => '0',
            'limit' => '0',
            'sort' => '',
            'order' => '',
            'params' => '',
            'global' => 1,
        ), $args));

        $offset = ($page - 1) * $limit;
        $limitConditional = ($page != 0 && $limit != 0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort != '' && $order != '') ? " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static )->table;
        if ($global == 0) {
            $params .= " AND {$table}.entry_user ='" . \Session::get('uid') . "'";
        }

        //    $params .= " AND {$table}.status =1 ";
        // End Update permission global / own access new ver 1.1

        $rows = array();
        $result = \DB::select(self::querySelect() . self::queryWhere() . "
				{$params} " . self::queryGroup() . " {$orderConditional}  {$limitConditional} ");

        if ($key == '') {$key = '*';} else { $key = $table . "." . $key;}
        $counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM', self::querySelect());
        //echo     $counter_select; exit;
        $res = \DB::select($counter_select . self::queryWhere() . " {$params} " . self::queryGroup());
        $total = $res[0]->total;

        return $results = array('rows' => $result, 'total' => $total);

    }

}
