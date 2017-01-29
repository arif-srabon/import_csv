@extends('layouts.master')
@section('page_title', trans('trans/registration.page_title'))
@section('menu_registration', 'active')
@section('page_header')
    <i class="icon-key position-left"></i> <span class="text-semibold">{{ trans('trans/registration.title') }}</span>
@endsection

@section('breadcrumb_links')
        <li><a href="{{url('registration/create')}}"><i class="icon-user-plus position-left"></i> {{ trans('trans/registration.link_add_user') }}</a></li>
        @endsection

        @section('content')

                <!--list -->

        <div id="grid_center"></div>

        <script type="application/javascript">

            $(document).ready(function () {

                {{!!$grid_data!!}}

                function commandEdit(e) {
                    e.preventDefault ? e.preventDefault() : e.returnValue = false;
                    var grid = $("#grid_center").data("kendoGrid");
                    var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
                    window.location.href = '/registration/'+ dataItem.id +'/edit/';
                }

                function commandPrintInfo(e) {
                    e.preventDefault ? e.preventDefault() : e.returnValue = false;
                    var grid = $("#grid_center").data("kendoGrid");
                    var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
                    window.location.href = '/registration/'+ dataItem.id +'/printInfo/';
                }
                function commandPrintID(e) {
                    e.preventDefault ? e.preventDefault() : e.returnValue = false;
                    var grid = $("#grid_center").data("kendoGrid");
                    var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
                    window.location.href = '/registration/'+ dataItem.id +'/printID/';
                }
                function commandDelete(e) {
                    e.preventDefault ? e.preventDefault() : e.returnValue = false;
                    var grid = $("#grid_center").data("kendoGrid");
                    if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
                        var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
                        $.ajax({
                            type: "POST",
                            url: "/registration/destroy",
                            contentType: "application/json",
                            data: JSON.stringify({id: dataItem.id}),
                        }).done(function(data) {
                            //console.log(data);
                            if(data == 1) {
                                toastr["success"]("{!!config('app_config.msg_delete')!!}", "Delete");
                            } else {
                                toastr["error"]("{!!config('app_config.msg_failed_delete')!!}", "Delete");
                            }
                            grid.dataSource.read();
                            grid.refresh();
                        });

                    }
                }

            });
        </script>

        <!-- /list -->

@endsection