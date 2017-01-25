<?php
/**
 * Counterfeit Reporting : Edit
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */
?>

@extends('layouts.master')
@section('page_title', trans('counterfeit.title_review'))
@section('menu_counterfeit','active')

@section('page_header')
    <i class="icon-stack position-left"></i> <span class="text-semibold">{{ trans('counterfeit.title_review') }}</span>
@endsection

@section('breadcrumb_links')
	<!-- If user is permitted -->
    @if (SentinelAuth::check('transactions.counterfeit.view'))	
	<li>
		<a href="{{url('counterfeit')}}">
			<i class="icon-stack position-left"></i> {{ trans('counterfeit.link_list') }}
		</a>
	</li>
	@endif
@endsection

@section('content')

	{!! Form::model($counterfeit, ['url' => ['/counterfeit', $counterfeit->id], 'method' => 'patch', 'id' =>'counterfeit-form', 'name' =>'counterfeit_form']) !!}

		@include('counterfeit.form')

	{!! Form::close() !!}

@endsection
