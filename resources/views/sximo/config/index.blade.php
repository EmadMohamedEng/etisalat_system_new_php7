@extends('layouts.app')


@section('content')

<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ Lang::get('core.configuration_settings') }} <small>{{ Lang::get('core.t_generalsettingsmall') }}</small></h3>
        </div>


        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
<!--            <li><a href="{{ URL::to('config') }}">{{ Lang::get('core.t_generalsetting') }}</a></li>-->
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
                <div class="tab-pane active use-padding" id="info">	
                    <div class="sbox  "> 
                        <div class="sbox-title"></div>
                        <div class="sbox-content"> 
                            {!! Form::open(array('url'=>'sximo/config/save/', 'class'=>'form-horizontal row', 'files' => true)) !!}

                            <div class="col-sm-6 animated fadeInRight ">
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appname') }} </label>
                                    <div class="col-md-8">
                                        <input name="cnf_appname" type="text" id="cnf_appname" class="form-control input-sm" required  value="{{ CNF_APPNAME }}" />  
                                    </div> 
                                </div>  

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appdesc') }} </label>
                                    <div class="col-md-8">
                                        <input name="cnf_appdesc" type="text" id="cnf_appdesc" class="form-control input-sm" value="{{ CNF_APPDESC }}" /> 
                                    </div> 
                                </div>  
                                

                                
                                @if(Auth::user()->id  == 1 )
                                 <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.cnf_show_builder_tool') }}  <br /> <small>  </small> </label>
                                    <div class="col-md-8">
                                        <div class="checkbox">
                                            <input name="cnf_show_builder_tool" type="checkbox"  value="1"
                                                   @if(CNF_BUILDER_TOOL ==1) checked @endif
                                                   />  
                                        </div>	
                                    </div> 
                                </div>
                                @endif
                                
                                

                        
                               
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.multilanguage') }}  </label>
                                    <div class="col-md-8">
                                        <div class="checkbox">
                                            <input name="cnf_multilang" type="checkbox" id="cnf_multilang" value="1"
                                                   @if(CNF_MULTILANG ==1) checked @endif
                                                   />  {{ Lang::get('core.fr_enable') }} 
                                        </div>	
                                    </div> 
                                </div>
                               


                            </div>



                            <div class="col-sm-6 animated fadeInRight ">

                            

                                <div class="form-group">
                                    <label  class=" control-label col-md-4">{{ Lang::get('core.backendlogo') }}  </label>
                                    <div class="col-md-8">
                                        <input type="file" name="logo">
                                        <p> <i>{{ Lang::get('core.logo_dimension') }}</i> </p>
                                        <div style="padding:5px; border:solid 1px #ddd; background:#f5f5f5; width:auto;">
                                            @if(file_exists(public_path().'/sximo/images/'.CNF_LOGO) && CNF_LOGO !='')
                                            <img src="{{ asset('sximo/images/'.CNF_LOGO)}}" alt="{{ CNF_APPNAME }}" />
                                            @else
                                            <img src="{{ asset('sximo/images/logo.png')}}" alt="{{ CNF_APPNAME }}" />
                                            @endif	
                                        </div>				
                                    </div> 
                                </div>  

                                <br>


                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
                                    <div class="col-md-8">
                                        <button class="btn btn-primary" type="submit">{{ Lang::get('core.sb_savechanges') }} </button>
                                    </div> 
                                </div> 


                            </div>  
                            {!! Form::close() !!}
                        </div>
                    </div>	 
                </div>
            </div>
        </div>
    </div>








    @stop