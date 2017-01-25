<div class="modal-content">
    <div class="modal-header bg-info">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h5 class="modal-title ">{{ trans('setup/thanaunionward.window_edit_title') }}</h5>
    </div>

    {!! Form::model($thanaunionward, ['method' => 'PATCH', 'url' => ['thanaunionward', $thanaunionward->id],'id' =>'frmThanaUnionWard', 'name' =>'frmThanaUnionWard']) !!}
    <div class="modal-body">
        @include('setup.thanaunionward.form')
    </div>

    {!! Form::close() !!}

</div>