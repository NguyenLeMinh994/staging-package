<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="/" class="m-brand__logo-wrapper">
                            <img alt="TAporta" src="{{asset('/asset/package/media/img/logo/taporta-white-logo.png')}}" style="width:150px"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>
                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->

                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                        <script>
                            $("#m_aside_left_minimize_toggle" ).click(function() {
                                var aside_status = "";
                                
                                if ($("body").hasClass("m-aside-left--minimize"))
                                    aside_status = "m-brand--minimize m-aside-left--minimize";
                                else
                                    aside_status = "";

                                $.ajax({
                                    url: "/update-sessions",
                                    method: 'POST',
                                    data: {
                                        _token: '{!! csrf_token() !!}',
                                        status: aside_status,
                                    },
                                    success: function(result){
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                <!-- END: Horizontal Menu -->

                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                </div>

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__languages m-dropdown m-dropdown--small m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width" m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-text">
                                        <img class="m-topbar__language-selected-img" src="{{asset('/asset/app/media/img/flags/020-flag.svg')}}">
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center" style="background: url({{asset('/asset/app/media/img/misc/quick_actions_bg.jpg')}}); background-size: cover;">
                                            <span class="m-dropdown__header-subtitle">Select your language</span>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__item m-nav__item--active">
                                                        <a href="#" class="m-nav__link m-nav__link--active">
                                                            <span class="m-nav__link-icon"><img class="m-topbar__language-img" src="{{asset('/asset/app/media/img/flags/020-flag.svg')}}"></span>
                                                            <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">USA</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle" style="cursor: default;">
                                    <span class="m-topbar__welcome">Welcome,&nbsp;</span>	
                                    <span class="m-topbar__username">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="{{ route('logout') }}" class="m-nav__link m-dropdown__toggle" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <span class="m-nav__link-icon"><i class="flaticon-logout"></i></span>
                                </a>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>