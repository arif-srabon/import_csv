<div class="row">
    <div class="col-md-12">
        <fieldset>
            <legend class="text-semibold"><i
                        class="icon-bookmark4 position-left"></i> {{ trans('users/user.lbl_user_identity') }}</legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('full_name', trans('users/user.lbl_user_full_name')) !!}
                        {!! Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => trans('users/user.ph_full_name')]) !!}
                        @if ($errors->has('full_name'))<p
                                class="text-danger">{!!$errors->first('full_name')!!}</p>@endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('department_id', trans('users/user.lbl_department')) !!}
                        {!! Form::select('department_id', $department, null, ['placeholder' => trans('users/user.ph_department'), 'class' => 'select form-control']) !!}
                        @if ($errors->has('department_id'))<p
                                class="text-danger">{!!$errors->first('department_id')!!}</p>@endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('designation_id', trans('users/user.lbl_desg')) !!}
                        {!! Form::select('designation_id', $designation, null, ['placeholder' => trans('users/user.ph_designation'), 'class' => 'select form-control']) !!}
                        @if ($errors->has('designation_id'))<p
                                class="text-danger">{!!$errors->first('designation_id')!!}</p>@endif
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('email', trans('users/user.lbl_username')) !!}

                        <?php if (!empty($user)) { ?>
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('users/user.ph_user_for_login'),'readonly'=> 'readonly']) !!}
                        <?php } else {?>
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('users/user.ph_user_for_login')]) !!}
                        <?php } ?>
                        @if ($errors->has('email'))<p class="text-danger">{!!$errors->first('email')!!}</p>@endif
                    </div>
                </div>

                <div class="col-md-4">

                </div>

                <div class="col-md-4">

                </div>
            </div>

        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <fieldset>
            <legend class="text-semibold"><i
                        class="icon-reading position-left"></i> {{ trans('users/user.lbl_personal_details') }}</legend>

            <div class="form-group">
                {!! Form::label('manufacturer_id', trans('users/user.lbl_manufacturer')) !!}
                {!! Form::select('manufacturer_id', $manufacturer, null, ['placeholder' => trans('users/user.ph_manufacturer'), 'class' => 'select form-control']) !!}
                @if ($errors->has('manufacturer_id'))<p
                        class="text-danger">{!!$errors->first('manufacturer_id')!!}</p>@endif
            </div>

            <div class="form-group">
                {!! Form::label('official_email', trans('users/user.lbl_email')) !!}
                {!! Form::email('official_email', null, ['class' => 'form-control', 'placeholder' => 'user@example.com']) !!}
                @if ($errors->has('official_email'))<p
                        class="text-danger">{!!$errors->first('official_email')!!}</p>@endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('mobile', trans('users/user.lbl_mobile')) !!}
                        {!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => '+88-0123-456789']) !!}
                        @if ($errors->has('mobile'))<p class="text-danger">{!!$errors->first('mobile')!!}</p>@endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('national_id', trans('users/user.lbl_nid')) !!}
                        {!! Form::text('national_id', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        @if ($errors->has('national_id'))<p
                                class="text-danger">{!!$errors->first('national_id')!!}</p>@endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('office_phone', trans('users/user.lbl_office_phone')) !!}
                        {!! Form::text('office_phone', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('office_phone'))<p
                                class="text-danger">{!!$errors->first('office_phone')!!}</p>@endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('home_phone', trans('users/user.lbl_home_phone')) !!}
                        {!! Form::text('home_phone', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        @if ($errors->has('home_phone'))<p
                                class="text-danger">{!!$errors->first('home_phone')!!}</p>@endif
                    </div>
                </div>
            </div>


        </fieldset>


    </div>
    <div class="col-md-4">
        <fieldset>
            <legend class="text-semibold"><i
                        class="icon-camera position-left"></i>{{ trans('users/user.lbl_user_photo') }}</legend>
            <div class="row">

                <div class="col-md-9">
                    <div class="thumbnail">
                        <div class="thumb thumb-slide">
                            <?php
                            $userPhotoPath = (!empty($user->user_photo)) ? $user->user_photo : "";
                            ?>
                            <img src="{{ asset(ImageManager::getImagePath($userPhotoPath, 250, 200, 'crop')) }}" alt=""
                                 id="preview_user_image">
                        </div>
                        <div class="caption text-center">
                            <div class="form-group">
                                <label>{{ trans('users/user.lbl_upload_photo') }}</label>

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
    <button id="reset" class="btn btn-default" type="reset"> {{ trans('users/user.btn_reset') }} <i
                class="icon-reload-alt position-right"></i></button>
    <button class="btn btn-primary" type="submit"> {{ trans('users/user.btn_save') }} <i
                class="icon-arrow-right14 position-right"></i></button>
</div>

