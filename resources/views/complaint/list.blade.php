@extends('layouts.master')
@section('page_title', trans('trans/complaint.page_title'))
@section('menu_complaint','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('trans/complaint.title') }}</span>
@endsection
         
@section('content')                
        <!--list -->
        <div id="grid_complaint"></div>
        <!-- /list --> 

        <script type="application/javascript">

            $(document).ready(function () {

                {{!!$kd_grid!!}}               

                $("#grid_complaint").on("click", ".k-grid-edit", function () {                    					
                    var grid = $("#grid_complaint").data("kendoGrid");
                    var dataItem = grid.dataItem(this.closest("tr"));
                    var url = '/complaint/' + dataItem.id + '/edit/';
					window.location.href = url; 
                });
				

                $("#grid_complaint").on("click", ".k-grid-print", function () {                    					
                    var grid = $("#grid_complaint").data("kendoGrid");
                    var dataItem = grid.dataItem(this.closest("tr"));
                    var url = '/complaint/' + dataItem.id + '/print/';
					window.open( url,  '_blank');
                });
				
			});
        </script>


@endsection


