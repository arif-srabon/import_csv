<div class="modal-content">

	<div class="modal-header bg-info">
	    <button data-dismiss="modal" class="close" type="button">&times;</button>
	    <h5 class="modal-title ">{{ trans('setup/manufacturer.window_edit_title') }}</h5>
	</div>
	
	{!! Form::model($manufacturer, ['url' => ['/manufacturer', $manufacturer->id], 'method' => 'patch', 'id' =>'manufacturer-form', 'name' =>'frmManufacturer']) !!}

		<div class="modal-body">
	        @include('setup.manufacturer.manufacturer_form')
		</div>

	{!! Form::close() !!}
        
</div>
