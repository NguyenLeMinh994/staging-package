<?php
    $active_menu = array();
    
    $active_menu['dashboard'] = "";
    $active_menu['product-type'] = "";
    $active_menu['package-category'] = "";
    $active_menu['themes'] = "";

    $active_menu['cancellation-policy'] = "";
    $active_menu['children-policy'] = "";
    
    $active_menu['supplier-type'] = "";
    $active_menu['supplier'] = "";
    $active_menu['user'] = "";
    
    $active_menu['package-plan'] = "";
    $active_menu['package-rates'] = "";
    $active_menu['package-allotment'] = "";

    $current_uri = request()->route()->uri();

    if(strpos($current_uri,'/') != false){
        $current_uri = substr($current_uri, 0, strpos($current_uri,'/'));
    }

    switch ($current_uri) {
        //Product (for only Supper Admin)
        case 'product-type':
            $active_menu['product-type']        = "m-menu__item--active";
            break;
        case 'package-category':
            $active_menu['package-category']    = "m-menu__item--active";
            break;
        case 'themes':
            $active_menu['themes']              = "m-menu__item--active";
            break;

        //Policy (for Admin)    
        case 'cancellation-policy':
            $active_menu['cancellation-policy'] = "m-menu__item--active";
            break;
        case 'children-policy':
            $active_menu['children-policy'] = "m-menu__item--active";
            break;
        
        //Supplier Management (for Admin)
        case 'supplier-type':
            $active_menu['supplier-type']       = "m-menu__item--active";
            break;
        case 'supplier':
            $active_menu['supplier']            = "m-menu__item--active";
            break;
        case 'user':
            $active_menu['user']                = "m-menu__item--active";
            break;

        //Main
        case 'package-plan':
            $active_menu['package-plan']        = "m-menu__item--active";
            break;
        case 'package-rates':
            $active_menu['package-rates']       = "m-menu__item--active";
            break;
        case 'rates':
            $active_menu['package-rates']       = "m-menu__item--active";
            break;
        case 'package-allotment':
            $active_menu['package-allotment']   = "m-menu__item--active";
            break;
        case 'allotments':
            $active_menu['package-allotment']   = "m-menu__item--active";
            break;

        //Home
        default:
            $active_menu['dashboard']           = "m-menu__item--active";
            break;
    }
?>
<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow asidebar-font-customize">
            <li class="m-menu__item  {{$active_menu['dashboard']}}" aria-haspopup="true">
                <a href="/" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text asidebar-font-customize">Home</span>
                        </span>
                    </span>
                </a>
            </li>
            <!-- Package Management Section -->
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">Product Managment</h4>
                <i class="m-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['package-plan']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/package-plan" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-2"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Product List</span>
                </a>
            </li>
            <!--
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['package-rates']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/package-rates" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-calendar-1"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Product Rate</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['package-allotment']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/package-allotment" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-3"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Product Availability</span>
                </a>
            </li>
            -->
            <!-- Product Section -->
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">Product</h4>
                <i class="m-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['product-type']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/product-type" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-folder"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Product Type</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['package-category']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/package-category" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-folder-1"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Product Category</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['themes']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/themes" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-responsive"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Product Themes</span>
                </a>
            </li>
            
            <!-- Policy Section -->
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">Policy</h4>
                <i class="m-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['cancellation-policy']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/cancellation-policy" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-warning"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Cancellation Policy</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['children-policy']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/children-policy" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-exclamation-1"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Children Policy</span>
                </a>
            </li>
            
            <!-- Supplier Management Section -->
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">Supplier</h4>
                <i class="m-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['supplier-type']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/supplier-type" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-network"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Supplier Type</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['supplier']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/supplier" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-presentation-1"></i>
                    <span class="m-menu__link-text asidebar-font-customize">Supplier Management</span>
                </a>
            </li>
            
            <li class="m-menu__item  m-menu__item--submenu {{$active_menu['user']}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="/user" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-users"></i>
                    <span class="m-menu__link-text asidebar-font-customize">User Management</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>