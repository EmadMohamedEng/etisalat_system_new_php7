@extends('layouts.app')

@section('content')
<style>
    .switch-animate span{
        display: none;
    }
    .switch-animate label{
       margin: 0;
    }
    </style>
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> Average Subscribe Days</h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>           
            <li class="active">Average Subscribe Days</li>
        </ul>

    </div>

    <div class="page-content-wrapper">

        <ul class="parsley-error-list">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <div class="sbox animated fadeInRight">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> Search </h4></div>
            <div class="sbox-content"> 	

                {!! Form::open(array('url'=>'subscribe_liftime/search','method'=>'post', 'class'=>'form-horizontal', 'parsley-validate'=>'','novalidate'=>' ','id'=>'search')) !!}
                <div class="col-md-12"> 
                    <div class="form-group  " >
                        <label class=" control-label col-md-4 text-left"> Service </label>
                        <div class="col-md-6">
                            <div class="input-group m-b" style="width:190px !important;">
                                <select class="form-control" name="ServiceName" required="">
                                    <option></option>
                                    @foreach($srvices as $value)
                                    <option value="{{$value->ServiceName}}">{{$value->ServiceName}}</option>
                                    @endforeach
                                </select>                              
                            </div>
                        </div>
                    </div> 
                    <div class="form-group " >
                        <label  class=" control-label col-md-4 text-left"> From  </label>
                        <div class="col-md-6">
                            <div class="input-group m-b" style="width:150px !important;">
                                {!! Form::text('start', '',array('class'=>'form-control date', 'style'=>'width:150px !important;','required'=>'true')) !!}
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div> 
                    </div> 
                    <div class="form-group  " >
                        <label  class=" control-label col-md-4 text-left"> To </label>
                        <div class="col-md-6">
                            <div class="input-group m-b" style="width:150px !important;">
                                {!! Form::text('end', '',array('class'=>'form-control date', 'style'=>'width:150px !important;','required'=>'true')) !!}
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div> 
                    </div> 
                </div> 
                <div style="clear:both"></div>	

                <div class="form-group">
                    <label class="col-sm-4 text-right">&nbsp;</label>
                    <div class="col-sm-8">	
                        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-search "></i> Search</button>
                    </div>	  

                </div> 

                {!! Form::close() !!}
            </div>
        </div>
        <div id="result"></div>
    </div>		 
</div>	
</div>			 
<script type="text/javascript">
    $(document).on('submit', '#search', function (e) {
        e.preventDefault();
        var url = "{{ url('subscribe_liftime/search/') }}";
        $.ajaxSetup({            headers: {        'csrftoken': '{{ csrf_token() }}'      }     });
        $.ajax({
            method: "get",
            url: url,
            data: $(this).serialize(),
            contentType: false,
            cache: false,
            processData: false,
            success: function (re) {
                $("#result").html(re.data);
            }
        });
    });



    $(document).on('click', '#pagenation a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            method: "get",
            url: url,
            contentType: false,
            cache: false,
            processData: false,
            success: function (re) {
                $("#result").html(re.data);
            }
        });
    });
    $('.date').datepicker({
        format: "dd/mm/yyyy",
    });
</script>		 
@stop