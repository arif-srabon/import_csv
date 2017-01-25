<?php
/**
 * Layout: Medicines Page
 *
 * @package  adr_dgda
 * @author   Mayeenul Islam
 */
?>

@extends('layouts.web')

<!-- display page title -->
@section('page_title', trans('web/medicines.page_title'))

<!-- make menu active -->
@section('menu_medicines','active')

@section('content')

    <section id="breadcrumbs">
        <div class="container-fluid content-wrapper">
            <ol class="breadcrumb">
                <li><a href="{{url('/home')}}"><i class="fa fa-home"></i> {{ trans('web/common.breadcrumb_home') }}</a></li>
                <li class="active">{{ trans('web/medicines.search_title') }} <em class="text-muted">{{ Input::get('search') }}</em></li>
            </ol>
        </div>
        <!-- /.container-fluid content-wrapper -->
    </section>
    <!-- /#breadcrumbs -->

    <div id="content">
        <div class="container-fluid content-wrapper">

            <header class="article-header">
                <div class="row">
                    <div class="col-sm-9">
                        <h3 class="entry-title page-title">
                            {{ trans('web/medicines.search_title') }} <em class="text-muted">{{ Input::get('search') }}</em>
                        </h3>
                    </div>
                    <div class="col-sm-3">
                        <form action="/medicines/search" method="post" id="form-search-medicines">
                            <div id="search-panel">
                                <input type="text" name="search" class="form-control" placeholder="{{ trans('web/medicines.search_placeholder') }}" required>
                            </div> <!-- /#search-panel -->
                            <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>                    
            </header>
            <div class="entry-content page-content">

                <?php if( ! $data->isEmpty() ) { ?>

                    <div class="row">
                        <?php
                        // Counter for column count
                        $counter = 1; ?>
                        @foreach( $data as $medicine )

                            <?php
                            // Loading dynamic classes for column breaking based on viewport sizes
                            $first_on_three = $counter % 3 === 1 ? ' first-col-on-three' : '';
                            $first_on_two = $counter % 2 === 1 ? ' first-col-on-two' : '';
                            ?>

                            <article id="medicine-{{ $medicine->id }}" class="medicine-card-holder col-sm-4 col-xs-6 {{ $first_on_three, $first_on_two }}">
                                <div class="medicine-card">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            @if( ! empty($medicine->image) )
                                                <img class="medicine-image" src="{{ asset(ImageManager::getImagePath($medicine->image, 100, 100, 'crop')) }}" alt="{{ $medicine->name }}">
                                            @else
                                                <img class="medicine-image" src="{{ asset('assets/images/medicine-no-image.jpg') }}" alt="Medicine image">
                                            @endif
                                        </div>
                                        <div class="col-sm-8 col-xs-12">
                                            <div class="medicine-code"><strong>{{ trans('web/medicines.card_title_code') }}</strong> {{ $medicine->code }}</div>
                                            <h2 class="medicine-name">{{ $medicine->name }}</h2>
                                            <p class="medicine-generic small"><em>{{ $medicine->generic }}</em></p>
                                            <p class="medicine-manufacturer">{{ $medicine->manufacturer }}</p>
                                            @if( ! empty($medicine->price) )
                                                <p class="medicine-price"><strong>{{ trans('web/medicines.card_title_price') }}</strong> {{ trans('web/medicines.card_title_price_unit') }} {{ $medicine->price }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.medicine-card -->
                            </article> <!-- /#medicine-{{ $medicine->id }} -->
                            <?php $counter++; ?>
                        @endforeach
                    </div>

                    <!-- pagination -->
                    {{ $data->links() }}

                <?php } else { ?>

                    <div class="alert alert-danger" role="alert">
                        <p><i class="fa fa-exclamation-circle"></i> {{ trans('web/medicines.no_data_found') }}</p>
                    </div>

                <?php } ?>

            </div>

        </div>
        <!-- /.container-fluid content-wrapper -->

    </div>
    <!-- /#content -->

@endsection
