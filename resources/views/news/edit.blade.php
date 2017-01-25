@extends('layouts.master')
@section('page_title', trans('setup/news.title'))
@section('menu_news','active')


@section('page_header')
    <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/news.title') }}</span>
@endsection

@section('breadcrumb_links')
	@if (SentinelAuth::check('transactions.news.view'))
        <li><a href="{{url('news')}}">
            <button class="btn btn-info btn-labeled btn-xs" type="button"><b><i class="icon-file-spreadsheet2"></i></b> {{ trans('setup/news.btn_list') }}</button>
        </a></li>
        @endif
        @if (SentinelAuth::check('transactions.news.add'))
        <li><a href="{{url('news/create')}}">
            <button class="btn btn-info btn-labeled btn-xs" type="button"><b><i class="icon-file-plus2"></i></b> {{ trans('setup/news.btn_add') }}</button>
        </a></li>
        @endif
@endsection

@section('content') 

<!-- User Form -->
<div class="panel panel-flat">
  <div class="panel-heading">
    <h5 class="panel-title">{{trans('setup/news.title_edit')}}</h5>
    <div class="heading-elements">
      <ul class="icons-list">
        <li><a data-action="collapse"></a></li>
      </ul>
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div class="panel-body"> 
   
  {!! Form::model($news, ['method' => 'PATCH', 'url' => ['news', $news->id], 'id' =>'frm_news', 'name'=>'frm_news']) !!}
     
     @include('news.form')
    
  {!! Form::close() !!} 
    
    </div>
</div>

<!-- /User form --> 

@endsection