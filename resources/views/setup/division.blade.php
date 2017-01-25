<?php
/**
 * Created by PhpStorm.
 * User: Kamrul
 * Date: 2/8/2016
 * Time: 10:42 AM
 */
?>
@extends('layouts.master')
@section('page_title', trans('setup/division.title'))
@section('menu_setup','active')
@section('menu_setup_location','active')
@section('menu_setup_division','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/division.title') }}</span>
@endsection

@section('breadcrumb_links')
    <li></li>
@endsection

@section('content') 

    <!--list -->
    <div id="grid_division"></div>
    <script type="application/javascript">
    
    $(document).ready(function () {
        {{!!$js_grid_division!!}}
    });
	
	 function commandDelete(e) {
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var grid = $("#grid_division").data("kendoGrid");
		if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
			var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
			$.ajax({
				type: "POST",
				url: "/division/destroy",
				contentType: "application/json",
				data: JSON.stringify({id: dataItem.id}),

			}).done(function(data) {
				//console.log(data);

                toastr["success"]("{!!config('app_config.msg_delete')!!}", "Delete");
				grid.dataSource.read();
				grid.refresh();

			});

		}
	 }

	function onRequestEnd(e) {
		//var grid = $("#grid_division").data("kendoGrid");
		if (e.type == "update" && !e.response.errors) {
			toastr["success"]("{!!config('app_config.msg_update')!!}", "Update");
			//grid.dataSource.read();
			//grid.refresh();
		} else if (e.type == "create" && !e.response.errors) {
			toastr["success"]("{!!config('app_config.msg_save')!!}", "Save");
			//grid.dataSource.read();
			//grid.refresh();
		}
	}

	function onError(e) {
		//console.log(e.errors);
		$(document).ready(function() {
			toastr['error'](e.errors, "Error");
			var grid = $("#grid_division").data("kendoGrid");
			grid.dataSource.read();
			grid.refresh();
		});
	}
	
    </script> 
    <!-- /list -->

@endsection