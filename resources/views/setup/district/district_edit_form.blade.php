<div class="modal-content">
<div class="modal-header bg-info">
    <button data-dismiss="modal" class="close" type="button">×</button>
    <h5 class="modal-title ">{{ trans('setup/district.window_edit_title') }}</h5>
</div>
            {!! Form::model($districts, ['url' => ['/district', $districts->id], 'method' => 'patch','id' =>'frmDistrict', 'name' =>'frmDistrict']) !!}
            <div class="modal-body">

            @include('setup.district.district_form')
			</div>
            {!! Form::close() !!}

        
    </div>

    <!-- /User form -->
