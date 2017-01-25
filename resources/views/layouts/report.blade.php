<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ trans('reports/report.title') }}</title>

<link href="{{ asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
    
<link href="{{ asset('assets/css/report.css')}}" rel="stylesheet" type="text/css">
</head>
<body> 
<!-- Page container -->
<div class="page-container">   
  <!-- Page content -->
  <div class="page-content">    
    <!-- Main content -->
    <div class="content-wrapper">       
      <!-- Page header -->      
        <div class="page-title text-center">
            <h5> {!! (isset($mode) && ($mode == 'pdf')) ? '<p style="font-family:ind_bn_1_001">' : '<p>' !!}
            	<span class="text-semibold">{{ trans('reports/report.header_line_1') }}</span><br>
            	<span class="text-semibold">{{ trans('reports/report.header_line_dept') }}</span><br>
                <small class="display-block text-default">{{ trans('reports/report.header_line_2') }}<br></small>
                </br>
             	 @yield('report_header_title')
             </h5>
        </div>      
      <!-- /page header --> 
      
      <!-- Content area -->
      <div class="content"> 
      		@yield('content') 
        <!-- Footer -->         
        <hr>
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
