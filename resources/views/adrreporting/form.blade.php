<div class="panel panel-default">

	<div class="panel-heading">
	    <div class="row">
			<div class="col-sm-4 form-horizontal">
				<div class="form-group">
					<label class="text-bold col-sm-4 control-label">{{ trans('adrreporting.label_status') }}</label>
					<div class="col-sm-8">
						{!! Form::select('status_id', $adrReportStatus, null, ['placeholder' => trans('adrreporting.select_status'), 'class' => 'select form-control']) !!}
					</div>
				</div>
			</div>
			<div class="col-sm-4 form-horizontal">
				<div class="form-group">
					<label class="text-bold col-sm-4 control-label">{{ trans('adrreporting.label_adr_advice') }}</label>
					<div class="col-sm-8">
						{!! Form::select('advice_id', $adrAdvice, null, ['placeholder' => trans('adrreporting.select_advice'), 'class' => 'select form-control']) !!}
					</div>
				</div>
			</div>
			<div class="col-sm-4 text-right">
				<button class="btn btn-primary btn-xs heading-btn" type="submit">
					<i class="icon-file-check position-left"></i> {{ trans('adrreporting.header_btn_save') }}
				</button>
				@if (SentinelAuth::check('transactions.adrreporting.print'))
					<a class="btn btn-primary btn-xs heading-btn k-grid-print" href="/adrreporting/{{ $getADRReportingInfo[0]->id }}/print" target="_blank">
						<i class='icon-printer'></i> {{ trans('adrreporting.header_btn_print') }}
					</a>
				@endif
			</div>
		</div>

	</div> <!-- /.panel-heading -->

	<div class="panel-body">

		<div class="well well-sm" style="margin-bottom: 20px">
			<div class="row">
				<div class="col-sm-6">
					<h6 class="text-bold">{{ trans('adrreporting.label_id') }} {{ $getADRReportingInfo[0]->id }}</h6>
				</div>
				<div class="col-sm-6 text-right">
					<h6 class="text-bold">{{ trans('adrreporting.label_submission_dt') }} <span class="text-light">{{ $getADRReportingInfo[0]->submission_dt }}</span></h6>
				</div>
			</div>
		</div>

		@include('errors.message')

		<div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="adrrerpoting-accordion">

			<!-- PANEL #1 | Reporter -->
		  	<div class="panel panel-white border-top-xlg border-top-slate">
		  		<div class="panel-heading">
			    	<h5 class="panel-title text-slate">
			    		<a data-toggle="collapse" href="#adrrerpoting-group-1" aria-expanded="true">
			    			<i class="icon-user"></i> {{ trans('adrreporting.title_reporter') }}
			    		</a>
			    	</h5>
				</div> <!-- /.panel-heading -->
		    	<div id="adrrerpoting-group-1" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_name') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->name_title }} {{ $getADRReportingInfo[0]->reporter_name }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_profession') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_profession }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_mobile') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_mobile }}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_district') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_district }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_upazila') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_upazila }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_union') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_union }}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_email') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_email }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_address') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_address }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_reporter_postcode') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->reporter_postcode }}</p>
							</div>
						</div>
					</div> <!-- /.panel-body -->
				</div>
		  	</div> <!-- /.panel panel-flat -->
			<!-- /PANEL #1 | Reporter -->


			<!-- PANEL #2 | Patient -->
		  	<div class="panel panel-white border-top-xlg border-top-slate">
		  		<div class="panel-heading">
			    	<h5 class="panel-title text-slate">
			    		<a aria-expanded="true" data-toggle="collapse" href="#adrrerpoting-group-2">
			    			<i class="icon-aid-kit"></i></i> {{ trans('adrreporting.title_patient') }}
			    		</a>
			    	</h5>
				</div> <!-- /.panel-heading -->
		    	<div id="adrrerpoting-group-2" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-12">
								<label class="text-bold">{{ trans('adrreporting.label_experienced_by') }}</label>
								<p class="text-muted">
									@if( 'you' === $getADRReportingInfo[0]->experienced_by )
										{{ trans('adrreporting.text_mine') }}
									@elseif( 'your child' === $getADRReportingInfo[0]->experienced_by )
										{{ trans('adrreporting.text_my_child') }}
									@else
										{{ trans('adrreporting.text_someone_else') }}
									@endif
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('adrreporting.label_patient_name') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->patient_name }}</p>
							</div>
							<div class="col-sm-2">
								<label class="text-bold">{{ trans('adrreporting.label_patient_gender') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->patient_gender }}</p>
							</div>
							<div class="col-sm-2">
								<label class="text-bold">{{ trans('adrreporting.label_patient_age') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->patient_age }} {{ $getADRReportingInfo[0]->patient_age_unit }}</p>
							</div>
							<div class="col-sm-2">
								<label class="text-bold">{{ trans('adrreporting.label_patient_weight') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->patient_weight }} {{ $getADRReportingInfo[0]->patient_weight_unit }}</p>
							</div>
							<div class="col-sm-2">
								<label class="text-bold">{{ trans('adrreporting.label_patient_height') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->patient_height }} {{ $getADRReportingInfo[0]->patient_height_unit }}</p>
							</div>
						</div>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('adrreporting.title_adverse_effect') }}</legend>
							<div class="row">
								<div class="col-sm-4">
									<label class="text-bold">{{ trans('adrreporting.label_event_started_dt') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->event_starting_dt }}</p>
								</div>
								<div class="col-sm-4">
									<label class="text-bold">{{ trans('adrreporting.label_event_stop_dt') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->event_stop_dt }}</p>
								</div>
								<div class="col-sm-4">
									<label class="text-bold">{{ trans('adrreporting.label_event_reported_dt') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->event_reporting_dt }}</p>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('adrreporting.title_treatment_details') }}</legend>
							<div class="row">
								<div class="col-sm-4">
									<label class="text-bold">{{ trans('adrreporting.label_hospital') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->hospital }}</p>
								</div>
								<?php $treatment_class = 'yes' === $getADRReportingInfo[0]->is_treated ? 'col-sm-4 col-sm-offset-4' : 'col-sm-4'; ?>
								<div class="{{ $treatment_class }}">
									<label class="text-bold">{{ trans('adrreporting.label_patient_ref_number') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->reference_number }}</p>
								</div>
								<?php
								/**
								 * We're not displaying the Yes/No if the value is yes
								 * because the treatment details is filled below, if yes
								 */
								?>
								@if( 'no' === $getADRReportingInfo[0]->is_treated )
									<div class="col-sm-4">
										<label class="text-bold">{{ trans('adrreporting.label_is_treated') }}</label>
										<p class="text-muted">{{ $getADRReportingInfo[0]->is_treated }}</p>
									</div>
								@endif
							</div>

							@if( 'yes' === $getADRReportingInfo[0]->is_treated )
							<div class="row">
								<div class="col-sm-12">
									<label class="text-bold">{{ trans('adrreporting.label_treatment_spec') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->treatment_specification }}</p>
								</div>
							</div>
							@endif
						</fieldset>

					</div> <!-- /.panel-body -->
				</div>
		  	</div> <!-- /.panel panel-flat -->
		  	<!-- /PANEL #2 | Patient -->


		  	<!-- PANEL #3 | Medicine -->
		  	<div class="panel panel-white border-top-xlg border-top-slate">
		  		<div class="panel-heading">
			    	<h5 class="panel-title text-slate">
			    		<a data-toggle="collapse" href="#adrrerpoting-group-3" aria-expanded="true">
			    			<i class="icon-lab"></i> {{ trans('adrreporting.title_medicine') }}
			    		</a>
			    	</h5>
				</div> <!-- /.panel-heading -->
		    	<div id="adrrerpoting-group-3" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3">
								<label class="text-bold">{{ trans('adrreporting.label_suspected_medicine') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->suspected_medicine }}</p>
							</div>
							<div class="col-sm-3">
								<label class="text-bold">{{ trans('adrreporting.label_generic') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->generic_name }}</p>
							</div>
							<div class="col-sm-3">
								<label class="text-bold">{{ trans('adrreporting.label_manufacaturer') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->manufacturer }}</p>
							</div>
							<div class="col-sm-3">
								<label class="text-bold">{{ trans('adrreporting.label_batch_lot') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->batch_lot }}</p>
							</div>
						</div>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('adrreporting.title_dosage') }}</legend>
							<div class="row">
								<div class="col-sm-4">
									<label class="text-bold">{{ trans('adrreporting.label_medicine_started_dt') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->dose_start_dt }}</p>
								</div>
								<div class="col-sm-4">
									<label class="text-bold">{{ trans('adrreporting.label_medicine_stop_dt') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->dose_stop_dt }}</p>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<label class="text-bold">{{ trans('adrreporting.label_medicine_reason') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->medicine_reason }}</p>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-2">
									<label class="text-bold">{{ trans('adrreporting.label_medicine_dose') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->dose }}</p>
								</div>
								<div class="col-sm-2">
									<label class="text-bold">{{ trans('adrreporting.label_medicine_dose_form') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->dose_form }}</p>
								</div>
								<div class="col-sm-2">
									<label class="text-bold">{{ trans('adrreporting.label_medicine_dose_frequency') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->dose_frequency }}</p>
								</div>
								<div class="col-sm-2">
									<label class="text-bold">{{ trans('adrreporting.label_medicine_route') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->dose_route }}</p>
								</div>
								<div class="col-sm-4">
									<label class="text-bold">{{ trans('adrreporting.label_action_after_reaction') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->action_after_reaction }}</p>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<label class="text-bold">{{ trans('adrreporting.label_lab_test_result') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->lab_test_result }}</p>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('adrreporting.title_other_medicines') }}</legend>
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive">
										<table class="table table-striped table-condensed table-framed">
											<thead>
												<tr>
													<th>{{ trans('adrreporting.table_row_brand_name') }}</th>
													<th>{{ trans('adrreporting.table_row_generic') }}</th>
													<th>{{ trans('adrreporting.table_row_indication') }}</th>
													<th>{{ trans('adrreporting.table_row_dosage_form') }}</th>
													<th>{{ trans('adrreporting.table_row_route') }}</th>
													<th>{{ trans('adrreporting.table_row_dose') }}</th>
													<th>{{ trans('adrreporting.table_row_frequency') }}</th>
													<th>{{ trans('adrreporting.table_row_dose_start_dt') }}</th>
													<th>{{ trans('adrreporting.table_row_dose_stop_dt') }}</th>
												</tr>
											</thead>
											<tbody>
												@foreach( $getConcurrentMedicineInfo as $concurrent_medicine )
													<tr class="text-muted">
														<td>{{ $concurrent_medicine->brand_name }}</td>
														<td>{{ $concurrent_medicine->generic }}</td>
														<td>{{ $concurrent_medicine->indication }}</td>
														<td>{{ $concurrent_medicine->dose_form }}</td>
														<td>{{ $concurrent_medicine->dose_route }}</td>
														<td>{{ $concurrent_medicine->dose }}</td>
														<td>{{ $concurrent_medicine->dose_frequency }}</td>
														<td>{{ $concurrent_medicine->dose_start_dt }}</td>
														<td>{{ $concurrent_medicine->dose_stop_dt }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div> <!-- /.table-responsive -->
								</div>
							</div>
						</fieldset>

					</div> <!-- /.panel-body -->
				</div>
		  	</div> <!-- /.panel panel-flat -->
			<!-- /PANEL #3 | Medicine -->


			<!-- PANEL #4 | Adverse Effect -->
		  	<div class="panel panel-white border-top-xlg border-top-slate">
		  		<div class="panel-heading">
			    	<h5 class="panel-title text-slate">
			    		<a data-toggle="collapse" href="#adrrerpoting-group-1" aria-expanded="true">
			    			<i class="icon-pulse2"></i> {{ trans('adrreporting.title_adverse_effect') }}
			    		</a>
			    	</h5>
				</div> <!-- /.panel-heading -->
		    	<div id="adrrerpoting-group-1" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3">
								<label class="text-bold">{{ trans('adrreporting.label_adverse_effect_start_dt') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->effect_start_dt }}</p>
							</div>
							<div class="col-sm-6">
								<label class="text-bold">{{ trans('adrreporting.label_adverse_effect_details') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->adverse_effects }}</p>
							</div>
							<div class="col-sm-3">
								<label class="text-bold">{{ trans('adrreporting.label_adverse_effect_stop_dt') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->effect_end_dt }}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<label class="text-bold">{{ trans('adrreporting.label_adverse_effect_seriousness') }}</label>
								<ul class="list-unstyled text-muted">
									@foreach( $getAdverseEffectSeriousness as $seriousness )
										<li>
											<i class="icon-meter-fast"></i> {{ $seriousness->seriousness_label }}
										</li>
									@endforeach
								</ul>
							</div>
							<div class="col-sm-6">
								<label class="text-bold">{{ trans('adrreporting.label_adverse_effect_outcome') }}</label>
								<ul class="list-unstyled text-muted">
									@foreach( $getAdverseEffectOutcome as $outcome )
										<li>
											<i class="icon-meter-fast"></i> {{ $outcome->outcome_label }}
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
											@if( config('app_config.adverse_effect_outcome_fatal_id') == $outcome->event_id && !empty($getADRReportingInfo[0]->outcome_fatal_dt) )
												{{ ' &mdash; '. trans('adrreporting.date_of_death') .'&nbsp;'. $getADRReportingInfo[0]->outcome_fatal_dt }}
											@endif
										</li>
									@endforeach
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<label class="text-bold">{{ trans('adrreporting.label_adverse_effect_other_history') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->other_history }}</p>
							</div>
						</div>
					</div> <!-- /.panel-body -->
				</div>
		  	</div> <!-- /.panel panel-flat -->
			<!-- /PANEL #4 | Adverse Effect -->


			<!-- PANEL #5 | Additional Details -->
		  	<div class="panel panel-white border-top-xlg border-top-slate">
		  		<div class="panel-heading">
			    	<h5 class="panel-title text-slate">
			    		<a data-toggle="collapse" href="#adrrerpoting-group-1" aria-expanded="true">
			    			<i class="icon-folder"></i> {{ trans('adrreporting.title_additional_details') }}
			    		</a>
			    	</h5>
				</div> <!-- /.panel-heading -->
		    	<div id="adrrerpoting-group-1" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<?php $three_months_class = 'yes' === $getADRReportingInfo[0]->is_medicine_three_months ? 'col-sm-6' : 'col-sm-12'; ?>
							<div class="{{ $three_months_class }}">
								<label class="text-bold">{{ trans('adrreporting.label_is_medicine_three_months') }}</label>
								<?php
								switch ($getADRReportingInfo[0]->is_medicine_three_months) {
									case 'no':
										$is_three_months     	= trans('adrreporting.label_no');
										$is_three_months_icon = '<i class="icon-close2"></i>';
										break;

									case 'yes':
										$is_three_months     	= trans('adrreporting.label_yes');
										$is_three_months_icon = '<i class="icon-checkmark-circle2"></i>';
										break;

									case 'unknown':
										$is_three_months     	= trans('adrreporting.label_unknown');
										$is_three_months_icon = '<i class="icon-exclamation"></i>';
										break;
									
									default:
										$is_three_months     	= trans('adrreporting.label_unknown');
										$is_three_months_icon = '<i class="icon-exclamation"></i>';
										break;
								}
								?>
								<p class="text-muted">{!! $is_three_months_icon !!} {{ $is_three_months }}</p>
							</div>

							@if( 'yes' === $getADRReportingInfo[0]->is_medicine_three_months )
								<div class="col-sm-6">
									<label class="text-bold">{{ trans('adrreporting.label_medice_three_months') }}</label>
									<ol class="text-muted">
										@foreach( $getThreeMonthsMedicineInfo as $three_months_medicine )
											<li>{{ $three_months_medicine->medicine_name }}</li>
										@endforeach
									</ol>
								</div>
							@endif
						</div>

						<div class="row">
							<div class="col-sm-12">
								<label class="text-bold">{{ trans('adrreporting.label_miscellaneous_info') }}</label>
								<p class="text-muted">{{ $getADRReportingInfo[0]->miscellaneous_info }}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<label class="text-bold">{{ trans('adrreporting.label_is_doctor_told') }}</label>
								<?php
								switch ($getADRReportingInfo[0]->is_doctor_told) {
									case 'no':
										$is_doctor_told      = trans('adrreporting.label_no');
										$is_doctor_told_icon = '<i class="icon-close2"></i>';
										break;

									case 'yes':
										$is_doctor_told      = trans('adrreporting.label_yes');
										$is_doctor_told_icon = '<i class="icon-checkmark-circle2"></i>';
										break;

									case 'unknown':
										$is_doctor_told      = trans('adrreporting.label_unknown');
										$is_doctor_told_icon = '<i class="icon-exclamation"></i>';
										break;
									
									default:
										$is_doctor_told      = trans('adrreporting.label_unknown');
										$is_doctor_told_icon = '<i class="icon-exclamation"></i>';
										break;
								}
								?>
								<p class="text-muted">{!! $is_doctor_told_icon !!} {{ $is_doctor_told }}</p>
							</div>
							<div class="col-sm-6">
								<label class="text-bold">{{ trans('adrreporting.label_is_doctor') }}</label>
								<?php
								switch ($getADRReportingInfo[0]->is_doctor) {
									case 'no':
										$is_doctor     	= trans('adrreporting.label_no');
										$is_doctor_icon = '<i class="icon-close2"></i>';
										break;

									case 'yes':
										$is_doctor     	= trans('adrreporting.label_yes');
										$is_doctor_icon = '<i class="icon-checkmark-circle2"></i>';
										break;

									case 'unknown':
										$is_doctor     	= trans('adrreporting.label_unknown');
										$is_doctor_icon = '<i class="icon-exclamation"></i>';
										break;
									
									default:
										$is_doctor     	= trans('adrreporting.label_unknown');
										$is_doctor_icon = '<i class="icon-exclamation"></i>';
										break;
								}
								?>
								<p class="text-muted">{!! $is_doctor_icon !!} {{ $is_doctor }}</p>
							</div>
						</div>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('adrreporting.title_doctor_info') }}</legend>
							<div class="row">
								<div class="col-sm-6">
									<label class="text-bold">{{ trans('adrreporting.label_doctor_name') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->doctor_name }}</p>
								</div>
								<div class="col-sm-6">
									<label class="text-bold">{{ trans('adrreporting.label_doctor_hospital') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->doctor_hospital }}</p>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<label class="text-bold">{{ trans('adrreporting.label_doctor_address') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->doctor_address }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('adrreporting.label_doctor_district') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->doctor_district }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('adrreporting.label_doctor_postcode') }}</label>
									<p class="text-muted">{{ $getADRReportingInfo[0]->doctor_postcode }}</p>
								</div>
							</div>
						</fieldset>
					</div> <!-- /.panel-body -->
				</div>
		  	</div> <!-- /.panel panel-flat -->
			<!-- /PANEL #5 | Additional Details -->

	  	</div> <!-- /.panel-group -->
	    
	</div> <!-- /.panel-body -->

</div> <!-- /.panel panel-flat -->
