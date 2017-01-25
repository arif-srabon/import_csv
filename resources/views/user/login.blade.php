<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{trans('users/login.page_title')}}</title>

    <!-- Global stylesheets -->
    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">--}}
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="assets/css/login.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <?php
    /**
     * Bangla stylesheet
     * Stylesheet specific to Bengali stuffs only.
     * ...
     */
    if( 'bn' === Session::get('locale') ) : ?>
    <link href="{{ asset('assets/css/dss-bn.min.css')}}" rel="stylesheet" type="text/css">
    <?php endif; ?>

    <!-- Core JS files -->
    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

    <script type="text/javascript" src="assets/js/pages/login.js"></script>
    <!-- /theme JS files -->

</head>

<body class="">

    <!-- Page container -->
    <div class="page-container login-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content tvl-login">

                    <!-- Login form -->
                    {!! Form::open(['url' => 'logincheck', 'method' => 'post']) !!}

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="panel">
                                    <div class="panel-body tvl-login-panel-body text-center">
                                        <div class="row">
                                            <div class="col-sm-3 text-center">
                                                <img alt="People's Republic of Bangladesh Logo" src="{{ asset('assets/images/bangladesh-govt-logo.png') }}" width="70" height="70">
                                            </div>
                                            <div class="col-sm-6">
                                                <h1 class="text-black">
                                                    {{ trans('users/login.department') }}
                                                </h1>
                                                <h2 class="text-light text-size-large">
                                                    {{ trans('users/login.vata_management_system') }}
                                                </h2>
                                            </div>
                                            <div class="col-sm-3">
                                                &nbsp;
                                            </div>
                                        </div>
                                        

                                        <div class="tvl-inline-header">
                                            <div class="btn-group login-language-switcher" data-toggle="buttons">
                                                <label class="btn btn-sm btn-default @if (Session::get("locale") == 'bn') active  @endif ">
                                                    <input type="radio" name="language_choice" id="bengali" autocomplete="off" value="bn" @if (Session::get("locale") == 'bn') checked  @endif > {{trans('master.header_bangla')}}
                                                </label>
                                                <label class="btn btn-sm btn-default @if (Session::get("locale") == 'en') active  @endif">
                                                    <input type="radio" name="language_choice" id="english" value="en" @if (Session::get("locale") == 'en') checked  @endif autocomplete="off"> {{trans('master.header_english')}}
                                                </label>
                                            </div>
                                        </div> <!-- /.tvl-inline-header -->
                                        
                                        <p class="text-size-large text-black">{{ trans('users/login.title') }}</p>

                                        @include('errors.validation')

                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <div class="form-group has-feedback has-feedback-left">
                                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('users/login.lbl_username')]) !!}
                                                    <div class="form-control-feedback"><i class="icon-user text-muted"></i></div>
                                                </div>
                                                <div class="form-group has-feedback has-feedback-left">
                                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('users/login.lbl_password')]) !!}
                                                    <div class="form-control-feedback"><i class="icon-lock2 text-muted"></i></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6 text-left">
                                                        <label class="checkbox-inline">
                                                            {!! Form::checkbox('remember', 'yes', true, ['class' => 'styled']) !!}
                                                            {{ trans('users/login.lbl_remember') }}
                                                        </label><br>
                                                        <br>
                                                        <div>
                                                        {{ link_to('passwordreset', trans('users/login.lbl_forgot_password')) }}
                                                    	</div>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <button type="submit" class="btn btn-info">
                                                            {{trans('users/login.btn_login')}} 
                                                            <i class="icon-circle-right2 position-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}
                    <!-- /Login form -->


                    <!-- Footer -->
                    <div class="footer tvl-login-footer text-muted">
                         &copy; 2016. <a href="#">{{trans('master.footer_dss')}}</a> | {{trans('master.footer_powered')}} <a href="http://www.technovista.com.bd" target="_blank">{{trans('master.footer_tvl')}}</a>
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

</body>
</html>
<script>
$(document).ready(function(){
    $('.login-language-switcher .btn').on('click', function(){
        if( $(this).find('input[type="radio"]').val() === 'bn' )
            window.location.replace('{{url("setlang/bn")}}');
        else
            window.location.replace('{{url("setlang/en")}}');
    });
});
</script>
