@extends('layouts.print')
@section('page_title', trans('trans/complaint.title_edit'))


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
 
  {!! Form::model($complaints, ['method' => 'PATCH', 'id' => 'frm_complaint', 'files' => true, 'url' => ['complaint', $complaints->id]]) !!}
     
     @include('complaint.form')
    
  {!! Form::close() !!} 
    
    </div>
</div>

<!-- /User form --> 

@endsection
<script>
	window.print();
</script>