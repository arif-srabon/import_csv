@extends('layouts.master')
@section('page_title', trans('setup/medicine.page_title'))
@section('menu_setup','active')
@section('menu_setup_medicine_price','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/medicine.title') }}</span>
@endsection

@section('breadcrumb_links')
		@if (SentinelAuth::check('settings.medicine.add'))
         <li>
            <a href="{{url('medicine/create')}}">
                <button id="btn-add" class="btn btn-info btn-labeled btn-xs"><b><i
                                class="icon-file-plus2"></i></b>{{ trans('setup/medicine.btn_add') }}</button>
            </a>
        </li>
        @endif
        @endsection
         
        @section('content')
                
        <!--list -->
        <div id="grid_medicine"></div>
        <!-- /list -->
 

        <script type="application/javascript">

            $(document).ready(function () {

                {{!!$js_grid_medicine!!}}               

                $("#grid_medicine").on("click", ".k-grid-edit", function () {                    					
                    var grid = $("#grid_medicine").data("kendoGrid");
                    var dataItem = grid.dataItem(this.closest("tr"));
                    var url = '/medicine/' + dataItem.id + '/edit/';
					window.location.href = url; 
                });
				

                $("#grid_medicine").on("click", ".k-grid-delete", function () {
                    var grid = $("#grid_medicine").data("kendoGrid");
                    if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
                        var dataItem = grid.dataItem(this.closest("tr"));
                        $.ajax({
                            type: "POST",
                            url: "/medicine/destroy",
                            contentType: "application/json",
                            data: JSON.stringify({id: dataItem.id}),
                        }).done(function (data) {
                            //console.log(data);
                            if (data == 1) {
                                toastr["success"]("{!!config('app_config.msg_delete')!!}", "Delete");
                            } else {
                                toastr["error"]("{!!config('app_config.msg_failed_delete')!!}", "Delete");
                            }
                            grid.dataSource.read();
                            grid.refresh();
                        });

                    }

                });

            });

        </script>


@endsection


