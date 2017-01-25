@extends('layouts.master')
@section('page_title', trans('users/user.lbl_change_password'))

@section('page_header') <i class="icon-gear position-left"></i> <span class="text-semibold">{{trans('users/user.lbl_change_password')}}</span> @endsection


@section('content')
<div class="panel panel-flat">
  <div class="panel-body"> 
   
   @include('errors.message')
   
    {!! Form::open(['url' => 'savepasswd',  'id' => 'frm_passwd', 'method' => 'PATCH']) !!}
    <div class="row">
      <div class="col-md-12">
        <fieldset>
          <legend class="text-semibold"><i class="icon-bookmark4 position-left"></i>{{trans('users/user.lbl_set_new_password')}}</legend>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group"> 
              	{!! Form::label('old_password', trans('users/user.lbl_old_password')) !!}
                {!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => trans('users/user.ph_cur_password')]) !!}
                @if ($errors->has('old_password'))<p class="text-danger">{!!$errors->first('old_password')!!}</p>@endif
                 </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> {!! Form::label('password', trans('users/user.lbl_new_password')) !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('users/user.ph_new_password')]) !!}
                @if ($errors->has('password'))<p class="text-danger">{!!$errors->first('password')!!}</p>@endif
                </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> {!! Form::label('password_confirmation', trans('users/user.lbl_confirmed_password')) !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('users/user.ph_retype_password')]) !!}
                @if ($errors->has('password_confirmation'))<p class="text-danger">{!!$errors->first('password_confirmation')!!}</p>@endif
                </div>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
    <div class="text-right">
      <button id="reset" class="btn btn-default" type="reset">{{trans('users/user.btn_reset')}} <i class="icon-reload-alt position-right"></i></button>
      <button class="btn btn-primary" type="submit">{{trans('users/user.btn_change_password')}}<i class="icon-arrow-right14 position-right"></i></button>
    </div>
    
    {!! Form::close() !!} 
    
    </div>
</div> 
@endsection