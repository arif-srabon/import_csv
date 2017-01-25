@extends('layouts.login_registration')

<!-- display page title -->
@section('page_title', trans('web/login_registration.page_title_reg'))

@section('form_content')

    <div class="register-form-area">

        <div id="content">
            
            <header class="box-header">
                <h3 class="login-title text-uppercase text-center">{{ trans('web/login_registration.page_title_reg') }}</h3>
            </header>
            
            @include('errors.message')

            {!! Form::open(['url' => 'register', 'method' => 'post', 'id' =>'site-register', 'name'=>'site_register']) !!}
				
                 @include('web.register_form')
            
            {!! Form::close() !!}

            <p class="text-center small">
                <a href="{{ url('/login') }}">{{ trans('web/login_registration.login') }}</a>
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
    <!-- /.register-form-area -->

@endsection

