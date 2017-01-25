
<div class="modal-content">
<div class="modal-header bg-info">
    <button data-dismiss="modal" class="close" type="button">×</button>
    <h5 class="modal-title ">{{ trans('setup/district.window_add_title') }}</h5>
</div>
 
{!! Form::open(['url' => '/district', 'method' => 'post', 'id' =>'frmDistrict', 'name' =>'frmDistrict']) !!}
  <div class="modal-body">
          

            @include('setup.district.district_form')

           
  </div>
 
 {!! Form::close() !!}

</div>


    


