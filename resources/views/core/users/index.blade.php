@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<div class="page-content row">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-title">
			<h3> {{ Lang::get('core.m_users') }} <small> {{ Lang::get('core.m_users') }} </small></h3>
		</div>

		<ul class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}"> {{ Lang::get('core.Dashboard') }} </a></li>
			<li class="active"> {{ Lang::get('core.m_users') }} </li>
		</ul>

	</div>


	<div class="page-content-wrapper m-t">

		<ul class="nav nav-tabs" style="margin-bottom:10px;">
			<li class="active"><a href="{{ URL::to('core/users')}}"><i class="fa fa-user"></i>
					{{ Lang::get('core.m_users') }} </a></li>
			<li><a href="{{ URL::to('core/groups')}}"><i class="fa fa-users"></i>
					{{ Lang::get('core.m_groups') }}</a></li>
			<!--	  <li class=""><a href="{{ URL::to('core/users/blast')}}"><i class="fa fa-envelope"></i> {{ Lang::get('core.m_sendmail') }}</a></li>-->
		</ul>

		<div class="sbox animated fadeIn">
			<div class="sbox-title">
				<!--  <h5> <i class="fa fa-table"></i> <?php // echo $pageTitle ;?> </h5> -->
				<div class="sbox-tools">
					@if(Session::get('gid') ==1)
					<a href="{{ URL::to('sximo/module/permission/users') }}" class="btn btn-xs btn-white tips"
						title=" {{ Lang::get('core.btn_config') }}"><i class="fa fa-cog"></i></a>
					@endif
				</div>
			</div>
			<div class="sbox-content">
				<div class="toolbar-line ">
					@if($access['is_add'] ==1)
					<a href="{{ URL::to('core/users/update') }}" class="tips btn btn-sm btn-white"
						title="{{ Lang::get('core.btn_create') }}">
						<i class="fa fa-plus-circle "></i>&nbsp;{{ Lang::get('core.btn_create') }}</a>


					<!--                        <a href="{{ URL::to('resetVacations') }}" class="tips btn btn-sm btn-white"  title="{{ Lang::get('core.reset_vacations') }}">
			<i class="fa fa-level-down "></i>&nbsp;{{ Lang::get('core.btn_reset_vacarions') }}</a>-->

					@endif
					@if($access['is_remove'] ==1)
					<a href="javascript://ajax" onclick="SximoDelete();" class="tips btn btn-sm btn-white"
						title="{{ Lang::get('core.btn_remove') }}">
						<i class="fa fa-minus-circle "></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
					@endif

					{{-- @if($access['is_excel'] ==1)
			<a href="{{ URL::to('core/users/download') }}" class="tips btn btn-sm btn-white"
					title="{{ Lang::get('core.btn_download') }}">
					<i class="fa fa-download "></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
					@endif --}}

				</div>



				{!! Form::open(array('url'=>'core/users/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' ))
				!!}
				<div class="table-responsive" style="min-height:300px;">
					<table class="table table-striped ">
						<thead>
							<tr>
								<th class="number"> {{Lang::get('core.No') }} </th>
								<th> <input type="checkbox" class="checkall" /></th>

								@foreach ($tableGrid as $t)
								@if($t['view'] =='1')
								<th> {{ Lang::get('core.'.$t["label"] )  }}</th>
								@endif
								@endforeach
								<th width="95">{{ Lang::get('core.btn_action') }}</th>
							</tr>
						</thead>

						<tbody>

							@foreach ($rowData as $row)
							<tr>
								<td width="30"> {{ ++$i }} </td>
								<td width="50"> @if($row->id !=1) <input type="checkbox" class="ids" name="id[]"
										value="{{ $row->id }}" /> @endif </td>
								@foreach ($tableGrid as $field)
								@php
								$conn = (isset($field['conn']) ? $field['conn'] : array() );
								$x = $field['field'];
								@endphp
								@if($field['view'] =='1')
								<td>
									@if($field['attribute']['image']['active'] =='1')
									{!!
									SiteHelpers::showUploadedFile($row->$x,$field['attribute']['image']['path'])
									!!}
									@else
									<?php
                                    if ($field['field'] == 'active' AND $row->$x == 1) {
                                        echo Lang::get('core.fr_mactive');
                                    } elseif ($field['field'] == 'active' AND $row->$x == 0) {
                                        echo Lang::get('core.fr_minactive');
                                    } else {
                                        ?>
									{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
									{!! SiteHelpers::gridDisplay($row->$x,$field['field'],$conn) !!}


									<?PHP
                                    }
                                    ?>
									@endif
								</td>
								@endif
								@endforeach
								<td>
									@if($access['is_detail'] ==1)
									<a href="{{ URL::to('core/users/show/'.$row->id.'?return='.$return)}}"
										class="tips btn btn-xs btn-white"
										title="{{ Lang::get('core.btn_view') }}"><i
											class="fa  fa-search "></i></a>
									@endif
									@if($access['is_edit'] ==1)
									<a href="{{ URL::to('core/users/update/'.$row->id.'?return='.$return) }}"
										class="tips btn btn-xs btn-white"
										title="{{ Lang::get('core.btn_edit') }}"><i
											class="fa fa-edit "></i></a>
									@endif




								</td>
							</tr>

							@endforeach

						</tbody>

					</table>
					<input type="hidden" name="md" value="" />
				</div>
				{!! Form::close() !!}
				@include('footer')
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("core/users/multisearch")}}');
		$('#SximoTable').submit();
	});
	
});	
</script>
@stop