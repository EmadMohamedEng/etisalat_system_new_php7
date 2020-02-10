@extends('layouts.app')


@section('content')

<style>

    .sbox {
        // border: 1px solid #ddd;
        clear: both;
        margin-bottom: 25px;
        margin-top: 0;
        padding: 0;
    }
</style>

<div class="page-content row">
    <div class="page-header">
        <div class="page-title">
            <h3><i class="fa fa-desktop"></i>  {{ Lang::get('core.Dashboard') }}    
        </div>

    </div>
    <div class="page-content-wrapper">  


        @if(Auth::check() )

        <section>
            <div class="row m-l-none m-r-none m-t  white-bg shortcut " >

                @if(Auth::user()->group_id == 1)
                <div class="col-sm-6 col-md-3 b-r  p-sm">
                    <span class="pull-left m-r-sm ">	<i class="fa fa-users"></i></span>
                    <a href="{{ URL::to('core/users') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong> {{$total_user}} {{ Lang::get('core.Users') }}</strong>
                        </span> <small class="text-muted text-uc">  {{ Lang::get('core.registered_on_system') }} </small> </a>
                </div>

                @endif

              
            </div> 
        </section>	







    </div>
    @endif
</div>	

</div>





@stop