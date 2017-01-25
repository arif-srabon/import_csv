<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
<script type="text/javascript" src="assets/js/app/thanaUnionWard_form_validation.js"></script>

<!-- Theme JS files -->
<script type="text/javascript" src="assets/js/core/libraries/jquery_ui/full.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

<script type="text/javascript" src="assets/js/pages/form_select2.js"></script>
<!-- /theme JS files -->

<div class="row">
    <fieldset>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('division_id', trans('setup/thanaunionward.label_division')) !!}
                        {!! Form::select('division_id', $division, $office_division, ['onChange'=>'loadDistrict()','placeholder' => trans('setup/thanaunionward.ph_select'), 'class' => 'select form-control']) !!}
                        @if ($errors->has('division_id'))<p
                                class="text-danger">{!!$errors->first('division_id')!!}</p>@endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('district_id', trans('setup/thanaunionward.label_district')) !!}
                        {!! Form::select('district_id', $district, $office_district, ['onChange'=>'loadThanaUpazilla()','placeholder' => trans('setup/thanaunionward.ph_select'), 'class' => 'select form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('thana_upazila_id', trans('setup/thanaunionward.label_thana_upazilla')) !!}
                        {!! Form::select('thana_upazila_id', $thanaUpazilla, $office_thana_upazila, ['onChange'=>'loadUnion()','placeholder' => trans('setup/thanaunionward.ph_select'), 'class' => 'select form-control']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('union_ward_id', trans('setup/thanaunionward.label_union')) !!}
                        {!! Form::select('union_ward_id', $union, $office_city_corp_paurasava, ['placeholder' => trans('setup/thanaunionward.ph_select'), 'class' => 'select form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-13">
                <div class="form-group">
                    {!! Form::label('geo_code', trans('setup/thanaunionward.label_geo_code')) !!}
                    {!! Form::text('geo_code', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                </div>
            </div>

            <div class="col-md-13">
                <div class="form-group">
                    {!! Form::label('name', trans('setup/thanaunionward.label_name')) !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                </div>
            </div>
            <div class="col-md-13">
                <div class="form-group">
                    {!! Form::label('name_bn', trans('setup/thanaunionward.label_name_bn')) !!} *
                    {!! Form::text('name_bn', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                </div>
            </div>
        </div>
    </fieldset>
</div>
<hr>
<div class="text-right">{!! Form::hidden('id') !!}
    <button id="reset" class="btn btn-default" type="reset">{{ trans('setup/thanaunionward.btn_reset') }} <i
                class="icon-reload-alt position-right"></i>
    </button>
    <button class="btn btn-primary" type="button" id="submit">{{ trans('setup/thanaunionward.btn_save') }} <i
                class="icon-arrow-right14 position-right"></i>
    </button>
</div>

{!! Form::close() !!}


<script type="text/javascript">
    function loadDistrict() {
        var divisionId = $("#division_id").val();
        $.get('/thanaupazilla/getDistrict/' + divisionId, function (data) {
            //success data
            $('#district_id').empty();
            $("#district_id").append("<option value=''>{{trans('setup/thanaunionward.ph_select')}}</option>");
            $.each(data, function (index, subcatObj) {
                $("#district_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
            });
        });
    }

    function loadThanaUpazilla() {
        var districtId = $("#district_id").val();
        $.get('/citycorppaurasava/getThanaUpazillaByDistrict/' + districtId, function (data) {
            //success data
            $('#thana_upazila_id').empty();
            $("#thana_upazila_id").append("<option value=''>{{trans('setup/thanaunionward.ph_select')}}</option>");
            $.each(data, function (index, subcatObj) {
                $("#thana_upazila_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
            });
        });
    }

    function loadUnion() {
        var thanaUpazillaId = $("#thana_upazila_id").val();
        $.get('/thanaunionward/getUnionByThana/' + thanaUpazillaId, function (data) {
            //success data
            $('#union_ward_id').empty();
            $("#union_ward_id").append("<option value=''>{{trans('setup/thanaunionward.ph_select')}}</option>");
            $.each(data, function (index, subcatObj) {
                $("#union_ward_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
            });
        });
    }

</script>

<script type="application/javascript">


    $(document).ready(function () {

        $("button#submit").click(function () {

            if ($("#frmThanaUnionWard").valid()) {
                var $form = $("#frmThanaUnionWard");
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    success: function (data, status) {
                        if (data.toastr_error) {
                            toastr[data.toastr_error](data.message, data.title);
                            return;
                        }

                        toastr[data.toastr_success](data.message, data.title);

                        var grid = $("#grid_thana_union_ward").data("kendoGrid");
                        grid.dataSource.read();
                        grid.refresh();
                        $('#myModal').modal('hide');
                    },
                    error: function (result) {
                        if (result.status === 401) { //redirect if not authenticated user.
                            //$( location ).prop( 'pathname', 'auth/login' );
                        }
                        if (result.status === 422) {
                            var errors = $.parseJSON(result.responseText);
                            errorsHtml = '<div><ul>'; //class="alert alert-danger"
                            $.each(errors, function (key, value) {
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