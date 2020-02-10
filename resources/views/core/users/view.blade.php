@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ Lang::get('core.m_users') }} <small> {{ Lang::get('core.m_users') }} </small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('core/users?return='.$return) }}"> {{ Lang::get('core.m_users') }} </a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('core/users?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('core/users/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeIn">
	<!-- <div class="sbox-title"> <h4> <i class="fa fa-table"></i> <?php // echo $pageTitle ;?></h4></div> -->
	<div class="sbox-content"> 	



	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.avatar') }}</td>
						<td>{!! SiteHelpers::showUploadedFile($row->avatar,'/uploads/users/') !!} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.group') }}</td>
						<td>{{ SiteHelpers::gridDisplayView($row->group_id,'group_id','1:tb_groups:group_id:name') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.username') }}</td>
						<td>{{ $row->username }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.firstname') }}</td>
						<td>{{ $row->first_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.lastname') }}</td>
						<td>{{ $row->last_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.email') }}</td>
						<td>{{ $row->email }} </td>
						
					</tr>
				
                                        <tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.fr_mactive') }}</td>
						<td>
                                                    @if( $row->active == 1 )
                                                     {{ \Lang::get('core.fr_mactive')   }}
                                                    @else 
                                                   {{ \Lang::get('core.fr_minactive') }}
                                                    @endif
                                                    
                                                    
                                                </td>
						
					</tr>
                                        
					
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.lastlogin') }}</td>
						<td>{{ $row->last_login }} </td>
						
					</tr>
                                        
                                        <tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.created_at') }}</td>
						<td>{{ $row->created_at }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ Lang::get('core.updated_at') }}</td>
						<td>{{ $row->updated_at }} </td>
						
					</tr>
				
					
				
		</tbody>	
	</table>    
	
	</div>
</div>	

	</div>
</div>
	  
@stop