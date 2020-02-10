<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class NewsController extends Controller {

	//protected $layout = "layouts.main";
	//protected $data = array();	
	//public $module = 'news';
	//static $per_page	= '10';

	public function __construct()
	{
		
		
		
	}
	public function postNewView(Request $request)
	{
	
		/*if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');*/
					
		$new = \DB::table('tb_news')->where(array('publish'=>1,'id'=>$request->input('id')))->first();
		if($new)
		{
			$this->data['row'] =  $new;
		} else {
			//$this->data['row'] = $this->model->getColumnTable('tb_news'); 
		}
		
		$this->data['id'] = $request->input('id');
		//$this->data['access']		= $this->access;
		return view('news.view',$this->data);	
	}
	public function postNews( Request $request )
	{
			$url=url()."/uploads/news/";
			$news=\DB::table('tb_news')->select(\DB::raw('* , fnStripTags(description) AS desc_notags , "'.$url.'" AS image_url'))->join('tb_news_categories','tb_news_categories.id','=','tb_news.category_id')->where(array('publish'=>1,))->paginate(10);
			$news->setPath(url().'/news');
			//var_dump($news);die();*/
			//$news=\DB::select('select *,"'.$url.'" as url ,afnStripTags(description)as desc2 from tb_news ');//->paginate(10);;
			//var_dump($news);die();
			/*$news=\DB::table('tb_news')
					->where(array('publish'=>1,))
					->paginate(10);
			 $news->setPath(url().'/news');*/
		return response()->json($news);
		
	}	
}