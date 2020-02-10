<!DOCTYPE html>
<html lang="en">
    <head>

        <!--     <link type="text/css" href="/chat/cometchatcss.php" rel="stylesheet" charset="utf-8">
            <script type="text/javascript" src="/chat/cometchatjs.php" charset="utf-8"></script>-->



        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> {{ CNF_APPNAME }} </title>
        <meta name="keywords" content="">
        <meta name="description" content=""/>
        <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">	




        <link href="{{ asset('sximo/js/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet"> 
        <link href="{{ asset('sximo/js/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/js/plugins/bootstrap.summernote/summernote.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/js/plugins/datepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/js/plugins/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
        <!--		<link href="{{ asset('sximo/js/plugins/select2/select2.css')}}" rel="stylesheet">-->
        <link href="{{ asset('sximo/js/plugins/iCheck/skins/square/green.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/js/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet">

        <!--		<link href="{{ asset('sximo/css/animate.css')}}" rel="stylesheet">		-->
        <link href="{{ asset('sximo/css/icons.min.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/js/plugins/toastr/toastr.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/css/sximo-dark-blue.css')}}" rel="stylesheet">
        <link href="{{ asset('sximo/css/style.css')}}" rel="stylesheet">




        @if(Session::get('lang') =='ar')
        <link href="{{ asset('sximo/css/hr-app-style-rtl.css')}}" rel="stylesheet">	
        <link href="{{ asset('sximo/css/bootstrap-rtl.css')}}" rel="stylesheet">	
        @endif

        <script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.cookie.js') }}"></script>			
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery-ui.min.js') }}"></script>				
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/iCheck/icheck.min.js') }}"></script>
        <!--		<script type="text/javascript" src="{{ asset('sximo/js/plugins/select2/select2.min.js') }}"></script>-->
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/fancybox/jquery.fancybox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/prettify.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/parsley.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/switch.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/bootstrap/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/sximo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.form.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.jCombo.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/toastr/toastr.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/plugins/bootstrap.summernote/summernote.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo/js/simpleclone.js') }}"></script>	
        <script type="text/javascript" src="{{ asset('sximo/js/chart/Chart.js') }}"></script>


        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->	

        <?php
        $current_action = Route::getCurrentRoute()->getActionName();
        // echo $current_action ; die;
        if ($current_action == "App\Http\Controllers\ProjectsemployeesController@getUpdate") {
            ?>

            <link href="{{ asset('sximo/files/select2.css')}}" rel="stylesheet">
            <script type="text/javascript" src="{{ asset('sximo/files/select2.js') }}"></script>

            <?php
        } else {
            ?>
            <link href="{{ asset('sximo/js/plugins/select2/select2.css')}}" rel="stylesheet">

            <script type="text/javascript" src="{{ asset('sximo/js/plugins/select2/select2.min.js') }}"></script>

            <?php
        }
        ?>	




        <!--  //===================================fix datepicker with language:  just replace class date with date_lang  =========================//-->

        <?php
        $current_lang = Session::get('lang');
        ?> 

        <script>


(function ($) {
    $.fn.datepicker.dates['ar'] = {
        days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
        daysShort: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"],
        daysMin: ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"],
        months: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
        monthsShort: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
        today: "هذا اليوم",
        rtl: true,
        clear: "Clear",
        format: "yyyy-mm-dd",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };
}(jQuery));


(function ($) {
    $.fn.datepicker.dates['en'] = {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        today: "Today",
        clear: "Clear",
        format: "yyyy-mm-dd",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };
}(jQuery));

        </script>



        <script type="text/javascript">
            $(document).ready(function () {

                var lang = "{{$current_lang}}";


                $('#example1').datepicker({
                    format: "yyyy-mm-dd",
                    rtl: true,
                    language: lang

                });

                $('.date_lang').datepicker({
                    format: "yyyy-mm-dd",
                    rtl: true,
                    language: lang

                });



            });
        </script>		 



        <!--to add time field for work hours peroid--> 
        <?php
        if ($current_action == "App\Http\Controllers\MypermissionsController@getUpdate") {
            ?>
            <link href="{{ asset('sximo/timepicker/jquery.timepicker.css')}}" rel="stylesheet">
            <script type="text/javascript" src="{{ asset('sximo/timepicker/jquery.timepicker.js') }}"></script>	
            <script>
            $(function () {

                $('.datetimepicker').timepicker({
                    'minTime': '09:00am',
                    'maxTime': '17:00pm',
                    'step': 5,
                    //  'showDuration': true
                });


    //                    $('.datetimepicker_button').on('click', function () {
    //                        $('.datetimepicker').timepicker('show');
    //                    });


            });



            </script>


            <?php
        }
        ?>

        <style>

            #s2id_rights_ids , #s2id_locations_ids , #s2id_department_ids ,#s2id_type_ids {
                direction: ltr !important;
            }

        </style>




    </head>
    <body class="sxim-init" >
        <div id="wrapper">
            @include('layouts/sidemenu')
            <div class="gray-bg " id="page-wrapper">
                @include('layouts/headmenu')

                @yield('content')		
            </div>

            <div class="footer fixed">
                <div class="pull-right">
                    {{ Lang::get('core.designed_develop_by') }}    <strong><a href="http://ivas.mobi/" target="_blank" >  {{ Lang::get('core.IVAS') }} </a> </strong>.
                </div>
                <div>
                    <strong>{{ Lang::get('core.Copyright') }}  </strong> &copy; {{ date('Y')}} . {{ CNF_COMNAME }}  
                </div>
            </div>		

        </div>


        <div class="modal fade" id="sximo-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-default">

                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body" id="sximo-modal-content">

                    </div>

                </div>
            </div>
        </div>
        <!--<div class="theme-config">
            <div class="theme-config-box">
                <div class="spin-icon">
                    <i class="fa fa-cogs fa-spin"></i>
                </div>
                <div class="skin-setttings">
                    <div class="title">Select Color Schema</div>
                    <div class="setings-item">
                            <ul>
                                    <li><a href="{{ url('home/skin/sximo') }}"> Default Skin  <span class="pull-right default-skin"> </span></a></li> 
                                    <li><a href="{{ url('home/skin/sximo-dark-blue') }}"> Dark Blue Skin <span class="pull-right dark-blue-skin"> </span> </a></li> 
                                    <li><a href="{{ url('home/skin/sximo-light-blue') }}"> Light Blue Skin <span class="pull-right light-blue-skin"> </span> </a></li> 
                                   
                            </ul>
        
                        
                    </div>
                    
                </div>
            </div>
        </div> -->

        {{ Sitehelpers::showNotification() }} 
        <script type="text/javascript">
            jQuery(document).ready(function ($) {

                $('#sidemenu').sximMenu();
                $('.spin-icon').click(function () {
                    $(".theme-config-box").toggleClass("show");
                });


            });


        </script>
    </body> 
</html>


