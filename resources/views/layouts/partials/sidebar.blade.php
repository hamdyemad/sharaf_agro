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
                 <span class="badge badge-primary d-block mt-1">{{ Auth::user()->name }}</span>
             </div>
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title">الرئيسية</li>
                 <li class="@if(activeRoute('dashboard')) mm-active @endif">
                     <a href="{{ route('dashboard') }}" class="@if(activeRoute('dashboard')) active @endif waves-effect">
                         <i class="mdi mdi-view-dashboard"></i>
                         <span>لوحة التحكم</span>
                     </a>
                 </li>
                 @if(Auth::user()->type == 'user')
                    <li class="@if(activeRoute('news.all_news')) mm-active @endif">
                        <a href="{{ route('news.all_news') }}" class="@if(activeRoute('news.all_news')) active @endif waves-effect">
                            <i class="mdi mdi-newspaper"></i>
                            <span>الأخبار</span>
                        </a>
                    </li>
                 @endif
                 @can('settings.edit')
                     <li class="@if(activeRoute('settings.edit')) mm-active @endif">
                         <a href="{{ route('settings.edit') }}" class="@if(activeRoute('settings.edit')) active @endif waves-effect">
                             <i class="mdi mdi-settings"></i>
                             <span>الأعدادات العامة</span>
                         </a>
                     </li>
                 @endcan
                 @can('categories.index')
                    <li class="@if(activeRoute(['categories.index', 'sub_categories.index'])) mm-active @endif">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-inbox-multiple"></i>
                            <span>الأقسام</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a class="@if(activeRoute('categories.index')) active @endif" href="{{ route('categories.index') }}"> الأقسام الرئيسية</a></li>
                            <li><a class="@if(activeRoute('sub_categories.index')) active @endif" href="{{ route('sub_categories.index') }}">الأقسام الفرعية</a></li>
                        </ul>
                    </li>
                @endcan
                @can('news.index')
                    <li class="@if(activeRoute(['news.index', 'news.create'])) mm-active @endif">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-newspaper"></i>
                            <span>الأخبار</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a class="@if(activeRoute('news.index')) active @endif" href="{{ route('news.index') }}">كل الأخبار</a></li>
                            @can('news.create')
                                <li><a class="@if(activeRoute('news.create')) active @endif" href="{{ route('news.create') }}">انشاء خبر</a></li>
                            @endcan
                        </ul>
                    </li>
                 @endcan
                @if(Auth::user()->type == 'user' || Auth::user()->can('orders.index'))
                    <li class="@if(activeRoute(['orders.index', 'orders.create', 'orders.alerts', 'orders.alerts.renovations'])) mm-active @endif">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-cart-outline"></i>
                            <span>الطلبات</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a class="@if(activeRoute('orders.index')) active @endif" href="{{ route('orders.index') }}">الطلبات</a></li>
                            @can('orders.create')
                            <li><a class="@if(activeRoute('orders.create')) active @endif" href="{{ route('orders.create') }}">انشاء طلب</a></li>
                            @endcan
                            @if(Auth::user()->type == 'user' || Auth::user()->can('orders.alerts.index'))
                            <li><a class="@if(activeRoute('orders.alerts')) active @endif" href="{{ route('orders.alerts') }}">التنبيهات اليومية</a></li>
                            @endif
                            @if(Auth::user()->type == 'user' || Auth::user()->can('orders.alerts.renovations'))
                            <li><a class="@if(activeRoute('orders.alerts.renovations')) active @endif" href="{{ route('orders.alerts.renovations') }}">تنبيهات التجديدات</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                <li class="@if(activeRoute(['orders_under_work.index', 'orders_under_work.create','orders_under_work.alerts'])) mm-active @endif">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-wechat"></i>
                        <span>الرسائل الخاصة بالطلبات</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(Auth::user()->type == 'user' || Auth::user()->can('orders_under_work.index'))
                            <li><a class="@if(activeRoute('orders_under_work.index')) active @endif" href="{{ route('orders_under_work.index') }}">كل الرسائل</a></li>
                        @endif
                        @if(Auth::user()->type == 'user' || Auth::user()->can('orders_under_work.alerts'))
                            <li><a class="@if(activeRoute('orders_under_work.alerts')) active @endif" href="{{ route('orders_under_work.alerts') }}">التنبيهات اليومية</a></li>
                        @endif
                        @if(Auth::user()->type == 'user')
                            <li><a class="@if(activeRoute('orders_under_work.create')) active @endif" href="{{ route('orders_under_work.create') }}">انشاء رسالة</a></li>
                        @endif
                    </ul>
                </li>
                @if(Auth::user()->type == 'user' || Auth::user()->can('inquires.index'))
                    <li class="@if(activeRoute(['inquires.index', 'inquires.create'])) mm-active @endif">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-chat"></i>
                            <span>الاستفسارات</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a class="@if(activeRoute('inquires.index')) active @endif" href="{{ route('inquires.index') }}">كل الأستفسارات</a></li>
                            @if(Auth::user()->type == 'user')
                                <li><a class="@if(activeRoute('inquires.create')) active @endif" href="{{ route('inquires.create') }}">انشاء أستفسار</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @can('users.index')
                    <li class="@if(activeRoute(['users.index', 'users.create'])) mm-active @endif">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-supervisor-outline"></i>
                            <span>الموظفين</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a class="@if(activeRoute('users.index')) active @endif" href="{{ route('users.index') }}">الموظفين</a></li>
                            <li><a class="@if(activeRoute('users.create')) active @endif" href="{{ route('users.create') }}">انشاء موظف</a></li>
                        </ul>
                    </li>
                 @endcan
                 @can('customers.index')
                    <li class="@if(activeRoute(['customers.index', 'customers.create', 'balances.index'])) mm-active @endif">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-supervisor-outline"></i>
                            <span>الشركات</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('customers.index')
                            <li><a class="@if(activeRoute('customers.index')) active @endif" href="{{ route('customers.index') }}">الشركات</a></li>
                            @endcan
                            @can('customers.create')
                            <li><a class="@if(activeRoute('customers.create')) active @endif" href="{{ route('customers.create') }}">انشاء شركة</a></li>
                            @endcan
                            @can('balances.index')
                            <li><a class="@if(activeRoute('balances.index')) active @endif" href="{{ route('balances.index') }}">رصيد الشركات</a></li>
                            @endcan
                        </ul>
                    </li>
                 @endcan
                 @can('roles.index')
                     <li class="@if(activeRoute(['roles.index', 'roles.create'])) mm-active @endif">
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="mdi mdi-account-lock-outline"></i>
                             <span>الصلاحيات</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a class="@if(activeRoute('roles.index')) active @endif" href="{{ route('roles.index') }}">كل الصلاحيات</a></li>
                             @can('roles.create')
                                 <li><a class="@if(activeRoute('roles.create')) active @endif" href="{{ route('roles.create') }}">انشاء صلاحية</a></li>
                             @endcan
                         </ul>
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
