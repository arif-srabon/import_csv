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

 
   {!! Form::model($medicinecodeInfo, ['method' => 'PATCH', 'url' => ['medicinecode', $medicinecodeInfo->id], 'id' =>'frm_medicinecode', 'name'=>'frm_medicinecode']) !!}
   
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
         
       </div>
    </div>
   </div>
</div>
    {!! Form::hidden('hidExportType', 'preview', ['id' => 'hidExportType']) !!}
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
            <div id="report_content"> 
    	      @if(isset($codes))
          		@include('medicinecode.generatedcode')
	          @endif 
          
          </div>
          </div>
    </div>
      </div>
</div>
     
    @endsection