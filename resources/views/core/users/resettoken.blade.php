<div class="form-group">
    <label for="resettoken" class=" control-label col-md-6">{{ Lang::get('core.are_you_sure_to_reset_mobile_token') }}</label>
    <div class="col-md-6">
        <button type="button" onclick="postResettoken2({{$user_id}})" name="reset_token" class="btn btn-info btn-sm" ><i class="icon-checkmark3"></i> {{ Lang::get('core.yes') }}</button>
        <button  type="button" onclick="" class="btn btn-info btn-sm" data-dismiss="modal"><i class="icon-close"></i> {{ Lang::get('core.no') }}</button>

    </div> 
</div>   

