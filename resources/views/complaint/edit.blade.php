@extends('layouts.master')
@section('page_title', trans('trans/complaint.title_edit'))
@section('menu_complaint','active')

@section('page_header')
 <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('trans/complaint.title') }}</span> 
@endsection

@section('breadcrumb_links')	
	@if (SentinelAuth::check('transactions.complaint.view'))
		<li><a href="{{url('complaint')}}"><i class="icon-comment-discussion position-left"></i> {{ trans('trans/complaint.link_list') }}</a>
        </li>    
     @endif   
@endsection


@section('content') 

<!-- User Form -->
<div class="panel panel-flat">
  <div class="panel-heading">
    <h5 class="panel-title">{{ trans('trans/complaint.title_edit') }}</h5>
    <div class="heading-elements">
      <ul class="icons-list">
        <li><a data-action="collapse"></a></li>
      </ul>
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div class="panel-body">

  @include('errors.message')

  {!! Form::model($complaints, ['method' => 'PATCH', 'id' => 'frm_complaint', 'files' => true, 'url' => ['complaint', $complaints->id]]) !!}
     
     @include('complaint.form')
    
  {!! Form::close() !!} 
    
    </div>
</div>

<!-- /User form --> 

@endsection