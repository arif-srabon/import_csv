<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('page_title') - {{trans('master.master_title')}}</title>

        <link rel="shortcut icon" href="{{ asset('assets/favicon.ico')}}">

        <!-- FontAwesome v4.3.0 -->
        <link href="{{ asset('assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">

        <?php // Render page-specific style sheets ?>
        {!! Assets::css() !!}

        <!-- ADR Stylesheet | Including Bootstrap v3.3.7 -->
        <link href="{{ asset('assets/css/app.css')}}" rel="stylesheet" type="text/css">

        <?php
        /**
         * Bengali stylesheet
         * Stylesheet specific to Bengali stuffs only.
         * ...
         */
        if( 'bn' === Session::get('locale') ) : ?>
            <link href="{{ asset('assets/css/app-bangla.css')}}" rel="stylesheet" type="text/css">
        <?php endif; ?>

        <!-- jQuery v2.1.4 -->
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js?ver=2.1.4')}}"></script>

    </head>
    <body class="login-registration">

        <div class="login-container">

            <header id="login-header" class="text-center">

                <a href="{{url('/home')}}">
                    <img id="site-logo" src="{{ asset('assets/images/logo-lat.png') }}" alt="ADR - DGDA">
                    <h1 class="site-title text-uppercase">{{ trans('web/login_registration.site_title') }}</h1>
                    <h2 class="site-description">{{ trans('web/login_registration.site_description') }}</h2>
                </a>

            </header>
            <!-- /#login-header -->

            @yield('form_content')

            <footer id="login-footer">
                <div class="container-fluid content-wrapper text-center">
                    <p>&copy; <?php echo date('Y'); ?> {{ trans('web/login_registration.footer_copyright') }}</p>
                    <p>{{ trans('web/login_registration.footer_credit') }} <a href="http://technovista.com.bd?ref=adrdgda" target="_blank">{{ trans('web/login_registration.footer_tvl') }}</a></p>
                </div>
                <!-- /.container-fluid content-wrapper -->
            </footer>
            <!-- /#login-footer -->

        </div>
        <!-- /.login-container -->


        <!-- DOM MANIPULATING SITE JAVASCRIPTS IN FOOTER -->
        
        <!-- Site JS v1.0.0 | Compiled with Bootstrap v3.3.7 | inewsticker.js v0.1.0 | Site.js v1.0.0 -->
        <!-- <script type="text/javascript" src="{{ asset('assets/js/main.js')}}"></script> -->

        <script>
            jQuery(document).ready(function($){
                $('#switch-lang-to-en').on('click', function () {
                    window.location.replace('{{url("setlang/en")}}');
                });
                $('#switch-lang-to-bn').on('click', function () {
                    window.location.replace('{{url("setlang/bn")}}');
                });
            });
        </script>

        <?php // Render page-specific javascripts ?>
        {!! Assets::js() !!}

    </body>
</html>
