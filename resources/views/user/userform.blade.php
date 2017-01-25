@extends('layouts.master')
@section('page_title', 'User Information')

@section('page_header')
<div class="page-header-content">
  <div class="page-title">
    <h4><i class="icon-meter2 position-left"></i> <span class="text-semibold">User</span></h4>
  </div>
  <div class="heading-elements"> <a href="#" class="btn btn-labeled btn-labeled-right bg-blue heading-btn">Button <b><i class="icon-menu7"></i></b></a> </div>
</div>
@endsection


@section('breadcrumb')
<div class="breadcrumb-line">
  <ul class="breadcrumb">
    <li><a href="/"><i class="icon-home2 position-left"></i> Security</a></li>
    <li><a href="2_col.html">User</a></li>
    <li class="active">Add</li>
  </ul>
  <ul class="breadcrumb-elements">
    <li><a href="#"><i class="icon-user position-left"></i> User List</a></li>
    <li><a href="#"><i class="icon-user-plus position-left"></i> Add User</a></li>
    <li><a href="#"><i class="icon-user-check position-left"></i> User Permission</a></li>
  </ul>
</div>
@endsection


@section('content') 

<!-- User Form -->

<div class="panel panel-flat">
  <div class="panel-heading">
    <h5 class="panel-title">Add User Information</h5>
    <div class="heading-elements">
      <ul class="icons-list">
        <li><a data-action="collapse"></a></li>
        <li><a data-action="reload"></a></li>
        <li><a data-action="close"></a></li>
      </ul>
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div class="panel-body"> 
  
  {!! Form::open(['url' => 'user', 'method' => 'post']) !!}
  
    <div class="row">
      <div class="col-md-12">
        <fieldset>
          <legend class="text-semibold"><i class="icon-bookmark4 position-left"></i> User Idientity</legend>
          <div class="col-md-6">
            <div class="form-group">

             {!! Form::label('full_name_en', 'User Name (English) *') !!}	
             {!! Form::text('full_name_en', null, ['class' => 'form-control', 'placeholder' => 'Username full name']) !!}            

            </div>
            <div class="form-group">
              
              {!! Form::label('idsc_center_id', 'IDSC Center *') !!}	
              {!! Form::select('idsc_center_id', array('L' => 'Large', 'S' => 'Small'), 'S', ['placeholder' => 'Select IDSC Center', 'class' => 'select form-control']) !!}
              
              
              </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                   
              {!! Form::label('designation_id', 'Designation *') !!}	
              {!! Form::select('designation_id', array('L' => 'Large', 'S' => 'Small'), 'S', ['placeholder' => 'Select Designation', 'class' => 'select form-control']) !!}
                  
                  </div>
                <div class="form-group">
                  
                    {!! Form::label('password', 'Password *') !!}	
                      {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
             
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                   {!! Form::label('email', 'User Name / Login ID *') !!}	
             	   {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Username for login']) !!}    
                </div>
                <div class="form-group">
                   {!! Form::label('confirm_password', 'Confirmed Password *') !!}	
                   {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Retype Password']) !!}
                </div>
              </div>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <fieldset>
          <legend class="text-semibold"><i class="icon-reading position-left"></i> Personal details</legend>
          <div class="form-group">
            
           {!! Form::label('full_name_bn', 'User Full Name (Bangla)') !!}	
           {!! Form::text('full_name_bn', null, ['class' => 'form-control', 'placeholder' => 'User full name in bangla']) !!}    

          </div>
          <div class="form-group">
            
           {!! Form::label('father_name', "Father's Name") !!}	
           {!! Form::text('father_name', null, ['class' => 'form-control', 'placeholder' => 'User father name']) !!}    


          </div>
          <div class="form-group">
            
           {!! Form::label('mother_name', "Mother's Name") !!}	
           {!! Form::text('mother_name', null, ['class' => 'form-control', 'placeholder' => 'User mother name']) !!}    

          </div>

          <div class="form-group">
             {!! Form::label('official_email', 'E-mail *') !!}	
             {!! Form::email('official_email', null, ['class' => 'form-control', 'placeholder' => 'user@example.com']) !!}    
		  </div>             
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                            
                {!! Form::label('blood_group', 'Blood Group') !!}	
             	{!! Form::text('blood_group', null, ['class' => 'form-control', 'placeholder' => '']) !!}   
             
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">               
                
                {!! Form::label('date_of_birth', 'Date of Birth') !!}	
             	{!! Form::date('date_of_birth', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => '']) !!}                   
                
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">                
                
                {!! Form::label('date_of_joining', 'Date of Joining (1st)') !!}	
             	{!! Form::date('date_of_joining', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => '']) !!}   
                
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">                 
                
                {!! Form::label('mobile', 'Mobile') !!}	
             	{!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => '+88-0123-456789']) !!}  
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                
                {!! Form::label('passport', 'Passport') !!}	
             	{!! Form::text('passport', null, ['class' => 'form-control', 'placeholder' => '']) !!}  
                
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
               
                {!! Form::label('national_id', 'National ID (NID)') !!}	
             	{!! Form::text('national_id', null, ['class' => 'form-control', 'placeholder' => '']) !!}  
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                    
              {!! Form::label('marital_status_id', 'Marital Status') !!}	
              {!! Form::select('marital_status_id', array('L' => 'Married', 'S' => 'Unmarried'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
               
              </div>
            </div>
          </div>
           
        </fieldset>
      </div>
      <div class="col-md-6">
        <fieldset>
          <legend class="text-semibold"><i class="icon-camera position-left"></i> User Photo &amp; Signature</legend>
          <div class="row">
              <div class="col-md-6">
	              <div class="thumbnail">
                <div class="thumb thumb-rounded thumb-slide"> <img alt="" src="{{ asset('assets/images/placeholder.jpg') }}">
                  <div class="caption"> <span> <a data-popup="lightbox" class="btn bg-success-400 btn-icon btn-xs" href="#"><i class="icon-plus2"></i></a> <a class="btn bg-success-400 btn-icon btn-xs" href="user_pages_profile.html"><i class="icon-link"></i></a> </span> </div>
                </div>
                <div class="caption text-center">
                  <div class="form-group">
                    <label>User Photo</label>
                   <div class="1uploader bg-warning">                    
                      {!! Form::file('signature', []) !!}
					</div>
                    <span class="help-block">Accepted formats: jpg, jpeg, gif. Max file size 1Mb</span> </div>
                </div>
              </div>
              </div>
              <div class="col-md-6">
    	          <div class="thumbnail">
                <div class="thumb thumb-rounded thumb-slide"> <img alt="" src="{{ asset('assets/images/placeholder.jpg') }}">
                  <div class="caption"> <span> <a data-popup="lightbox" class="btn bg-success-400 btn-icon btn-xs" href="#"><i class="icon-plus2"></i></a> <a class="btn bg-success-400 btn-icon btn-xs" href="user_pages_profile.html"><i class="icon-link"></i></a> </span> </div>
                </div>
                <div class="caption text-center">
                  <div class="form-group">
                    <label>User Signature</label>
                    <div class="1uploader bg-warning">                    
                      {!! Form::file('signature', []) !!}
					</div>
                    <span class="help-block">Accepted formats: jpg, jpeg, gif. Max file size 1Mb</span> </div>
                </div>
              </div>
              </div>
          </div>
          
          
          
          <div class="form-group">
            <label class="display-block">Status</label>
            <label class="radio-inline">
            <div class="">
              {!! Form::radio('status', '1', true) !!}              
              </div>
            Active
            </label>
            <label class="radio-inline">
            <div class="">
              {!! Form::radio('status', '0') !!}              
              </div>
            Inactive
            </label>
          </div>
          
           <div class="thumbnail">
          <div class="caption text-left">
              <div class="form-group pt-15">
                <fieldset>
                  <legend class="text-semibold"><i class="icon-users4 position-left"></i> Assign Role(s)</legend>
                  <div class="row">
                     
                     <div class="col-md-6">
                          <div class="checkbox">
                            <label> {!! Form::checkbox('role[]', '1', true) !!} Role name 1 </label>
                          </div>
                     </div>
                     <div class="col-md-6">
                          <div class="checkbox">
                            <label> {!! Form::checkbox('role[]', '1', true) !!} Role name 1 </label>
                          </div>
                     </div>
                     <div class="col-md-6">
                          <div class="checkbox">
                            <label> {!! Form::checkbox('role[]', '1', true) !!} Role name 1 </label>
                          </div>
                     </div>
                     <div class="col-md-6">
                          <div class="checkbox">
                            <label> {!! Form::checkbox('role[]', '1', true) !!} Role name 1 </label>
                          </div>
                     </div>
                     <div class="col-md-6">
                          <div class="checkbox">
                            <label> {!! Form::checkbox('role[]', '1', true) !!} Role name 1 </label>
                          </div>
                     </div>
                     <div class="col-md-6">
                          <div class="checkbox">
                            <label> {!! Form::checkbox('role[]', '1', true) !!} Role name 1 </label>
                          </div>
                     </div>
                     
                   </div>
                </fieldset>
              </div>
          </div>
          </div>    
           
        </fieldset>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <fieldset>
          <legend class="text-semibold"><i class="icon-home position-left"></i> Permanent Address</legend>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
              
                {!! Form::label('permanent_house_road', 'House / Road') !!}	
             	{!! Form::text('permanent_house_road', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
             
                {!! Form::label('permanent_village', 'Village') !!}	
             	{!! Form::text('permanent_village', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
                
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                       
              {!! Form::label('permanent_division', 'Division') !!}	
              {!! Form::select('permanent_division', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
           
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
               
              {!! Form::label('permanent_district', 'District') !!}	
              {!! Form::select('permanent_district', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
           
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">               
              {!! Form::label('permanent_zilla', 'Zilla') !!}	
              {!! Form::select('permanent_zilla', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">                
              {!! Form::label('permanent_upzilla', 'Upzilla') !!}	
              {!! Form::select('permanent_upzilla', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
             {!! Form::label('permanent_thana', 'Thana') !!}	
              {!! Form::select('permanent_thana', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">             
             {!! Form::label('permanent_postcode', 'Postcode') !!}	
		  	 {!! Form::text('permanent_postcode', null, ['class' => 'form-control', 'placeholder' => '']) !!} 

              </div>
            </div>
          </div>
        </fieldset>
      </div>
      <div class="col-md-6">
        <fieldset>
          <legend class="text-semibold"><i class="icon-flag3 position-left"></i> Present Address &nbsp;&nbsp;&nbsp;[ {!! Form::checkbox('name', 'value') !!} copy ]</legend>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                 
                {!! Form::label('permanent_house_road', 'House / Road') !!}	
             	{!! Form::text('permanent_house_road', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              
                {!! Form::label('permanent_village', 'Village') !!}	
             	{!! Form::text('permanent_village', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
              {!! Form::label('permanent_division', 'Division') !!}	
              {!! Form::select('permanent_division', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              {!! Form::label('permanent_district', 'District') !!}	
              {!! Form::select('permanent_district', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
              {!! Form::label('permanent_zilla', 'Zilla') !!}	
              {!! Form::select('permanent_zilla', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              {!! Form::label('permanent_upzilla', 'Upzilla') !!}	
              {!! Form::select('permanent_upzilla', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
             {!! Form::label('permanent_thana', 'Thana') !!}	
              {!! Form::select('permanent_thana', array('L' => 'A', 'S' => 'B'), 'S', ['placeholder' => 'Select', 'class' => 'select form-control']) !!}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
             {!! Form::label('permanent_postcode', 'Postcode') !!}	
		  	 {!! Form::text('permanent_postcode', null, ['class' => 'form-control', 'placeholder' => '']) !!} 
              </div>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
    <div class="text-right">
      <button class="btn btn-primary" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
    </div>
    
    {!! Form::close() !!} 
    
    </div>
</div>

<!-- /User form --> 

@endsection