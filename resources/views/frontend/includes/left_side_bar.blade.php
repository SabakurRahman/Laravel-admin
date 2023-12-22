<style>
    #side-menu li a {
        text-decoration: none !important;
    }

    .data-center {
        padding-left: 20px !important;
    }

    .breadcrumb-item a, h4 {
        text-decoration: none !important;
    }
</style>

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{route('front.index')}}" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{--product related all things goes here--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-list-radio"></i>
                        <span>Catalog</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'product') !!}>
                            <a href="{{route('product.index')}}">
                                <i class="ri-box-3-fill"></i>
                                Product
                            </a>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'category') !!}>
                            <a href="{{route('category.index')}}">
                                <i class="ri-list-check-2"></i>
                                Categories
                            </a>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'manufacture') !!}>
                            <a href="{{route('manufacture.index')}}" class="waves-effect">
                                <i class="ri-boxing-fill"></i>
                                <span>Manufactures</span>
                            </a>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'warehouses') !!}>
                            <a href="{{route('warehouses.index')}}" class="waves-effect">
                                <i class="ri-home-smile-fill"></i>
                                <span>Warehouses</span>
                            </a>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'vendor') !!}>
                            <a href="{{route('vendor.index')}}" class="waves-effect">
                                <i class="ri-store-line"></i>
                                <span>Vendor</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-list-check-3"></i>
                                <span>Attribute</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'attribute') !!}>
                                    <a href="{{ route('attribute.index') }}"> Attribute</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'attribute-value') !!}>
                                    <a href="{{ route('attribute-value.index') }}"> Attribute Value </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                {{--sales related all things goes here--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-exchange-dollar-line"></i>
                        <span>Sales</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'order') !!}>
                            <a href="{{route('order.index')}}">
                                <i class="ri-file-list-3-fill"></i>
                                Order
                            </a>
                        </li>
                    </ul>
                </li>
                {{--Lead related all things goes here--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-seo-line"></i>
                        <span>Leads</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-calculator-line"></i>
                                <span>Estimate</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'estimate-category') !!}>
                                    <a href="{{ route('estimate-category.index') }}"> Category</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'estimate-sub-category') !!}>
                                    <a href="{{ route('estimate-sub-category') }}">Sub Category</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'estimate-package') !!}>
                                    <a href="{{ route('estimate-package.index') }}">Package</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'unit-price') !!}>
                                    <a href="{{ route('unit-price.index') }}">Estimate Price</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'estimation-lead') !!}>
                                    <a href="{{ route('estimation-lead.index') }}">Estimation Leads</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                {{--Report related all things goes here--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-line-chart-fill"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'category') !!}>
                            <a href="{{route('category.index')}}">
                                <i class="ri-bar-chart-box-line"></i>
                                Sale Report
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-riding-line"></i>
                        <span>Courier</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'courier') !!}>
                            <a href="{{route('couriers.index')}}">
                                Courier
                            </a>
                        </li>
                    <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'division') !!}>
                            <a href="{{route('division.index')}}">
                                Division
                            </a>
                    </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'city') !!}>
                            <a href="{{route('city.index')}}">
                                City
                            </a>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'zone') !!}>
                            <a href="{{route('zone.index')}}">
                                Zone
                            </a>
                        </li>
                    </ul>
                </li>

                {{--Settings related all things goes here--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-tools-line"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'payment-method') !!}>
                            <a href="{{route('payment-method.index')}}" class="waves-effect">
                                <i class="ri-wallet-3-line"></i>
                                <span>Payment Method</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-shield-user-line"></i>
                                <span>User Permission</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'role') !!}>
                                    <a href="{{route('role.index')}}">Role</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'user') !!}>
                                    <a href="{{ route('user.index') }}">Role User Association </a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'customer-group') !!}>
                                    <a href="{{route('customer-group.index')}}">Customer Group</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'user-customer') !!}>
                                    <a href="{{ route('user-customer.group') }}">Customer Group User Association </a>
                                </li>
                            </ul>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'unit') !!}>
                            <a href="{{route('unit.index')}}" class="waves-effect">
                                <i class="ri-pencil-ruler-2-line"></i>
                                <span>Unit</span>
                            </a>
                        </li>
                    </ul>
                </li>


                {{--CMS related all things goes here--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-earth-fill"></i>
                        <span>CMS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li >
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-questionnaire-line"></i>
                                <span>Faq</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'faq-pages') !!}>
                                    <a href="{{ route('faq-pages.index') }}">Faq Pages</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'faq') !!}>
                                    <a href="{{ route('faq.index') }}">Faq</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-pages-fill"></i>
                                <span>Blog</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'blog-category') !!}>
                                    <a href="{{ route('blog-category.index') }}">Blog Category</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'blog-post') !!}>
                                    <a href="{{ route('blog-post.index') }}">Blog Post</a>
                                </li>
                            </ul>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'social') !!}>
                            <a href="{{route('social.index')}}" class="waves-effect">
                                <i class="ri-movie-2-line"></i>
                                <span>Social Media</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-gallery-line"></i>
                                <span>Banner</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'banner-size') !!}>
                                    <a href="{{ route('banner-size.index') }}">Banner Size</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'banner') !!}>
                                    <a href="{{ route('banner.index') }}">Banner</a>
                                </li>
                            </ul>
                        </li>

                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'client-logo') !!}>
                            <a href="{{route('client-logo.index')}}" class="waves-effect">
                                <i class="ri-image-add-line"></i>
                                <span>Client Logo</span>
                            </a>
                        </li>

                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'photo-gallery') !!}>
                            <a href="{{route('photo-gallery.index')}}" class="waves-effect">
                                <i class="ri-album-line"></i>
                                <span>Photo Gallery</span>
                            </a>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'team') !!}>
                            <a href="{{route('team.index')}}" class="waves-effect">
                                <i class="ri-team-fill"></i>
                                <span>Team</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-leaf-fill"></i>
                                <span>Our Approach</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                {{--                        <li><a href="{{ route('our-approach-category.create') }}"> Our approach Category</a></li>--}}
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'our-approach-category') !!}>
                                    <a href="{{ route('our-approach-category.index') }}"> Our approach Category </a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'our-approach') !!}>
                                    <a href="{{ route('our-approach.index') }}"> Our approach</a>
                                </li>
                                {{--                        <li><a href="{{ route('our-approach.index') }}"> Our approach List</a></li>--}}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-store-2-line"></i>
                                <span>Our projects</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'project-category') !!}>
                                    <a href="{{ route('project-category.index') }}"> Project Category</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'our-project') !!}>
                                    <a href="{{ route('our-project.index') }}"> Projects</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'tag') !!}>
                                    <a href="{{ route('tag.index') }}"> Project Tag List</a>
                                </li>
                                <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'web-content') !!}>
                                    <a href="{{ route('web-content.index') }}"> Web Content</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>


                {{--Accessories related all things goes here--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-list-settings-fill"></i>
                        <span>Accessories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'news-letter') !!}>
                            <a href="{{route('news-letter.index')}}" class="waves-effect">
                                <i class="ri-newspaper-line"></i>
                                <span>Newsletter</span>
                            </a>
                        </li>
                        <li {!! \App\Manager\SidebarManager::dropdownListSelected(Route::currentRouteName(), 'visitor') !!}>
                            <a href="{{route('visitor.index')}}" class="waves-effect">
                                <i class="ri-team-fill"></i>
                                <span>Visitors</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- end ul -->
        </div>
        <!-- Sidebar -->
    </div>
</div>
