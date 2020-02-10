<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiries;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class InquiriesController extends Controller {

	//protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'inquiries';
	//static $per_page	= '10';

	public function __construct()
	{
		$this->model = new Inquiries();
		//$this->info = $this->model->makeInfo( $this->module);
		//$this->access = $this->model->validAccess($this->info['id']);
		
		
	}
	public function postDepartments(Request $request)
	{
		$data['status']='success';	
		$data['departments']=\DB::table('tb_departments')->where('access_inquiry', 1)->select('id','name')->get();
		return response()->json($data);
	}
	public function getEmployees(Request $request)
	{
		return view('api.employees');	
	}
	public function postEmployees(Request $request)
	{
		$current_user = \DB::table('tb_users')->where('mobile_token', $request->input('mobile_token'))->value('employee_id');
		$data['status']='success';	
		$data['employees']=\DB::table('tb_employees')->where('department_id','=',$request->input('id'))->where('id','!=',$current_user)->select('id','fname','lname')->get();
		return response()->json($data);
	}
	public function getInquiryCreate( )
	{
		return view('api.create');
	}
	public function postInquiryCreate(Request $request)
	{
		$rules = [
        'title' => 'required',
        'message' => 'required',
        'department_id' => 'required',
        'to' => 'required',
        
    		];
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
					///// Form Data /////////////
				$data['title']=$request->input('title');
				$data['message']=$request->input('message');
				$data['department_id']=$request->input('department_id');
				$data['to']=$request->input('to');
				$data['status']=1;
				$data['parent']=0;
				$data['entry_date']=new \DateTime();
				$data['from']= \DB::table('tb_users')->where('mobile_token', $request->input('mobile_token'))->value('employee_id');
					///// Form Data /////////////
			/****** From & To Names ******/
			$from_name=\DB::table('tb_employees')->where('id', $data['from'])->first();
			$data['emp_from'] = $from_name->fname.' '.$from_name->lname;
			$data['emp_to']='';
			if($data['to']==0)
			{
				$data['emp_to']='All';
			}
			else{
				$to_name=\DB::table('tb_employees')->where('id',$data['to'])->first();
				$data['emp_to'] = $to_name->fname.' '.$to_name->lname;
			}
			
			
			$id = $this->model->insertRow($data , $request->input('id'));
		
			$return = 'inquiries/reply/'.$id.'?return='.self::returnUrl();

			// Insert logs into database
			\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			
			 
			
			/***** Send Email Notification ****/
			$to='';
			$from_user= \DB::table('tb_users')
						->where('employee_id', $data['from'])
						->first();
			$to_department= \DB::table('tb_departments')->where('id', $data['department_id'])->value('email');
			$to_manager=\DB::table('tb_users')
							->join('tb_departments', 'tb_departments.manager', '=', 'tb_users.id')
							->where('tb_departments.id', $data['department_id'])
							->value('tb_users.email');
										
			if($data['to']!=0)
			{
				$to_user=\DB::table('tb_users')
								->where('employee_id', $data['to'])
								->first();
				$to =$to_user->email.',';
			}
			else {
				$to_users=\DB::table('tb_users')
						        ->join('tb_employees', 'tb_employees.user_id', '=', 'tb_users.id')
						        ->where('tb_employees.department_id', $data['department_id'])
						        ->where('tb_employees.id','<>',$data['from'])
						        ->select('tb_users.email')
						        ->get();
			/*	$to_users=\DB::table('tb_users')
								->join('tb_employees', 'tb_employees.user_id', '=', 'tb_users.id')
								->where('tb_employees.department_id', $data['department_id'])
								->where('tb_employees.user_id','<>','')
								->orwhere('tb_employees.user_id','<>',$data['from'])
								->select('tb_users.email')
								->get();*/
				foreach($to_users as $users_row)
				{
					$to.=$users_row->email .',';
				}
			}

			$to.=$to_department.','.$to_manager;
			
			$subject='New Inquiry '.$data['title'];
			$message='<!DOCTYPE html>
					<html lang="en-US">
						<head>
							<meta charset="utf-8">
						</head>
						<body>
							<h2>New Inquiry Message</h2>
					
							<div>
								'.$data['message'].'
							</div>
							<div><a href="'.asset('/').$return.'">Reply</a>
							</div>
						</body>
					</html>';
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$from_user->first_name.' '.$from_user->last_name.' <'.$from_user->email.'>' . "\r\n";
			mail($to, $subject, $message, $headers);
			
			
			// Add Notification
			$current_employee_id =$data['from'];
			$link='inquiries/reply/'.$id;
			if($data['to']!=0)
			{
				$to_employees=$data['to'];
				\SiteHelpers::addNotification($current_employee_id,$to_employees,$subject,$link);
			}
			else {		
				$to_employees=\DB::table('tb_employees')
				->where('department_id',$data['department_id'])
				->where('id','<>',$data['from'])
				->select('id')
				->get();
				foreach($to_employees as $employees_row)
				{
					\SiteHelpers::addNotification($current_employee_id,$employees_row->id,$subject,$link);
				}
				
			}		
			$data_response['status']="Success";
			return  response()->json($data_response);
			
		} else {
			
			$data_response['status']="Failed";
			$data_response['message']=$validator->errors()->first();
			return response()->json($data_response);
		}	
		
	}
	public function getInquiryReply()
	{
		return view('api.reply');
	}
	public function postInquiryReply(Request $request)
	{
		$rules = [
        'message' => 'required',
        'parent'=>'required'
    		];
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
				$inqury=\DB::table('tb_inquiries')->where('id', $request->input('parent'))->first();
			///// Form Data /////////////
				$data['message']=$request->input('message');
				$data['department_id']=$inqury->department_id;
				$data['status']=$inqury->status;
				$data['parent']=$request->input('parent');
				$data['entry_date']=new \DateTime();
				$data['from']= \DB::table('tb_users')->where('mobile_token', $request->input('mobile_token'))->value('employee_id');
						//from / to check //
						if($inqury->from == $data['from'])
						{$data['to']=$inqury->to;}
						else{$data['to']=$inqury->from;}
						///////////////////
					///// Form Data /////////////
			
			/****** From & To Names ******/
			$from_name=\DB::table('tb_employees')->where('id', $data['from'])->first();
			$data['emp_from'] = $from_name->fname.' '.$from_name->lname;
			$data['emp_to']='';
			if($data['to']==0)
			{
				$data['emp_to']='All';
			}
			else{
				$to_name=\DB::table('tb_employees')->where('id',$data['to'])->first();
				$data['emp_to'] = $to_name->fname.' '.$to_name->lname;
			}
			
			\DB::table('tb_inquiries')->insert($data);
			
			/***** Increment Reply Total *****/ 
			
			\DB::table('tb_inquiries')
					->where('id', $data['parent'])
					->increment('replay_count', 1);
			/***** Update Main Inquiry Status *****/ 		
			/*\DB::table('tb_inquiries')
					->where('id', $data['parent'])
					->update(['status' => $data['status']]);
			*/
			$id = $data['parent'];
			
			$return = 'inquiries/reply/'.$data['parent'].'?return='.self::returnUrl();			
			
			// Insert logs into database
				\SiteHelpers::auditTrail( $request , 'New Reply with ID '.$id.' Has been Inserted !');
			
			/***** Send Email Notification ****/
			$to='';
			$from_user= \DB::table('tb_users')
						->join('tb_employees', 'tb_employees.user_id', '=', 'tb_users.id')
						->where('tb_employees.id', $data['from'])
						->first();
			$to_department= \DB::table('tb_departments')->where('id', $data['department_id'])->value('email');
			$to_manager=\DB::table('tb_users')
							->join('tb_departments', 'tb_departments.manager', '=', 'tb_users.id')
							->where('tb_departments.id', $data['department_id'])
							->value('tb_users.email');
							
			if($data['to']!=0)
			{
				$to_user=\DB::table('tb_users')
								->join('tb_employees', 'tb_employees.user_id', '=', 'tb_users.id')
								->where('tb_employees.id', $data['to'])
								->first();
				$to =$to_user->email.',';
				
			}
			else {
				$to_users=\DB::table('tb_users')
						        ->join('tb_employees', 'tb_employees.user_id', '=', 'tb_users.id')
						        ->where('tb_employees.department_id', $data['department_id'])
						        ->where('tb_employees.id','<>',$data['from'])
						        ->select('tb_users.email')
						        ->get();
				/*$to_users=\DB::table('tb_users')
								->join('tb_employees', 'tb_employees.user_id', '=', 'tb_users.id')
								->where('tb_employees.department_id', $data['department_id'])
								->where('tb_employees.user_id','<>','')
								->orwhere('tb_employees.user_id','<>',$data['from'])
								->select('tb_users.email')
								->get();*/
				foreach($to_users as $users_row)
				{
					$to.=$users_row->email .',';
				}
			}

			$to.=$to_department.','.$to_manager;
			$inquiry_title=\DB::table('tb_inquiries')->where('id', $data['parent'])->value('title');
			$subject='New Reply To Inquiry: '.$inquiry_title;
			$message='<!DOCTYPE html>
					<html lang="en-US">
						<head>
							<meta charset="utf-8">
						</head>
						<body>
							<h2>New Inquiry Reply</h2>
					
							<div>
								'.$data['message'].'
							</div>
							<div><a href="'.asset('/').$return.'">Reply</a>
							</div>
						</body>
					</html>';
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$from_user->first_name.' '.$from_user->last_name.' <'.$from_user->email.'>' . "\r\n";
			mail($to, $subject, $message, $headers);
			
			
			// Add Notification
			$current_employee_id =$data['from'];
			$link='inquiries/reply/'.$id;
			if($data['to']!=0)
			{
				$to_employees=$data['to'];
				\SiteHelpers::addNotification($current_employee_id,$to_employees,$subject,$link);
			}
			else {		
				$to_employees=\DB::table('tb_employees')
				->where('department_id',$data['department_id'])
				->where('id','<>',$data['from'])
				->select('id')
				->get();
				foreach($to_employees as $employees_row)
				{
					\SiteHelpers::addNotification($current_employee_id,$employees_row->id,$subject,$link);
				}
				
			}			
			
			$data_response['status']="Success";
			return  response()->json($data_response);
			
		} else {
			
			$data_response['status']="Failed";
			$data_response['message']=$validator->errors()->first();
			return response()->json($data_response);
		}			
	}
	public function getInquiryView()
	{
		return view('api.inquiry');
	}
	public function postInquiryView(Request $request)
	{
		$id=$request->input('id');	
		$this->data['status']="success";
		$inquiry = \DB::table('tb_inquiries')
		->join ('tb_departments','tb_departments.id','=','tb_inquiries.department_id')
		->where(array('tb_inquiries.id'=>$id))
		->select('tb_inquiries.id','tb_inquiries.title','tb_inquiries.message','tb_inquiries.entry_date','tb_inquiries.from','tb_inquiries.emp_from','tb_inquiries.to','tb_inquiries.emp_to','tb_inquiries.id','tb_inquiries.status','tb_inquiries.parent','tb_inquiries.department_id','tb_departments.name','tb_inquiries.replay_count')
		->get();
		if($inquiry)
		{
			$this->data['inquiry'] =  $inquiry;
		} 
		
		
		$replies = \DB::table('tb_inquiries')->where(array('parent'=>$id))->get();
		if($replies)
		{
			$this->data['replies'] =  $replies;
		} 
		return response()->json($this->data);
	}
	public function getInquiriesList()
	{
		return view('api.inquiries');
	}
	public function postInquiriesList( Request $request )
	{
				
			$inquiries=\DB::table('tb_inquiries')
						->join ('tb_employees','tb_employees.id','=','tb_inquiries.from')
						->join ('tb_users','tb_employees.id','=','tb_users.employee_id')
					    ->where(array('mobile_token'=>$request->input('mobile_token'),'parent'=>0))
						->select('tb_inquiries.id','title','message','tb_inquiries.entry_date','from','emp_from','to','emp_to','status','parent','tb_inquiries.department_id','replay_count')
						->paginate(5);
			 $inquiries->setPath(url().'/inquiries');
		return response()->json($inquiries);
		
	}	
}