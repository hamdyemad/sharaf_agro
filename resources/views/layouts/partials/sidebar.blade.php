 <!-- ========== Left Sidebar Start ========== -->
 @php
    if(Auth::user()->type == 'admin') {
        $orders_count = App\Models\Order::where('viewed', 0)->latest()->get()->count();
    } else {
        $orders_count = App\Models\Order::where('viewed', 0)->where('branch_id', Auth::user()->branch_id)->latest()->get()->count();
    }
@endphp
 <div class="vertical-menu">


     <div data-simplebar class="h-100">
         <!--- Sidemenu -->
         <div id="sidebar-menu">
             <div class="logo text-center">
                 <a href="{{route('dashboard')}}">
                     @if (get_setting('logo'))
                         <img src="{{ asset(get_setting('logo')) }}" alt="">
                     @else
                         <img src="{{ asset('/images/default.jpg') }}" alt="">
                     @endif
                 </a>
                 <span class="badge badge-primary d-block">{{ Auth::user()->name }}</span>
             </div>
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title">{{translate("the main")}}</li>
                 <li>
                     <a href="{{ route('dashboard') }}" class="waves-effect">
                         <i class="mdi mdi-view-dashboard"></i>
                         <span>{{ translate('dashboard') }}</span>
                     </a>
                 </li>
                 @can('settings.edit')
                     <li>
                         <a href="{{ route('settings.edit') }}" class="waves-effect">
                             <i class="mdi mdi-settings"></i>
                             <span>{{ translate('general settings') }}</span>
                         </a>
                     </li>
                 @endcan
                 @can('business.index')
                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-credit-card"></i>
                             <span>{{ translate('financial transactions') }}</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                            @can('currencies.index')
                                <li>
                                    <a href="{{ route('currencies.index') }}" class="waves-effect">
                                        <span>{{ translate('currencies') }}</span>
                                    </a>
                                </li>
                            @endcan
                             @can('business.all')
                                 <li>
                                     <a href="{{ route('business.all') }}" class="waves-effect">
                                         <span>{{ translate('revenues and expenses') }}</span>
                                     </a>
                                 </li>
                             @endcan
                             <li>
                                <a href="{{ route('business.index') }}" class="waves-effect">
                                    <span>{{ translate('all financial transactions') }}</span>
                                </a>
                            </li>
                         </ul>
                     </li>
                 @endcan
                 @can('branches.index')
                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-source-branch"></i>
                             <span>{{ translate('branches') }}</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('branches.index') }}">{{ translate('all branches') }}</a></li>
                             @can('branches.create')
                                 <li><a href="{{ route('branches.create') }}">{{ translate('create branch') }}</a></li>
                             @endcan
                         </ul>
                     </li>
                 @endcan
                 <li class="orders">
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-cart-outline"></i>
                         @if($orders_count !== 0)
                            <span class="badge badge-pill badge-primary float-right">{{ $orders_count }}</span>
                         @endif
                         <span>{{ translate('orders') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                             @can('orders.index')
                                <li><a href="{{ route('orders.index') }}">{{ translate('all orders') }}</a></li>
                             @endcan
                             @can('orders.create')
                                 <li><a href="{{ route('orders.create') }}">{{ translate('create order') }}</a></li>
                             @endcan
                             @can('statuses.index')
                             <li><a href="{{ route('statuses.index') }}">{{ translate('orders statuses') }}</a></li>
                             @endcan
                             @can('statuses.create')
                                <li><a href="{{ route('statuses.create') }}">{{ translate('create orders statuses') }}</a></li>
                             @endcan
                         </ul>
                </li>

                 @can('categories.index')
                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-inbox-multiple"></i>

                             <span>{{ translate('categories') }}</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('categories.index') }}">{{ translate('all categories') }}</a></li>
                             @can('categories.create')
                                 <li><a href="{{ route('categories.create') }}">{{ translate('create category') }}</a></li>
                             @endcan
                         </ul>
                     </li>
                 @endcan
                 @can('products.index')
                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-food"></i>

                             <span>{{ translate('foods') }}</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('products.index') }}">{{ translate('all foods') }}</a></li>
                             @can('products.create')
                                 <li><a href="{{ route('products.create') }}">{{ translate('create food') }}</a></li>
                             @endcan
                         </ul>
                     </li>
                 @endcan
                 @can('countries.index')
                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-airplane"></i>
                             <span>{{ translate('shipping and countries') }}</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('countries.index') }}">{{ translate('all countries') }}</a></li>
                             @can('countries.create')
                                 <li><a href="{{ route('countries.create') }}">{{ translate('create country') }}</a></li>
                             @endcan
                         </ul>
                     </li>
                 @endcan
                 @can('users.index')
                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-account-supervisor-outline"></i>

                             <span>{{ translate('staff and users') }}</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('users.index') }}">{{ translate('all staff') }}</a></li>
                             <li><a href="{{ route('users.index') . '?type=user' }}">{{ translate('all users') }}</a></li>
                         </ul>
                     </li>
                 @endcan
                 @can('roles.index')
                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-account-lock-outline"></i>
                             <span>{{ translate('permessions') }}</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('roles.index') }}">{{ translate('all permessions') }}</a></li>
                             @can('roles.create')
                                 <li><a href="{{ route('roles.create') }}">{{ translate('create permession') }}</a></li>
                             @endcan
                         </ul>
                     </li>
                 @endcan
                 @can('languages.index')
                    <li>
                        <a href="{{ route('languages.index') }}" class="waves-effect">
                            <i class="mdi mdi-translate"></i>
                            <span>{{ translate('langs ​​and translation') }}</span>
                        </a>
                    </li>
                 @endcan
                 {{-- <li>
                     <a href="/calendar/calendar" class=" waves-effect">
                         <i class="mdi mdi-calendar-check"></i>
                         <span>Calendar</span>
                     </a>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-email-outline"></i>
                         <span>Email</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/email/email-inbox">Inbox</a></li>
                         <li><a href="/email/email-read">Email Read</a></li>
                         <li><a href="/email/email-compose">Email Compose</a></li>
                     </ul>
                 </li>

                 <li class="menu-title">Components</li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-buffer"></i>
                         <span>UI Elements</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/ui/ui-alerts">Alerts</a></li>
                         <li><a href="/ui/ui-buttons">Buttons</a></li>
                         <li><a href="/ui/ui-badge">Badge</a></li>
                         <li><a href="/ui/ui-cards">Cards</a></li>
                         <li><a href="/ui/ui-carousel">Carousel</a></li>
                         <li><a href="/ui/ui-dropdowns">Dropdowns</a></li>
                         <li><a href="/ui/ui-grid">Grid</a></li>
                         <li><a href="/ui/ui-images">Images</a></li>
                         <li><a href="/ui/ui-lightbox">Lightbox</a></li>
                         <li><a href="/ui/ui-modals">Modals</a></li>
                         <li><a href="/ui/ui-pagination">Pagination</a></li>
                         <li><a href="/ui/ui-popover-tooltips">Popover &amp; Tooltips</a></li>
                         <li><a href="/ui/ui-rangeslider">Range Slider</a></li>
                         <li><a href="/ui/ui-session-timeout">Session Timeout</a></li>
                         <li><a href="/ui/ui-progressbars">Progress Bars</a></li>
                         <li><a href="/ui/ui-sweet-alert">Sweet-Alert</a></li>
                         <li><a href="/ui/ui-tabs-accordions">Tabs &amp; Accordions</a></li>
                         <li><a href="/ui/ui-typography">Typography</a></li>
                         <li><a href="/ui/ui-video">Video</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="waves-effect">
                         <i class="mdi mdi-clipboard-outline"></i>
                         <span class="badge badge-pill badge-success float-right">6</span>
                         <span>Forms</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/form/form-elements">Form Elements</a></li>
                         <li><a href="/form/form-validation">Form Validation</a></li>
                         <li><a href="/form/form-advanced">Form Advanced</a></li>
                         <li><a href="/form/form-editors">Form Editors</a></li>
                         <li><a href="/form/form-uploads">Form File Upload</a></li>
                         <li><a href="/form/form-xeditable">Form Xeditable</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-chart-line"></i>
                         <span>Charts</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/charts/charts-morris">Morris Chart</a></li>
                         <li><a href="/charts/charts-chartist">Chartist Chart</a></li>
                         <li><a href="/charts/charts-chartjs">Chartjs Chart</a></li>
                         <li><a href="/charts/charts-flot">Flot Chart</a></li>
                         <li><a href="/charts/charts-c3">C3 Chart</a></li>
                         <li><a href="/charts/charts-other">Jquery Knob Chart</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-format-list-bulleted-type"></i>
                         <span>Tables</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/tables/tables-basic">Basic Tables</a></li>
                         <li><a href="/tables/tables-datatable">Data Table</a></li>
                         <li><a href="/tables/tables-responsive">Responsive Table</a></li>
                         <li><a href="/tables/tables-editable">Editable Table</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-album"></i>
                         <span>Icons</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/icons/icons-material">Material Design</a></li>
                         <li><a href="/icons/icons-ion">Ion Icons</a></li>
                         <li><a href="/icons/icons-fontawesome">Font Awesome</a></li>
                         <li><a href="/icons/icons-themify">Themify Icons</a></li>
                         <li><a href="/icons/icons-dripicons">Dripicons</a></li>
                         <li><a href="/icons/icons-typicons">Typicons Icons</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="waves-effect">
                         <span class="badge badge-pill badge-danger float-right">2</span>
                         <i class="mdi mdi-google-maps"></i>
                         <span>Maps</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/maps/maps-google"> Google Map</a></li>
                         <li><a href="/maps/maps-vector"> Vector Map</a></li>
                     </ul>
                 </li>

                 <li class="menu-title">Extras</li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-responsive"></i>
                         <span> Layouts </span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/pagelayouts/layouts-horizontal">Horizontal</a></li>
                         <li><a href="/pagelayouts/layouts-light-sidebar">Light Sidebar</a></li>
                         <li><a href="/pagelayouts/layouts-compact-sidebar">Compact Sidebar</a></li>
                         <li><a href="/pagelayouts/layouts-icon-sidebar">Icon Sidebar</a></li>
                         <li><a href="/pagelayouts/layouts-boxed">Boxed Layout</a></li>
                         <li><a href="/pagelayouts/layouts-preloader">Preloader</a></li>
                         <li><a href="/pagelayouts/layouts-colored-sidebar">Colored Sidebar</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-account-box"></i>
                         <span> Authentication </span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/pages/pages-login">Login</a></li>
                         <li><a href="/pages/pages-register">Register</a></li>
                         <li><a href="/pages/pages-recoverpw">Recover Password</a></li>
                         <li><a href="/pages/pages-lock-screen">Lock Screen</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-google-pages"></i>
                         <span> Extra Pages </span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="/pages/pages-timeline">Timeline</a></li>
                         <li><a href="/pages/pages-invoice">Invoice</a></li>
                         <li><a href="/pages/pages-directory">Directory</a></li>
                         <li><a href="/pages/pages-blank">Blank Page</a></li>
                         <li><a href="/pages/pages-404">Error 404</a></li>
                         <li><a href="/pages/pages-500">Error 500</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="mdi mdi-share-variant"></i>
                         <span>Multi Level</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="true">
                         <li><a href="javascript: void(0);">Level 1.1</a></li>
                         <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                             <ul class="sub-menu" aria-expanded="true">
                                 <li><a href="javascript: void(0);">Level 2.1</a></li>
                                 <li><a href="javascript: void(0);">Level 2.2</a></li>
                             </ul>
                         </li>
                     </ul>
                 </li> --}}

             </ul>
         </div>
         <!-- Sidebar -->
     </div>
 </div>
 <!-- Left Sidebar End -->
