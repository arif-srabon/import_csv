<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Password Reminder</title>

<!-- Global stylesheets -->
{{--
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
--}}
<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="assets/css/core.css" rel="stylesheet" type="text/css">
<link href="assets/css/components.css" rel="stylesheet" type="text/css">
<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
<link href="assets/css/login.css" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->

<!-- Core JS files -->
<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
<!-- /core JS files -->


</head><body class="">

<!-- Page container -->
<div class="page-container login-container"> 
  
  <!-- Page content -->
  <div class="page-content"> 
    
    <!-- Main content -->
    <div class="content-wrapper"> 
      
      <!-- Content area -->
      <div class="content tvl-login"> 
        
        <!-- Login form --> 
         <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <div class="panel">
              <div class="panel-body tvl-login-panel-body text-center">
                <div class="row">
                  <div class="col-sm-3 text-center"> <img alt="People's Republic of Bangladesh Logo" src="{{ asset('assets/images/bangladesh-govt-logo.png') }}" width="70" height="70"> </div>
                  <div class="col-sm-6">
                    <h1 class="text-black"> {{ trans('users/login.department') }} </h1>
                    <h2 class="text-light text-size-large"> {{ trans('users/login.vata_management_system') }} </h2>
                  </div>
                  <div class="col-sm-3"> &nbsp; </div>
                </div>
                
                <!-- /.tvl-inline-header -->
                
                <p class="text-size-large text-black">Forgot Password?</p>
                <div class="row">
                  <div>
                   @include('errors.validation')
                   
                   @if (Session::get('error'))
                    <div class="alert alert-error">{{ Session::get('error') }}</div>
                    @endif
                    
                    @if (Session::get('notice'))
                    <div class="alert">{{ Session::get('notice') }}</div>
                    @endif
                    
                    {!! Form::open(array('action' => 'ReminderController@store')) !!}
                     {!! Form::label('email', 'Provide your username or e-mail address') !!}
                    <div class="form-group has-feedback has-feedback-left"> 
                    {!! Form::text('login', null, array('class' => 'form-control', 'placeholder'=>'Email or Username', 'required'=>'required')) !!}
                      <div class="form-control-feedback"><i class="icon-mail5 text-muted"></i></div>
                    </div>
                     {!! Form::submit('Get Password Reset', array('class' => 'btn btn-info')) !!}
                    
                    {!! Form::close() !!} </div>
                </div>
              </div>
            </div>
          </div>
        </div>
         <!-- /Login form --> 
        
        <!-- Footer -->
        <div class="footer tvl-login-footer text-muted"> &copy; 2016. <a href="#">{{trans('master.footer_dss')}}</a> | {{trans('master.footer_powered')}} <a href="http://www.technovista.com.bd" target="_blank">{{trans('master.footer_tvl')}}</a> </div>
        <!-- /footer --> 
        
      </div>
      <!-- /content area --> 
      
    </div>
    <!-- /main content --> 
    
  </div>
  <!-- /page content --> 
  
</div>
<!-- /page container -->

</body>
</html>
 
 
 