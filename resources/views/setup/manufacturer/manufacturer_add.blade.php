<div class="modal-content">

	<div class="modal-header bg-info">
	    <button data-dismiss="modal" class="close" type="button">&times;</button>
	    <h5 class="modal-title ">{{ trans('setup/manufacturer.window_add_title') }}</h5>
	</div>
	 
	{!! Form::open(['url' => '/manufacturer', 'method' => 'post', 'id' =>'manufacturer-form', 'name' =>'frmManufacturer']) !!}
		
		<div class="modal-body">
			@include('setup.manufacturer.manufacturer_form')
		</div>
	 
	 {!! Form::close() !!}

</div>
