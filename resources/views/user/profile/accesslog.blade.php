@extends('layouts.master')
@section('page_title', trans('users/user.breadcrumb7'))
@section('page_header') <i class="icon-key position-left"></i> <span class="text-semibold">{{trans('users/user.lbl_my_access_logs')}}</span> @endsection
@section('content') 
<div id="grid_center"></div>
<script type="application/javascript">
          $(document).ready(function () {
                {{!!$grid_data!!}}  
          });
</script> 
@endsection