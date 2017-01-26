<div class="panel panel-default">

    <div class="panel-body">

        <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="adrrerpoting-accordion">

            <!-- PANEL #1 | Reporter -->
            <div class="panel panel-white border-top-xlg border-top-slate">
                <div class="panel-heading">
                    <h5 class="panel-title text-slate">
                        <a data-toggle="collapse" href="#adrrerpoting-group-1" aria-expanded="true">
                            <i class="icon-user"></i> {{ trans('users/user.lbl_user_identity') }}
                        </a>
                    </h5>
                </div> <!-- /.panel-heading -->
                <div id="adrrerpoting-group-1" class="panel-collapse collapse in">
                    <div class="panel-body">
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
                                    {!! Form::label('full_name_bn', trans('users/user.lbl_user_full_name')) !!}
                                    {!! Form::text('full_name_bn', null, ['class' => 'form-control', 'placeholder' => trans('users/user.ph_full_name')]) !!}
                                    @if ($errors->has('full_name_bn'))<p
                                            class="text-danger">{!!$errors->first('name_en')!!}</p>@endif
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
                                <div class="form-group">
                                    {!! Form::label('password', trans('users/user.lbl_password')) !!}
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('users/user.ph_password')]) !!}
                                    @if ($errors->has('password'))<p class="text-danger">{!!$errors->first('password')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('password_confirmation', trans('users/user.lbl_conf_password')) !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('users/user.ph_retype_password')]) !!}
                                    @if ($errors->has('password_confirmation'))<p
                                            class="text-danger">{!!$errors->first('password_confirmation')!!}</p>@endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                                    {!! Form::label('official_email', trans('users/user.lbl_email')) !!}
                                    {!! Form::email('official_email', null, ['class' => 'form-control', 'placeholder' => 'user@example.com']) !!}
                                    @if ($errors->has('official_email'))<p
                                            class="text-danger">{!!$errors->first('official_email')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('office_phone', trans('users/user.lbl_office_phone')) !!}
                                    {!! Form::text('office_phone', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('office_phone'))<p
                                            class="text-danger">{!!$errors->first('office_phone')!!}</p>@endif
                                </div>
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
                        <a data-toggle="collapse" href="#adrrerpoting-group-2" aria-expanded="true">
                            <i class="icon-user-lock"></i> {{ trans('users/user.lbl_assign_role') }}
                        </a>
                    </h5>
                </div> <!-- /.panel-heading -->
                <div id="adrrerpoting-group-2" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    {!! Form::label('assigned_roles_list', trans('users/user.lbl_assign_role')) !!} *
                                    {!! Form::select('assigned_roles_list[]', $allRoles, $assignedRole, ['required' => 'required' ,'class' => 'select form-control', 'multiple']) !!}
                                </div>

                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="display-block text-semibold">{{ trans('users/user.lbl_status') }}</label>
                                    <label class="radio-inline">
                                        <div class="choice">
                                            {!! Form::radio('status', 1, true,  ['class' => 'styled']) !!}
                                        </div>
                                        {{ trans('users/user.lbl_active') }}
                                    </label>
                                    <label class="radio-inline">
                                        <div class="choice">
                                            {!! Form::radio('status', 0, null,  ['class' => 'styled']) !!}
                                        </div>
                                        {{ trans('users/user.lbl_inactive') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.panel-body -->
                </div>
            </div> <!-- /.panel panel-flat -->
            <!-- /PANEL #2 | PRODUCT & INCIDENT -->

            <!-- PANEL #3 | Personal Information -->
            <div class="panel panel-white border-top-xlg border-top-slate">
                <div class="panel-heading">
                    <h5 class="panel-title text-slate">
                        <a data-toggle="collapse" href="#adrrerpoting-group-3" aria-expanded="true">
                            <i class="icon-file-text"></i> {{ trans('users/user.lbl_personal_details') }}
                        </a>
                    </h5>
                </div> <!-- /.panel-heading -->
                <div id="adrrerpoting-group-3" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('father_name', "Father's Name") !!}
                                    {!! Form::text('father_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('father_name'))<p class="text-danger">{!!$errors->first('father_name')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('mother_name', "Mother's Name") !!}
                                    {!! Form::text('mother_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('mother_name'))<p class="text-danger">{!!$errors->first('mother_name')!!}</p>@endif
                                </div>
                            </div>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('home_phone', trans('users/user.lbl_home_phone')) !!}
                                    {!! Form::text('home_phone', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('home_phone'))<p
                                            class="text-danger">{!!$errors->first('home_phone')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('gender_id', 'Gender') !!}
                                    {!! Form::select('gender_id', $gender, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('gender_id'))<p
                                            class="text-danger">{!!$errors->first('gender_id')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('marital_status_id', 'Marital Status') !!}
                                    {!! Form::select('marital_status_id', $maritalstatus, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('marital_status_id'))<p
                                            class="text-danger">{!!$errors->first('marital_status_id')!!}</p>@endif
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('blood_group', 'Blood Group') !!}
                                    {!! Form::text('blood_group', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('blood_group'))<p
                                            class="text-danger">{!!$errors->first('blood_group')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('date_of_birth', 'Date of Birth') !!}
                                    <div class="input-group">
                                        {!! Form::text('date_of_birth', null, ['class' => 'form-control date_format']) !!}
                                        <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                    </div>
                                    @if ($errors->has('date_of_birth'))<p
                                            class="text-danger">{!!$errors->first('date_of_birth')!!}</p>@endif

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('date_of_joining', 'Date of Joining ( 1st )') !!}
                                    <div class="input-group">
                                        {!! Form::text('date_of_joining', null, ['class' => 'form-control date_format']) !!}
                                        <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                    </div>
                                    @if ($errors->has('date_of_joining'))<p
                                            class="text-danger">{!!$errors->first('date_of_joining')!!}</p>@endif
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.panel-body -->
                </div>
            </div> <!-- /.panel panel-flat -->
            <!-- /PANEL #3 | Personal Information -->


            <!-- PANEL #4 | picture -->
            <div class="panel panel-white border-top-xlg border-top-slate">
                <div class="panel-heading">
                    <h5 class="panel-title text-slate">
                        <a data-toggle="collapse" href="#adrrerpoting-group-4" aria-expanded="true">
                            <i class="icon-camera position-left"></i> {{ trans('users/user.lbl_user_photo') }}
                        </a>
                    </h5>
                </div> <!-- /.panel-heading -->
                <div id="adrrerpoting-group-4" class="panel-collapse collapse in">
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="col-md-offset-6">
                                    <div class="thumbnail">
                                        <div class="thumb text-center">
                                            <?php
                                            $userSignPath = (!empty($user->user_sign)) ? $user->user_sign : "";
                                            ?>
                                            <img src="{{ asset(ImageManager::getImagePath($userSignPath, 250, 200, 'crop')) }}"
                                                 alt="" id="preview_sign_image">
                                        </div>
                                        <div class="caption text-center">
                                            <div class="form-group">
                                                <label>Upload User signature</label>

                                                <div class="uploader">
                                                    {!! Form::file('user_sign', ['id' => 'user_sign', 'class' => 'file-styled']) !!}
                                                    @if ($errors->has('user_sign'))<p
                                                            class="text-danger">{!!$errors->first('user_sign')!!}</p>@endif
                                                </div>
                    <span class="help-block">
                    Allow File: jpg, jpeg, png. Max Size: 800KB. <br> Max Dimension: h:600px X w:600px
                    </span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div> <!-- /.panel-body -->
                </div>
            </div> <!-- /.panel panel-flat -->
            <!-- /PANEL #4 | picture -->


            <!-- PANEL #5 | Address -->
            <div class="panel panel-white border-top-xlg border-top-slate">
                <div class="panel-heading">
                    <h5 class="panel-title text-slate">
                        <a data-toggle="collapse" href="#adrrerpoting-group-4" aria-expanded="true">
                            <i class="icon-address-book2"></i> User Address
                        </a>
                    </h5>
                </div> <!-- /.panel-heading -->
                <div id="adrrerpoting-group-4" class="panel-collapse collapse in">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <legend class="text-semibold text-slate"><i class="icon-home position-left"></i> Permanent Address</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('permanent_house_road', 'House / Road') !!}
                                                {!! Form::text('permanent_house_road', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                                @if ($errors->has('permanent_house_road'))<p
                                                        class="text-danger">{!!$errors->first('permanent_house_road')!!}</p>@endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('permanent_village', 'Village') !!}
                                                {!! Form::text('permanent_village', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                                @if ($errors->has('permanent_village'))<p
                                                        class="text-danger">{!!$errors->first('permanent_village')!!}</p>@endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('permanent_division', 'Division') !!}
                                                {!! Form::select('permanent_division', $divisionList, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('permanent_division'))<p
                                                        class="text-danger">{!!$errors->first('permanent_division')!!}</p>@endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('permanent_district', 'District') !!}
                                                {!! Form::select('permanent_district', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('permanent_district'))<p
                                                        class="text-danger">{!!$errors->first('permanent_district')!!}</p>@endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('permanent_upzilla', 'Upazila / Thana') !!}
                                                {!! Form::select('permanent_upzilla', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('permanent_upzilla'))<p
                                                        class="text-danger">{!!$errors->first('permanent_upzilla')!!}</p>@endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('permanent_ward', 'Ward') !!}
                                                {!! Form::select('permanent_ward', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('permanent_ward'))<p
                                                        class="text-danger">{!!$errors->first('permanent_ward')!!}</p>@endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('permanent_postcode', 'Postcode') !!}
                                                {!! Form::text('permanent_postcode', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                                @if ($errors->has('permanent_postcode'))<p
                                                        class="text-danger">{!!$errors->first('permanent_postcode')!!}</p>@endif
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <legend class="text-semibold text-slate"><i class="icon-flag3 position-left"></i> Present Address &nbsp;&nbsp;&nbsp;
                                    </legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('present_house_road', 'House / Road') !!}
                                                {!! Form::text('present_house_road', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                                @if ($errors->has('present_house_road'))<p
                                                        class="text-danger">{!!$errors->first('present_house_road')!!}</p>@endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('present_village', 'Village') !!}
                                                {!! Form::text('present_village', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                                @if ($errors->has('present_village'))<p
                                                        class="text-danger">{!!$errors->first('present_village')!!}</p>@endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('present_division', 'Division') !!}
                                                {!! Form::select('present_division', $divisionList, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('present_division'))<p
                                                        class="text-danger">{!!$errors->first('present_division')!!}</p>@endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('present_district', 'District') !!}
                                                {!! Form::select('present_district', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('present_district'))<p
                                                        class="text-danger">{!!$errors->first('present_district')!!}</p>@endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('present_upzilla', 'Upazila / Thana') !!}
                                                {!! Form::select('present_upzilla', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('present_upzilla'))<p
                                                        class="text-danger">{!!$errors->first('present_upzilla')!!}</p>@endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('present_ward', 'Ward') !!}
                                                {!! Form::select('present_ward', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                                @if ($errors->has('present_ward'))<p
                                                        class="text-danger">{!!$errors->first('present_ward')!!}</p>@endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('present_postcode', 'Postcode') !!}
                                                {!! Form::text('present_postcode', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                                @if ($errors->has('present_postcode'))<p
                                                        class="text-danger">{!!$errors->first('present_postcode')!!}</p>@endif
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </div> <!-- /.panel-body -->
                </div>
            </div> <!-- /.panel panel-flat -->
            <!-- /PANEL #5 | Address -->



        </div> <!-- /.panel-group -->

    </div> <!-- /.panel-body -->

</div> <!-- /.panel panel-flat -->



<div class="text-right">
    {!! Form::hidden('id') !!}
    <button id="reset" class="btn btn-default" type="reset"> {{ trans('users/user.btn_reset') }} <i
                class="icon-reload-alt position-right"></i></button>
    <button class="btn btn-primary" type="submit"> {{ trans('users/user.btn_save') }} <i
                class="icon-arrow-right14 position-right"></i></button>
</div>

<script type="application/javascript">

    $(document).ready(function () {
 
        if ($("#full_name").val() == '') {
            $("#email").val('');
            $("#password").val('');
        }
        $(function () {
            $(".date_format").datetimepicker({
                format: "DD-MM-YYYY"
            });
        });
    });

</script>