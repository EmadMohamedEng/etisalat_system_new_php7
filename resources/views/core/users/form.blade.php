@extends('layouts.app')

@section('content')

<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
           <h3> {{ Lang::get('core.'.$pageTitle) }}   <small>{{ Lang::get('core.'.$pageTitle) }} </small></h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('core/users?return='.$return) }}">{{ Lang::get('core.'.$pageTitle) }}</a></li>
            <li class="active">{{ Lang::get('core.addedit') }} </li>
        </ul>

    </div>

    <div class="page-content-wrapper m-t">


        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> {{ Lang::get('core.'.$pageTitle) }} </h4></div>
            <div class="sbox-content"> 	
                <ul class="parsley-error-list">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>	

           
                {!! Form::open(array('url'=>'core/users/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                <div class="col-md-6">


                    <div class="form-group hidethis " style="display:none;">
                        <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                        <div class="col-md-6">
                            {!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 					
                    <div class="form-group  " >
                        <label for="Group / Level" class=" control-label col-md-4 text-left"> {{ Lang::get('core.Group') }}  <span class="asterix"> * </span></label>
                        <div class="col-md-6">

                            {!! Form::select('group_id', $groups, $row['group_id'], ['class'=>'select2']) !!}     

                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 



                    <div class="form-group  " >
                        <label for="Username" class=" control-label col-md-4 text-left">   {{ Lang::get('core.Username') }}  <span class="asterix"> * </span></label>
                        <div class="col-md-6">
                            {!! Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 					
                    <div class="form-group  " >
                        <label for="First Name" class=" control-label col-md-4 text-left">    {{ Lang::get('core.First Name') }} <span class="asterix"> * </span></label>
                        <div class="col-md-6">
                            {!! Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 					
                    <div class="form-group  " >
                        <label for="Last Name" class=" control-label col-md-4 text-left">  {{ Lang::get('core.Last Name') }}  </label>
                        <div class="col-md-6">
                            {!! Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 					
                    <div class="form-group  " >
                        <label for="Email" class=" control-label col-md-4 text-left">   {{ Lang::get('core.Email') }}  <span class="asterix"> * </span></label>
                        <div class="col-md-6">
                            {!! Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'email'   )) !!} 
                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 

                   




                    <div class="form-group  " >
                        <label for="Status" class=" control-label col-md-4 text-left"> {{ Lang::get('core.Status') }}  <span class="asterix"> * </span></label>
                        <div class="col-md-6">

                            <label class='radio radio-inline'>
                                <input type='radio' name='active' value ='0' required @if($row['active'] == '0') checked="checked" @endif > {{ Lang::get('core.Inactive') }}   </label>
                            <label class='radio radio-inline'>
                                <input type='radio' name='active' value ='1' required @if($row['active'] == '1') checked="checked" @endif >  {{ Lang::get('core.Active') }}  </label> 
                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 


                    <div class="form-group  " >
                        <label for="Avatar" class=" control-label col-md-4 text-left">   {{ Lang::get('core.Avatar') }} </label>
                        <div class="col-md-6">
                            <input  type='file' name='avatar' id='avatar' @if($row['avatar'] =='') class='required' @endif style='width:150px !important;'  />
                                    <div >
                                {!! SiteHelpers::showUploadedFile($row['avatar'],'/uploads/users/') !!}

                            </div>					

                        </div> 
                        <div class="col-md-2">

                        </div>
                    </div> 
                </div>



                <div class="col-md-6">	  

                    <div class="form-group">

                        <label for="ipt" class=" control-label col-md-4 text-left" > </label>
                        <div class="col-md-8">
                            @if($row['id'] !='')
                            {{ Lang::get('core.notepassword') }}
                            @else
                            Create Password
                            @endif	 
                        </div>
                    </div>	


                    <div class="form-group">
                        <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.newpassword') }} </label>
                        <div class="col-md-8">
                            <input name="password" type="password" id="password" class="form-control input-sm" value=""
                                   @if($row['id'] =='')
                                   required
                                   @endif
                                   /> 
                        </div> 
                    </div>  

                    <div class="form-group">
                        <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.conewpassword') }} </label>
                        <div class="col-md-8">
                            <input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value=""
                                   @if($row['id'] =='')
                                   required
                                   @endif		
                                   />  
                        </div> 
                    </div>  				  



                </div>			


                <div style="clear:both"></div>	


                <div class="form-group">
                    <label class="col-sm-6 col-lg-6  col-md-6 text-right">&nbsp;</label>
                    <div class="col-sm-6 col-lg-6  col-md-6">	
<!--                        <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>-->
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
                        <button type="button" onclick="location.href ='{{ URL::to('core/users?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
                    </div>	  

                </div> 

                {!! Form::close() !!}


                <!-- reset by sending email
                   <div   class="rest_user_password" >
                   
                     <div class="form-group" >
                      
                       <div class="col-md-6">
                           <form method="post" action="{{ url('user/request')}}" class="" id="fr">
                               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                               <div class="form-group has-feedback">
                                   <div class="">
                                       <input type="hidden" name="credit_email" placeholder="{{ Lang::get('core.email') }}" class="form-control"  value="{{$row['email']}}" required autocomplete="off"/>
                                       <i class="icon-envelope form-control-feedback"></i>
                                   </div> 	
                               </div>

                               <div class="form-group" >
                                   <div class="col-md-6">        
                                       <button type="submit" class="btn btn-info btn-sm"  > {{ Lang::get('core.restPasswordBySendMail') }} </button>        
                                   </div>
                               </div>


                               <div class="clr"></div>
                           </form>

                       </div> 
                       <div class="col-md-2">

                       </div>
                   </div> 
               </div>	
                -->


            </div>
        </div>		 
    </div>	
</div>			 
<script type="text/javascript">
    $(document).ready(function () {

        $("#group_id").jCombo("{{ URL::to('core/users/comboselect?filter=tb_groups:group_id:name') }}",
                {selected_value: '{{ $row["group_id"] }}'});

    });
</script>		 
@stop