@extends('layouts.master')
@section('page_title', trans('users/user.title_edit'))
@section('menu_security', 'active')
@section('menu_user', 'active')

@section('page_header')
 <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('users/user.title') }}</span> 
@endsection

@section('breadcrumb_links')
	@if (SentinelAuth::check('dss.security.users.edit'))
		<li><a href="{{url("userpermission/$user->id/edit")}}"><i class="icon-file-check position-left"></i> {{ trans('users/user.link_apply_permission') }}</a></li>
   	@endif
    @if (SentinelAuth::check('dss.security.users.view'))
		<li><a href="{{url('user')}}"><i class="icon-users position-left"></i> {{ trans('users/user.link_user_list') }}</a></li>
    @endif
    @if (SentinelAuth::check('dss.security.users.add'))
  		<li><a href="{{url('user/create')}}"><i class="icon-file-plus2 position-left"></i> {{ trans('users/user.link_add_user') }}</a></li>
    @endif
@endsection


@section('content') 

<!-- User Form -->
<div class="panel panel-flat">
  <div class="panel-heading">
    <h5 class="panel-title">{{ trans('users/user.title_edit') }}</h5>
    <div class="heading-elements">
      <ul class="icons-list">
        <li><a data-action="collapse"></a></li>
      </ul>
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div class="panel-body">

  @include('errors.message')

  {!! Form::model($user, ['method' => 'PATCH', 'id' => 'frm_user', 'files' => true, 'url' => ['user', $user->id]]) !!}
     
     @include('user.form')
    
  {!! Form::close() !!} 
    
    </div>
</div>

<!-- /User form --> 

@endsection