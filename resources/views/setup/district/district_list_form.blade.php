<?php
/**
 * Created by PhpStorm.
 * User: Kamrul
 * Date: 2/8/2016
 * Time: 10:42 AM
 */
?>
@extends('layouts.master')
@section('page_title', trans('setup/district.page_title'))
@section('menu_setup','active')
@section('menu_setup_location','active')
@section('menu_setup_district','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/district.title') }}</span>
@endsection

@section('breadcrumb_links')
    @if (SentinelAuth::check('dss.settings.district.add'))
        <li>
            <a>
                <button id="btn-add" class="btn btn-info btn-labeled btn-xs"><b><i
                                class="icon-file-plus2"></i></b>{{ trans('setup/district.btn_add') }}</button>
            </a>
        </li>
        @endif
        @endsection
        @section('content')
                <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog -->

        </div> <!-- /.modal -->
        <!--list -->
        <div id="grid_district"></div>
        <!-- /list -->

        <script type="application/javascript">


            $(document).ready(function () {
                $('#myModal').on('hidden.bs.modal', function (e) {
                    $('#myModal').modal('hide');
                    var myModal = $('#myModal');
                    var modalBody = myModal.find('.modal-content');
                    modalBody.empty();
                })

            });

        </script>

        <script type="application/javascript">

            $(document).ready(function () {
                {{!!$js_grid_district!!}}

                $("#btn-add").click(function () {
                    var url = "/district/create/";

                    var myModal = $('#myModal');
                    var modalBody = myModal.find('.modal-content');
                    modalBody.load(url);
                    myModal.modal('show');
                });

                $("#grid_district").on("click", ".k-grid-edit", function () {
                    var grid = $("#grid_district").data("kendoGrid");
                    var dataItem = grid.dataItem(this.closest("tr"));
                    var url = '/district/' + dataItem.id + '/edit/';
                    var myModal = $('#myModal');
                    var modalBody = myModal.find('.modal-content');
                    modalBody.load(url);

//                $('.modal-dialog').css('width', '70%');
                    myModal.modal('show');

                });

                $("#grid_district").on("click", ".k-grid-delete", function () {
                    var grid = $("#grid_district").data("kendoGrid");
                    if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
                        var dataItem = grid.dataItem(this.closest("tr"));
                        $.ajax({
                            type: "POST",
                            url: "/district/destroy",
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


