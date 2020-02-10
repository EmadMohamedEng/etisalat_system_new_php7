@extends('layouts.app')

@section('content')


  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3><i class="fa fa-lock"></i>  {{ Lang::get('core.t_loginsecurity') }} <small> {{ Lang::get('core.t_loginsecuritysmall') }} </small></h3>
      </div>

		  <ul class="breadcrumb">
		   <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
			<li><a href="{{ URL::to('config') }}">{{ Lang::get('core.t_loginsecurity') }}</a></li>
			
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
<div class="tab-content m-t">
	  <div class="tab-pane active use-padding row" id="info">	


 {!! Form::open(array('url'=>'sximo/config/login/', 'class'=>'form-horizontal')) !!}

	<div class="col-sm-6">
		<div class="sbox   animated fadeInRight"> 
			<div class="sbox-title"> {{ Lang::get('core.fr_registrationsetting') }} </div>
			<div class="sbox-content"> 	
  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_registrationdefault') }}  </label>	
			<div class="col-sm-8">
					<div >
						<label class="checkbox-inline">
						<select class="form-control" name="CNF_GROUP">
							@foreach($groups as $group)
							<option value="{{ $group->group_id }}"
							 @if(CNF_GROUP == $group->group_id ) selected @endif
							>{{ $group->name }}</option>
							@endforeach
						</select>
						</label>
					</div>				
			</div>	
					
		  </div> 

		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4">{{ Lang::get('core.fr_registration') }} </label>	
			<div class="col-sm-8">
					
					<label class="radio">
					<input type="radio" name="CNF_ACTIVATION" value="auto" @if(CNF_ACTIVATION =='auto') checked @endif /> 
					{{ Lang::get('core.fr_registrationauto') }}
					</label>
					
					<label class="radio">
					<input type="radio" name="CNF_ACTIVATION" value="manual" @if(CNF_ACTIVATION =='manual') checked @endif /> 
					{{ Lang::get('core.fr_registrationmanual') }}
					</label>								
					<label class="radio">
					<input type="radio" name="CNF_ACTIVATION" value="confirmation" @if(CNF_ACTIVATION =='confirmation') checked @endif/>
					{{ Lang::get('core.fr_registrationemail') }}
					</label>	
				
							
			</div>	
					
		  </div> 
		  
 		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_allowregistration') }} </label>	
			<div class="col-sm-8">
					<label class="checkbox">
					<input type="checkbox" name="CNF_REGIST" value="true"  @if(CNF_REGIST =='true') checked @endif/> 
					{{ Lang::get('core.fr_enable') }}
					</label>			
			</div>
		</div>	
		
 		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_allowfrontend') }} </label>	
			<div class="col-sm-8">
					<label class="checkbox">
					<input type="checkbox" name="CNF_FRONT" value="false" @if(CNF_FRONT =='true') checked @endif/> 
					{{ Lang::get('core.fr_enable') }}
					</label>			
			</div>
		</div>		
	
 		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.t_captcha') }} </label>	
			<div class="col-sm-8">
					<label class="checkbox">
					<input type="checkbox" name="CNF_RECAPTCHA" value="false" @if(CNF_RECAPTCHA =='true') checked @endif/> 
					{{ Lang::get('core.fr_enable') }}
					</label>	
										
			</div>
		</div>		
		
		  		  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
		<div class="col-md-8">
			<button class="btn btn-primary" type="submit"> {{ Lang::get('core.sb_savechanges') }}</button>
		 </div> 
	 
	  </div>	  
	</div>
	</div>
 </div>

	<div class="col-sm-6">
		<div class="sbox   animated fadeInRight"> 
			<div class="sbox-title">{{ Lang::get('core.t_blockedipaddress') }}</div>
			<div class="sbox-content "> 	
					<div class="form-vertical">
						<div class="form-group">
							<label> {{ Lang::get('core.t_restrictipaddress') }}</label>	
							
							<p><small><i>
								
								{{ Lang::get('core.t_writerestrictedipaddress') }}  <br />
								{{ Lang::get('core.t_example') }} : <code> 192.116.134 , 194.111.606.21 </code>
							</i></small></p>
							<textarea rows="5" class="form-control" name="CNF_RESTRICIP">{{ CNF_RESTRICIP }}</textarea>
						</div>
						
						<div class="form-group">
							<label> {{ Lang::get('core.t_allowedipaddress') }} </label>	
							<p><small><i>
								
								{{ Lang::get('core.t_example') }}  <br />
								{{ Lang::get('core.t_writeallowedipaddress') }} : <code> 192.116.134 , 194.111.606.21 </code>
							</i></small></p>							
							<textarea rows="5" class="form-control" name="CNF_ALLOWIP">{{ CNF_ALLOWIP }}</textarea>
						</div>

						<p> {{ Lang::get('core.t_ifallowedip') }} </p>
					</div>	
				
			</div>
		</div>
			


	 </div>
 {!! Form::close() !!}
</div>
</div>
</div>
</div>

@stop




