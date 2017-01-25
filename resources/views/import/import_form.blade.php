@extends('layouts.master')
@section('page_title', trans('import.page_title'))
@section('menu_import', 'active')

@section('page_header')
    <i class="icon-import position-left"></i> <span class="text-semibold">{{ trans('import.title') }}</span>
@endsection

@section('content')
        <!-- User Form -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">{{ trans('import.title_add') }}</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
        <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
    <div class="panel-body">

        @include('errors.message')
        @include('errors.validation')

        {!! Form::open(['url' => 'importfile/store', 'method' => 'post', 'id' => 'frmImport','name'=>'frmImport', 'files' => true]) !!}

        @include('import.form')

        {!! Form::close() !!}

    </div>
</div>

<!-- /User form -->
@endsection