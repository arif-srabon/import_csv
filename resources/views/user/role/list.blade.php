@extends('layouts.master')
@section('page_title', trans('users/permission.lbl_permission'))
@section('menu_security', 'active')
@section('menu_role', 'active')

@section('page_header') <i class="icon-key position-left"></i> <span class="text-semibold">{{trans('users/permission.lbl_role')}}</span> @endsection

@section('content')
<div id="grid_data"></div>
<script type="application/javascript">

        $(document).ready(function () {
            {{!! $js_grid_data !!}}

        });

      
		function onRequestEnd(e) {
			if (e.type == "update" && !e.response.errors) {
				toastr["success"]("{!!config('app_config.msg_update')!!}", "Update");
			} else if (e.type == "create" && !e.response.errors) {
				toastr["success"]("{!!config('app_config.msg_save')!!}", "Save");
			} 
		}
		
		function onError(e) {
			//console.log(e.errors);
			toastr['error']("{!!config('app_config.msg_invalid_input')!!}", "Error");
			return false;
		}

        function commandPermission(e) {
            e.preventDefault ? e.preventDefault() : e.returnValue = false;
            var grid = $("#grid_data").data("kendoGrid");
            var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
            window.location.href = '/permission/'+ dataItem.id +'/edit/';
        }

        function commandDelete(e) {
            e.preventDefault ? e.preventDefault() : e.returnValue = false;
            var grid = $("#grid_data").data("kendoGrid");
            if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
                var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
                $.ajax({
                    type: "POST",
                    url: "/role/destroy",
                    contentType: "application/json",
                    data: JSON.stringify({id: dataItem.id})
                }).done(function (data) {
                    //console.log(data);
                    toastr["success"]("{!!config('app_config.msg_delete')!!}", "Delete");
                    grid.dataSource.read();
                    grid.refresh();
                });
            }
        }
    </script> 
@endsection