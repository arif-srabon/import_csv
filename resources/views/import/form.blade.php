<div  class="row" style="border: 1px solid #CCCCCC; padding: 10px 10px 10px 10px ; margin:1px;">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('type',trans('import.lable_import_select')) !!}<span class="text-danger">&nbsp;*</span>
                {!! Form::Select('type',array('generic'=>'Generic','dosage'=>'Dosage','medicine'=>'Medicine','manufacturer'=>'Manufacturer'),null, ['required'=>'required','class' => 'select form-control', 'placeholder' => trans('import.select_type')]) !!}
                @if ($errors->has('type'))
                    <p class="text-danger">{!!$errors->first('type')!!}</p>
                @endif
            </div>
        </div>
    </div>
</br>

    <div class="row">
        <div class="col-md-6">
        {!! Form::label('lable_import_title', trans('import.lable_import_title')) !!}<span class="text-danger">{{ trans('import.label_file_type') }}&nbsp;*</span>
        <div class="form-group">
            {!! Form::file('import_file', ['required'=>'required','class' => 'file-styled']) !!}
            @if ($errors->has('import_file'))
                <p class="text-danger">{!!$errors->first('import_file')!!}</p>
            @endif
        </div>
        </div>
    </div>
</br>
    <div class="row">
        <div class="col-md-6">
            <div id="progressouter"></div>
            <div style="display: none" id="message" class="alert alert-warning"></div>
            <div id="report_content">
            </div>
        </div>
    </div>
</br>
    <div class="col-md-6 ">
        <a href="uploads/importFile/guideline/Format Guidelines for Your Import File.pdf" target="_blank" download>
            <i class="icon-file-download2"></i> {{trans("import.download_guidline")}}
        </a>
    </div>
</div>
</br>
<div class="text-right">
    {!! Form::hidden('id') !!}
    <button id="btnReset" class="btn btn-default" type="reset">
        {{ trans('import.btn_reset')}} <i class="icon-reload-alt position-right"></i>
    </button>
    <button class="btn btn-primary" type="submit" id="btnSave">
        {{trans('import.btn_save')}} <i class="icon-arrow-right14 position-right"></i>
    </button>
