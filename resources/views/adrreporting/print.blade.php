<?php
/**
 * ADR Reporting : Print
 *
 * @author  Mayeenul Islam
 * @since   1.0.0
 */
?>

@extends('layouts.print')
@section('page_title', trans('adrreporting.title_review'))

@section('content')

  {!! Form::model($adrreporting, ['url' => ['/adrreporting', $adrreporting->id], 'method' => 'patch', 'id' =>'adrreporting-form', 'name' =>'adrreporting_form']) !!}

    @include('adrreporting.form')

  {!! Form::close() !!}

@endsection

<script>
	window.print();
</script>
