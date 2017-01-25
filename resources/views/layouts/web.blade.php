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
        <div class="site-container">

            <div id="top-bar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="top-bar-news">
                                <div id="news-label" class="text-uppercase">
                                    <a href="{{url('/all-news')}}"><i class="fa fa-bullhorn"></i> {{ trans('web/common.news_title') }}</a>
                                </div>
                                <div id="news-feed">
                                    <ul id="feed-news">
                                        @foreach( $topbreaking_news as $news )
                                            <li>
                                                <a href="{{ url("/all-news/$news->id")}}">
                                                    {{ $news->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- /.top-bar-news -->
                        </div>
                        <!-- /.col-sm-8 -->
                        <div class="col-sm-4 text-right">
                            <nav id="user-nav">
                                <ul class="nav nav-pills navbar-right">
                                    
                                    @if ( 'bn' === Session::get("locale") )
                                        <li>
                                            <a id="switch-lang-to-en" href="javascript:">
                                                <i class="fa fa-language"></i> English
                                            </a>
                                        </li>
                                    @endif

                                    @if ( 'en' === Session::get("locale") )
                                        <li>
                                            <a id="switch-lang-to-bn" href="javascript:">
                                                <i class="fa fa-language"></i> বাংলা
                                            </a>
                                        </li>
                                    @endif

                                    @if( !empty(Session::get('sess_user_id')) )
                                        <!-- user is LOGGED IN -->
                                        <li class="dropdown">
                                            <?php $sess_user_img = Session::get("sess_user_image"); ?>
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-user"></i> {{ Session::get("sess_user_full_name") }} <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">                                               
                                                
                                                <li><a href="{{url('/myprofile')}}"><i class="fa fa-edit"></i> {{ trans('web/common.edit_profile') }}</a></li>
                                                <li><a href="{{url('change-password')}}"><i class="fa fa-key"></i> {{ trans('web/common.change_password') }}</a></li>

                                                <li role="separator" class="divider"></li>

                                                <li><a href="{{url('/web/logout')}}"><i class="fa fa-power-off"></i> {{ trans('web/common.log_out') }}</a></li>
                                            </ul>
                                        </li>
                                    @else
                                        <!-- user is LOGGED OUT -->
                                        <li>
                                            <a href="{{url('/login')}}">
                                                <i class="fa fa-sign-in"></i> Login
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/register')}}">
                                                <i class="fa fa-circle"></i> Register
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                            <!-- /#user-nav -->
                        </div>
                        <!-- /.col-sm-4 -->
                    </div>
                </div>
                <!-- /.container-fluid content-wrapper -->
            </div>
            <!-- /#top-bar -->

            <header id="site-header">

                <div class="container-fluid content-wrapper">
                    <nav id="main-nav" class="navbar">

                        <div class="navbar-header">
                            <a class="navbar-brand" href="{{url('/home')}}">
                                <img id="site-logo" src="{{ asset('assets/images/logo-lat.png') }}" alt="ADR - DGDA">
                                <span class="navbar-branding">
                                    <h1 class="site-title text-uppercase">{{ trans('web/common.site_title') }}</h1>
                                    <h2 class="site-description">{{ trans('web/common.site_description') }}</h2>
                                </span>
                            </a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse" id="main-menu-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="@yield('menu_home')"><a href="{{url('/home')}}">{{ trans('web/common.menu_home') }}</a></li>
                                <li class="@yield('menu_complaints')" class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('web/common.menu_complaints') }} <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li class="@yield('menu_complaints_counterfeit')"><a href="{{url('complaints/counterfeit')}}"><i class="fa fa-sun-o"></i> {{ trans('web/common.menu_counterfeit') }}</a></li>
                                        <li class="@yield('menu_complaints_complain')"><a href="{{url('complaints/complain')}}"><i class="fa fa-frown-o"></i> {{ trans('web/common.menu_complain') }}</a></li>
                                    </ul>
                                </li>
                                <li class="@yield('menu_complaints_adr')"><a href="{{url('complaints/adr')}}">{{ trans('web/common.menu_adrreporting') }}</a></li>
                                <li class="@yield('menu_companies')"><a href="{{url('companies')}}">{{ trans('web/common.menu_companies') }}</a></li>
                                <li class="@yield('menu_medicines')"><a href="{{url('medicines')}}">{{ trans('web/common.menu_medicines') }}</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('web/common.menu_downloads') }} <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ asset('assets/downloads/bangladesh-ade-form-021014-form-distributed.pdf') }}" download><i class="fa fa-file-pdf-o"></i> {{ trans('web/common.menu_adr_form_public') }}</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- /.nav navbar-nav navbar-right -->
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
                </div>
                <!-- /.container-fluid content-wrapper -->

            </header>
            <!-- /#site-header -->
            
            
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
