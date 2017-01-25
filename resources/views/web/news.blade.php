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
@section('page_title', trans('web/news.page_title'))

@section('content')

    <section id="breadcrumbs">
        <div class="container-fluid content-wrapper">
            <ol class="breadcrumb">
                <li><a href="{{url('/home')}}"><i class="fa fa-home"></i> {{ trans('web/common.breadcrumb_home') }}</a></li>
                <li class="active">{{ trans('web/news.page_title') }}</li>
            </ol>
        </div>
        <!-- /.container-fluid content-wrapper -->
    </section>
    <!-- /#breadcrumbs -->

    <div id="content">
        <div class="container-fluid content-wrapper">

            <header class="article-header">
                <h3 class="entry-title page-title">{{ trans('web/news.page_title') }}</h3>
            </header>
            <div class="row">
                <div class="news-list col-sm-9">
                    <div class="page-content">

                        <div class="row">
                            <?php
                            // Counter for column count
                            $counter = 1; ?>
                            @foreach( $allNews as $news )

                                <?php
                                // Loading dynamic classes for column breaking based on viewport sizes
                                $first_on_two = $counter % 2 === 1 ? ' first-col-news' : '';
                                ?>

                                <article id="news-{{ $news->id }}" class="news-card-holder col-xs-6 {{ $first_on_two }}">
                                    <div class="news-card">
                                        <header class="news-header">
                                            <p class="news-type text-uppercase">{{ trans('web/news.meta_type') }}</p>
                                            <h2 class="entry-title">
                                                <a href="{{ url("/all-news/$news->id") }}">
                                                    {{ $news->title }}
                                                </a>
                                            </h2>
                                        </header>
                                        <div class="entry-meta">
                                            <strong>{{ trans('web/news.meta_published') }}</strong> {{ date( 'F d, Y', strtotime($news->published_dt) ) }}
                                        </div>
                                        <div class="entry-content">
                                            <?php
                                            $full_content     = $news->details;
                                            $stripped_content = preg_replace('/(<.*?>)|(&.*?;)/', '', $full_content);
                                            $excerpts         = str_limit( $stripped_content, 200 );
                                            ?>
                                            {!! $excerpts !!}
                                        </div>
                                        <!-- /.entry-content -->
                                    </div>
                                    <!-- /.news-card -->
                                </article> <!-- /#news-{{ $news->id }} -->
                                <?php $counter++; ?>
                            @endforeach
                        </div>

                        <!-- pagination -->
                        {{ $allNews->links() }}

                    </div>
                </div>
                <!-- /.news-list col-sm-9 -->
                <aside id="news-sidebar" class="col-sm-3">

                    @if( count($events) > 0 )
                        <!-- WIDGET: EVENTS -->
                        <div id="widget-event" class="widget">
                            <h3 class="widget-title text-uppercase">{{ trans('web/news.widget_event') }}</h3>
                            <div class="widget-content">
                                <ul>
                                    @foreach( $events as $event )
                                        <li>
                                            <a href="{{ url("/all-news/$event->id") }}">
                                                {{ $event->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.widget-content -->
                        </div>
                        <!-- /.widget -->
                    @endif

                    <!-- WIDGET: NOTICE -->
                    <div id="widget-event" class="widget">
                        <h3 class="widget-title text-uppercase">{{ trans('web/news.widget_notice') }}</h3>
                        <div class="widget-content">
                            <h6 class="widget-inner-title text-uppercase"><i class="fa fa-frown-o"></i> {{ trans('web/news.widget_notice_subhead_complaint') }}</h6>
                            <p>{{ trans('web/news.widget_notice_text_complaint') }}</p>
                            <a href="{{ url('/complaints/complain') }}" class="btn btn-info btn-sm"><i class="fa fa-frown-o"></i> {{ trans('web/news.widget_notice_btn_complain') }}</a>
                            <hr>

                            <h6 class="widget-inner-title text-uppercase"><i class="fa fa-sun-o"></i> {{ trans('web/news.widget_notice_subhead_counterfeit') }}</h6>
                            <p>{{ trans('web/news.widget_notice_text_counterfeit') }}</p>
                            <a href="{{ url('/complaints/counterfeit') }}" class="btn btn-info btn-sm"><i class="fa fa-sun-o"></i> {{ trans('web/news.widget_notice_btn_report') }}</a>
                            <hr>

                            <h6 class="widget-inner-title text-uppercase"><i class="fa fa-dot-circle-o"></i> {{ trans('web/news.widget_notice_subhead_adr') }}</h6>
                            <p>{{ trans('web/news.widget_notice_text_adr') }}</p>
                            <a href="{{ url('/complaints/adr') }}" class="btn btn-info btn-sm"><i class="fa fa-dot-circle-o"></i> {{ trans('web/news.widget_notice_btn_report') }}</a>
                            <hr>
                        </div>
                        <!-- /.widget-content -->
                    </div>
                    <!-- /.widget -->
                </aside>
                <!-- /#news-sidebar.col-sm-3 -->
            </div>

        </div>
        <!-- /.container-fluid content-wrapper -->

    </div>
    <!-- /#content -->

@endsection
