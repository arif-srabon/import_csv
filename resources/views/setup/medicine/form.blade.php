<div class="row">
    <div class="col-md-12">
        <fieldset>
            <legend class="text-semibold"><i
                        class="icon-bookmark4 position-left"></i> {{ trans('setup/medicine.gr_medicine_info') }}</legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('name', trans('setup/medicine.label_medicine')) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))<p class="text-danger">{!!$errors->first('name')!!}</p>@endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('generic_id', trans('setup/medicine.label_generic')) !!}
                        {!! Form::select('generic_id', $generic, null, ['placeholder' => trans('setup/medicine.ph_select'), 'class' => 'select form-control']) !!}
                        @if ($errors->has('generic_id'))<p
                                class="text-danger">{!!$errors->first('generic_id')!!}</p>@endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('medicine_type_id', trans('setup/medicine.label_medicine_type')) !!}
                        {!! Form::select('medicine_type_id', $medicine_type, null, ['placeholder' => trans('setup/medicine.ph_select'), 'class' => 'select form-control']) !!}
                        @if ($errors->has('medicine_type_id'))<p
                                class="text-danger">{!!$errors->first('medicine_type_id')!!}</p>@endif
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('code', trans('setup/medicine.label_code')) !!}
                        {!! Form::text('code', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('code'))<p class="text-danger">{!!$errors->first('code')!!}</p>@endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('price', trans('setup/medicine.label_price')) !!}
                        {!! Form::text('price', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('price'))<p
                                class="text-danger">{!!$errors->first('price')!!}</p>@endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('manufactuer_id', trans('setup/medicine.label_manufacture')) !!}
                        {!! Form::select('manufactuer_id', $manufacturer, null, ['placeholder' => trans('setup/medicine.ph_select'), 'class' => 'select form-control']) !!}
                        @if ($errors->has('manufactuer_id'))<p class="text-danger">{!!$errors->first('manufactuer_id')!!}</p>@endif
                    </div>
                </div>
            </div>

        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <fieldset>
            <legend class="text-semibold"><i
                        class="icon-reading position-left"></i> {{ trans('setup/medicine.gr_medicine_details') }}</legend>

            <div class="form-group">
                {!! Form::label('presentation', trans('setup/medicine.lbl_presentation')) !!}
                {!! Form::textarea('presentation', null, ['class' => 'form-control', 'rows'=>'2']) !!}
                @if ($errors->has('presentation'))<p class="text-danger">{!!$errors->first('presentation')!!}</p>@endif
            </div>

            <div class="form-group">
                {!! Form::label('descriptions', trans('setup/medicine.lbl_descriptions')) !!}
                {!! Form::textarea('descriptions', null, ['class' => 'form-control', 'rows'=>'2']) !!}
                @if ($errors->has('descriptions'))<p class="text-danger">{!!$errors->first('descriptions')!!}</p>@endif
            </div>

            <div class="form-group">
                {!! Form::label('indications', trans('setup/medicine.lbl_Indications')) !!}
                {!! Form::textarea('indications', null, ['class' => 'form-control', 'rows'=>'2']) !!}
                @if ($errors->has('indications'))<p class="text-danger">{!!$errors->first('indications')!!}</p>@endif
            </div>

            <div class="form-group">
                {!! Form::label('dosage_administration', trans('setup/medicine.lbl_administration')) !!}
                {!! Form::textarea('dosage_administration', null, ['class' => 'form-control', 'rows'=>'2']) !!}
                @if ($errors->has('dosage_administration'))<p class="text-danger">{!!$errors->first('dosage_administration')!!}</p>@endif
            </div>

            <div class="form-group">
                {!! Form::label('side_effects', trans('setup/medicine.lbl_side_effects')) !!}
                {!! Form::textarea('side_effects', null, ['class' => 'form-control', 'rows'=>'2']) !!}
                @if ($errors->has('side_effects'))<p class="text-danger">{!!$errors->first('side_effects')!!}</p>@endif
            </div>

            <div class="form-group">
                {!! Form::label('precaution', trans('setup/medicine.lbl_precaution')) !!}
                {!! Form::textarea('precaution', null, ['class' => 'form-control', 'rows'=>'2']) !!}
                @if ($errors->has('precaution'))<p class="text-danger">{!!$errors->first('precaution')!!}</p>@endif
            </div>
            

 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="display-block text-semibold">{{ trans('setup/medicine.lbl_status') }}</label>
                        <label class="radio-inline">
                            <div class="choice">
                                {!! Form::radio('status', 1, true,  ['class' => 'styled']) !!}
                            </div>
                            {{ trans('setup/medicine.lbl_active') }}
                        </label>
                        <label class="radio-inline">
                            <div class="choice">
                                {!! Form::radio('status', 0, null,  ['class' => 'styled']) !!}
                            </div>
                            {{ trans('setup/medicine.lbl_inactive') }}
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset>
            <legend class="text-semibold"><i
                        class="icon-camera position-left"></i>{{ trans('setup/medicine.lbl_user_photo') }}</legend>
            <div class="row">

                <div class="col-md-9">
                    <div class="thumbnail">
                        <div class="thumb thumb-slide">
                            <?php
                            $userPhotoPath = (!empty($medicine->medicine_image_path)) ? $medicine->medicine_image_path : "";
                            ?>
                            <img src="{{ asset(ImageManager::getImagePath($userPhotoPath, 250, 200, 'crop')) }}" alt=""
                                 id="preview_user_image">
                        </div>
                        <div class="caption text-center">
                            <div class="form-group">
                                <label>{{ trans('setup/medicine.lbl_upload_photo') }}</label>

                                <div class="uploader">
                                    {!! Form::file('user_photo', ['id' => 'user_photo', 'class' => 'file-styled']) !!}
                                    @if ($errors->has('user_photo'))<p
                                            class="text-danger">{!!$errors->first('user_photo')!!}</p>@endif
                                </div>
                    <span class="help-block">
                    Allow File: jpg, jpeg, png. Max Size: 800KB. <br> Max Dimension: h:600px X w:600px
                    </span></div>
                        </div>
                    </div>
                </div>

            </div>


        </fieldset>
    </div>
</div>


<div class="text-right">
    {!! Form::hidden('id') !!}
    <button id="reset" class="btn btn-default" type="reset"> {{ trans('setup/medicine.btn_reset') }} <i
                class="icon-reload-alt position-right"></i></button>
    <button class="btn btn-primary" type="submit"> {{ trans('setup/medicine.btn_save') }} <i
                class="icon-arrow-right14 position-right"></i></button>
</div>

<script type="application/javascript">

    $(document).ready(function () {
 

    });

</script>