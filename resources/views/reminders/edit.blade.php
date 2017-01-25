@extends('layouts.web')
@section('content')
<div class="row">
  <div class="col-sm-6 col-sm-offset-3">
    <div class="panel">
      <div class="panel-body tvl-login-panel-body text-center"> 
      
      	@include('errors.validation')
                         
	    @if (Session::get('error'))
         	<div class="alert alert-error">{{ Session::get('error') }}</div>
        @endif
        
        @if (Session::get('notice'))
	        <div class="alert">{{ Session::get('notice') }}</div>
        @endif
        
        <div class="row">
                  <div class="col-sm-3 text-center"> <img alt="People's Republic of Bangladesh Logo" src="{{ asset('assets/images/bangladesh-govt-logo.png') }}" width="70" height="70"> </div>
                  <div class="col-sm-6">
                    <h1 class="text-black"> {{ trans('users/login.department') }} </h1>
                    <h2 class="text-light text-size-large"> {{ trans('users/login.vata_management_system') }} </h2>
                  </div>
            <div class="col-sm-3"> &nbsp; </div>
                </div>
         <p class="text-size-large text-black">Reset Your New Password</p>
        
        {!! Form::open(['reminders.update', $id, $code]) !!}
        {!! Form::password('password', array('placeholder'=>'new password', 'required'=>'required')) !!}
        {!! Form::password('password_confirmation', array('placeholder'=>'new password confirmation', 'required'=>'required')) !!}
        {!! Form::submit('Reset Password') !!}
        {!! Form::close() !!} </div>
    </div>
  </div>
</div>
@stop