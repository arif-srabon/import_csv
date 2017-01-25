<?php
/**
 * Counterfeit Reporting : Print
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */
?>

@extends('layouts.print')
@section('page_title', trans('counterfeit.title_review'))

@section('content')

  {!! Form::model($counterfeit, ['url' => ['/counterfeit', $counterfeit->id], 'method' => 'patch', 'id' =>'counterfeit-form', 'name' =>'counterfeit_form']) !!}

    @include('counterfeit.form')

  {!! Form::close() !!}

@endsection

<script>
	window.print();
</script>
