@extends('layouts.master')
@section('page_title', trans('trans/medicinecode.title'))
@section('menu_medicinecode','active')


@section('page_header') <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('trans/medicinecode.title') }}</span> @endsection

@section('breadcrumb_links')
    @if (SentinelAuth::check('manufacturer.uniquenumber.view'))
	    <li><a href="{{url('medicinecode')}}">
      <button class="btn btn-info btn-labeled btn-xs" type="button"><b><i class="icon-file-spreadsheet2"></i></b> {{ trans('trans/medicinecode.btn_list') }}</button>
      </a></li>
  @endif
@endsection



@section('content') 

 {!! Form::open(['url' => 'medicinecode', 'method' => 'post', 'id' =>'frm_medicinecode', 'name' =>'frm_medicinecode', 'target' => '_blank']) !!}
 <div class="panel-group panel-group-control content-group-lg" id="accordion-control">
  <div class="panel panel-white">
     <div class="panel-heading">
      <h6 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group1"> {{config('app_config.lbl_generate_report')}} </a> </h6>
    </div>
     <div id="accordion-control-group1" class="panel-collapse collapse in">
      <div class="panel-body">
         <div class="row">
          <div class="col-md-12">
             <div class="form-group"> {!! Form::label('medicine_id', trans('trans/medicinecode.lbl_medicine')) !!} *
              {!! Form::select('medicine_id', $medicines, null, ['placeholder' => trans('trans/medicinecode.select_medicine'), 'class' => 'select form-control']) !!}
              @if ($errors->has('medicine_id'))
              <p class="text-danger">{!!$errors->first('medicine_id')!!}</p>
              @endif </div>
             <div class="row">
              <div class="col-md-4">
                 <div class="form-group"> {!! Form::label('batch_lot_no', trans('trans/medicinecode.lbl_lot_no')) !!} *
                  {!! Form::text('batch_lot_no', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                  @if ($errors->has('batch_lot_no'))
                  <p class="text-danger">{!!$errors->first('batch_lot_no')!!}</p>
                  @endif </div>
               </div>
              <div class="col-md-4">
                 <div class="form-group"> {!! Form::label('total_codes', trans('trans/medicinecode.lbl_total_count')) !!} *
                  {!! Form::text('total_codes', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                  @if ($errors->has('total_codes'))
                  <p class="text-danger">{!!$errors->first('total_codes')!!}</p>
                  @endif </div>
               </div>
              <div class="col-md-4">
                 <div class="form-group"> {!! Form::label('generate_date', trans('trans/medicinecode.lbl_generate_dt')) !!} *
                  <div class="input-group"> {!! Form::text('generate_date', null, ['class' => 'form-control daterange-single daterange-left']) !!} <span class="input-group-addon"><i class="icon-calendar22"></i></span> </div>
                  @if ($errors->has('generate_date'))
                  <p
                            class="text-danger">{!!$errors->first('generate_date')!!}</p>
                  @endif </div>
               </div>
            </div>
           </div>
        </div>
         <div class="text-right" style="padding-bottom:10px; padding-right:10px">
          <button class="btn btn-default" type="button" id="btnReset"
                                onClick="this.form.reset()"> {{ trans('trans/medicinecode.btn_reset') }} <i
                                    class="icon-reload-alt position-right"></i> </button>
          <div class="btn-group">
             <button class="btn btn-primary" type="button" id="btnPreview"><i
                                        class="icon-display4 position-left"></i> {{ trans('trans/medicinecode.btn_save') }} </button>
                 <!--   <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button"
                                    aria-expanded="false"><span class="caret"></span></button>
      <ul class="dropdown-menu dropdown-menu-right">
              <li><a href="#" id="btnPdfExport"><i
                                                class="icon-file-pdf"></i> Export to pdf</a> </li>
              <li><a href="#" id="btnXlsExport"><i
                                                class="icon-file-excel"></i> Export to xls</a> </li>
              <li class="divider"></li>
              <li><a href="#" id="btnPrint"><i
                                                class="icon-printer2"></i> Print</a></li>
            </ul>-->
           </div>
        </div>
       </div>
    </div>
   </div>
</div>
    {!! Form::hidden('hidExportType', 'preview', ['id' => 'hidExportType']) !!}
    {!! Form::hidden('hidProgram', null, ['id' => 'hidProgram']) !!}
    {!! Form::close() !!}
    <div class="panel-group panel-group-control content-group-lg" id="accordion-control-show">
  <div class="panel panel-white">
        <div class="panel-heading">
      <h6 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion-control-show"
                       href="#accordion-control-group2"> Generated Medicine Codes </a> </h6>
    </div>
        <div id="accordion-control-group2" class="panel-collapse collapse in">
      <div class="panel-body">
            <div id="progressouter"></div>
            <div id="report_content"> @if(isset($info))
          @include('partials.reports')
          @endif </div>
          </div>
    </div>
      </div>
</div>
    <script>

        $(function () {

            $('#reportForm input').keydown(function (e) {
                if (e.keyCode == 13) {
                    $('#btnPreview').trigger('click');
                }
            });

            jQuery("#frm_medicinecode").validate({
                rules: {
					medicine_id: {
						required: true                
					},
					batch_lot_no: {
						required: true               
					},
					generate_date: {
						required: true,
						dateBD:true
					},
					total_codes: {
						required: true,
						digits: true
					} 
                },
                messages: {                   
                }
            });

            var options = {
                type: 'POST',
                async: false,
                beforeSubmit: function () {
                    $("#progressouter").append("<div id='divAjaxLoading'>Please wait. Generating Unique Codes ...</div>");
                },
                success: function (data) {
                    $("#progressouter").empty();
                    $('#report_content').html(data);
                }
            };

            $("#btnPreview").click(function () {
                $("#hidProgram").val($("#allocation_program_id option:selected").text());
                $("#hidInstallment").val($("#installment_id option:selected").text());

                if ($("#frm_medicinecode").valid()) {
                    $("#frm_medicinecode").ajaxSubmit(options);
                }
            });


            $("#btnPdfExport").click(function () {
                if ($("#frm_medicinecode").valid()) {
                    $("#hidExportType").val('exportPDF');
                    $("#frm_medicinecode").submit();
                }
            });

            $("#btnXlsExport").click(function () {
                if ($("#frm_medicinecode").valid()) {
                    $("#hidExportType").val('exportXLS');
                    $("#frm_medicinecode").submit();
                }
            });

            $("#btnPrint").click(function () {
                if ($("#frm_medicinecode").valid()) {
                    $("#hidExportType").val('exportPrint');
                    $("#frm_medicinecode").submit();
                }
            });
			
			  // Reset form
			$('#reset').on('click', function() {
				validator.resetForm();
			});

        });


    </script> 
    @endsection