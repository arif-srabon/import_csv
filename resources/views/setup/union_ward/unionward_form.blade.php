<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
<script type="text/javascript" src="assets/js/app/unionWard_form_validation.js"></script>
<!-- Theme JS files -->
<script type="text/javascript" src="assets/js/core/libraries/jquery_ui/full.min.js"></script>
<!-- /theme JS files -->
<div class="panel panel-flat">
    <div class="">
        <div class="panel-body">
            <div class="row">
                <fieldset>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php if(!empty($unionWard)) { ?>
                                    <input type="hidden" id="locationTypeId"
                                           value="<?php echo $unionWard['location_type_id'] ?>">
                                    <?php } else { ?>
                                         <?php } ?>
                                    <div class="cls2">
                                        {!! Form::label('division_id', trans('setup/unionward.label_division')) !!}
                                        {!! Form::select('division_id', $division, null, ['onChange'=>'loadDistrict()','placeholder' => trans('setup/unionward.ph_select'), 'class' => 'select form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="cls2">
                                        {!! Form::label('district_id', trans('setup/unionward.label_district')) !!}
                                        {!! Form::select('district_id', $district, null, ['onChange'=>'loadThanaUpazilla()','placeholder' => trans('setup/unionward.ph_select'), 'class' => 'select form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('location_type_id', trans('setup/unionward.label_location_type')) !!}
                                    {!! Form::select('location_type_id', $locationType, null, ['onChange'=>'showHide()','placeholder' => trans('setup/unionward.ph_select'), 'class' => 'select form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-4" id="divThanaUpazilla">
                                <div class="form-group">
                                    {!! Form::label('thana_upazila_id', trans('setup/unionward.label_thana_upazilla')) !!}
                                    {!! Form::select('thana_upazila_id', $thanaUpazilla, null, ['placeholder' => trans('setup/unionward.ph_select'), 'class' => 'select form-control','id' => 'thana_upazila_id']) !!}
                                </div>
                            </div>

                            <div class="col-md-4" id="divPaurasava">
                                <div class="form-group">
                                    {!! Form::label('paurasava_id', trans('setup/unionward.label_paurasava')) !!}
                                    <?php
                                    $city_corp_paurasava = (!empty($unionWard->city_corp_paurasava_id)) ?  $unionWard->city_corp_paurasava_id : "";
                                    ?>
                                    {!! Form::select('paurasava_id', $paurasava, $city_corp_paurasava , ['placeholder' => trans('setup/unionward.ph_select'), 'class' => 'select form-control','id' => 'paurasava_id']) !!}
                                </div>
                            </div>

                            <div class="col-md-4" id="divCityCorp">
                                <div class="form-group">
                                    {!! Form::label('city_corp_id', trans('setup/unionward.label_city_corp')) !!}
                                    <?php
                                    $city_corp_paurasava = (!empty($unionWard->city_corp_paurasava_id)) ?  $unionWard->city_corp_paurasava_id : "";
                                    ?>
                                    {!! Form::select('city_corp_id', $cityCorp, $city_corp_paurasava, ['placeholder' => trans('setup/unionward.ph_select'), 'class' => 'select form-control','id' => 'city_corp_id']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('geo_code', trans('setup/unionward.label_geo_code')) !!}
                                    {!! Form::text('geo_code', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', trans('setup/unionward.label_name')) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name_bn', trans('setup/unionward.label_name_bn')) !!}
                            {!! Form::text('name_bn', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="text-right">{!! Form::hidden('id') !!}
                <button id="reset" class="btn btn-default" type="reset">{{ trans('setup/unionward.btn_reset') }} <i class="icon-reload-alt position-right"></i>
                </button>
                <button class="btn btn-primary" type="button" id="submit"> {{ trans('setup/unionward.btn_save') }} <i
                            class="icon-arrow-right14 position-right"></i>
                </button>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function () {

            $type = $("#location_type_id").val();
            if ($type == "") {
                var value = $("#location_type_id").val();
                if (value == "") {
                    $("#divThanaUpazilla").hide();
                    $("#divPaurasava").hide();
                    $("#divCityCorp").hide();
//                    $("#thana_upazila_id").addClass("required");
                    $("#thana_upazila_id").removeClass("required");
                    $("#paurasava_id").removeClass("required");
                    $("#city_corp_id").removeClass("required");
                }
            }
            else {
                if ($type == '1') {
                    $("#divThanaUpazilla").show();
                    $("#divPaurasava").hide();
                    $("#divCityCorp").hide();
                    $("#thana_upazila_id").addClass("required");
                    $("#paurasava_id").removeClass("required");
                    $("#city_corp_id").removeClass("required");
                }
                if ($type == '3') {
                    $("#divThanaUpazilla").hide();
                    $("#divPaurasava").show();
                    $("#divCityCorp").hide();
                    $("#thana_upazila_id").removeClass("required");
                    $("#paurasava_id").addClass("required");
                    $("#city_corp_id").removeClass("required");
                }
                if ($type == '2') {
                    $("#divThanaUpazilla").hide();
                    $("#divPaurasava").hide();
                    $("#divCityCorp").show();
                    $("#thana_upazila_id").removeClass("required");
                    $("#paurasava_id").removeClass("required");
                    $("#city_corp_id").addClass("required");
                }
            }
        });

        function showHide() {
            var value = $("#location_type_id").val();
            if (value == '1') {
                $("#divThanaUpazilla").show();
                $("#divPaurasava").hide();
                $("#divCityCorp").hide();

                $("#thana_upazila_id").addClass("required");
                $("#paurasava_id").removeClass("required");
                $("#city_corp_id").removeClass("required");

                $("#paurasava_id").val('');
                $("#city_corp_id").val('');
            }
            else if (value == '3') {
                $("#divThanaUpazilla").hide();
                $("#divPaurasava").show();
                $("#divCityCorp").hide();

                $("#thana_upazila_id").removeClass("required");
                $("#paurasava_id").addClass("required");
                $("#city_corp_id").removeClass("required");

                $("#thana_upazila_id").val('');
                $("#city_corp_id").val('');
            } else if (value == '2') {
                $("#divThanaUpazilla").hide();
                $("#divPaurasava").hide();
                $("#divCityCorp").show();

                $("#thana_upazila_id").removeClass("required");
                $("#paurasava_id").removeClass("required");
                $("#city_corp_id").addClass("required");

                $("#thana_upazila_id").val('');
                $("#paurasava_id").val('');
            } else {
                $("#divThanaUpazilla").hide();
                $("#divPaurasava").hide();
                $("#divCityCorp").hide();

                $("#thana_upazila_id").removeClass("required");
                $("#paurasava_id").removeClass("required");
                $("#city_corp_id").removeClass("required");

                $("#thana_upazila_id").val('');
                $("#paurasava_id").val('');
                $("#city_corp_id").val('');
            }
        }

        function loadDistrict() {
            var divisionId = $("#division_id").val();
            $.get('/unionward/getDistrict/' + divisionId, function (data) {
                //success data
                $('#district_id').empty();
                $("#district_id").append("<option value=''>{{trans('setup/unionward.ph_select')}}</option>");
                $.each(data, function (index, subcatObj) {
                    $("#district_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
                });
            });
        }

        function loadThanaUpazilla() {
            var districtId = $("#district_id").val();
            $.get('/unionward/getThanaUpazillaByDistrict/' + districtId, function (data) {
                //success data
                $('#thana_upazila_id').empty();
                $("#thana_upazila_id").append("<option value=''>{{trans('setup/unionward.ph_select')}}</option>");
                $.each(data, function (index, subcatObj) {
                    $("#thana_upazila_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
                });
            });

            $.get('/unionward/getPaurasavaByDistrict/' + districtId, function (data) {
                //success data
                $('#paurasava_id').empty();
                $("#paurasava_id").append("<option value=''>{{trans('setup/unionward.ph_select')}}</option>");
                $.each(data, function (index, subcatObj) {
                    $("#paurasava_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
                });
            });

            $.get('/unionward/getCityCorpByDistrict/' + districtId, function (data) {
                //success data
                $('#city_corp_id').empty();
                $("#city_corp_id").append("<option value=''>{{trans('setup/unionward.ph_select')}}</option>");
                $.each(data, function (index, subcatObj) {
                    $("#city_corp_id").append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
                });
            });
        }

    </script>
    <script type="application/javascript">


        $(document).ready(function () {

            $("button#submit").click(function(){

                if ($("#frmUnionWard").valid()) {
                    var $form = $("#frmUnionWard");
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

                            var grid = $("#grid_union_ward").data("kendoGrid");
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