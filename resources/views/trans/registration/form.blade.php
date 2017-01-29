
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            {!! Form::label('client_id', "Client ID No. *") !!}
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div style="padding-right: 0px;" class="col-md-3">
                                    {!! Form::text('client_prefix', @isset($prefix) ? $prefix :null, ['readonly'=>'readonly','class' => 'form-control','id'=>'prefixId']) !!}
                                </div>

                                <div style="padding-left: 0px;" class="col-md-9">
                                    <?php
                                    $client_id = (!empty($client_id)) ? $client_id : null;
                                    ?>
                                    {!! Form::text('client_id', $client_id, ['class' => 'form-control', 'placeholder' => '']) !!}
                                </div>
                            </div>

                            <p id="messageClientId" class="text-danger"></p>
                            @if ($errors->has('client_id'))<p class="text-danger">{!!$errors->first('client_id')!!}</p>@endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('department_id', 'Select Department *') !!}
                            {!! Form::select('department_id', $department, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                            @if ($errors->has('department_id'))<p
                                    class="text-danger">{!!$errors->first('department_id')!!}</p>@endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('registration_date', 'Registration Date *') !!}
                            <div class="input-group">
                                {!! Form::text('registration_date', null, ['class' => 'form-control date_format']) !!}
                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                            </div>
                            @if ($errors->has('registration_date'))<p
                                    class="text-danger">{!!$errors->first('registration_date')!!}</p>@endif

                        </div>
                    </div>

        </div>
<!-- PANEL #1 | Reporter -->
<div class="panel panel-white border-top-xlg border-top-slate">
    <div class="panel-heading">
        <h5 class="panel-title text-slate">
            <a data-toggle="collapse" href="#adrrerpoting-group-1" aria-expanded="true">
                <i class="icon-user"></i> {{ trans('trans/registration.head_client_information') }}
            </a>
        </h5>
    </div> <!-- /.panel-heading -->
    <div id="adrrerpoting-group-1" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-9">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('client_name', "Client Name ( English ) *") !!}
                                    {!! Form::text('client_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('client_name'))<p
                                            class="text-danger">{!!$errors->first('client_name')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('client_name_bn', "Client Name ( Bangla )") !!}
                                    {!! Form::text('client_name_bn', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('client_name_bn'))<p
                                            class="text-danger">{!!$errors->first('client_name_bn')!!}</p>@endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('mobile', 'Mobile No. *') !!}
                                    {!! Form::text('mobile', null, ['placeholder' => '015*******', 'class' => 'form-control']) !!}
                                    @if ($errors->has('mobile'))<p
                                            class="text-danger">{!!$errors->first('mobile')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', 'E - mail') !!}
                                    {!! Form::text('email', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                                    @if ($errors->has('email'))<p
                                            class="text-danger">{!!$errors->first('home_phone')!!}</p>@endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('date_of_birth', 'Date of Birth *') !!}
                                    <div class="input-group">
                                        {!! Form::text('date_of_birth', null, ['class' => 'form-control date_format']) !!}
                                        <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                    </div>
                                    @if ($errors->has('date_of_birth'))<p
                                            class="text-danger">{!!$errors->first('date_of_birth')!!}</p>@endif

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('age', "Age") !!}
                                    {!! Form::text('age', null, ['readonly'=>'readonly','class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('gender_id', 'Gender *') !!}
                                    {!! Form::select('gender_id', $gender, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('gender_id'))<p
                                            class="text-danger">{!!$errors->first('gender_id')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('marital_status_id', 'Marital Status *') !!}
                                    {!! Form::select('marital_status_id', $maritalstatus, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('marital_status_id'))<p
                                            class="text-danger">{!!$errors->first('marital_status_id')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('birth_certificate_no', "Birth Registration No./Certificate No.") !!}
                                    {!! Form::text('birth_certificate_no', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('birth_certificate_no'))<p
                                            class="text-danger">{!!$errors->first('birth_certificate_no')!!}</p>@endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('father_name', "Father's Name ( English )") !!}
                                    {!! Form::text('father_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('father_name'))<p
                                            class="text-danger">{!!$errors->first('father_name')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('father_phone', "Father's Phone No.") !!}
                                    {!! Form::text('father_phone', null, ['class' => 'form-control', 'placeholder' => '019*******']) !!}
                                    @if ($errors->has('father_phone'))<p
                                            class="text-danger">{!!$errors->first('father_phone')!!}</p>@endif
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('mother_name', "Mother's Name ( English )") !!}
                                    {!! Form::text('mother_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('mother_name'))<p
                                            class="text-danger">{!!$errors->first('mother_name')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('mother_phone', "Mother's Phone No.") !!}
                                    {!! Form::text('mother_phone', null, ['class' => 'form-control', 'placeholder' => '019*******']) !!}
                                    @if ($errors->has('mother_phone'))<p
                                            class="text-danger">{!!$errors->first('mother_phone')!!}</p>@endif
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('guardian_name', "Guardian Name ( English )") !!}
                                    {!! Form::text('guardian_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('guardian_name'))<p
                                            class="text-danger">{!!$errors->first('guardian_name')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('guardian_phone', "Guardian Phone No.") !!}
                                    {!! Form::text('guardian_phone', null, ['class' => 'form-control', 'placeholder' => '019*******']) !!}
                                    @if ($errors->has('guardian_name_bn'))<p
                                            class="text-danger">{!!$errors->first('guardian_phone')!!}</p>@endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('religion_id', 'Religion') !!}
                                    {!! Form::select('religion_id', $religionlist, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('religion_id'))<p
                                            class="text-danger">{!!$errors->first('religion_id')!!}</p>@endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('national_id_type', 'National ID Type') !!}
                                    {!! Form::select('national_id_type', array('Client' => 'Client', 'Father' => 'Father','Mother'=>'Mother','Husband'=>'Husband','Guardian'=>'Guardian'), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('national_id_type'))<p
                                            class="text-danger">{!!$errors->first('national_id_type')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('national_id', "National ID ( NID )") !!}
                                    {!! Form::text('national_id', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('national_id'))<p
                                            class="text-danger">{!!$errors->first('national_id')!!}</p>@endif
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-3">
                    <fieldset>
                        <legend class="text-semibold">
                            <i class="icon-camera position-left"></i> Client Photo
                        </legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="thumbnail">
                                    <div class="thumb text-center">
                                        <?php
                                        $imgPath = (!empty($Registration->client_photo)) ? $Registration->client_photo : "";
                                        ?>
                                        <img src="{{ asset(ImageManager::getImagePath($imgPath, 200, 200, 'crop')) }}"
                                             alt="Client Photo" id="preview_image">
                                    </div>

                                    <div class="caption text-center">
                                        <div class="form-group">
                                            <label>Upload Client Photo</label>

                                            <div class="uploader">
                                                {!! Form::file('client_photo', ['id' => 'logo_image', 'class' => 'file-styled']) !!}
                                                @if ($errors->has('client_photo'))
                                                    <p class="text-danger">{!!$errors->first('client_photo')!!}</p>
                                                @endif
                                            </div>
                                                  <span class="help-block">
                                                      Allow File: jpg, jpeg, png. Max Size: 800KB. <br> Max Dimension: h:600px X w:600px
                                                  </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <label class="display-block text-semibold">Status</label>
                        <label class="radio-inline">
                            <div class="">
                                {!! Form::radio('status', 'active', true,['class'=>'styled']) !!}
                            </div>
                            Active
                        </label>

                        <label class="radio-inline">
                            <div class="">
                                {!! Form::radio('status', 'inactive',null,['class'=>'styled']) !!}
                            </div>
                            Inactive
                        </label>
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
                <i class="icon-user"></i> {{ trans('trans/registration.head_contact_details') }}
            </a>
        </h5>
    </div> <!-- /.panel-heading -->
    <div id="adrrerpoting-group-2" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="row">
                <fieldset>
                        <legend class="text-slate"><i
                                    class="icon-user-check position-left"></i> Permanent Address</legend>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('house_no', "House No. *") !!}
                                    {!! Form::text('house_no', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('house_no'))<p
                                            class="text-danger">{!!$errors->first('house_no')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('village', "Village") !!}
                                    {!! Form::text('village', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    @if ($errors->has('village'))<p
                                            class="text-danger">{!!$errors->first('village')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('division_id', 'Division *') !!}
                                    {!! Form::select('division_id', $divisionList, null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('division_id'))<p
                                            class="text-danger">{!!$errors->first('division_id')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('district_id', 'District *') !!}
                                    {!! Form::select('district_id',array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('district_id'))<p
                                            class="text-danger">{!!$errors->first('district_id')!!}</p>@endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('upazilla_id', 'Upazila / Thana *') !!}
                                    {!! Form::select('upazilla_id', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('upazilla_id'))<p
                                            class="text-danger">{!!$errors->first('upazilla_id')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('ward', 'Ward') !!}
                                    {!! Form::select('ward', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
                                    @if ($errors->has('ward'))<p
                                            class="text-danger">{!!$errors->first('ward')!!}</p>@endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('post_code', 'Postcode *') !!}
                                    {!! Form::text('post_code', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                                    @if ($errors->has('post_code'))<p
                                            class="text-danger">{!!$errors->first('post_code')!!}</p>@endif
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-md-12">
                        </br></br>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <legend class="text-slate"><i
                                                class="icon-user-check position-left"></i> Present Address</legend>

                                    <div class="form-group">
                                        {!! Form::label('present_address', 'Present Address') !!}
                                        {!! Form::textarea('present_address', null, ['class' => 'form-control', 'placeholder' => '', 'rows'=>'3']) !!}
                                        @if ($errors->has('present_address'))<p
                                                class="text-danger">{!!$errors->first('present_address')!!}</p>@endif
                                    </div>

                                </fieldset>
                            </div>
                        </div>



                    </div>
                </fieldset>
            </div>

        </div> <!-- /.panel-body -->
    </div>
</div> <!-- /.panel panel-flat -->
<!-- /PANEL #2 | PRODUCT & INCIDENT -->

<!-- PANEL #3 | PRODUCT & INCIDENT -->
<div class="panel panel-white border-top-xlg border-top-slate">
    <div class="panel-heading">
        <h5 class="panel-title text-slate">
            <a data-toggle="collapse" href="#adrrerpoting-group-3" aria-expanded="true">
                <i class="icon-user"></i> {{ trans('trans/registration.head_other_details') }}
            </a>
        </h5>
    </div> <!-- /.panel-heading -->
    <div id="adrrerpoting-group-3" class="panel-collapse collapse in">
        <div class="panel-body">
            {{--<div class="row">--}}
                {{--<fieldset>--}}
                    {{--<div class="col-md-6">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('education_qualification_id', 'Educational Qualification *') !!}--}}
                                    {{--{!! Form::select('education_qualification_id', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control','id'=>'EduQualification']) !!}--}}
                                    {{--@if ($errors->has('education_qualification_id'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('education_qualification_id')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<div style="margin-top:26px;" class="form-group">--}}
                                    {{--{!! Form::text('education_qualification_others', null, ['placeholder' => 'Fill when Other', 'class' => 'form-control','id'=>'EduOthers']) !!}--}}
                                    {{--@if ($errors->has('education_qualification_others'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('education_qualification_others')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('family_member', 'Number of  Family Members') !!}--}}
                                    {{--{!! Form::text('family_member', null, ['placeholder' => '', 'class' => 'form-control']) !!}--}}
                                    {{--@if ($errors->has('family_member'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('family_member')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('earning_family_member', 'Number of Earning Members') !!}--}}
                                    {{--{!! Form::text('earning_family_member', null, ['placeholder' => '', 'class' => 'form-control']) !!}--}}
                                    {{--@if ($errors->has('earning_family_member'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('earning_family_member')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}


                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('family_monthly_income_id', 'Monthly Income of the Family') !!}--}}
                                    {{--{!! Form::select('family_monthly_income_id', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control']) !!}--}}
                                    {{--@if ($errors->has('family_monthly_income_id'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('family_monthly_income_id')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-md-6">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('professional_id', 'Profession / Occupation *') !!}--}}
                                    {{--{!! Form::select('professional_id', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control','id'=>'profession']) !!}--}}
                                    {{--@if ($errors->has('professional_id'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('professional_id')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<div style="margin-top:26px;" class="form-group">--}}
                                    {{--{!! Form::text('professional_others', null, ['placeholder' => 'Fill when Other', 'class' => 'form-control','id'=>'professionOther']) !!}--}}
                                    {{--@if ($errors->has('professional_others'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('education_qualification_others')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('living_house_id', 'Type of House Living in *') !!}--}}
                                    {{--{!! Form::select('living_house_id', array(), null, ['placeholder' => 'Select', 'class' => 'select form-control','id'=>'houseLivingType']) !!}--}}
                                    {{--@if ($errors->has('living_house_id'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('living_house_id')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div style="margin-top:26px;" class="form-group">--}}
                                    {{--{!! Form::text('living_house_others', null, ['placeholder' => 'Fill when Other', 'class' => 'form-control','id'=>'houseLivingTypeOther']) !!}--}}
                                    {{--@if ($errors->has('living_house_others'))<p--}}
                                            {{--class="text-danger">{!!$errors->first('living_house_others')!!}</p>@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</fieldset>--}}
            {{--</div>--}}
        </div> <!-- /.panel-body -->
    </div>
</div> <!-- /.panel panel-flat -->
<!-- /PANEL #3 | PRODUCT & INCIDENT -->

<!-- PANEL #4 | PRODUCT & INCIDENT -->
<div class="panel panel-white border-top-xlg border-top-slate">
    <div class="panel-heading">
        <h5 class="panel-title text-slate">
            <a data-toggle="collapse" href="#adrrerpoting-group-4" aria-expanded="true">
                <i class="icon-user"></i> {{ trans('trans.registration.title_2') }}
            </a>
        </h5>
    </div> <!-- /.panel-heading -->
    <div id="adrrerpoting-group-4" class="panel-collapse collapse in">
        <div class="panel-body">





        </div> <!-- /.panel-body -->
    </div>
</div> <!-- /.panel panel-flat -->
<!-- /PANEL #4| PRODUCT & INCIDENT -->

<!-- PANEL #5 | PRODUCT & INCIDENT -->
<div class="panel panel-white border-top-xlg border-top-slate">
    <div class="panel-heading">
        <h5 class="panel-title text-slate">
            <a data-toggle="collapse" href="#adrrerpoting-group-5" aria-expanded="true">
                <i class="icon-user"></i> {{ trans('trans.registration.title_2') }}
            </a>
        </h5>
    </div> <!-- /.panel-heading -->
    <div id="adrrerpoting-group-5" class="panel-collapse collapse in">
        <div class="panel-body">





        </div> <!-- /.panel-body -->
    </div>

</div> <!-- /.panel panel-flat -->

<!-- /PANEL #5 | PRODUCT & INCIDENT -->
</br>
<div class="text-right">
    {!! Form::hidden('id') !!}
    <button id="reset" class="btn btn-default" type="reset"> {{ trans('users/user.btn_reset') }} <i
                class="icon-reload-alt position-right"></i></button>
    <button class="btn btn-primary" type="submit"> {{ trans('users/user.btn_save') }} <i
                class="icon-arrow-right14 position-right"></i></button>
</div>
<script type="application/javascript">
    $(function () {
        $(".date_format").datetimepicker({
            format: "DD-MM-YYYY"
        });
    });
    $(document).ready(function () {
        $('#age').on('focus', function () {
            var dob = $('#date_of_birth').val();
            $.ajax({
                type: "POST",
                url: "/registration/getAge",
                contentType: "application/json",
                data: JSON.stringify({date: dob}),
                cache: false
            }).done(function (data) {
                $('#age').val(data);
                //console.log(html)
            });
        });
    });

    $('#department_id').on('change', function () {
        var dpetID = $('#department_id').val();
        var data = 'dpetID=' + dpetID ;
        $.ajax({
            type: "POST",
            url: "/registration/getDepartmentCode",
            data: data,
            cache: false
        }).done(function (data) {
            $('#prefixId').val(data);
            //console.log(html)
        });
    });
</script>