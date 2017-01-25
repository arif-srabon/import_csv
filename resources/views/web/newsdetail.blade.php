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
                <li><a href="{{url('/all-news')}}">{{ trans('web/news.page_title') }}</a></li>
                <li class="active">
                    @if( 'events' === $item->pluck('type')[0] )
                        {{ trans('web/news.event_title') }}&nbsp;
                    @endif
                    {{ $item->pluck('title')[0] }}
                </li>
            </ol>
        </div>
        <!-- /.container-fluid content-wrapper -->
    </section>
    <!-- /#breadcrumbs -->

    <div id="content">
        <div class="container-fluid content-wrapper">

            <div class="row">
                <div class="news-list col-sm-9">

                    <article id="news-{{ $item->pluck('id')[0] }}" class="news-detail">

                        <header class="article-header">
                            <h3 class="entry-title page-title">
                                @if( 'events' === $item->pluck('type')[0] )
                                    {{ trans('web/news.event_title') }}&nbsp;
                                @endif
                                {{ $item->pluck('title')[0] }}
                            </h3>
                        </header>
                        
                        <div class="entry-content">
                            {!! $item->pluck('details')[0] !!}
                        </div>

                        <div class="entry-meta">
                            <strong>{{ trans('web/news.meta_published') }}</strong> {{ date( 'F d, Y', strtotime($item->pluck('published_dt')[0]) ) }}
                        </div>

                    </article> <!-- /#news-{{ $item->pluck('id')[0] }} -->

                </div>
                <!-- /.news-list col-sm-9 -->
                <aside id="news-sidebar" class="col-sm-3">

                    @if( !empty($events) )
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
                            <h6 class="widget-inner-title text-uppercase"><i class="fa fa-frown-o"></i> General Complaint</h6>
                            <p>If you have any Counterfeit objection, you can easily inform us using the following form:</p>
                            <a href="{{ url('/complaints/complain') }}" class="btn btn-info btn-sm"><i class="fa fa-frown-o"></i> Complain</a>
                            <hr>

                            <h6 class="widget-inner-title text-uppercase"><i class="fa fa-sun-o"></i> Complain Counterfeit</h6>
                            <p>If you have any Counterfeit objection, you can easily inform us using the following form:</p>
                            <a href="{{ url('/complaints/counterfeit') }}" class="btn btn-info btn-sm"><i class="fa fa-sun-o"></i> Report</a>
                            <hr>

                            <h6 class="widget-inner-title text-uppercase"><i class="fa fa-dot-circle-o"></i> Complain Adverse Drug Reaction Reporting</h6>
                            <p>If you have any Counterfeit objection, you can easily inform us using the following form:</p>
                            <a href="{{ url('/complaints/adr') }}" class="btn btn-info btn-sm"><i class="fa fa-dot-circle-o"></i> Report</a>
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
