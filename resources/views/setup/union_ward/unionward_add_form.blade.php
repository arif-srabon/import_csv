<div class="modal-content">
    <div class="modal-header bg-info">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h5 class="modal-title ">{{ trans('setup/unionward.window_add_title') }}</h5>
    </div>

    {!! Form::model($district,['url' => 'unionward', 'method' => 'post','id' =>'frmUnionWard', 'name' =>'frmUnionWard']) !!}
    <div class="modal-body">

        @include('setup.union_ward.unionward_form')
    </div>
    {!! Form::close() !!}
</div>
