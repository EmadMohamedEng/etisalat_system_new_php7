<div class="table-responsive" >
   @if(count($Data)>0)
    <table class="table table-striped ">
        <thead>
            <tr>
                <th class="number" width="60"> No </th>                
                <th width="160">Phone</th>
                <th>Subscribe Days</th>              
            </tr>
        </thead>
        <tbody>   
         <?php $c=($Data->currentpage()-1)*$Data->perpage()+1?>         
            @foreach ($Data as  $k=>$row)                
            <tr>
                <td > {{ $c++ }} </td> 
                <td>					 
                    {{$row->phone}}					 
                </td>
                <td>					 
                    {{$row->days}} Day(s)					 
                </td>                			 
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2"> Average Subscribe Days</th> 
                <th>{{round($DataAVG/$Data->total(),2)}} Day(s)</th>              
            </tr>
        </tfoot>
    </table>
    <div id="pagenation" class="pull-right" style="margin-bottom: 30px;">
        <span style="font-weight: bold;display: block; margin:0 10px -15px 0;color:#428bca"> Total : {{$Data->total()}} </span>
      {!! $Data->render() !!}         
    </div>
   @else
   <h3 class="text-center" style="margin:25px 0;">No Data Found</h3>
   @endif
</div>
