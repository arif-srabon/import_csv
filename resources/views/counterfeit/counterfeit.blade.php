<?php
/**
 * Blade: Counterfeit Reporting
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */
?>

@extends('layouts.master')
@section('page_title', trans('counterfeit.title'))
@section('menu_counterfeit','active')

@section('page_header')
    <i class="icon-archive position-left"></i> <span class="text-semibold">{{ trans('counterfeit.title') }}</span>
@endsection

@section('content')

    <!--LIST -->
    <div id="grid_counterfeit"></div>
    <!-- /LIST -->


    <script type="text/javascript">
        jQuery(document).ready(function($){

            /**
             * Populating list with unEscaped data
             * ---------------------------------------------------------------
             */
            {{!!$js_grid_counterfeit!!}}


            var grid_counterfeit   = $('#grid_counterfeit'),
                grid               = grid_counterfeit.data('kendoGrid');

            /**
             * Edit Counterfeit Report | New Window
             * ---------------------------------------------------------------
             */
            grid_counterfeit.on('click', '.k-grid-edit', function() {
                var dataItem   = grid.dataItem(this.closest('tr')),
                    url        = '/counterfeit/' + dataItem.id + '/edit/';

                window.location.href = url;
            });


            /**
             * Print Counterfeit Report | New Window
             * ---------------------------------------------------------------
             */
            grid_counterfeit.on('click', '.k-grid-print', function() {
                console.log('clicked');
                var dataItem   = grid.dataItem(this.closest("tr")),
                    url        = '/counterfeit/' + dataItem.id + '/print/';
                
                window.open( url,  '_blank');
            });

        });
    </script>

@endsection
