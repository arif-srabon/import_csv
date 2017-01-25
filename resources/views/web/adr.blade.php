<?php
/**
 * Layout: Adverse Drug Reaction Reporting Page
 *
 * @package  adr_dgda/web
 * @author   Mayeenul Islam
 */
?>

@extends('layouts.web')

<!-- display page title -->
@section('page_title', trans('web/adr.page_title'))

<!-- make menu active -->
@section('menu_complaints_adr','active')

@section('content')

    <section id="breadcrumbs">
        <div class="container-fluid content-wrapper">
            <ol class="breadcrumb">
                <li><a href="{{url('/home')}}"><i class="fa fa-home"></i> {{ trans('web/common.breadcrumb_home') }}</a></li>
                <li class="active">{{ trans('web/adr.page_title') }}</li>
            </ol>
        </div>
        <!-- /.container-fluid content-wrapper -->
    </section>
    <!-- /#breadcrumbs -->

    <div id="content">
        <div class="container-fluid content-wrapper">

            <article>
                <header class="article-header">
                    <h3 class="entry-title page-title">{{ trans('web/adr.page_title') }}</h3>
                </header>
                <div class="entry-content page-content">

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <nav id="step-nav-panel">
                                <ul class="nav nav-pills nav-justified thumbnail step-nav">
                                    <li class="active"><a href="#step-1">
                                        <h4 class="step-heading text-uppercase">{{ trans('web/adr.step_id_1') }}</h4>
                                        <p class="list-group-item-text">{{ trans('web/adr.step_intro_1') }}</p>
                                    </a></li>
                                    <li class="disabled"><a href="#step-2">
                                        <h4 class="step-heading text-uppercase">{{ trans('web/adr.step_id_2') }}</h4>
                                        <p class="list-group-item-text">{{ trans('web/adr.step_intro_2') }}</p>
                                    </a></li>
                                    <li class="disabled"><a href="#step-3">
                                        <h4 class="step-heading text-uppercase">{{ trans('web/adr.step_id_3') }}</h4>
                                        <p class="list-group-item-text">{{ trans('web/adr.step_intro_3') }}</p>
                                    </a></li>
                                    <li class="disabled"><a href="#step-4">
                                        <h4 class="step-heading text-uppercase">{{ trans('web/adr.step_id_4') }}</h4>
                                        <p class="list-group-item-text">{{ trans('web/adr.step_intro_4') }}</p>
                                    </a></li>
                                </ul>
                            </nav> <!-- /.nav nav-pills nav-justified -->
                        </div>
                    </div> <!-- /.form-group -->

                    @include('errors.message')

                    {!! Form::open(['url' => 'complaints/adr', 'method' => 'post', 'id' =>'form-adr', 'name'=>'form_adr']) !!}

                    <div class="row step-body" id="step-1">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-head text-uppercase"><i class="fa fa-chevron-circle-right"></i> {{ trans('web/adr.step_id_1') }} : {{ trans('web/adr.step_intro_1') }}</h2>
                                </div>
                                <div class="panel-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <p><label for="incident_aftermath" class="control-label">
                                                {{ trans('web/adr.label_who_experienced') }}<sup class="text-danger">*</sup>
                                            </label></p>
                                            <p>
                                                <label class="radio-inline">
                                                    {{ Form::radio('experienced_by', 'you') }} {{ trans('web/adr.label_who_experienced_you') }}
                                                </label>

                                                <label class="radio-inline">
                                                    {{ Form::radio('experienced_by', 'your child') }} {{ trans('web/adr.label_who_experienced_child') }}
                                                </label>

                                                <label class="radio-inline">
                                                    {{ Form::radio('experienced_by', 'someone else') }} {{ trans('web/adr.label_who_experienced_else') }}
                                                </label>
                                            </p>
                                        </div>
                                        <div class="col-sm-5 col-sm-offset-2">
                                            <?php $patient_name_err_class = $errors->has('patient_name') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $patient_name_err_class; ?>">
                                                <label for="patient-name" class="control-label">{{ trans('web/adr.label_patient_name') }}<sup class="text-danger">*</sup></label>
                                                {!! Form::text('patient_name', null, ['class' => 'form-control', 'id' => 'patient-name']) !!}
                                                @if ($errors->has('patient_name'))
                                                    <p class="small text-danger">{!!$errors->first('patient_name')!!}</p>
                                                @endif
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <p><label for="patient_gender" class="control-label">
                                                {{ trans('web/adr.label_patient_gender') }}<sup class="text-danger">*</sup>
                                            </label></p>
                                            <p>
                                                <label class="radio-inline">
                                                    {{ Form::radio('patient_gender', 'male') }} {{ trans('web/adr.label_gender_male') }}
                                                </label>

                                                <label class="radio-inline">
                                                    {{ Form::radio('patient_gender', 'female') }} {{ trans('web/adr.label_gender_female') }}
                                                </label>
                                            </p>
                                        </div>
                                        <div class="col-sm-5 col-sm-offset-2">
                                            <?php $patient_age_err_class = $errors->has('patient_age') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $patient_age_err_class; ?>">
                                                <label for="patient-age" class="control-label">{{ trans('web/adr.label_patient_age') }}<sup class="text-danger">*</sup></label>
                                                <div class="row">
                                                    <div class="col-xs-7">
                                                        {!! Form::number('patient_age', null, ['class' => 'form-control', 'id' => 'patient-age']) !!}
                                                    </div>
                                                    <div class="col-xs-5">
                                                        {!! Form::select('patient_age_unit_id', $ageUnit, null, ['class' => 'select form-control', 'id' => 'age-unit']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors->has('patient_age'))
                                                    <p class="small text-danger">{!!$errors->first('patient_age')!!}</p>
                                                @endif
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <?php $patient_weight_err_class = $errors->has('patient_weight') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $patient_weight_err_class; ?>">
                                                <label for="patient-weight" class="control-label">{{ trans('web/adr.label_patient_weight') }}<sup class="text-danger">*</sup></label>
                                                <div class="row">
                                                    <div class="col-xs-7">
                                                        {!! Form::number('patient_weight', null, ['class' => 'form-control', 'id' => 'patient-weight']) !!}
                                                    </div>
                                                    <div class="col-xs-5">
                                                        {!! Form::select('patient_weight_unit_id', $weightUnit, null, ['class' => 'select form-control', 'id' => 'weight-unit']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors->has('patient_weight'))
                                                    <p class="small text-danger">{!!$errors->first('patient_weight')!!}</p>
                                                @endif
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                        <div class="col-sm-5 col-sm-offset-2">
                                            <?php $patient_height_err_class = $errors->has('patient_height') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $patient_height_err_class; ?>">
                                                <label for="patient-height" class="control-label">{{ trans('web/adr.label_patient_height') }}<sup class="text-danger">*</sup></label>
                                                <div class="row">
                                                    <div class="col-xs-7">
                                                        {!! Form::number('patient_height', null, ['class' => 'form-control', 'id' => 'patient-height']) !!}
                                                    </div>
                                                    <div class="col-xs-5">
                                                        {!! Form::select('patient_height_unit_id', $heightUnit, null, ['class' => 'select form-control', 'id' => 'height-unit']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors->has('patient_height'))
                                                    <p class="small text-danger">{!!$errors->first('patient_height')!!}</p>
                                                @endif
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="hospital" class="control-label">{{ trans('web/adr.label_hospital') }}</label>
                                                {!! Form::text('hospital', null, ['class' => 'form-control', 'id' => 'hospital']) !!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-5 col-sm-offset-2">
                                            <div class="form-group">
                                                <label for="reference-number" class="control-label">{{ trans('web/adr.label_reference_number') }}</label>
                                                {!! Form::text('reference_number', null, ['class' => 'form-control', 'id' => 'reference-number']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?php $event_str_dt_err_class = $errors->has('event_starting_dt') ? ' has-error' : ''; ?>
                                                    <div class="form-group <?php echo $event_str_dt_err_class; ?>">
                                                        <label for="event-starting-date" class="control-label">{{ trans('web/adr.label_event_starting_dt') }}<sup class="text-danger">*</sup></label>
                                                        {!! Form::text('event_starting_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'event-starting-date']) !!}
                                                        @if ($errors->has('event_starting_dt'))
                                                            <p class="small text-danger">{!!$errors->first('event_starting_dt')!!}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php $event_stp_dt_err_class = $errors->has('event_stop_dt') ? ' has-error' : ''; ?>
                                                    <div class="form-group <?php echo $event_stp_dt_err_class; ?>">
                                                        <label for="event-stop-date" class="control-label">{{ trans('web/adr.label_event_stop_dt') }}<sup class="text-danger">*</sup></label>
                                                        {!! Form::text('event_stop_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'event-stop-date']) !!}
                                                        @if ($errors->has('event_stop_dt'))
                                                            <p class="small text-danger">{!!$errors->first('event_stop_dt')!!}</p>
                                                        @endif
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-sm-offset-2">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?php $event_rprt_dt_err_class = $errors->has('event_reporting_dt') ? ' has-error' : ''; ?>
                                                    <div class="form-group <?php echo $event_rprt_dt_err_class; ?>">
                                                        <label for="event-report-date" class="control-label">{{ trans('web/adr.label_event_reporting_dt') }}<sup class="text-danger">*</sup></label>
                                                        {!! Form::text('event_reporting_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'event-report-date']) !!}
                                                        @if ($errors->has('event_reporting_dt'))
                                                            <p class="small text-danger">{!!$errors->first('event_reporting_dt')!!}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p><label for="is_treated" class="control-label">
                                                        {{ trans('web/adr.label_is_treated') }}
                                                    </label></p>
                                                    <p>
                                                        <label class="radio-inline">
                                                            {{ Form::radio('is_treated', 'yes') }} {{ trans('web/adr.label_yes') }}
                                                        </label>

                                                        <label class="radio-inline">
                                                            {{ Form::radio('is_treated', 'no') }} {{ trans('web/adr.label_no') }}
                                                        </label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group" id="treatment-details">
                                                <label for="treatment-details" class="control-label">{{ trans('web/adr.label_treatment_details') }}</label>
                                                {!! Form::textarea('treatment_specification', null, ['class' => 'form-control', 'id' => 'treatment-details', 'rows' => '5']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <div id="activate-step-2" class="btn btn-primary hide-if-no-js">{{ trans('web/adr.label_btn_next') }} <i class="fa fa-chevron-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#step-1 .step-body -->

                    <div class="row step-body" id="step-2">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-head text-uppercase"><i class="fa fa-chevron-circle-right"></i> {{ trans('web/adr.step_id_2') }} : {{ trans('web/adr.step_intro_2') }}</h2>
                                </div>
                                <div class="panel-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php $medicine_name_err_class = $errors->has('suspected_medicine') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $medicine_name_err_class; ?>">
                                                <label for="suspected-medicine" class="control-label">{{ trans('web/adr.label_suspected_medicine') }}<sup class="text-danger">*</sup></label>
                                                {!! Form::text('suspected_medicine', null, ['class' => 'form-control', 'id' => 'suspected-medicine', 'autocomplete' => 'off']) !!}
                                                @if ($errors->has('suspected_medicine'))
                                                    <p class="small text-danger">{!!$errors->first('suspected_medicine')!!}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="generic-name" class="control-label">{{ trans('web/adr.label_generic_name') }}</label>
                                                {!! Form::text('generic_name', null, ['class' => 'form-control', 'id' => 'generic-name', 'autocomplete' => 'off']) !!}
                                                @if ($errors->has('generic_name'))
                                                    <p class="small text-danger">{!!$errors->first('generic_name')!!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php $manufac_err_class = $errors->has('manufacturer') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $manufac_err_class; ?>">
                                                <label for="manufacturer" class="control-label">{{ trans('web/adr.label_manufacturer') }}<sup class="text-danger">*</sup></label>
                                                {!! Form::text('manufacturer', null, ['class' => 'form-control', 'id' => 'manufacturer', 'autocomplete' => 'off']) !!}
                                                @if ($errors->has('manufacturer'))
                                                    <p class="small text-danger">{!!$errors->first('manufacturer')!!}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="batch-lot" class="control-label">{{ trans('web/adr.label_batch_lot') }}</label>
                                                {!! Form::text('batch_lot', null, ['class' => 'form-control', 'id' => 'batch-lot']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php $dose_str_dt_err_class = $errors->has('dose_start_dt') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $dose_str_dt_err_class; ?>">
                                                <label for="dose-starting-date" class="control-label">{{ trans('web/adr.label_dose_start_dt') }}<sup class="text-danger">*</sup></label>
                                                {!! Form::text('dose_start_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'dose-starting-date']) !!}
                                                @if ($errors->has('dose_start_dt'))
                                                    <p class="small text-danger">{!!$errors->first('dose_start_dt')!!}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php $dose_stp_dt_err_class = $errors->has('dose_stop_dt') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $dose_stp_dt_err_class; ?>">
                                                <label for="dose-stop-date" class="control-label">{{ trans('web/adr.label_dose_stop_dt') }}<sup class="text-danger">*</sup></label>
                                                {!! Form::text('dose_stop_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'dose-stop-date']) !!}
                                                @if ($errors->has('dose_stop_dt'))
                                                    <p class="small text-danger">{!!$errors->first('dose_stop_dt')!!}</p>
                                                @endif
                                            </div>                                                    
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dose" class="control-label">{{ trans('web/adr.label_dose') }}</label>
                                                {!! Form::text('dose', null, ['class' => 'form-control', 'id' => 'dose', 'placeholder' => '1 + 0 + 1']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dose-form-id" class="control-label">{{ trans('web/adr.label_dose_form') }}</label>
                                                {!! Form::select('dose_form_id', $doseForm, null, ['placeholder' => trans('web/adr.select_dose_form'), 'class' => 'select form-control', 'id' => 'dose-form-id']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="frequency" class="control-label">{{ trans('web/adr.label_dose_frequency') }}</label>
                                                {!! Form::select('dose_frequency_id', $doseFrequency, null, ['placeholder' => trans('web/adr.select_dose_frequency'), 'class' => 'select form-control', 'id' => 'frequency']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dose-route" class="control-label">{{ trans('web/adr.label_dose_route') }}</label>
                                                {!! Form::select('route_id', $doseRoute, null, ['placeholder' => trans('web/adr.select_dose_route'), 'class' => 'select form-control', 'id' => 'dose-route']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dose-reason" class="control-label">{{ trans('web/adr.label_dose_reason') }}</label>
                                                {!! Form::textarea('medicine_reason', null, ['class' => 'form-control', 'id' => 'dose-reason', 'rows' => '5']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="lab-test-result" class="control-label">{{ trans('web/adr.label_lab_test_result') }}</label>
                                                {!! Form::textarea('lab_test_result', null, ['class' => 'form-control', 'id' => 'lab-test-result', 'rows' => '5']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="reaction" class="control-label">{{ trans('web/adr.label_action_after_reaction') }}</label>
                                                {!! Form::select('action_after_reaction_id', $reactionAction, null, ['placeholder' => trans('web/adr.select_action_after_reaction'), 'class' => 'select form-control', 'id' => 'reaction']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3 class="control-label">{{ trans('web/adr.label_other_medicine_info') }}</h3>
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('web/adr.label_other_medicine_name') }}</th>
                                                            <th>{{ trans('web/adr.label_other_generic') }}</th>
                                                            <th>{{ trans('web/adr.label_other_indication') }}</th>
                                                            <th>{{ trans('web/adr.label_other_dose_form') }}</th>
                                                            <th>{{ trans('web/adr.label_other_dose_route') }}</th>
                                                            <th>{{ trans('web/adr.label_other_dose') }}</th>
                                                            <th>{{ trans('web/adr.label_other_dose_frequency') }}</th>
                                                            <th>{{ trans('web/adr.label_other_dose_start_dt') }}</th>
                                                            <th>{{ trans('web/adr.label_other_dose_stop_dt') }}</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="other-medicine-repeater">
                                                            <td>
                                                                {!! Form::text('other_suspected_medicine[]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::text('other_generic[]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::text('other_indication[]', null, ['class' => 'form-control']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::select('other_dose_form_id[]', $doseForm, null, ['placeholder' => trans('/web/adr.select_common'), 'class' => 'select form-control']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::select('other_route_id[]', $doseRoute, null, ['placeholder' => trans('/web/adr.select_common'), 'class' => 'select form-control']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::text('other_dose[]', null, ['class' => 'form-control', 'placeholder' => '1 + 0 + 1']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::select('other_dose_frequency_id[]', $doseFrequency, null, ['placeholder' => trans('/web/adr.select_common'), 'class' => 'select form-control']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::text('other_dose_start_dt[]', null, ['class' => 'form-control call-datepicker']) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::text('other_dose_stop_dt[]', null, ['class' => 'form-control call-datepicker']) !!}
                                                                <div class="btn btn-sm btn-info add-other-medicine pull-right"><i class="fa fa-plus"></i> {{ trans('/web/adr.label_add_row') }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="btn btn-sm btn-danger remove-other-medicine" title="{{ trans('/web/adr.label_remove_row') }}"><i class="fa fa-minus"></i></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="goto-first-step" class="btn btn-primary hide-if-no-js"><i class="fa fa-chevron-left"></i> {{ trans('web/adr.label_btn_previous') }}</div>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <div id="activate-step-3" class="btn btn-primary hide-if-no-js">{{ trans('web/adr.label_btn_next') }} <i class="fa fa-chevron-right"></i></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#step-2 .step-body -->

                    <div class="row step-body" id="step-3">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-head text-uppercase"><i class="fa fa-chevron-circle-right"></i> {{ trans('web/adr.step_id_3') }} : {{ trans('web/adr.step_intro_3') }}</h2>
                                </div>
                                <div class="panel-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php $adverse_effects_err_class = $errors->has('adverse_effects') ? ' has-error' : ''; ?>
                                            <div class="form-group <?php echo $adverse_effects_err_class; ?>">
                                                <label for="adverse-effects" class="control-label">{{ trans('web/adr.label_adverse_effects') }}<sup class="text-danger">*</sup></label>
                                                {!! Form::textarea('adverse_effects', null, ['class' => 'form-control', 'id' => 'adverse-effects', 'rows' => '5']) !!}
                                                @if ($errors->has('adverse_effects'))
                                                    <p class="small text-danger">{!!$errors->first('adverse_effects')!!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="effect-start-date" class="control-label">{{ trans('web/adr.label_adverse_effect_start_dt') }}</label>
                                                {!! Form::text('effect_start_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'effect-start-date']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="effect-stop-date" class="control-label">{{ trans('web/adr.label_adverse_effect_stop_dt') }}</label>
                                                {!! Form::text('effect_end_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'effect-stop-date']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><label class="control-label">{{ trans('web/adr.label_adverse_effect_seriousness') }}</label></p>
                                            @foreach( $seriousness as $id => $label )
                                                <div class="checkbox">
                                                    <label>
                                                        {{ Form::checkbox('incident_seriousness[]', $id) }} {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-sm-6">
                                            <p><label class="control-label">{{ trans('web/adr.label_adverse_effect_outcome') }}</label></p>
                                            @foreach( $outcome as $id => $label )
                                                <div class="checkbox">
                                                    <label>
                                                        {{ Form::checkbox('incident_outcome[]', $id, null, array('id'=> "outcome-$id")) }} {{ $label }}
                                                    </label>

                                                    <?php
                                                    /**
                                                     * Taking the Fatal Date of Death event_id from
                                                     * app_config file to make it dynamic. User have to change
                                                     * the value of the `cc_adr_outcome` table's row `id` so
                                                     * that both can match and display the date_of_death
                                                     * with the value 'Fatal'
                                                     * ...
                                                     */
                                                    ?>
                                                    @if( config('app_config.adverse_effect_outcome_fatal_id') == $id )
                                                        <div class="form-inline fatal-date-of-death-holder">
                                                            <div class="form-group">
                                                                <label for="outcome-fatal-dt">{{ trans('adrreporting.date_of_death') }}</label>
                                                                {!! Form::text('outcome_fatal_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'outcome-fatal-dt']) !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="other-history" class="control-label">{{ trans('web/adr.label_other_history') }}</label>
                                                {!! Form::textarea('other_history', null, ['class' => 'form-control', 'id' => 'other-history', 'rows' => '5']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="goto-second-step" class="btn btn-primary hide-if-no-js"><i class="fa fa-chevron-left"></i> {{ trans('web/adr.label_btn_previous') }}</div>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <div id="activate-step-4" class="btn btn-primary hide-if-no-js">{{ trans('web/adr.label_btn_next') }} <i class="fa fa-chevron-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#step-3 .step-body -->

                    <div class="row step-body" id="step-4">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-head text-uppercase"><i class="fa fa-chevron-circle-right"></i> {{ trans('web/adr.step_id_4') }} : {{ trans('web/adr.step_intro_4') }}</h2>
                                </div>
                                <div class="panel-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><label for="incident_aftermath" class="control-label">
                                                {{ trans('web/adr.label_is_medicine_three_months') }}<sup class="text-danger">*</sup>
                                            </label></p>
                                            <p>
                                                <label class="radio-inline">
                                                    {{ Form::radio('is_medicine_three_months', 'yes') }} {{ trans('web/adr.label_yes') }}
                                                </label>

                                                <label class="radio-inline">
                                                    {{ Form::radio('is_medicine_three_months', 'no') }} {{ trans('web/adr.label_no') }}
                                                </label>

                                                <label class="radio-inline">
                                                    {{ Form::radio('is_medicine_three_months', 'unknown') }} {{ trans('web/adr.label_unknown') }}
                                                </label>
                                            </p>
                                        </div>
                                        <div class="col-sm-6 three-months-medicine-holder">
                                            <div class="form-group">
                                                <label class="col-xs-12">{{ trans('/web/adr.label_three_months_med_name') }}</label>
                                                <div id="three-months-medicine-repeater" class="three-months-repeater clearfix">
                                                    <div class="col-xs-11">
                                                        {!! Form::text('three_months_medicine[]', null, ['class' => 'form-control']) !!}
                                                        <div class="btn btn-sm btn-info add-three-months-medicine pull-right"><i class="fa fa-plus"></i> {{ trans('/web/adr.label_add_row') }}</div>
                                                    </div>
                                                    <div class="col-xs-1">
                                                        <div class="btn btn-sm btn-danger remove-three-months-medicine" title="{{ trans('/web/adr.label_remove_row') }}"><i class="fa fa-minus"></i></div>
                                                    </div>
                                                </div>
                                                <!-- /#three-months-medicine-repeater -->
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="miscellaneous-info" class="control-label">{{ trans('web/adr.label_miscellaneous_info') }}</label>
                                                {!! Form::textarea('miscellaneous_info', null, ['class' => 'form-control', 'id' => 'miscellaneous-info', 'rows' => '5']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><label for="is_doctor_told" class="control-label">
                                                {{ trans('web/adr.label_is_doctor_told') }}
                                            </label></p>
                                            <p>
                                                <label class="radio-inline">
                                                    {{ Form::radio('is_doctor_told', 'yes') }} {{ trans('web/adr.label_yes') }}
                                                </label>

                                                <label class="radio-inline">
                                                    {{ Form::radio('is_doctor_told', 'no') }} {{ trans('web/adr.label_no') }}
                                                </label>
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><label for="is_doctor" class="control-label">
                                                {{ trans('web/adr.label_is_doctor') }}
                                            </label></p>
                                            <p>
                                                <label class="radio-inline">
                                                    {{ Form::radio('is_doctor', 'yes') }} {{ trans('web/adr.label_yes') }}
                                                </label>

                                                <label class="radio-inline">
                                                    {{ Form::radio('is_doctor', 'no') }} {{ trans('web/adr.label_no') }}
                                                </label>
                                            </p>
                                        </div>
                                    </div>

                                    <hr>
                                    
                                    <h4>{{ trans('web/adr.head_doc_info') }}</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="doc-name" class="control-label">{{ trans('web/adr.label_doctor_name') }}</label>
                                                {!! Form::text('doctor_name', null, ['class' => 'form-control', 'id' => 'doc-name']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="doc-hospital" class="control-label">{{ trans('web/adr.label_doctor_hospital') }}</label>
                                                {!! Form::text('doctor_hospital', null, ['class' => 'form-control', 'id' => 'doc-hospital']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="doc-address" class="control-label">{{ trans('web/adr.label_doctor_address') }}</label>
                                            {!! Form::textarea('doctor_address', null, ['class' => 'form-control', 'id' => 'doc-address', 'rows' => '4']) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="doc-district" class="control-label">{{ trans('web/adr.label_doctor_district') }}</label>
                                                {!! Form::select('doctor_district_id', $district, null, ['placeholder' => trans('web/adr.select_district'), 'class' => 'select form-control', 'id' => 'district-id']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="doc-postcode" class="control-label">{{ trans('web/adr.label_doctor_postcode') }}</label>
                                                {!! Form::text('doctor_postcode', null, ['class' => 'form-control', 'id' => 'doc-postcode']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div id="goto-third-step" class="btn btn-primary hide-if-no-js"><i class="fa fa-chevron-left"></i> {{ trans('web/adr.label_btn_previous') }}</div>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-paper-plane"></i> {{ trans('web/adr.label_btn_submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /#step-4 .step-body -->
                    
                    {!! Form::close() !!}

                </div>
            </article>

        </div>
        <!-- /.container-fluid content-wrapper -->

    </div>
    <!-- /#content -->

    <script type="application/javascript">
    jQuery(document).ready(function($){

        /**
         * Initiated the Steps
         * ...
         */
        var step_nav_item   = $('ul.step-nav li a'),
            step_body       = $('.step-body');

        //Default: Hidden by default
        step_body.hide();

        step_nav_item.click(function(e)
        {
            e.preventDefault();
            var target = $($(this).attr('href')),
                item   = $(this).closest('li');
            
            if (!item.hasClass('disabled')) {
                step_nav_item.closest('li').removeClass('active');
                item.addClass('active');
                step_body.hide();
                target.show();
            }
        });
        
        $('ul.step-nav li.active a').trigger('click');
        
        $('#activate-step-2').on('click', function(e) {
            $('ul.step-nav li:eq(1)').removeClass('disabled');
            $('ul.step-nav li a[href="#step-2"]').trigger('click');
            //$(this).remove();
        });
        $('#goto-first-step').on('click', function(e) {
            $('ul.step-nav li a[href="#step-1"]').trigger('click');
        });
        $('#activate-step-3').on('click', function(e) {
            $('ul.step-nav li:eq(2)').removeClass('disabled');
            $('ul.step-nav li a[href="#step-3"]').trigger('click');
            //$(this).remove();
        });
        $('#goto-second-step').on('click', function(e) {
            $('ul.step-nav li a[href="#step-2"]').trigger('click');
        });
        $('#activate-step-4').on('click', function(e) {
            $('ul.step-nav li:eq(3)').removeClass('disabled');
            $('ul.step-nav li a[href="#step-4"]').trigger('click');
            //$(this).remove();
        });
        $('#goto-third-step').on('click', function(e) {
            $('ul.step-nav li a[href="#step-3"]').trigger('click');
        });

        /**
         * Conditional treatment details.
         * ...
         */
        var treatment_radio     = $('[name="is_treated"]'),
            treatment_details  = $('#treatment-details');

        //Default: Hidden by default
        treatment_details.hide();

        //Incident Details based on Radio choice
        treatment_radio.on( 'change', function() {
            if( 'yes' === $(this).val() ) {
                treatment_details.slideDown();
            } else {
                treatment_details.find('textarea').val(''); //clear the input, if any
                treatment_details.slideUp();
            }
        });


        /**
         * Conditional three months' medicines.
         * ...
         */
        var three_months_medicine_radio     = $('[name="is_medicine_three_months"]'),
            three_months_medicine_holder    = $('.three-months-medicine-holder');

        //Default: Hidden by default
        three_months_medicine_holder.hide();

        //Three Month's Medicines based on Radio choice
        three_months_medicine_radio.on( 'change', function() {
            if( 'yes' === $(this).val() ) {
                three_months_medicine_holder.slideDown();
            } else {
                three_months_medicine_holder.find('input[type="text"]').val(''); //clear the input, if any
                three_months_medicine_holder.slideUp();
            }
        });


        /**
         * Conditional date of death field.
         * ...
         */
        var set_fatal_id        = {{ config('app_config.adverse_effect_outcome_fatal_id') }}, //dynamic value
            fatal_checkbox      = $('#outcome-' + set_fatal_id),
            fatal_date_of_death = $('.fatal-date-of-death-holder');

        //Default: Hidden by default
        fatal_date_of_death.hide();

        if( fatal_checkbox.is(':checked') ) {
            fatal_date_of_death.show();
        }

        //Incident Aftermath date of death on checkbox choice
        fatal_checkbox.on('click', function() {
            if( $(this).is(':checked') ) {
                fatal_date_of_death.slideDown();
            } else {
                fatal_date_of_death.find('input[type="text"]').val(''); //clear the input, if any
                fatal_date_of_death.slideUp();
            }
        });


        /**
         * Initiated Date Picker
         * Calling DatePicker for every '.call-datepicker' element - onFocus()
         *
         * @author  skafandri
         * @link    http://stackoverflow.com/a/10433307
         * ...
         */
        $('body').on( 'focus', '.call-datepicker', function(){
            $(this).datepicker({
                format: 'dd-mm-yyyy'
            });
        });


        /**
         * Adding/Removing dynamic rows
         * using: jQueryDynamicForm
         * ...
         */
        $('#other-medicine-repeater').dynamicForm( '.add-other-medicine', '.remove-other-medicine', {limit: 20});

        $('#three-months-medicine-repeater').dynamicForm( '.add-three-months-medicine', '.remove-three-months-medicine', {limit: 20});


        /**
         * AutoCompletes
         * using: Bootstrap3 TypeHead.js
         * ...
         */
        $.get('/auto/medicinename', function(data){
            $('#suspected-medicine').typeahead({ source: data, minLength: 2 });
            $('[name="other_suspected_medicine[]"]').typeahead({ source: data, minLength: 2 });
        },'json');

        $.get('/auto/medicinegeneric', function(data){
            $('#generic-name').typeahead({ source: data, minLength: 2 });
            $('[name="other_generic[]"]').typeahead({ source: data, minLength: 2 });
        },'json');

        $.get('/auto/manufacturername', function(data){
            $('#manufacturer').typeahead({ source: data, minLength: 2 });
        },'json');

    });

    </script>

@endsection
