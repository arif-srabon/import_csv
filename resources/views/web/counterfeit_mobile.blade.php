<?php
/**
 * Layout: Counterfeit Page
 *
 * @package  adr_dgda/web
 * @author   Mayeenul Islam
 */
?>

@extends('layouts.mobile')

<!-- display page title -->
@section('page_title', trans('web/counterfeit.page_title'))

<!-- make menu active -->
@section('menu_complaints','active')
@section('menu_complaints_counterfeit','active')

@section('content')

    <div id="content">
        <div class="container-fluid content-wrapper">

            <article>
                <header class="article-header">
                    @if ( 'bn' === Session::get("locale") )
                        <a id="switch-lang-to-en" class="pull-right btn btn-primary btn-xs" href="javascript:">
                            <i class="fa fa-language"></i> English
                        </a>
                    @endif

                    @if ( 'en' === Session::get("locale") )
                        <a id="switch-lang-to-bn" class="pull-right btn btn-primary btn-xs" href="javascript:">
                            <i class="fa fa-language"></i> বাংলা
                        </a>
                    @endif
                    <h3 class="entry-title page-title">{{ trans('web/counterfeit.page_title') }}</h3>
                </header>
                <div class="entry-content page-content">

                    @include('errors.message')

                    {!! Form::open(['url' => 'complaints/counterfeit-mobile', 'method' => 'post', 'id' =>'form-counterfeit', 'name'=>'form_counterfeit']) !!}

                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-bookmark-o"></i> {{ trans('web/counterfeit.panel_incident') }}</div>
                            <div class="panel-body">
                                <p><label for="incident_aftermath" class="control-label">{{ trans('web/counterfeit.label_incident_aftermath') }}<sup class="text-danger">*</sup></label></p>
                                <p>
                                    @foreach( $counterfeitIncidents as $id => $label )
                                        <label class="radio-inline">
                                            {{ Form::radio('incident_aftermath', $id) }} {{ $label }}
                                        </label>
                                    @endforeach
                                </p>
                                @if ($errors->has('incident_aftermath'))
                                    <p class="small text-danger">{!!$errors->first('incident_aftermath')!!}</p>
                                @endif

                                <br>

                                <div class="form-group" id="incident-details-item">
                                    <label for="incident-details" class="control-label">{{ trans('web/counterfeit.label_counterfeit_details') }}</label>
                                    {!! Form::textarea('incident_details', null, ['class' => 'form-control', 'id' => 'incident-details', 'rows' => '5']) !!}
                                </div>
                            </div> <!-- /.panel-body -->
                        </div> <!-- /.panel -->

                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-cube"></i> {{ trans('web/counterfeit.panel_product') }}</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php $med_err_class = $errors->has('suspected_medicine') ? ' has-error' : ''; ?>
                                        <div class="form-group <?php echo $med_err_class; ?>">
                                            <label for="suspected-medicine" class="control-label">{{ trans('web/counterfeit.label_medicine_name') }}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('suspected_medicine', null, ['class' => 'form-control', 'id' => 'suspected-medicine', 'autocomplete' => 'off']) !!}
                                            @if ($errors->has('suspected_medicine'))
                                                <p class="small text-danger">{!!$errors->first('suspected_medicine')!!}</p>
                                            @endif
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="generic-name" class="control-label">{{ trans('web/counterfeit.label_generic') }}</label>
                                            {!! Form::text('generic_name', null, ['class' => 'form-control', 'id' => 'generic-name', 'autocomplete' => 'off']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php $manufac_err_class = $errors->has('manufacturer') ? ' has-error' : ''; ?>
                                        <div class="form-group <?php echo $manufac_err_class; ?>">
                                            <label for="manufacturer" class="control-label">{{ trans('web/counterfeit.label_manufacturer') }}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('manufacturer', null, ['class' => 'form-control', 'id' => 'manufacturer', 'autocomplete' => 'off']) !!}
                                            @if ($errors->has('manufacturer'))
                                                <p class="small text-danger">{!!$errors->first('manufacturer')!!}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="batch-lot" class="control-label">{{ trans('web/counterfeit.label_batch_lot') }}</label>
                                            {!! Form::text('batch_lot', null, ['class' => 'form-control', 'id' => 'batch-lot']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="dose" class="control-label">{{ trans('web/counterfeit.label_dose') }}</label>
                                            {!! Form::text('dose', null, ['class' => 'form-control', 'id' => 'dose']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="dose-form-id" class="control-label">{{ trans('web/counterfeit.label_dose_form') }}</label>
                                        {!! Form::select('dose_form_id', $doseForm, null, ['placeholder' => trans('setup/manufacturer.select_dose_form'), 'class' => 'select form-control', 'id' => 'dose-form-id']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="license-number" class="control-label">{{ trans('web/counterfeit.label_license_number') }}</label>
                                            {!! Form::text('license_number', null, ['class' => 'form-control', 'id' => 'license-number']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="unique-number" class="control-label">{{ trans('web/counterfeit.label_unique_number') }}</label>
                                            {!! Form::text('unique_number', null, ['class' => 'form-control', 'id' => 'unique-number']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="dar-number" class="control-label">{{ trans('web/counterfeit.label_dar_number') }}</label>
                                            {!! Form::text('dar_number', null, ['class' => 'form-control', 'id' => 'dar-number']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="district" class="control-label">{{ trans('web/counterfeit.label_district') }}</label>
                                            {!! Form::select('district_id', $district, null, ['placeholder' => trans('setup/manufacturer.select_district'), 'class' => 'select form-control', 'id' => 'district-id']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="purchase-address" class="control-label">{{ trans('web/counterfeit.label_purchase_address') }}</label>
                                            {!! Form::textarea('purchase_address', null, ['class' => 'form-control', 'id' => 'purchase-address', 'rows' => '4']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="purchase-dt" class="control-label">{{ trans('web/counterfeit.label_purchase_dt') }}</label>
                                            {!! Form::text('purchase_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'purchase-dt']) !!}
                                        </div>
                                        <?php $exp_err_class = $errors->has('expiry_dt') ? ' has-error' : ''; ?>
                                        <div class="form-group <?php echo $exp_err_class; ?>">
                                            <label for="expiry-dt" class="control-label">{{ trans('web/counterfeit.label_expiry_dt') }}<sup class="text-danger">*</sup></label>
                                            {!! Form::text('expiry_dt', null, ['class' => 'form-control call-datepicker', 'id' => 'expiry-dt']) !!}
                                            @if ($errors->has('expiry_dt'))
                                                <p class="small text-danger">{!!$errors->first('expiry_dt')!!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="adverse-effects" class="control-label">{{ trans('web/counterfeit.label_adverse_details') }}</label>
                                    {!! Form::textarea('adverse_effects', null, ['class' => 'form-control', 'id' => 'adverse-effects', 'rows' => '4']) !!}
                                </div>

                            </div> <!-- /.panel-body -->
                        </div> <!-- /.panel -->

                        

                        <div class="text-right">
                            <button type="submit" name="submit_complaint" class="btn btn-primary"><i class="fa fa-paper-plane"></i> {{ trans('web/counterfeit.label_submit_btn') }}</button>
                        </div>
                    
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
         * Conditional incident details.
         * ...
         */
        var incident_radio     = $('[name="incident_aftermath"]'),
            set_other_val      = {{ config('app_config.counterfeit_incident_type_other_id') }}, //dynamic value
            incident_details   = $('#incident-details-item');

        //Default: Hidden by default
        incident_details.hide();

        //Incident Details based on Radio choice
        incident_radio.on( 'change', function() {
            if( set_other_val == $(this).val() ) {
                incident_details.slideDown();
            } else {
                incident_details.find('textarea').val(''); //clear the input, if any
                incident_details.slideUp();
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
         * AutoCompletes
         * using: Bootstrap3 TypeHead.js
         * ...
         */
        $.get('/auto/medicinename', function(data){
            $('#suspected-medicine').typeahead({ source: data, minLength: 2 });
        },'json');

        $.get('/auto/medicinegeneric', function(data){
            $('#generic-name').typeahead({ source: data, minLength: 2 });
        },'json');

        $.get('/auto/manufacturername', function(data){
            $('#manufacturer').typeahead({ source: data, minLength: 2 });
        },'json');

    });
    </script>

@endsection
