<?php
/**
 * Layout: Complaint Page
 *
 * @package  adr_dgda
 * @author   Mayeenul Islam
 */
?>

@extends('layouts.web')

<!-- display page title -->
@section('page_title', trans('trans/complaint.title'))

<!-- make menu active -->
@section('menu_complaints','active')
@section('menu_complaints_complain','active')

@section('content')

    <section id="breadcrumbs">
        <div class="container-fluid content-wrapper">
            <ol class="breadcrumb">
                <li><a href="{{url('/home')}}"><i class="fa fa-home"></i> {{ trans('web/common.breadcrumb_home') }}</a></li>
                <li>{{ trans('trans/complaint.breadcrumb_complaints') }}</li>
                <li class="active">{{ trans('trans/complaint.page_title') }}</li>
            </ol>
        </div>
        <!-- /.container-fluid content-wrapper -->
    </section>
    <!-- /#breadcrumbs -->

    <div id="content">
        <div class="container-fluid content-wrapper">

            <article>
                <header class="article-header">
                    <h3 class="entry-title page-title">{{ trans('trans/complaint.page_title') }}</h3>
                </header>
                <div class="entry-content page-content">

                    @include('errors.message')

                    {!! Form::open(['url' => 'complaints/complain', 'method' => 'post', 'id' =>'form-complaint', 'name'=>'form_complaint']) !!}

                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-bookmark-o"></i> {{ trans('trans/complaint.label_panel_title') }}</div>
                            <div class="panel-body">

                                <div class="row">
                                    <?php $type_err_class = $errors->has('complaint_type_id') ? ' has-error' : ''; ?>
                                    <div class="col-sm-6 form-group {{ $type_err_class }}">
                                        <label for="complaint-type" class="control-label">{{ trans('trans/complaint.label_complaint_type') }}<sup class="text-danger">*</sup></label>
                                        {!! Form::select('complaint_type_id', $complaintType, null, ['placeholder' => trans('trans/complaint.select_complaint_type'), 'class' => 'select form-control', 'id' => 'complaint-type']) !!}
                                        @if ($errors->has('complaint_type_id'))
                                            <p class="small text-danger">{!!$errors->first('complaint_type_id')!!}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label for="complaint-details" class="control-label">{{ trans('trans/complaint.label_complaint_details') }}</label>
                                        {!! Form::textarea('complaint_details', null, ['class' => 'form-control', 'id' => 'complaint-details', 'placeholder' => '', 'rows' => '5']) !!}
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-6">                                
                                        <div class="form-group">
                                            <label for="full-name" class="control-label">{{ trans('trans/complaint.label_name') }}<sup class="text-danger">*</sup></label>
                                            <div class="row">
                                                <div class="col-sm-3 col-xs-4">
                                                    <select name="repoter_title" id="repoter-title" class="form-control">
                                                        <option value="Mr.">Mr.</option>
                                                        <option value="Ms.">Ms.</option>
                                                        <option value="Mst.">Mst.</option>
                                                        <option value="Miss">Miss</option>
                                                    </select>
                                                </div>
                                                <?php $name_err_class = $errors->has('full_name') ? ' has-error' : ''; ?>
                                                <div class="col-sm-9 col-xs-8 <?php echo $name_err_class; ?>">
                                                    {!! Form::text('full_name', null, ['class' => 'form-control', 'id' => 'full-name', 'placeholder' => 'e.g. John Doe']) !!}
                                                    @if ($errors->has('full_name'))
                                                        <p class="small text-danger">{!!$errors->first('full_name')!!}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-sm-6">
                                        <?php $profession_err_class = $errors->has('profession') ? ' has-error' : ''; ?>
                                        <div class="form-group <?php echo $profession_err_class; ?>">
                                            <label for="profession" class="control-label">{{ trans('trans/complaint.label_profession') }}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('profession', null, ['class' => 'form-control', 'id' => 'profession', 'placeholder' => 'e.g. Doctor/ Pharmacist/ Student/ Housewife', 'autocomplete' => 'off']) !!}
                                            @if ($errors->has('profession'))
                                                <p class="small text-danger">{!!$errors->first('profession')!!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php $district_err_class = $errors->has('district_id') ? ' has-error' : ''; ?>
                                        <div class="form-group <?php echo $district_err_class; ?>">
                                            <label for="district-id" class="control-label">{{ trans('trans/complaint.label_district') }}<sup class="text-danger">*</sup></label>
                                            {!! Form::select('district_id', $district, null, ['onChange' => 'loadUpazilla()', 'placeholder' => trans('setup/manufacturer.select_district'), 'class' => 'select form-control', 'id' => 'district-id']) !!}
                                            @if ($errors->has('district_id'))
                                                <p class="small text-danger">{!!$errors->first('district_id')!!}</p>
                                            @endif
                                        </div>
                                        <?php $upazila_err_class = $errors->has('upazila_id') ? ' has-error' : ''; ?>
                                        <div class="form-group <?php echo $upazila_err_class; ?>">
                                            <label for="upazilla-id" class="control-label">{{ trans('trans/complaint.label_upazila') }}<sup class="text-danger">*</sup></label>
                                            <!-- not loading anything by default, loading data using AJAX -->
                                            {!! Form::select('upazilla_id', array(), null, ['onChange' => 'loadUnion()', 'placeholder' => trans('trans/complaint.select_upazila'), 'class' => 'select form-control', 'id' => 'upazilla-id']) !!}
                                            @if ($errors->has('upazila_id'))
                                                <p class="small text-danger">{!!$errors->first('upazila_id')!!}</p>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="union-id" class="control-label">{{ trans('trans/complaint.label_union') }}</label>
                                            <!-- not loading anything by default, loading data using AJAX -->
                                            {!! Form::select('union_id', array(), null, ['placeholder' => trans('trans/complaint.select_union'), 'class' => 'select form-control', 'id' => 'union-id']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address" class="control-label">{{ trans('trans/complaint.label_address') }}</label>
                                            {!! Form::textarea('address', null, ['class' => 'form-control', 'id' => 'address', 'placeholder' => '', 'rows' => '5']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label for="postcode" class="control-label">{{ trans('trans/complaint.label_postcode') }}</label>
                                            {!! Form::text('postcode', null, ['class' => 'form-control', 'id' => 'postcode', 'placeholder' => 'e.g. 3252']) !!}
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php $email_err_class = $errors->has('email') ? ' has-error' : ''; ?>
                                        <div class="form-group {{ $email_err_class }}">
                                            <label for="email" class="control-label">{{ trans('trans/complaint.label_email') }}<sup class="text-danger">*</sup></label>
                                            {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'e.g. someone@example.com']) !!}
                                            @if ($errors->has('email'))
                                                <p class="small text-danger">{!!$errors->first('email')!!}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php $phone_err_class = $errors->has('phone') ? ' has-error' : ''; ?>
                                        <div class="form-group <?php echo $phone_err_class; ?>">
                                            <label for="phone" class="control-label">{{ trans('trans/complaint.label_phone') }}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => '']) !!}
                                            @if ($errors->has('phone'))
                                                <p class="small text-danger">{!!$errors->first('phone')!!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8 checkbox">
                                        <label class="control-label">
                                            {{ Form::checkbox('is_sms_notification', 1) }}&nbsp;
                                            {{ trans('trans/complaint.label_sms_notification') }} <i class="fa fa-bell-o"></i>
                                        </label>
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <button type="submit" name="submit_complaint" class="btn btn-primary"><i class="fa fa-paper-plane"></i> {{ trans('trans/complaint.label_submit_btn') }}</button>
                                    </div>
                                </div>

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel panel-default -->
                    
                    {!! Form::close() !!}

                </div>
            </article>

        </div>
        <!-- /.container-fluid content-wrapper -->

    </div>
    <!-- /#content -->

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


        /**
         * AutoCompletes
         * using: Bootstrap3 TypeHead.js
         * ...
         */
        $.get('/auto/profession', function(data){
            $('#profession').typeahead({ source: data, minLength: 2 });
        },'json');

    </script>

@endsection
