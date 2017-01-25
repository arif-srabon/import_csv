@extends('layouts.master')
@section('page_title', trans('setup/medicine.page_title'))
@section('menu_setup','active')
@section('menu_setup_medicine_price','active')


@section('page_header')
 <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/medicine.title') }}</span> 
@endsection

@section('breadcrumb_links') 	
	@if (SentinelAuth::check('settings.medicine.view'))
		<li><a href="{{url('medicine')}}"><i class="icon-price-tags2 position-left"></i> {{ trans('setup/medicine.link_list') }}</a></li>    
    @endif    
@endsection

@section('content') 

<!-- User Form -->
<div class="panel panel-flat">
  <div class="panel-heading">
    <h5 class="panel-title">{{ trans('setup/medicine.title_add') }}</h5>
    <div class="heading-elements">
      <ul class="icons-list">
        <li><a data-action="collapse"></a></li>
      </ul>
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div class="panel-body">

  @include('errors.message')
  @include('errors.validation')

  {!! Form::open(['url' => 'medicine', 'method' => 'post', 'id' => 'frm_medicine', 'files' => true]) !!}
     
     @include('setup.medicine.form')
    
  {!! Form::close() !!} 
    
    </div>
</div>

@endsection