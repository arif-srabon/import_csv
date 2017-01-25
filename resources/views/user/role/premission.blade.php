@extends('layouts.master')
@section('page_title', trans('users/permission.lbl_permission'))
@section('menu_security', 'active')
@section('menu_role', 'active')

@section('page_header')
    <i class="icon-key position-left"></i> <span class="text-semibold">{{ trans('users/permission.lbl_permission') }}</span>
@endsection

 <?php 
		if($flag == 'user') {
			$actionUrl = url('userpermissionsave');
			$mode = "USER";
			$user_id = $role->id;
			$backPath = url("user/$user_id/edit");
			$appliedTo = $role->full_name_en;
		} else {
			$actionUrl = url('permissionsave');
			$mode = "ROLE";
			$backPath = url('role');
			$appliedTo = $role->name;
		}
	?>
    
    
@section('breadcrumb_links')
    <li><a href="{{ $backPath }}"><i class=" icon-arrow-left16 position-left"></i> {{ trans('users/permission.link_back') }}</a></li>
    <li><a href="{{url('user')}}"><i class="icon-users position-left"></i> {{ trans('users/permission.link_user_list') }}</a></li>
    <li><a href="{{url('role')}}"><i class="icon-grid4 position-left"></i> {{ trans('users/permission.link_role_list') }}</a></li>
@endsection

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h6 class="panel-title">{{ trans('users/permission.page_title') }} <?php if($appliedTo != ''){echo '('.$appliedTo.')';}?></h6>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                </ul>
            </div>
            <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

	    @include('errors.message')
    
     <form method="post" action="{{ $actionUrl }}">                 
        <div class="panel-body">
                 <div class="text-right">
              <input type="hidden" name="id" value="{{ $role->id }}" />
              <button class="btn btn-primary" type="submit">{{ trans('users/permission.btn_save') }} <i class="icon-arrow-right14 position-right"></i></button>
	    </div>

            <div class="tabbable tab-content-bordered">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    @foreach($modules as $k=>$module)
                        <li class="<?php echo ($k==0) ? 'active' : ''; ?>"><a data-toggle="tab" href="#tab-{{ $module }}">{{ $module }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($modules as $k=>$module)
                        <div id="tab-{{ $module }}" class="tab-pane has-padding <?php echo ($k==0) ? 'active' : ''; ?>">
                            <?php  $perOptions = $permission->getPermissionData($module); ?>
                            <?php //dump($permissionData); ?>
                                <fieldset>
                                    <legend><?php echo $perOptions[0]['description']; ?></legend>
                                    <dl>
                                        <?php foreach($perOptions as $k => $option) {  ?>
                                            <h6 class="text-semibold text-primary "><?php echo $option['section']; ?></h6>
                                        <dd>
                                            <?php
                                            $opts = unserialize($option['premission']);
                                            foreach($opts as $k => $opt) {
													
												if(in_array($k, $appliedPermissions)) {
													 $chked = 'checked="checked"';
												} else {
													$chked = "";
												}
                                            ?>
                                                <div class="checkbox-div">
                                                  <label class="checkbox-inline">
                                                        <div class="checkers">
                                                                <input type="checkbox" value="<?php echo $k; ?>" name="chkPermission[]" <?php echo $chked; ?> class="styled">
														</div> 
                                                        <?php echo $opt; ?>
                                                    </label>
                                                </div>

                                            <?php } ?>
                                        </dd>
                                        <?php } ?>
                                    </dl>
                                </fieldset>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      
     </form>
      
    </div>


@endsection