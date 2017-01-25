@extends('layouts.login_registration') 

<!-- display page title --> 
@section('page_title', trans('web/login_registration.page_title_myprofile'))

@section('form_content')
<div class="register-form-area">
    <div id="content">
        <header class="box-header">
            <h3 class="login-title text-uppercase text-center">{{ trans('web/login_registration.page_title_myprofile') }}</h3>
        </header>
        @include('errors.message')    
    
        {!! Form::model($user, ['method' => 'PATCH', 'id' =>'site-register', 'name'=>'site_register', 'url' => ['savemyprofile', $user->id]]) !!}
  
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="email">{{ trans('web/login_registration.label_email') }}<sup class="text-danger">*</sup></label>
                    <?php if (!empty($user)) { ?>
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('users/user.ph_user_for_login'),'readonly'=> 'readonly']) !!}
                    <?php } else { ?>
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                    <?php } ?>
                    @if ($errors->has('email'))
                        <p class="text-danger">{!!$errors->first('email')!!}</p>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="username">{{ trans('web/login_registration.label_full_name') }}<sup class="text-danger">*</sup></label>
                    {!! Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => trans('users/user.ph_full_name')]) !!}
                    @if ($errors->has('full_name'))
                        <p class="text-danger">{!!$errors->first('full_name')!!}</p>
                    @endif
                </div>
            </div>
        </div>
         
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="profession" class="control-label">{{ trans('trans/complaint.label_profession') }}<sup class="text-danger">*</sup></label>
                    {!! Form::text('profession', null, ['class' => 'form-control', 'id' => 'profession', 'placeholder' => 'e.g. Doctor/ Pharmacist/ Student/ Housewife']) !!}
                    @if ($errors->has('profession'))
                        <p class="small text-danger">{!!$errors->first('profession')!!}</p>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
                <label for="mobile">{{ trans('web/login_registration.label_mobile') }} <sup class="text-danger">*</sup></label>
                {!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => '+88-0123-456789']) !!}
                @if ($errors->has('mobile'))
                    <p class="text-danger">{!!$errors->first('mobile')!!}</p>
                @endif </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="district-id" class="control-label">{{ trans('trans/complaint.label_district') }}<sup class="text-danger">*</sup></label>
                    {!! Form::select('district_id', $district, null, ['onChange' => 'loadUpazilla()', 'placeholder' => trans('setup/manufacturer.select_district'), 'class' => 'select form-control', 'id' => 'district-id']) !!}
                    @if ($errors->has('district_id'))
                        <p class="small text-danger">{!!$errors->first('district_id')!!}</p>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="upazilla-id" class="control-label">{{ trans('trans/complaint.label_upazila') }}<sup class="text-danger">*</sup></label>
                    <!-- not loading anything by default, loading data using AJAX --> 
                    {!! Form::select('upazilla_id', $upazilla, null, ['onChange' => 'loadUnion()', 'placeholder' => trans('trans/complaint.select_upazila'), 'class' => 'select form-control', 'id' => 'upazilla-id']) !!}
                    @if ($errors->has('upazila_id'))
                        <p class="small text-danger">{!!$errors->first('upazila_id')!!}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="union-id" class="control-label">{{ trans('trans/complaint.label_union') }}</label>
                    <!-- not loading anything by default, loading data using AJAX --> 
                    {!! Form::select('union_id', $union, null, ['placeholder' => trans('trans/complaint.select_union'), 'class' => 'select form-control', 'id' => 'union-id']) !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="postcode" class="control-label">{{ trans('trans/complaint.label_postcode') }}</label>
                    {!! Form::text('postcode', null, ['class' => 'form-control', 'id' => 'postcode', 'placeholder' => 'e.g. 3252']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="address" class="control-label">{{ trans('trans/complaint.label_address') }}<sup class="text-danger">*</sup></label>
                    {!! Form::textarea('address', null, ['class' => 'form-control', 'id' => 'address', 'placeholder' => '', 'rows' => '5']) !!}
                    @if ($errors->has('address'))
                        <p class="text-danger">{!!$errors->first('address')!!}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group text-center"> 
            {!! Form::hidden('id') !!}

            <div class="form-group text-center"> {{ Form::button( trans('web/login_registration.label_save_btn'), array('type' => 'submit', 'class' => 'btn btn-info text-uppercase', 'id'=> 'myprofile-submit')) }} </div>
        </div>    
    
        {!! Form::close() !!}

        <p class="text-center small">
            <a href="{{ url('/home') }}">{{ trans('web/login_registration.back_home') }}</a>
        </p>

        <p class="login-language-switcher text-center small">
            @if ( 'bn' === Session::get('locale') )
                <a id="switch-lang-to-en" href="javascript:">
                    <i class="fa fa-language"></i> English
                </a>
            @endif

            @if ( 'en' === Session::get('locale') )
                <a id="switch-lang-to-bn" href="javascript:">
                    <i class="fa fa-language"></i> বাংলা
                </a>
            @endif
        </p>

    </div>
    <!-- /#content -->
  
</div>
<!-- /.register-form-area -->

<script type="application/javascript">

    /**
     * Load Upazila
     * Load the corresponding Upazila based on the District choice.
     * @return {mixed} Select field.
     * ...
     */
    function loadUpazilla() {
        var districtId = $("#district-id").val();

        //defined as in routes.php
        $.get('/area/getThanaUpazillaByDistrict/' + districtId, function (data) {
            var upazila_id = $('#upazilla-id');

            //success data
            upazila_id.empty();
            upazila_id.append("<option value=''>{{trans('trans/complaint.select_upazila')}}</option>");
            $.each(data, function (index, subcatObj) {
                upazila_id.append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
            });
        });
    }

    /**
     * Load Union
     * Load the corresponding Union based on the Upazilla choice.
     * @return {mixed} Select field.
     * ...
     */
    function loadUnion() {
        var upzilaId = $("#upazilla-id").val();

        //defined as in routes.php
        $.get('/area/getUnionByThana/' + upzilaId, function (data) {
            var union_id = $('#union-id');

            //success data
            union_id.empty();
            union_id.append("<option value=''>{{trans('trans/complaint.select_union')}}</option>");
            $.each(data, function (index, subcatObj) {
                union_id.append("<option value='" + subcatObj.id + "'>" + subcatObj.name + "</option>");
            });
        });
    }

</script>

@endsection
