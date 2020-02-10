@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('subscribers?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('subscribers?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('subscribers/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td>{{ $row->id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone</td>
						<td>{{ $row->phone }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MSISDN</td>
						<td>{{ $row->MSISDN }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TSTAMP</td>
						<td>{{ $row->TSTAMP }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Price</td>
						<td>{{ $row->Price }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NextRenwal</td>
						<td>{{ $row->NextRenwal }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ServiceID</td>
						<td>{{ $row->ServiceID }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ServiceName</td>
						<td>{{ $row->ServiceName }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NewStatus</td>
						<td>{{ $row->NewStatus }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Channel</td>
						<td>{{ $row->Channel }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Subs Web</td>
						<td>{{ $row->subs_web }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Login</td>
						<td>{{ $row->login }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ $row->created_at }} </td>
						
					</tr>
				
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop