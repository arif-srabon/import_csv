<div class="panel panel-white">
  <div class="panel-heading">
    <h6 class="panel-title">Complaint # {{ $complaintInfo[0]->id }} (<strong>Type:</strong> {{ 'bn' === Session::get('locale') ? $complaintInfo[0]->complaint_type_bn : $complaintInfo[0]->complaint_type }})</h6>
    <div class="heading-elements">
    @if (SentinelAuth::check('transactions.complaint.edit'))
      <button class="btn btn-default btn-xs heading-btn" type="submit"><i class="icon-file-check position-left"></i> Save</button>
    @endif
    @if (SentinelAuth::check('transactions.complaint.print'))  
      <a class="btn btn-default btn-xs heading-btn" type="button" href="/complaint/{{ $complaintInfo[0]->id }}/print" target="_blank"><i class="icon-printer position-left"></i> Print</a>
     @endif 
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div contenteditable="true" id="invoice-editable" class="cke_editable cke_editable_inline cke_contents_ltr" tabindex="0" spellcheck="false" style="position: relative;" role="textbox">
    <div class="panel-body no-padding-bottom">
      <div class="row">
        <div class="col-md-6 content-group"> <span class="text-muted">Complaint by</span>
          <ul class="list-condensed list-unstyled">
            <li>
              <h5>{{ $complaintInfo[0]->repoter_title }} {{ $complaintInfo[0]->full_name }}</h5>
            </li>
            <li><span class="text-semibold">{{ $complaintInfo[0]->address }}</span></li>
            <li>{{ $complaintInfo[0]->upazilla_name }} , {{ $complaintInfo[0]->district_name }}</li>
            <li>{{ $complaintInfo[0]->division_name }}</li>
            <li>{{ $complaintInfo[0]->postcode }}</li>
            <li>{{ $complaintInfo[0]->phone }}</li>
            <li><a href=mailto:{{ $complaintInfo[0]->email }} data-cke-saved-href="#">{{ $complaintInfo[0]->email }}</a></li>
          </ul>
        </div>
        <div class="col-md-6 content-group">
          <div class="invoice-details">
            <ul class="list-condensed list-unstyled">
              <li>Submit Date: <span class="text-semibold">{{ $complaintInfo[0]->submit_date }}</span></li>
              <li>Status: {!! Form::select('status_id', $complaintStatus, null, ['placeholder' => trans('setup/medicine.ph_select'), 'class' => 'select form-control']) !!}</li>
              <li>Report Advice: {!! Form::select('report_advice_id', $complaintReportAdvice, null, ['placeholder' => trans('setup/medicine.ph_select'), 'class' => 'select form-control']) !!}</li>
            </ul>
             {!! Form::hidden('id') !!}
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <h6>Complant Details</h6>
      <p class="text-muted"><?php echo nl2br( htmlentities($complaintInfo[0]->complaint_details)); ?></p>

      <br>
      <?php echo isset($complaintInfo[0]->is_sms_notification) && $complaintInfo[0]->is_sms_notification == 1 ? '<span class="label label-primary"><i class="small icon-mobile"></i> '. trans('trans/complaint.sms_notification_label') .'</span>' : ''; ?>
    </div>
  </div>
</div>
