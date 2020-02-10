@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3>  {{ Lang::get('core.m_groups') }} <small> {{ Lang::get('core.m_groups') }} </small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('core/groups') }}"> {{ Lang::get('core.m_groups') }} </a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('core/groups?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('core/groups/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeIn">
	<!--<div class="sbox-title"> <h4> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> </h4></div>-->
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	
<!--					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.Id') }}</td>
						<td>{{ $row->group_id }} </td>
						
					</tr>-->
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.name') }}</td>
						<td>{{ $row->name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.Description') }}</td>
						<td>{{ $row->description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.Level') }}</td>
						<td>{{ $row->level }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	
	</div>
</div>	

	</div>
</div>
@stop	  
