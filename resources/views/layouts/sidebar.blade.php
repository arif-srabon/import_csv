<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    @if ( 'bn' === Session::get("locale") )

                        <li>
                            <a id="sidebar-language-switcher-en">
                                <img id="sidebar-toggle-icon" alt="English Flag"
                                     src="{{ asset('assets/images/flags/gb.png') }}" class="position-left"> <span
                                        class="collapse-label">Switch to English</span>
                            </a>
                        </li>

                    @endif

                    @if ( 'en' === Session::get("locale") )

                        <li>
                            <a id="sidebar-language-switcher-bn">
                                <img id="sidebar-toggle-icon" alt="Bangladesh Flag"
                                     src="{{ asset('assets/images/flags/bd.png') }}" class="position-left"> <span
                                        class="collapse-label">বাংলায় দেখুন</span>
                            </a>
                        </li>

                    @endif

                    <li>
                        <a class="sidebar-control sidebar-main-toggle hidden-xs">
                            <i id="sidebar-toggle-icon" class="icon-circle-left2"></i> <span class="collapse-label">Collapse Menu</span>
                        </a>
                    </li>

                    <!-- Main -->
                    <li class="@yield('menu_dashboard')">
                        <a href="/dashboard"><i class="icon-home4"></i>
                            <span>{{trans('sidebar.dashboard')}}</span></a>
                    </li>

                    @if (SentinelAuth::check(['dss.security.users.view', 'dss.security.role.view']))
                        <li class="@yield('menu_security')"><a href="#"><i class="icon-key"></i>
                                <span>{{trans('sidebar.security')}}</span></a>
                            <ul>
                                @if (SentinelAuth::check('dss.security.users.view'))
                                    <li class="@yield('menu_user')">{{ link_to('user', trans('sidebar.users')) }}</li>
                                @endif
                                @if (SentinelAuth::check('dss.security.role.view'))
                                    <li class="@yield('menu_role')">{{ link_to('role', trans('sidebar.role')) }}</li>
                                @endif
                            </ul>
                        </li>
                    @endif

				  @if (SentinelAuth::check(['dss.settings.commonconfig.view', 'dss.settings.division.view', 'dss.settings.district.view', 'dss.settings.thana_upazilla.view','dss.settings.city_corp_paurasava.view','dss.settings.union_ward.view','dss.settings.unionward.view', 'dss.settings.city_corp_zone.view', 'settings.medicine.view']))
                    <li class="@yield('menu_setup')"><a href="#"><i class="icon-gear"></i>
                            <span>{{trans('sidebar.settings')}}</span></a>
                        <ul>
                            @if (SentinelAuth::check('dss.settings.commonconfig.view'))
                               <li class="@yield('menu_setup_common_config')">{{ link_to('commonconfig', trans('sidebar.common_configuration')) }}</li>
                            @endif
                            @if (SentinelAuth::check(['dss.settings.division.view', 'dss.settings.district.view', 'dss.settings.thana_upazilla.view','dss.settings.city_corp_paurasava.view','dss.settings.union_ward.view','dss.settings.unionward.view', 'dss.settings.city_corp_zone.view' ]))
                                <li>
                                    <a href="#"
                                       class="has-ul @yield('menu_setup_location')">{{trans('sidebar.location')}}</a>
                                    <ul>
                                        @if (SentinelAuth::check('dss.settings.division.view'))
                                            <li class="@yield('menu_setup_division')">{{ link_to('division', trans('sidebar.division')) }}</li>
                                        @endif
                                        @if (SentinelAuth::check('dss.settings.district.view'))
                                            <li class="@yield('menu_setup_district')">{{ link_to('district', trans('sidebar.district')) }}</li>
                                        @endif
                                        @if (SentinelAuth::check('dss.settings.thana_upazilla.view'))
                                            <li class="@yield('menu_setup_thanaupazilla')">{{ link_to('thanaupazilla', trans('sidebar.thanaupazilla')) }}</li>
                                        @endif
                                        @if (SentinelAuth::check('dss.settings.union_ward.view'))
                                            <li class="@yield('menu_setup_unionward')">{{ link_to('unionward', trans('sidebar.unionward')) }}</li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            
                            @if (SentinelAuth::check('settings.manufacturer.view'))
                                <li class="@yield('menu_setup_manufacturer')">{{ link_to('manufacturer', trans('sidebar.manufacturer')) }}</li>
                            @endif
                            @if (SentinelAuth::check('settings.medicine.view'))
                                <li class="@yield('menu_setup_medicine_price')">{{ link_to('medicine', trans('sidebar.medicine_price')) }}</li>
                            @endif
                            		
                        </ul>
                    </li>
                    @endif


					@if (SentinelAuth::check('transactions.adrreporting.view'))
                        <li class="@yield('menu_ADR_Reporting')">
                            <a href="{{url('adrreporting')}}">
                                <i class="icon-stack"></i> <span>{{trans('sidebar.ADR_Reporting')}}</span>
                            </a>
                        </li>
                    @endif
    
                    @if (SentinelAuth::check('transactions.complaint.view'))
                        <li class="@yield('menu_complaint')">
                            <a href="{{url('complaint')}}">
                                <i class="icon-comment-discussion"></i> <span>{{trans('sidebar.complaint')}}</span>
                            </a>
                        </li>
                    @endif
    
                    @if (SentinelAuth::check('transactions.counterfeit.view'))
                        <li class="@yield('menu_Counterfeit_fake')">
                            <a href="{{url('counterfeit')}}">
                                <i class="icon-archive"></i> <span>{{trans('sidebar.counterfeit')}}</span>
                            </a>
                        </li>
                    @endif
    
                    @if (SentinelAuth::check('transactions.news.view'))
                        <li class="@yield('menu_news')">
                            <a href="{{url('news')}}">
                                <i class="icon-list"></i> <span>{{trans('sidebar.news')}}</span>
                            </a>
                        </li>
                    @endif
    
                    @if (SentinelAuth::check('manufacturer.uniquenumber.view'))
					<li class="@yield('menu_medicinecode')">
                        <a href="{{url('medicinecode')}}">
                            <i class="icon-qrcode"></i> <span>{{trans('sidebar.uni_num_generation')}}</span>
                        </a>
                    </li>
                    @endif

                        {{--import file--}}
                        <li class="@yield('menu_import')">
                            <a href="{{url('importfile')}}">
                                <i class="icon-import"></i> <span>{{trans('sidebar.import_file')}}</span>
                            </a>
                        </li>
                        {{--end import--}}

                    <li>
                        <a id="sidebar-theme-switcher">
                            <i class="icon-color-sampler position-left"></i> <span class="collapse-label">@if ( 'bn' === Session::get("locale") )
                                    রঙ পরিবর্তন করুন @elseif( 'en' === Session::get("locale") ) Color Switcher @endif
                                <span class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-sm active">
                                        <span class="theme-ui-color-box"></span>
                                        <input type="radio" name="color_switcher" class="color-switches" value="default"
                                               checked="checked">
                                    </label>
                                    <label class="btn btn-sm">
                                        <span class="theme-ui-color-box color-green"></span>
                                        <input type="radio" name="color_switcher" class="color-switches" value="green">
                                    </label>
                                    <label class="btn btn-sm">
                                        <span class="theme-ui-color-box color-violet"></span>
                                        <input type="radio" name="color_switcher" class="color-switches" value="violet">
                                    </label>
                                </span>
                            </span>
                        </a>
                    </li>
                    <!-- /main -->

                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>

<script>
    $(document).ready(function () {
        $('#sidebar-language-switcher-en').on('click', function () {
            window.location.replace('{{url("setlang/en")}}');
        });
        $('#sidebar-language-switcher-bn').on('click', function () {
            window.location.replace('{{url("setlang/bn")}}');
        });
    });
</script>