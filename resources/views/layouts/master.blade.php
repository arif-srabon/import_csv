<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title') | {{trans('master.master_title')}} </title>

    <!-- Global stylesheets -->
    <link href="{{ asset('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
    <!-- <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css"> -->
    <link href="{{ asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/colors.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('assets/css/toastr.css') }}">

    <!-- DSS Stylesheet - Language-independent -->
    <link href="{{ asset('assets/css/dss.min.css')}}" rel="stylesheet" type="text/css">

    <?php
    /**
     * Bangla stylesheet
     * Stylesheet specific to Bengali stuffs only.
     * ...
     */
    if( 'bn' === Session::get('locale') ) : ?>
        <link href="{{ asset('assets/css/dss-bn.min.css')}}" rel="stylesheet" type="text/css">
    <?php endif; ?>

    <!-- DSS Color Theme Stylesheet -->
    <?php
    $theme = 'default';
    if(Session::get('color'))
    {
        $theme = Session::get('color');
    }
    ?>
    <link href="<?php echo asset('assets/css/colors/'.$theme.'.css')?>" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js')}}"></script>
    <!-- /core JS files -->


    {!! Assets::css() !!}
    <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css">
</head>

<body>

<!-- top navbar -->
@include('layouts.header')
        <!-- /top navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main left sidebar -->
        @include('layouts.sidebar')
                <!-- /main left sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4> @yield('page_header') </h4>
                    </div>
                    <div class="heading-elements"> @yield('page_header_links') </div>
                </div>

                <div class="breadcrumb-line">
                    @include('layouts.breadcrumbs')
                    <ul class="breadcrumb-elements"> @yield('breadcrumb_links') </ul>
                </div>

            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">

                @yield('content')

                        <!-- Footer -->
                <div class="footer text-muted">
                    &copy; 2016. <a href="#">{{trans('master.footer_dss')}} </a> | {{trans('master.footer_powered')}} <a
                            href="http://www.technovista.com.bd" target="_blank">{{trans('master.footer_tvl')}} </a>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
<!-- Theme JS files -->
<script type="text/javascript" src="{{ asset('assets/js/app/app.js')}}"></script>


<script src="{{ asset('assets/js/plugins/toastr.min.js') }}"></script>
{!! Assets::js() !!}
{!! Toastr::render() !!}
</body>
</html>
