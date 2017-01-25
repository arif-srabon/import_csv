<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
<script type="text/javascript" src="assets/js/app/district_form_validation.js"></script>
<div class="form-group">
  <div class="row">
    <div class="col-sm-6"> {!! Form::label('division_id', trans('setup/district.label_division')) !!}
      {!! Form::select('division_id', $division, null, ['placeholder' => trans('setup/district.ph_select'), 'class' => 'select form-control']) !!}
      
      </div>
    <div class="col-sm-6"> {!! Form::label('geo_code', trans('setup/district.label_geo_code')) !!}
      {!! Form::text('geo_code', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
      </div>
  </div>
</div>
<div class="form-group">
  <div class="row">
    <div class="col-sm-12"> {!! Form::label('name', trans('setup/district.label_name')) !!}
      {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
      </div>
  </div>
</div>
<div class="form-group">
  <div class="row">
    <div class="col-sm-12"> {!! Form::label('name_bn', trans('setup/district.label_name_bn')) !!} *
      {!! Form::text('name_bn', null, ['class' => 'form-control', 'placeholder' => '']) !!} </div>
  </div>
</div>
<hr>
<div class="text-right"> {!! Form::hidden('id') !!}
  <button id="reset" class="btn btn-default" type="reset">{{  trans('setup/district.btn_reset') }}  <i class="icon-reload-alt position-right"></i></button>
  <button class="btn btn-primary" type="button" id="submit"  >{{  trans('setup/district.btn_save') }} <i class="icon-arrow-right14 position-right"></i> </button>
</div>
<!-- /District form -->

<script type="application/javascript">


  $(document).ready(function () {
	  
	  

    $("button#submit").click(function(){

	if ($("#frmDistrict").valid()) {
		var $form = $("#frmDistrict");
	  $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        success: function (data, status) {
		  if(data.toastr_error){
		  	toastr[data.toastr_error](data.message, data.title);
			return;
		  }
		  	
		  toastr[data.toastr_success](data.message, data.title);
		  
		  var grid = $("#grid_district").data("kendoGrid");
		  grid.dataSource.read();
          grid.refresh();
		  $('#myModal').modal('hide');
		},
        error: function (result) {
			if( result.status === 401 ) { //redirect if not authenticated user.
            //$( location ).prop( 'pathname', 'auth/login' );
			}
			if( result.status === 422 ) {
				var errors = $.parseJSON(result.responseText);
				errorsHtml = '<div><ul>'; //class="alert alert-danger"
	    		$.each( errors, function( key, value ) {
					errorsHtml += '<li>' + value[0] + '</li>'; 
				});
				errorsHtml += '</ul></div>';
				toastr["error"](errorsHtml, "Invalid/Duplicate Input Data");
			}
        }
      });	
	}
	
    });

  });
  


</script>


