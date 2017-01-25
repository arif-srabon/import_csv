@extends('layouts.login_registration')

<!-- display page title -->
@section('page_title', trans('web/login_registration.page_title'))

@section('form_content')

    <div class="login-form-area">

        <div id="content">
            
            <header class="box-header">
                <h3 class="login-title text-uppercase text-center">{{ trans('web/login_registration.page_title') }}</h3>
            </header>
            
            @include('errors.message')


            {!! Form::open(['url' => '/web/logincheck', 'method' => 'post', 'id' =>'site-login', 'name'=>'site_login']) !!}


                <div class="form-group">
                    <label for="email">{{ trans('web/login_registration.label_email') }}</label>
                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                    @if ($errors->has('email'))
                        <p class="small text-danger">{!!$errors->first('email')!!}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('web/login_registration.label_password') }}</label>
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                    @if ($errors->has('password'))
                        <p class="small text-danger">{!!$errors->first('password')!!}</p>
                    @endif
                </div>

                <p id="forgot-password" class="text-center small">
                {{ link_to('passwordreset', trans('web/login_registration.forgot_password')) }}
                </p>

                <div class="form-group text-center">
                    {{ Form::button( trans('web/login_registration.label_login_btn'), array('type' => 'submit', 'class' => 'btn btn-info text-uppercase', 'id'=> 'login-submit')) }}
                </div>
            
            {!! Form::close() !!}

            <p class="text-center small">
                <a href="{{ url('/register') }}">{{ trans('web/login_registration.register') }}</a>
                <span class="login-separator">|</span>
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
