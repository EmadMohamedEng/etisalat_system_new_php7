@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3><i class="fa fa-key"></i> {{ Lang::get('core.log') }}   <small> {{ Lang::get('core.view_all_logs') }} </small></h3>
      </div>

		  <ul class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
<!--			<li><a href="{{ URL::to('config') }}">{{ Lang::get('core.error_logs') }}   </a></li>-->
		  </ul>
		
		  
    </div>

	<div class="page-content-wrapper">  
	@if(Session::has('message'))
	  
		   {{ Session::get('message') }}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		
<div class="block-content">
	@include('sximo.config.tab')		
<div class="tab-content">
	  <div class="tab-pane active use-padding" id="info">	
	 {!! Form::open(array('url'=>'config/email/', 'class'=>'form-vertical row')) !!}
	
	<div class="col-sm-6">
	
		<fieldset > <legend> {{ Lang::get('core.session_cache_template') }}   </legend>
		  <div class="form-group">
			 		
		  </div>  
		
		  <div class="form-group">
			<label for="ipt" class=" control-label"> {{ Lang::get('core.template_cache') }}  </label>		
				
		  </div>  
		  
		<div class="form-group">   
			<a href="{{ URL::to('sximo/config/clearlog') }}" class="btn btn-primary" > {{ Lang::get('core.tab_clearcacheandlogs') }}</a>	 
		</div>
	
  	</fieldset>


	</div> 


 	
 </div>
 {!! Form::close() !!}
</div>
</div>
</div>
</div>







@endsection