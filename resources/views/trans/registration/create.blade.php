@extends('layouts.master')
@section('page_title', trans('trans/registration.title_add'))
@section('menu_registration', 'active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('trans/registration.title') }}</span>
@endsection

@section('breadcrumb_links')

        <li><a href="{{url('registration')}}"><i class="icon-grid4 position-left"></i> {{ trans('trans/registration.link_registration_list') }}</a></li>

        @endsection

        @section('content')
        <!-- User Form -->
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-4 form-horizontal">
                        <div class="form-group">
                            <label class="text-bold col-sm-12 control-label">{{ trans('trans/registration.title_add') }}</label>
                        </div>
                    </div>
                </div>

            </div> <!-- /.panel-heading -->

            <div class="panel-body">
                @include('errors.message')

                <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="adrrerpoting-accordion">

                    @include('errors.validation')

                    {!! Form::open(['url' => 'registration', 'method' => 'post', 'id' => 'frm_registration', 'files' => true]) !!}

                    @include('trans.registration.form')

                    {!! Form::close() !!}

                </div> <!-- /.panel-group -->

            </div> <!-- /.panel-body -->

        </div> <!-- /.panel panel-flat -->

        <!-- /User form -->

@endsection