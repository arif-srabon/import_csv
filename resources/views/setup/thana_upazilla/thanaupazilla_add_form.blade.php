<div class="modal-content">
    <div class="modal-header bg-info">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h5 class="modal-title ">{{ trans('setup/thanaupazilla.window_add_title') }}</h5>
    </div>

    {!! Form::model($district,['url' => 'thanaupazilla', 'method' => 'post','id' =>'frmThanaUpazilla', 'name' =>'frmThanaUpazilla']) !!}
    <div class="modal-body">
        @include('setup.thana_upazilla.thanaupazilla_form')
    </div>

    {!! Form::close() !!}

</div>
