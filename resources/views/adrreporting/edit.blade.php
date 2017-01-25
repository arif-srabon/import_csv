<?php
/**
 * ADR Reporting : Edit
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */
?>

@extends('layouts.master')
@section('page_title', trans('adrreporting.title_review'))
@section('menu_ADR_Reporting','active')

@section('page_header')
    <i class="icon-stack position-left"></i> <span class="text-semibold">{{ trans('adrreporting.title_review') }}</span>
@endsection

@section('breadcrumb_links')
	<!-- If user is permitted -->
    @if (SentinelAuth::check('transactions.adrreporting.view'))
		<li>
			<a href="{{ url('adrreporting') }}">
				<i class="icon-stack position-left"></i> {{ trans('adrreporting.link_list') }}
			</a>
		</li>
	@endif
@endsection

@section('content')

	{!! Form::model($adrreporting, ['url' => ['/adrreporting', $adrreporting->id], 'method' => 'patch', 'id' =>'adrreporting-form', 'name' =>'adrreporting_form']) !!}

		@include('adrreporting.form')

	{!! Form::close() !!}

@endsection
