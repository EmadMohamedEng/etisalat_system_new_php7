@extends('layouts.app')


@section('content')

  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ Lang::get('core.tab_translation') }}   <small> {{ Lang::get('core.t_manage_translation') }}  </small></h3>
      </div>

		  <ul class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}"> {{ Lang::get('core.Dashboard') }}  </a></li>
			<li><a href="{{ URL::to('sximo/config') }}"> {{ Lang::get('core.setting') }}  </a></li>
			<li class="active"> {{ Lang::get('core.tab_translation') }}   </li>
		  </ul>
			  
	  
    </div>


	<div class="page-content-wrapper m-t">  	
	@include('sximo.config.tab',array('active'=>'translation'))
	 <div class="tab-pane active use-padding" id="info">	
<div class="tab-content m-t ">
		<div class="sbox   animated fadeInUp"> 
			<div class="sbox-title">{{ Lang::get('core.t_language_manager') }} </div>
			<div class="sbox-content"> 		 

	@if(Session::has('message'))
	  
		   {{ Session::get('message') }}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>	  
	  
	 {!! Form::open(array('url'=>'sximo/config/translation/', 'class'=>'form-vertical row')) !!}
	
	<div class="col-sm-9">
		
		<a href="{{ URL::to('sximo/config/addtranslation')}} " onclick="SximoModal(this.href,'Add New Language');return false;" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {{ Lang::get('core.t_add_translation') }}</a>  
		<hr />
		<table class="table table-striped">
			<thead>
				<tr>
					<th> {{ Lang::get('core.name') }} </th>
					<th> {{ Lang::get('core.folder') }} </th>
					<th> {{ Lang::get('core.author') }} </th>
					<th> {{ Lang::get('core.btn_action') }} </th>
				</tr>
			</thead>
			<tbody>		
		
			@foreach(SiteHelpers::langOption() as $lang)
				<tr>
					<td>  {{  $lang['name'] }}   </td>
					<td> {{  $lang['folder'] }} </td>
					<td> {{  $lang['author'] }} </td>
				  	<td>
					@if($lang['folder'] !='en')
					<a href="{{ URL::to('sximo/config/translation?edit='.$lang['folder'])}} " class="btn btn-sm btn-primary"> {{ Lang::get('core.btn_manage') }} </a>
					<a href="{{ URL::to('sximo/config/removetranslation/'.$lang['folder'])}} " class="btn btn-sm btn-danger"> {{ Lang::get('core.btn_delete') }} </a> 
					 
					@endif 
				
				</td>
				</tr>
			@endforeach
			
			</tbody>
		</table>
	</div> 
	</div>
	</div>



 	
 </div>
 {!! Form::close() !!}
</div>
</div>
</div>
</div>






@endsection