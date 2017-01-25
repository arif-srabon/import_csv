<div class="panel panel-default">

	<div class="panel-heading">
	    <div class="row">
			<div class="col-sm-4 form-horizontal">
				<div class="form-group">
					<label class="text-bold col-sm-4 control-label">{{ trans('counterfeit.label_status') }}</label>
					<div class="col-sm-8">
						{!! Form::select('status_id', $adrReportStatus, null, ['placeholder' => trans('counterfeit.select_status'), 'class' => 'select form-control']) !!}
					</div>
				</div>
			</div>
			<div class="col-sm-4 form-horizontal">
				<div class="form-group">
					<label class="text-bold col-sm-4 control-label">{{ trans('counterfeit.label_counterfeit_advice') }}</label>
					<div class="col-sm-8">
						{!! Form::select('advice_id', $adrAdvice, null, ['placeholder' => trans('counterfeit.select_advice'), 'class' => 'select form-control']) !!}
					</div>
				</div>
			</div>
			<div class="col-sm-4 text-right  hidden-print">
				<button class="btn btn-primary btn-xs heading-btn" type="submit">
					<i class="icon-file-check position-left"></i> {{ trans('counterfeit.header_btn_save') }}
				</button>
				@if (SentinelAuth::check('transactions.counterfeit.print'))
					<a class="btn btn-primary btn-xs heading-btn k-grid-print" href="/counterfeit/{{ $getCounterfeitInfo[0]->id }}/print" target="_blank">
						<i class='icon-printer'></i> {{ trans('counterfeit.header_btn_print') }}
					</a>
				@endif
			</div>
		</div>

	</div> <!-- /.panel-heading -->

	<div class="panel-body">

		<div class="well well-sm" style="margin-bottom: 20px">
			<div class="row">
				<div class="col-xs-6">
					<h6 class="text-bold">{{ trans('counterfeit.label_id') }} {{ $getCounterfeitInfo[0]->id }}</h6>
				</div>
				<div class="col-xs-6 text-right">
					<h6 class="text-bold">{{ trans('counterfeit.label_submission_dt') }} <span class="text-light">{{ $getCounterfeitInfo[0]->submission_dt }}</span></h6>
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
			    			<i class="icon-user"></i> {{ trans('counterfeit.title_reporter') }}
			    		</a>
			    	</h5>
				</div> <!-- /.panel-heading -->
		    	<div id="adrrerpoting-group-1" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_name') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->name_title }} {{ $getCounterfeitInfo[0]->reporter_name }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_profession') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_profession }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_mobile') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_mobile }}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_district') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_district }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_upazila') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_upazila }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_union') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_union }}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_email') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_email }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_address') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_address }}</p>
							</div>
							<div class="col-sm-4">
								<label class="text-bold">{{ trans('counterfeit.label_reporter_postcode') }}</label>
								<p class="text-muted">{{ $getCounterfeitInfo[0]->reporter_postcode }}</p>
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
			    		<a data-toggle="collapse" href="#adrrerpoting-group-3" aria-expanded="true">
			    			<i class="icon-file-text"></i> {{ trans('counterfeit.title_incident_medicine') }}
			    		</a>
			    	</h5>
				</div> <!-- /.panel-heading -->
		    	<div id="adrrerpoting-group-3" class="panel-collapse collapse in">
					<div class="panel-body">
						<fieldset>
							<legend class="text-bold text-slate">{{ trans('counterfeit.title_incident') }}</legend>
							<div class="row">
								<div class="col-sm-6">
									<label class="text-bold">{{ trans('counterfeit.label_is_incident') }}</label>
									<ul class="list-unstyled text-muted">
										@foreach( $getCounterfeitIncidentInfo as $incident )
											<?php
											/**
											 * Array: Incident IDs
											 * Just to make easy checking value for 'other'
											 * field to display the detail text on the
											 * next block.
											 */
											$incident_ids[] = $incident->incident_id; ?>
											<li>
												<i class="icon-point-right"></i> {{ 'bn' === App::getLocale() ? $incident->incident_label_bn : $incident->incident_label }}
											</li>
										@endforeach
									</ul>
									
								</div>
								<?php
								/**
								 * Taking the Counterfeit Incident 'other' field's ID from
								 * app_config file to make it dynamic. User have to change
								 * the value of the `cc_counterfeit_incident` table's row
								 * `id` so that both can match and display the details
								 * filed accordingly
								 * ...
								 */
								?>
								@if( in_array( config('app_config.counterfeit_incident_type_other_id'), $incident_ids ) )
									<div class="col-sm-6">
										<label class="text-bold">{{ trans('counterfeit.label_incident_details') }}</label>
										<div class="text-muted">{{ $getCounterfeitInfo[0]->incident_details }}</div>
									</div>
								@endif
							</div>
						</fieldset>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('counterfeit.title_product') }}</legend>
							<div class="row">
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_suspected_medicine') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->suspected_medicine }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_generic') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->generic_name }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_manufacaturer') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->manufacturer }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_batch_lot') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->batch_lot }}</p>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_license_number') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->license_number }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_unique_number') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->unique_number }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_dar_number') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->dar_number }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_expiry_dt') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->expiry_dt }}</p>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('counterfeit.title_dosage') }}</legend>
							<div class="row">
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_medicine_dose') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->dose }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_medicine_dose_form') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->dose_form }}</p>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('counterfeit.title_purchase') }}</legend>
							<div class="row">
								<div class="col-sm-6">
									<label class="text-bold">{{ trans('counterfeit.label_purchase_address') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->purchase_address }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_purchase_district') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->purchase_district }}</p>
								</div>
								<div class="col-sm-3">
									<label class="text-bold">{{ trans('counterfeit.label_purchase_dt') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->purchase_dt }}</p>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend class="text-bold text-slate">{{ trans('counterfeit.title_adverse_effects') }}</legend>
							<div class="row">
								<div class="col-sm-12">
									<label class="text-bold">{{ trans('counterfeit.label_adverse_effects') }}</label>
									<p class="text-muted">{{ $getCounterfeitInfo[0]->adverse_effects }}</p>
								</div>
							</div>
						</fieldset>

					</div> <!-- /.panel-body -->
				</div>
		  	</div> <!-- /.panel panel-flat -->
			<!-- /PANEL #2 | PRODUCT & INCIDENT -->

	  	</div> <!-- /.panel-group -->
	    
	</div> <!-- /.panel-body -->

</div> <!-- /.panel panel-flat -->