</div>
<div class="panel panel-default">

    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-4 form-horizontal">
                <div class="form-group">
                    <label class="text-bold col-sm-4 control-label">{{ trans('counterfeit.label_status') }}</label>
                    <div class="col-sm-8">
                    </div>
                </div>
            </div>
            <div class="col-sm-4 form-horizontal">
                <div class="form-group">
                    <label class="text-bold col-sm-4 control-label">{{ trans('counterfeit.label_counterfeit_advice') }}</label>
                    <div class="col-sm-8">
                    </div>
                </div>
            </div>
            <div class="col-sm-4 text-right  hidden-print">
                <button class="btn btn-primary btn-xs heading-btn" type="submit">
                    <i class="icon-file-check position-left"></i> {{ trans('counterfeit.header_btn_save') }}
                </button>
                <a class="btn btn-primary btn-xs heading-btn k-grid-print" href="/counterfeit/{{ $getCounterfeitInfo[0]->id }}/print" target="_blank">
                    <i class='icon-printer'></i> {{ trans('counterfeit.header_btn_print') }}
                </a>

            </div>
        </div>

    </div> <!-- /.panel-heading -->

    <div class="panel-body">

        <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="adrrerpoting-accordion">

            <!-- PANEL #1 | Reporter -->
            <div class="panel panel-white border-top-xlg border-top-slate">
                <div class="panel-heading">
                    <h5 class="panel-title text-slate">
                        <a data-toggle="collapse" href="#adrrerpoting-group-1" aria-expanded="true">
                            <i class="icon-user"></i> {{ trans('counterfeit.title_reporter') }}
                        </a>
                    </h5>
                </div> <!-- /.panel-heading -->
                <div id="adrrerpoting-group-1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_name') }}</label>
                                <p class="text-muted"></p>
                            </div>
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_profession') }}</label>
                                <p class="text-muted"></p>
                            </div>
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_mobile') }}</label>
                                <p class="text-muted"></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_district') }}</label>
                                <p class="text-muted"></p>
                            </div>
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_upazila') }}</label>
                                <p class="text-muted"></p>
                            </div>
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_union') }}</label>
                                <p class="text-muted"></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_email') }}</label>
                                <p class="text-muted"></p>
                            </div>
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_address') }}</label>
                                <p class="text-muted"></p>
                            </div>
                            <div class="col-sm-4">
                                <label class="text-bold">{{ trans('counterfeit.label_reporter_postcode') }}</label>
                                <p class="text-muted"></p>
                            </div>
                        </div>
                    </div> <!-- /.panel-body -->
                </div>
            </div> <!-- /.panel panel-flat -->
            <!-- /PANEL #1 | Reporter -->

            <!-- PANEL #2 | PRODUCT & INCIDENT -->
            <div class="panel panel-white border-top-xlg border-top-slate">
                <div class="panel-heading">
                    <h5 class="panel-title text-slate">
                        <a data-toggle="collapse" href="#adrrerpoting-group-3" aria-expanded="true">
                            <i class="icon-file-text"></i> {{ trans('counterfeit.title_incident_medicine') }}
                        </a>
                    </h5>
                </div> <!-- /.panel-heading -->
                <div id="adrrerpoting-group-3" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <fieldset>
                            <legend class="text-bold text-slate">{{ trans('counterfeit.title_incident') }}</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="text-bold">{{ trans('counterfeit.label_is_incident') }}</label>
                                    <ul class="list-unstyled text-muted">

                                    </ul>

                                </div>

                                <div class="col-sm-6">
                                    <label class="text-bold">{{ trans('counterfeit.label_incident_details') }}</label>
                                    <div class="text-muted"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-bold text-slate">{{ trans('counterfeit.title_product') }}</legend>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_suspected_medicine') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_generic') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_manufacaturer') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_batch_lot') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_license_number') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_unique_number') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_dar_number') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-sm-3">
                                    <label class="text-bold">{{ trans('counterfeit.label_expiry_dt') }}</label>
                                    <p class="text-muted"></p>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-bold text-slate">{{ trans('counterfeit.title_dosage') }}</legend>
                            <div class="row">

                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-bold text-slate">{{ trans('counterfeit.title_purchase') }}</legend>
                            <div class="row">

                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-bold text-slate">{{ trans('counterfeit.title_adverse_effects') }}</legend>
                            <div class="row">

                            </div>
                        </fieldset>

                    </div> <!-- /.panel-body -->
                </div>
            </div> <!-- /.panel panel-flat -->
            <!-- /PANEL #2 | PRODUCT & INCIDENT -->

        </div> <!-- /.panel-group -->

    </div> <!-- /.panel-body -->

</div> <!-- /.panel panel-flat -->
<script type="application/javascript">

    $(document).ready(function(){
        $("#btnReset").on('click', function (e) {
            $("#progressouter").empty();
            $("#report_content").empty();
        });
    })///
    $(function () {
        var options = {
            type: 'POST',
            async: false,
            beforeSubmit: function () {
                $("#progressouter").append("<div id='divAjaxLoading'>Please wait. File Uploading ...</div>");
            },
            success: function (data) {
                console.log(data)
                $("#progressouter").empty();
                $('#report_content').html(data);

                if (data.toastr_error) {
                    toastr[data.toastr_error](data.message, data.title);
                    return;
                }
                if (data.toastr_warning) {
//                   // alert(data.message)
//                    $('#message').show();
//                    $('#message').text(data.message)
                    toastr[data.toastr_warning](data.message, data.title);
                    return;
                }
                if (data.toastr_success) {
                    toastr[data.toastr_success](data.message, data.title);
                    return;
                }

            }
        };

        $("#btnSave").click(function (e) {
            $("#report_content").empty();
            if ($("#frmImport").valid()) {
                e.preventDefault();
                $("#frmImport").ajaxSubmit(options);
            }
        });

    });

</script>