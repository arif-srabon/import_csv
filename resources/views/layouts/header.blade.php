<div class="navbar navbar-inverse">
  <div class="navbar-header">
    <a class="navbar-brand" href="{{url('dashboard')}}">
      <img class="navbar-logo" src="{{ asset('assets/images/srabon.jpg') }}" alt="Ariful Islam Srabon">
      <span class="navbar-branding">
        <span class="brand-text">
         @if('bn' === Session::get('locale')) Project Name Bangla @else Project Name English @endif
        </span>
        <small class="brand-secondary-text">

        </small>
      </span>
    </a>
    <ul class="nav navbar-nav pull-right visible-xs-block">
      <li>
        <a data-toggle="collapse" data-target="#navbar-mobile">
          <i class="icon-tree5"></i>
        </a>
      </li>
      <li>
        <a class="sidebar-mobile-main-toggle">
          <i class="icon-paragraph-justify3"></i>
        </a>
      </li>
    </ul>
  </div>
  <div class="navbar-collapse collapse" id="navbar-mobile">
    <div class="navbar-text">
      
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown dropdown-user">
        <a class="dropdown-toggle text-right" data-toggle="dropdown">
          <?php $sess_user_img = Session::get("sess_user_image"); ?>
          <img src="{{ asset(ImageManager::getImagePath($sess_user_img, 28, 28, 'crop')) }}"> <strong>{{ Session::get("sess_user_full_name") }}</strong> <i class="caret"></i><br>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="{{url('dashboard')}}"><i class="icon-home"></i> {{trans('master.header_home')}}</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="{{url('profile')}}"><i class="icon-user-plus"></i> {{trans('master.header_my_profile')}}</a></li>
          <li><a href="{{url('myaccesslog')}}"><i class="icon-pulse2"></i> {{trans('master.header_my_log')}}</a></li>
          <li><a href="{{url('passwd')}}"><i class="icon-cog5"></i> {{trans('master.header_change_password')}}</a></li>
          <li class="divider"></li>
          <li><a href="{{url('logout')}}"><i class="icon-switch2"></i> {{trans('master.header_logout')}}</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
