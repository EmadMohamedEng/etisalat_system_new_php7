<div class="row  ">
    <nav style="margin-bottom: 0;" role="navigation" class="navbar navbar-static-top nav-inside">
        <div class="navbar-header">
            <a href="javascript:void(0)" class="navbar-minimalize minimalize-btn btn btn-primary "><i class="fa fa-bars"></i> </a>

        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li>

            </li>





            <li class="user dropdown"  id="notify_result">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-exclamation-circle"></i><span>{{ Lang::get('core.notifications') }} </span> 
                    <span class="badge badge-danger">{!! SiteHelpers::getnotificationstotal() !!}</span> 
                    @if( SiteHelpers::getnotificationstotal() )
                    <i class="caret"></i>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-right icons-right">

                    @foreach(SiteHelpers::getnotifications() as $notification)
                    <li><a onclick="return seen_notification('<?php echo $notification->id ?>', '<?php echo $notification->link ?>');" href="javascript:void(0);"> {{ $notification->subject }}</a></li>
                    @endforeach
<!--                    <li><a href="{{ URL::to('notifications')}}" > {{ Lang::get('core.view_all_notifications') }}</a></li>-->
                </ul>
            </li>





            @if(CNF_MULTILANG ==1)
            <?php
            $lang = 'en';
            if (Session::get('lang') !== NULL) {
                Session::put('lang', Session::get('lang'));
                $lang = Session::get('lang');
            }
            ?>
            <li  class="user dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('sximo/images/'.$lang.'.png')}}"><i class="caret"></i></a>
                <ul class="dropdown-menu dropdown-menu-right icons-right">
                    @foreach(SiteHelpers::langOption() as $lang)
                    <li><a href="{{ URL::to('home/lang/'.$lang['folder'])}}"><img class="flag-lang" src="{{ asset('sximo/images/'.strtolower($lang['name']).'.png')}}">  {{ Lang::get('core.'.$lang['name']) }}   </a></li>
                    @endforeach	
                </ul>
            </li>	
            @endif			
            @if(Auth::user()->group_id == 1)
            @if(CNF_BUILDER_TOOL ==1)  
            <li class="user dropdown"><a class="dropdown-toggle" href="javascript:void(0)"  data-toggle="dropdown"><i class="fa fa-desktop"></i> <span>{{ Lang::get('core.m_controlpanel') }}</span><i class="caret"></i></a>
                <ul class="dropdown-menu dropdown-menu-right icons-right">
<!--		   <li><a href="{{ URL::to('')}}" target="_blank"><i class="fa fa-desktop"></i>  Main Site </a></li>-->
                    <li><a href="{{ URL::to('sximo/config')}}"><i class="fa  fa-wrench"></i> {{ Lang::get('core.m_setting') }}</a></li>
                    <li><a href="{{ URL::to('core/users')}}"><i class="fa fa-user"></i> {{ Lang::get('core.m_users') }} &  {{ Lang::get('core.m_groups') }} </a></li>
<!--			<li><a href="{{ URL::to('core/users/blast')}}"><i class="fa fa-envelope"></i> {{ Lang::get('core.m_blastemail') }} </a></li>	-->
<!--			<li><a href="{{ URL::to('core/logs')}}"><i class="fa fa-clock-o"></i> {{ Lang::get('core.m_logs') }}</a></li>	-->
                    <li class="divider"></li>
<!--			<li><a href="{{ URL::to('core/pages')}}"><i class="fa fa-copy"></i> {{ Lang::get('core.m_pagecms')}}</a></li>-->

                    <li class="divider"></li>
                    <li><a href="{{ URL::to('sximo/module')}}"><i class="fa fa-cogs"></i> {{ Lang::get('core.m_codebuilder') }}</a></li>
                    <li><a href="{{ URL::to('sximo/tables')}}"><i class="icon-database"></i> Database Tables </a></li>
                    <li><a href="{{ URL::to('sximo/menu')}}"><i class="fa fa-sitemap"></i> {{ Lang::get('core.m_menu') }}</a></li>	
<!--			<li><a href="{{ URL::to('core/elfinder')}}"><i class="fa fa-folder"></i>  File Manager </a></li>-->

                    <li class="divider"></li>
                    <li><a href="{{ URL::to('core/template')}}"><i class="fa fa-desktop"></i> Template Guide </a></li>

                </ul>
            </li>
            @endif
            @endif

            <li class="user dropdown"><a class="dropdown-toggle" href="javascript:void(0)"  data-toggle="dropdown"><i class="fa fa-user"></i> <span>{{ Lang::get('core.m_myaccount') }}</span><i class="caret"></i></a>
                <ul class="dropdown-menu dropdown-menu-right icons-right">
                    <li><a href="{{ URL::to('dashboard')}}"><i class="fa  fa-laptop"></i> {{ Lang::get('core.m_dashboard') }}</a></li>

                    <li><a href="{{ URL::to('user/profile')}}"><i class="fa fa-user"></i> {{ Lang::get('core.m_profile') }}</a></li>

                    <li><a href="{{ URL::to('user/logout')}}"><i class="fa fa-sign-out"></i> {{ Lang::get('core.m_logout') }}</a></li>
                </ul>
            </li>			



        </ul>

    </nav>
</div>

<script type="text/javascript">
    function seen_notification(notification_id, url) {
        // this work local 
     //   var base_url = window.location.origin;
        
         // this work good on server above         
         var base_url = {!! json_encode(url('/')) !!};
         
         console.log(base_url);
       
        $.ajax({
            url: "{{ URL::to('notifications/seennotification')}}",
            type: 'POST',
            data: {id: notification_id},
            dataType: 'json',
            success: function () {
              //  window.location.href = url;
                window.location.href = base_url+"/"+url ;

            }
        });

    }





</script>






<script>

    // setInterval(function(){alert("Hello")}, 1000);

    function upnotifications() {
        $.ajax({
            url: "{{ URL::to('notifications/upnotifications')}}",
            type: 'POST',
       
            dataType: 'html',
            success: function (result) {
                // alert(result);
                $("#notify_result").html(result);
            }
        });
    }






    setInterval(function () {
        upnotifications();
    }, 10000);  // 10 sec as  1 sec = 1000 milisec

</script>