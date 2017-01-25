@extends('layouts.master')
@section('page_title', trans('users/user.title_edit'))
@section('menu_setup','active')
@section('menu_setup_medicine_price','active')

@section('page_header')
 <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('setup/medicine.title') }}</span> 
@endsection

@section('breadcrumb_links')	    
	@if (SentinelAuth::check('settings.medicine.view'))
    <li><a href="{{url('medicine')}}"><i class="icon-price-tags2 position-left"></i> {{ trans('setup/medicine.link_list') }}</a></li>  
    @endif
    @if (SentinelAuth::check('settings.medicine.add'))
    <li><a href="{{url('medicine/create')}}"><i class="icon-file-plus2 position-left"></i> {{ trans('setup/medicine.btn_add') }}</a></li>    
    @endif
@endsection


@section('content') 

<!-- User Form -->
<div class="panel panel-flat">
  <div class="panel-heading">
    <h5 class="panel-title">{{ trans('setup/medicine.title_edit') }}</h5>
    <div class="heading-elements">
      <ul class="icons-list">
        <li><a data-action="collapse"></a></li>
      </ul>
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div class="panel-body">

  @include('errors.message')

  {!! Form::model($medicine, ['method' => 'PATCH', 'id' => 'frm_medicine', 'files' => true, 'url' => ['medicine', $medicine->id]]) !!}
     
     @include('setup.medicine.form')
    
  {!! Form::close() !!} 
    
    </div>
</div>

<!-- /User form --> 

@endsection