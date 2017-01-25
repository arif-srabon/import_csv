<div class="row">
  <div class="col-md-12">
    <div class="form-group"> {!! Form::label('title', trans('trans/medicinecode.lbl_medicine')) !!} *
     {!! Form::select('medicine_id', $medicines, null, ['placeholder' => trans('trans/medicinecode.select_medicine'), 'class' => 'select form-control']) !!}
      @if ($errors->has('medicine_id'))
      <p class="text-danger">{!!$errors->first('medicine_id')!!}</p>
      @endif </div>
    <div class="row">
      <div class="col-md-4">  
      	<div class="form-group"> {!! Form::label('title', trans('trans/medicinecode.lbl_lot_no')) !!} *
      {!! Form::text('batch_lot_no', null, ['class' => 'form-control', 'placeholder' => '']) !!}
      @if ($errors->has('batch_lot_no'))
      <p class="text-danger">{!!$errors->first('batch_lot_no')!!}</p>
      @endif </div>
       </div>
      <div class="col-md-4">
       <div class="form-group"> {!! Form::label('title', trans('trans/medicinecode.lbl_total_count')) !!} *
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
  <div class="col-md-12"> </div>
  <div class="text-right"> {!! Form::hidden('id') !!}
    <button id="reset" class="btn btn-default" type="reset"> {{ trans('trans/medicinecode.btn_reset') }} <i
                class="icon-reload-alt position-right"></i></button>
    <button class="btn btn-primary" type="submit"> {{ trans('trans/medicinecode.btn_save') }} <i
                class="icon-arrow-right14 position-right"></i></button>
  </div>
</div>
