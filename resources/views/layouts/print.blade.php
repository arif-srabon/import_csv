<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('page_title') | {{trans('master.master_title')}}</title>

<!-- Global stylesheets -->
<link href="{{ asset('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/colors.css')}}" rel="stylesheet" type="text/css">

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

 

<!-- Page container -->
<div class="page-container"> 
  
  <!-- Page content -->
  <div class="page-content">    
    
    <!-- Main content -->
    <div class="content-wrapper"> 
      
      <!-- Content area -->
      <div class="content"> @yield('content') </div>
      <!-- /content area --> 
      
    </div>
    <!-- /main content --> 
    
  </div>
  <!-- /page content --> 
  
</div>
<!-- /page container --> 

{!! Assets::js() !!}
</body>
</html>
