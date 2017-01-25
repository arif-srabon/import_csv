<?php
/**
 * Created by PhpStorm.
 * User: Kamrul
 * Date: 2/8/2016
 * Time: 10:42 AM
 */
?>
@extends('layouts.master')
@section('page_title', trans('setup/common_config.title'))
@section('menu_setup_common_config','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/common_config.title') }}</span>
@endsection

@section('breadcrumb_links')
    <li></li>
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('category_id', trans('setup/common_config.common_config_category')) !!}
                        {!! Form::select('category_id', $commonconfigmaps, null, ['placeholder' =>trans('setup/common_config.category_default'), 'class' => 'select form-control']) !!}
                        <span class="help-block">{{ trans('setup/common_config.common_confg_notes') }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div id="list_view"></div>
    </div>

    <script type="text/javascript">

        if ($('#category_id').val()) {
            var category_id = $('#category_id').val();
            if (category_id) {
                $.ajax({
                    type: "POST",
                    url: "/commonconfig/index/" + category_id,
                    cache: false
                }).done(function (html) {
                    $("#list_view").html(html);
                });
            }

        }

        $('#category_id').on('change', function () {
            if (this.value) {
                var category_id = this.value;
                if (category_id) {
                    $.ajax({
                        type: "POST",
                        url: "/commonconfig/index/" + category_id,
                        cache: false
                    }).done(function (html) {
                        $("#list_view").html(html);
                    });
                }
            }

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
            $(document).ready(function () {

                toastr['error'](e.errors, "Error");

                var grid = $("#grid_common_config").data("kendoGrid");
                grid.dataSource.read();
                grid.refresh();

            });
        }


    </script>

@endsection