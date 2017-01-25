<?php
/**
 * Blade: ADR Reporting
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */
?>

@extends('layouts.master')
@section('page_title', trans('adrreporting.title'))
@section('menu_ADR_Reporting','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('adrreporting.title') }}</span>
@endsection

@section('content')

    <!--LIST -->
    <div id="grid_adrreporting"></div>
    <!-- /LIST -->


    <script type="text/javascript">
        jQuery(document).ready(function($){

            /**
             * Populating list with unEscaped data
             * ---------------------------------------------------------------
             */
            {{!!$js_grid_adrreporting!!}}


            var grid_adrreporting   = $('#grid_adrreporting'),
                grid                = grid_adrreporting.data('kendoGrid');

            /**
             * Edit ADR Report | New Window
             * ---------------------------------------------------------------
             */
            grid_adrreporting.on('click', '.k-grid-edit', function() {
                var dataItem   = grid.dataItem(this.closest('tr')),
                    url        = '/adrreporting/' + dataItem.id + '/edit/';

                window.location.href = url;
            });


            /**
             * Print ADR Report | New Window
             * ---------------------------------------------------------------
             */
            grid_adrreporting.on('click', '.k-grid-print', function() {
                console.log('clicked');
                var dataItem   = grid.dataItem(this.closest("tr")),
                    url        = '/adrreporting/' + dataItem.id + '/print/';
                
                window.open( url,  '_blank');
            });

        });
    </script>

@endsection
