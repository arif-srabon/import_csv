<div class="modal-content">
    <div class="modal-header bg-info">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h5 class="modal-title ">{{ trans('setup/unionward.window_edit_title') }}</h5>
    </div>

    {!! Form::model($unionWard, ['url' => ['unionward', $unionWard->id], 'method' => 'PATCH','id' =>'frmUnionWard', 'name' =>'frmUnionWard']) !!}
    <div class="modal-body">

        @include('setup.union_ward.unionward_form')
    </div>
    {!! Form::close() !!}

</div>
