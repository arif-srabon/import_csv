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
        <link href="{{ asset('assets/css/icons/fontawesome/styles.min.css?ver=4.3.0')}}" rel="stylesheet" type="text/css">

        <?php // Render page-specific style sheets ?>
        {!! Assets::css() !!}

        <!-- ADR Stylesheet | Including Bootstrap v3.3.7 -->
        <link href="{{ asset('assets/css/app.css?ver=1.0.0')}}" rel="stylesheet" type="text/css">

        <?php
        /**
         * Bengali stylesheet
         * Stylesheet specific to Bengali stuffs only.
         * ...
         */
        if( 'bn' === Session::get('locale') ) : ?>
            <link href="{{ asset('assets/css/app-bangla.css?ver=1.0.0')}}" rel="stylesheet" type="text/css">
        <?php endif; ?>

        <!-- jQuery v2.1.4 -->
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js?ver=2.1.4') }}"></script>

    </head>
    <body>
        <div class="site-container mobile-container">
            
            
            @yield('content')
         

            <footer id="site-footer">
                <div class="container-fluid content-wrapper text-center">
                    <div class="row">
                        <div class="col-sm-6 footer-col">
                            &copy; <?php echo date('Y'); ?> {{ trans('web/common.footer_copyright') }}
                        </div>
                        <!-- /.col-sm-6 footer-col -->
                        <div class="col-sm-6 footer-col footer-col-right">
                            {{ trans('web/common.footer_credit') }} <a href="http://technovista.com.bd?ref=adrdgda" target="_blank">{{ trans('web/common.footer_tvl') }}</a>
                        </div>
                        <!-- /.col-sm-6 footer-col -->
                    </div>
                </div>
                <!-- /.container-fluid content-wrapper -->
            </footer>
            <!-- /#site-footer -->

        </div>
        <!-- /.site-container -->


        <!-- DOM MANIPULATING SITE JAVASCRIPTS IN FOOTER -->
        
        <!-- Site JS v1.0.0 | Compiled with Bootstrap v3.3.7 | inewsticker.js v0.1.0 | Site.js v1.0.0 -->
        <script type="text/javascript" src="{{ asset('assets/js/main.js?ver=1.0.0')}}"></script>

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
