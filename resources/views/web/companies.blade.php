<?php
/**
 * Layout: Companies Page
 *
 * @package  adr_dgda
 * @author   Mayeenul Islam
 */
?>

@extends('layouts.web')

<!-- display page title -->
@section('page_title', trans('web/companies.page_title'))

<!-- make menu active -->
@section('menu_companies','active')

@section('content')

    <section id="breadcrumbs">
        <div class="container-fluid content-wrapper">
            <ol class="breadcrumb">
                <li><a href="{{url('/home')}}"><i class="fa fa-home"></i> {{ trans('web/common.breadcrumb_home') }}</a></li>
                <li class="active">{{ trans('web/companies.page_title') }}</li>
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
                            {{ trans('web/companies.page_title') }}
                        </h3>
                    </div>
                    <div class="col-sm-3">
                        <form action="/companies/search" method="post" id="form-search-companies">
                            <div id="search-panel">
                                <input type="text" name="search" class="form-control" placeholder="{{ trans('web/companies.search_placeholder') }}" required>
                            </div> <!-- /#search-panel -->
                            <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>                    
            </header>
            <div class="entry-content page-content">

                <div class="row">
                    <?php
                    // Counter for column count
                    $counter = 1; ?>
                    @foreach( $data as $company )

                        <?php
                        // Loading dynamic classes for column breaking based on viewport sizes
                        $first_on_two = $counter % 2 === 1 ? ' first-col-on-two' : '';
                        ?>

                        <article id="company-{{ $company->id }}" class="company-card-holder col-sm-6 col-xs-12 {{ $first_on_two }}">
                            <div class="company-card">
                                <div class="pull-right">
                                    @if( $company->status == 1 )
                                        <span class="label label-xs label-success"><i class="fa fa-check-circle-o"></i> Active</span>
                                    @else
                                        <span class="label label-default label-xs"><i class="fa fa-times-circle-o"></i> Inactive</span>
                                    @endif
                                </div>
                                <div class="company-code"><strong>{{ trans('web/companies.card_title_code') }}</strong> {{ $company->code }}</div>
                                @if( $company->code_non_bio )
                                    <div class="company-code"><strong>{{ trans('web/companies.card_title_code2') }}</strong> {{ $company->code_non_bio }}</div>
                                @endif
                                <h2 class="company-name">
                                    {{ $company->name }}
                                </h2>
                                @if( ! empty($company->address) )
                                    <div class="company-address">{!! nl2br(e($company->address)) !!}</div>
                                @endif
                                @if( ! empty($company->district) && ! empty($company->division) )
                                    <p class="company-division-district">{{ $company->district }}, {{ $company->division }}</p>
                                @endif
                            </div>
                            <!-- /.company-card -->
                        </article> <!-- /#company-{{ $company->id }} -->
                        <?php $counter++; ?>
                    @endforeach
                </div>

                <!-- pagination -->
                {{ $data->links() }}

            </div>

        </div>
        <!-- /.container-fluid content-wrapper -->

    </div>
    <!-- /#content -->

@endsection
