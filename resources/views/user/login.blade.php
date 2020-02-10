@extends('layouts.login')

@section('content')

<div class="sbox ">
	<!--<div class="sbox-title">
			
				<h3 >{{ CNF_APPNAME }} <small> {{ CNF_APPDESC }} </small></h3>
				
	</div>-->
	<div class="sbox-content">
	<div class="text-center  animated fadeIn delayp1">
		@if(file_exists(public_path().'/sximo/images/'.CNF_LOGO) && CNF_LOGO !='')
                <img src="{{ asset('sximo/images/'.CNF_LOGO)}}" alt="{{ CNF_APPNAME }}"    style="opacity: 1.0;" />
		 	@else
			<img src="{{ asset('sximo/images/logo-sximo')}}" alt="{{ CNF_APPNAME }}" width="70" height="70"/>
			@endif
	</div>	
 
	    	@if(Session::has('message'))
				{!! Session::get('message') !!}
			@endif
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>		
		
	<ul class="nav nav-tabs" >
            <li class="active"><a href="#tab-sign-in" data-toggle="tab"   >  {{ Lang::get('core.signin') }} </a></li>
	   <li ><a href="#tab-forgot" data-toggle="tab"> {{ Lang::get('core.forgotpassword') }} </a></li>
	   @if(CNF_REGIST =='true') 			
	   <li><a href="{{ URL::TO('user/register')}}" >  {{ Lang::get('core.signup') }} </a></li>
	   @endif	
	 
	</ul>	
	<div class="tab-content" >
		<div class="tab-pane active m-t" id="tab-sign-in">
		<form method="post" action="{{ url('user/signin')}}" class="form-vertical">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		
			<div class="form-group has-feedback animated fadeIn delayp1">
				<!--<label>{{ Lang::get('core.username') }}	</label>-->
                                <input type="text" name="username" placeholder="{{ Lang::get('core.Username or Email') }}" class="form-control" required="username" autocomplete="off"  oninvalid="InvalidMsg(this);"  oninput="InvalidMsg(this);" />
				
				<i class="icon-users form-control-feedback"></i>
			</div>
			
			<div class="form-group has-feedback  animated fadeIn delayp1">
				<!--<label>{{ Lang::get('core.password') }}	</label>-->
				<input type="password" name="password" placeholder="{{ Lang::get('core.Password') }}" class="form-control" required="true"  oninvalid="InvalidMsg(this);"  oninput="InvalidMsg(this);" />
				
				<i class="icon-lock form-control-feedback"></i>
			</div>

                        <div class="form-group has-feedback  animated fadeIn delayp1"  style="direction: rtl">
				<label>{{ Lang::get('core.Remember Me') }}   	</label>
				<input type="checkbox" name="remember" value="1" />
				
				<!--<i class="icon-lock form-control-feedback"></i>-->
			</div>


			@if(CNF_RECAPTCHA =='true') 
			<div class="form-group has-feedback  animated fadeIn delayp1">
				<label class="text-left"> Are u human ? </label>	
				<br />
				{!! captcha_img() !!} <br /><br />
				<input type="text" name="captcha" placeholder="Type Security Code" class="form-control" required/>
				
				<div class="clr"></div>
			</div>	
		 	@endif	

			@if(CNF_MULTILANG =='1') 
			<div class="form-group has-feedback  animated fadeIn delayp1">
				<!--<label class="text-left"> {{ Lang::get('core.language') }} </label>-->
				<select class="form-control" name="language">
					@foreach(SiteHelpers::langOption() as $lang)
					<option value="{{ $lang['folder'] }}" @if(Session::get('lang') ==$lang['folder']) selected @endif>  {{ Lang::get('core.'.$lang['name']) }} </option>
					@endforeach

				</select>	
				
				<div class="clr"></div>
			</div>	
		 	@endif	




			<div class="form-group  has-feedback text-center  animated fadeIn delayp1" style=" margin-bottom:20px;" >
				 	 
                            <button type="submit" class="btn btn-info btn-sm btn-block"  style="background-color:  #0192AF !important ; border-color : #fff ;" ><i class="fa fa-sign-in"></i> {{ Lang::get('core.signin') }}</button>
				       

				
			 	<div class="clr"></div>
				
			</div>	
			{{-- <!--<div class="animated fadeIn delayp1">
		<div class="form-group has-feedback text-center">
			@if($socialize['google']['client_id'] !='' || $socialize['twitter']['client_id'] !='' || $socialize['facebook'] ['client_id'] !='') 
			<br />
			<p class="text-muted text-center"><b> {{ Lang::get('core.loginsocial') }} </b>	  </p>
			@endif
			<div style="padding:15px 0;">
				@if($socialize['facebook']['client_id'] !='') 
				<a href="{{ URL::to('user/socialize/facebook')}}" class="btn btn-primary"><i class="icon-facebook"></i> Facebook </a>
				@endif
				@if($socialize['google']['client_id'] !='') 
				<a href="{{ URL::to('user/socialize/google')}}" class="btn btn-danger"><i class="icon-google"></i> Google </a>
				@endif
				@if($socialize['twitter']['client_id'] !='') 
				<a href="{{ URL::to('user/socialize/twitter')}}" class="btn btn-info"><i class="icon-twitter"></i> Twitter </a>
				@endif
			</div>
		</div>			


			  <p style="padding:10px 0" class="text-center">
			  <a href="{{ URL::to('')}}"> {{ Lang::get('core.backtosite') }} </a>  
		   		</p>
		 </div>	--> --}}
		   </form>			
		</div>
	
	

	<div class="tab-pane  m-t" id="tab-forgot">	

		
		<form method="post" action="{{ url('user/request')}}" class="form-vertical box" id="fr">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		   <div class="form-group has-feedback">
		   <div class="">
				<label>{{ Lang::get('core.enteremailforgot') }}</label>
				<input type="text" name="credit_email" placeholder="{{ Lang::get('core.email') }}" class="form-control" required autocomplete="off"/>
				<i class="icon-envelope form-control-feedback"></i>
			</div> 	
			</div>
			<div class="form-group has-feedback">        
		      <button type="submit" class="btn btn-info pull-right" style="margin-bottom: 20px;background-color:  #0192AF !important ; border-color : #fff ;"> {{ Lang::get('core.sb_submit') }}  </button>        
		  </div>
		  
		  
		  <div class="clr"></div>

		  
		</form>

	
	</div>

            <div class="text-center" style="direction: rtl">
                <b>  {{ CNF_APPNAME }} </b>
                <br>
                <strong>{{ Lang::get('core.Copyright') }} </strong> © {{ date('Y')}}   
                <br>{{ Lang::get('core.designed_develop_by') }}   <strong><a href="http://ivas.mobi/" target="_blank" >IVAS </a></strong></div>
	</div>  

  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#or').click(function(){
		$('#fr').toggle();
		});
	});
</script>

<script>
function InvalidMsg(textbox) {
    
    if (textbox.value == '') {
        textbox.setCustomValidity("{{ Lang::get('core.field_is_required') }}");
    }
    else if(textbox.validity.typeMismatch){
        textbox.setCustomValidity('please enter a valid email address');
    }
    else {
        textbox.setCustomValidity('');
    }
    return true;
}
</script>

@stop