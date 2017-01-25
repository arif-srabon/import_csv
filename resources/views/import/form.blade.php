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