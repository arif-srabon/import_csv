<!-- FORM: MANUFACTURER -->
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('code', trans('setup/manufacturer.label_code')) !!} <span class="text-danger">*</span>
            {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('code_non_bio', trans('setup/manufacturer.label_code2')) !!} <span class="text-danger">*</span>
            {!! Form::text('code_non_bio', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('name', trans('setup/manufacturer.label_name')) !!} <span class="text-danger">*</span>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('name_bn', trans('setup/manufacturer.label_name_bn')) !!} <span class="text-danger">*</span>
            {!! Form::text('name_bn', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('division_id', trans('setup/manufacturer.label_division')) !!} <span class="text-danger">*</span>
            {!! Form::select('division_id', $division, null, ['onChange' => 'loadDistrict()', 'placeholder' => trans('setup/manufacturer.select_division'), 'class' => 'select form-control']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('district_id', trans('setup/manufacturer.label_district')) !!} <span class="text-danger">*</span>
            {!! Form::select('district_id', $district, null, ['placeholder' => trans('setup/manufacturer.select_district'), 'class' => 'select form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('address', trans('setup/manufacturer.label_address')) !!}
            {!! Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => '3']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('registration_dt', trans('setup/manufacturer.label_registration_dt')) !!}
            <div class="input-group date">
                {!! Form::text('registration_dt', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                <span class="input-group-addon"><i class="icon-calendar"></i></span>
            </div>
        </div>
        <div>
            <label for="status" class="display-block text-semibold">{!! trans('setup/manufacturer.label_status') !!}</label>
            <label class="radio-inline">
                {!! Form::radio('status', '1', true) !!} {!! trans('setup/manufacturer.label_active') !!}
            </label>
            <label class="radio-inline">
                {!! Form::radio('status', '0') !!} {!! trans('setup/manufacturer.label_inactive') !!}
            </label>
        </div>
    </div>
</div>

<hr>

<div class="text-right">
    {!! Form::hidden('id') !!}
    <button id="reset" class="btn btn-default" type="reset">{{  trans('setup/manufacturer.btn_reset') }}  <i class="icon-reload-alt position-right"></i></button>
    <button class="btn btn-primary" type="button" id="submit">{{  trans('setup/manufacturer.btn_save') }} <i class="icon-arrow-right14 position-right"></i> </button>
</div>
<!-- /FORM: MANUFACTURER -->

<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
<script type="text/javascript" src="assets/js/app/manufacturer_form_validation.js"></script>

<script type="application/javascript">

    /**
     * Load districts
     * Load the corresponding districts based on the Division choice.
     * @return {mixed} Select field.
     * ...
     */
    function loadDistrict() {
        var divisionId = $("#division_id").val();

        $.get('/thanaupazilla/getDistrict/' + divisionId, function (data) {
            //success data
            $('#district_id').empty();
            $("#district_id").append("<option value=''>{{trans('setup/manufacturer.select_district')}}</option>");
            $.each(data, function (index, subcatObj) {
                $("#district_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
            });
        });
    }

    jQuery(document).ready(function($){

        /**
         * Save Manufacturer Data
         */
        $("button#submit").click(function(){

            var manufacturer_form = $('#manufacturer-form');

            if (manufacturer_form.valid()) {

                $.ajax({
                    type: manufacturer_form.attr('method'),
                    url: manufacturer_form.attr('action'),
                    data: manufacturer_form.serialize(),
                    success: function (data, status) {
                        if(data.toastr_error) {
                            toastr[data.toastr_error](data.message, data.title);
                            return;
                        }
            
                        toastr[data.toastr_success](data.message, data.title);
          
                        var grid = $("#grid_manufacturer").data("kendoGrid");
                        grid.dataSource.read();
                        grid.refresh();
                        $('#manufacturerModal').modal('hide');
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


        /**
         * Initiated Date Picker
         * @plugin Bootstrap DatePicker
         * ...
         */
        $('.input-group.date').datepicker({
            format: 'dd-mm-yyyy'
        });

    });
</script>
