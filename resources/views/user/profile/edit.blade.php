@extends('layouts.master')
@section('page_title', trans('users/user.title_profile'))
@section('menu_security', 'active')
@section('menu_user', 'active')

@section('page_header')
 <i class="icon-gear position-left"></i> <span class="text-semibold">{{ trans('users/user.title_profile') }}</span> 
@endsection


@section('content') 

<!-- User Form -->
<div class="panel panel-flat">
  <div class="panel-heading">
    <h5 class="panel-title">{{ trans('users/user.title_profile_info') }}</h5>
    <div class="heading-elements">
      <ul class="icons-list">
        <li><a data-action="collapse"></a></li>
      </ul>
    </div>
    <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
  <div class="panel-body">

  @include('errors.message')
    @include('errors.validation')


  {!! Form::model($user, ['method' => 'PATCH', 'id' => 'frm_user', 'files' => true, 'url' => ['saveprofile', $user->id]]) !!}
     
    
  {!! Form::close() !!} 
    
    </div>
</div>

<!-- /User form --> 

@endsection