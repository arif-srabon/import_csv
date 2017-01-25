<?php
/**
 * Blade: Manufacturer
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */
?>

@extends('layouts.master')
@section('page_title', trans('setup/manufacturer.title'))
@section('menu_setup','active')
@section('menu_setup_manufacturer','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/manufacturer.title') }}</span>
@endsection

@section('breadcrumb_links')
    <!-- If user is permitted -->
    @if (SentinelAuth::check('settings.manufacturer.add'))
    	<li>
            <div id="btn-add" class="btn btn-info btn-labeled btn-xs">
            	<i class="icon-file-plus2"></i> {{ trans('setup/manufacturer.btn_add') }}
            </div>
        </li>
    @endif
@endsection

@section('content')

	<!-- MODAL -->
    <div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog" aria-labelledby="manufacturerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div> <!-- /.modal -->
	<!-- /MODAL -->

	<!--LIST -->
    <div id="grid_manufacturer"></div>
    <!-- /LIST -->


    <script type="text/javascript">
    	jQuery(document).ready(function($){

    		/**
    		 * Populating list with unescaped data
             * ---------------------------------------------------------------
    		 */
    		{{!!$js_grid_manufacturer!!}}


    		/**
    		 * Initiating Modal Window
             * ---------------------------------------------------------------
    		 */
			var manufacturerModal = $('#manufacturerModal'),
				modalBody         = manufacturerModal.find('.modal-content');

    		manufacturerModal.on('hidden.bs.modal', function (e) {
                manufacturerModal.modal('hide');
                modalBody.empty();
            });


    		/**
    		 * Add Manufacturer | Modal
             * ---------------------------------------------------------------
    		 */
            $('#btn-add').click(function () {
                var url = '/manufacturer/create/';

                modalBody.load(url);
                manufacturerModal.modal('show');
            });


            /**
             * Edit Manufacturer | Modal
             * ---------------------------------------------------------------
             */
            var grid_manufacturer 	= $('#grid_manufacturer'),
            	grid 				= grid_manufacturer.data('kendoGrid');

            grid_manufacturer.on('click', '.k-grid-edit', function() {
            	var dataItem   = grid.dataItem(this.closest('tr')),
            		url        = '/manufacturer/' + dataItem.id + '/edit/';

                modalBody.load(url);
                manufacturerModal.modal('show');
			});


            /**
             * Delete Manufacturer | Modal
             * ---------------------------------------------------------------
             */
			grid_manufacturer.on('click', '.k-grid-delete', function() {

                if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
                    var dataItem = grid.dataItem(this.closest('tr'));
                    
                    $.ajax({
                        type: "POST",
                        url: "/manufacturer/destroy",
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
