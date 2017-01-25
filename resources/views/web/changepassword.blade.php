@extends('layouts.login_registration')

<!-- display page title -->
@section('page_title', trans('users/user.lbl_set_new_password'))

@section('form_content')

    <div class="login-form-area">

        <div id="content">
            
            <header class="box-header">
                <h3 class="login-title text-uppercase text-center">{{trans('users/user.lbl_set_new_password')}}</h3>
            </header>
            
            @include('errors.message')


            {!! Form::open(['url' => 'savechangepasswd',  'id' => 'frm_passwd', 'method' => 'PATCH']) !!}


                <div class="form-group">
                    <label for="old-password">{{ trans('users/user.lbl_old_password') }}</label>
                    {!! Form::password('old_password', ['class' => 'form-control', 'id' => 'old-password', 'placeholder' => trans('users/user.ph_cur_password')]) !!}
                    @if ($errors->has('old_password'))
                        <p class="small text-danger">{!!$errors->first('old_password')!!}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('users/user.lbl_new_password') }}</label>
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => trans('users/user.ph_new_password')]) !!}
                    @if ($errors->has('password'))
                        <p class="small text-danger">{!!$errors->first('password')!!}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password-confirmation">{{ trans('users/user.lbl_confirmed_password') }}</label>
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirmation', 'placeholder' => trans('users/user.ph_retype_password')]) !!}
                    @if ($errors->has('password_confirmation'))
                        <p class="small text-danger">{!!$errors->first('password_confirmation')!!}</p>
                    @endif
                </div>

                <div class="form-group text-center">
                    {{ Form::button( trans('users/user.btn_change_password'), array('type' => 'submit', 'class' => 'btn btn-info text-uppercase', 'id'=> 'password-reset-submit')) }}
                </div>
            
            {!! Form::close() !!}

            <p class="text-center small">
                <a href="{{ url('/home') }}">{{ trans('web/login_registration.back_home') }}</a>
            </p>

            <p class="login-language-switcher text-center small">
                @if ( 'bn' === Session::get("locale") )
                    <a id="switch-lang-to-en" href="javascript:">
                        <i class="fa fa-language"></i> English
                    </a>
                @endif

                @if ( 'en' === Session::get("locale") )
                    <a id="switch-lang-to-bn" href="javascript:">
                        <i class="fa fa-language"></i> বাংলা
                    </a>
                @endif
            </p>

        </div>
        <!-- /#content -->

    </div>
    <!-- /.login-form-area -->
    
@endsection