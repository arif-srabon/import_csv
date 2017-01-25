<div class="row">
  <div class="col-md-12">
    <div class="form-group"> {!! Form::label('title', trans('setup/news.lbl_title')) !!}
      {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => '']) !!}
      @if ($errors->has('title'))
      <p class="text-danger">{!!$errors->first('title')!!}</p>
      @endif </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="display-block text-semibold">{{ trans('setup/news.lbl_type') }}</label>
          <label class="radio-inline">
          <div class="choice"> {!! Form::radio('type', 'news', true,  ['class' => 'styled']) !!} </div>
          {{ trans('setup/news.lbl_news') }}
          </label>
          <label class="radio-inline">
          <div class="choice"> {!! Form::radio('type', 'events', null,  ['class' => 'styled']) !!} </div>
          {{ trans('setup/news.lbl_events') }}
          </label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="display-block text-semibold">{{ trans('users/user.lbl_status') }}</label>
          <label class="radio-inline">
          <div class="choice"> {!! Form::radio('status', 1, true,  ['class' => 'styled']) !!} </div>
          {{ trans('users/user.lbl_active') }}
          </label>
          <label class="radio-inline">
          <div class="choice"> {!! Form::radio('status', 0, null,  ['class' => 'styled']) !!} </div>
          {{ trans('users/user.lbl_inactive') }}
          </label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group"> {!! Form::label('published_dt', trans('setup/news.lbl_pub_dt')) !!}
          <div class="input-group"> {!! Form::text('published_dt', null, ['class' => 'form-control daterange-single daterange-left']) !!} <span class="input-group-addon"><i class="icon-calendar22"></i></span> </div>
          @if ($errors->has('published_dt'))
          <p
                            class="text-danger">{!!$errors->first('published_dt')!!}</p>
          @endif </div>
      </div>
    </div>
  </div>
  <div class="col-md-12"> 
    
    <!-- Summernote click to edit -->
    <div class="panel panel-flat">
      <div class="panel-body">
        <div class="form-group">
          <button type="button" id="edit" class="btn btn-primary"><i
                                    class="icon-pencil3 position-left"></i> Change </button>
          <button type="button" id="save" class="btn btn-success"><i
                                    class="icon-checkmark3 position-left"></i> Apply </button>
        </div>
        <div class="click2edit media-list-container" id="media-list-target-left" style="min-height: 300px;"> {!!  $news->details !!} </div>
      </div>
    </div>
    <!-- /summernote click to edit --> 
    
  </div>
  <div class="text-right">
    {!! Form::hidden('id') !!}
    {!! Form::hidden('details', null, ['id' => 'hidNewsBody']) !!}
    <button id="reset" class="btn btn-default" type="reset"> {{ trans('users/user.btn_reset') }} <i
                class="icon-reload-alt position-right"></i></button>
    <button class="btn btn-primary" type="submit"> {{ trans('users/user.btn_save') }} <i
                class="icon-arrow-right14 position-right"></i></button>
</div>
</div>