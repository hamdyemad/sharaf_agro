<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen font-size-24"></i>
                </button>
            </div>
            {{-- Start Notification --}}
                @php
                        // News
                    if(Auth::user()->can('news.show') || Auth::user()->type == 'user') {
                        $news_ids_view = App\Models\NewsView::where('user_id', Auth::id())
                        ->where('viewed', 1)
                        ->pluck('new_id');
                        if(Auth::user()->type == 'admin') {
                            $news = App\Models\News::whereNotIn('id', $news_ids_view)
                            ->orderBy('updated_at', 'DESC')
                            ->get();
                        } else if(Auth::user()->type == 'sub-admin') {
                            $news = App\Models\News::
                            whereNotIn('id', $news_ids_view)->latest()->get();
                        } else {
                            $news = App\Models\News::whereNotIn('id', $news_ids_view)
                            ->latest()
                            ->get();
                        }
                    } else {
                        $news = [];
                    }

                    // Orders
                    if(Auth::user()->can('orders.show') || Auth::user()->type == 'user') {
                        $orders_view_ids = App\Models\OrderView::where('user_id', Auth::id())
                        ->where('viewed', 1)
                        ->pluck('order_id');
                        if(Auth::user()->type == 'admin') {
                            $orders = App\Models\Order::whereNotIn('id', $orders_view_ids)
                            ->orderBy('updated_at', 'DESC')
                            ->get();
                        } else if(Auth::user()->type == 'sub-admin') {
                            $userCategories = App\Models\UserCategory::where('user_id', Auth::id())->pluck('category_id');
                            $userSubCategories = App\Models\UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
                            $orders = App\Models\Order::
                            whereIn('category_id',$userCategories)
                            ->whereNotIn('id', $orders_view_ids)
                            ->whereIn('sub_category_id',$userSubCategories)->latest()->get();
                        } else {
                            $orders = App\Models\Order::
                            where('customer_id', Auth::id())
                            ->whereNotIn('id', $orders_view_ids)
                            ->latest()
                            ->get();
                        }
                    } else {
                        $orders = [];
                    }


                    // Orders Under Work
                    if(Auth::user()->can('orders_under_work.show') || Auth::user()->type == 'user') {
                        $orders_under_work_ids_views = App\Models\OrderUnderWorkView::where('user_id', Auth::id())
                        ->where('viewed', 1)
                        ->pluck('order_under_work_id');
                        if(Auth::user()->type == 'admin') {
                            $orders_under_work = App\Models\OrderUnderWork::whereNotIn('id', $orders_under_work_ids_views)
                            ->orderBy('updated_at', 'DESC')
                            ->get();
                        } else if(Auth::user()->type == 'sub-admin') {
                            $userCategories = App\Models\UserCategory::where('user_id', Auth::id())->pluck('category_id');
                            $userSubCategories = App\Models\UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
                            $orders_under_work = App\Models\OrderUnderWork::
                            whereIn('category_id',$userCategories)
                            ->whereNotIn('id', $orders_under_work_ids_views)
                            ->whereIn('sub_category_id',$userSubCategories)->latest()->get();
                        } else {
                            $orders_under_work = App\Models\OrderUnderWork::
                            where('customer_id', Auth::id())
                            ->whereNotIn('id', $orders_under_work_ids_views)
                            ->latest()
                            ->get();
                        }
                    } else {
                        $orders_under_work = [];
                    }

                    // Inquires
                    if(Auth::user()->can('inquires.show') || Auth::user()->type == 'user') {
                        $inquires_ids_view = App\Models\InquireView::where('user_id', Auth::id())
                        ->where('viewed', 1)
                        ->pluck('inquire_id');
                        if(Auth::user()->type == 'admin') {
                            $inquires = App\Models\Inquire::whereNotIn('id', $inquires_ids_view)
                            ->orderBy('updated_at', 'DESC')
                            ->get();
                        } else if(Auth::user()->type == 'sub-admin') {
                            $userCategories = App\Models\UserCategory::where('user_id', Auth::id())->pluck('category_id');
                            $userSubCategories = App\Models\UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
                            $inquires = App\Models\Inquire::
                            whereIn('category_id',$userCategories)
                            ->whereNotIn('id', $inquires_ids_view)
                            ->whereIn('sub_category_id',$userSubCategories)->latest()->get();
                        } else {
                            $inquires = App\Models\Inquire::
                            where('customer_id', Auth::id())
                            ->whereNotIn('id', $inquires_ids_view)
                            ->latest()
                            ->get();
                        }
                    } else {
                        $inquires = [];
                    }
                @endphp
                <div class="dropdown d-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti-bell"></i>
                        <span class="badge badge-danger badge-pill">{{ count($orders) + count($orders_under_work) +  count($inquires) + count($news) }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        {{-- Orders --}}
                        @if(Auth::user()->can('orders.show') || Auth::user()->type == 'user')
                            <div class="pt-2" data-simplebar  style="max-height: 230px;">
                                <h5 class="heading ml-4">الطلبات (<span class="order_count">{{ $orders->count() }}</span>)</h5>
                                <div class="simplebar-content orders">
                                    @foreach ($orders as $order)
                                        <a href="{{ route('orders.show', $order) }}" class="text-reset notification-item">
                                            <div class="media">
                                                <div class="avatar-xs mr-3">
                                                    <span class="avatar-title border-success rounded-circle">
                                                        <i class="mdi mdi-cart-outline"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">الشركة : {{ $order->customer->name }}</h6>
                                                    <h6 class="mt-0 mb-1">أسم المركب : {{ $order->name }}</h6>
                                                    <h6 class="mt-0 mb-1">القسم الرئيسى : {{ $order->category->name }}</h6>
                                                    @if($order->sub_category)
                                                        <h6 class="mt-0 mb-1">القسم الفرعى : {{ $order->sub_category->name }}</h6>
                                                    @endif
                                                    <h6 class="mt-0 mb-1">الحالة : <span class="badge badge-success p-1">{{ $order->status->name }}</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {{-- Orders Under Work --}}
                        @if(Auth::user()->can('orders_under_work.show') || Auth::user()->type == 'user')
                            <div class="pt-2" data-simplebar style="max-height: 230px;">
                                <h5 class="heading ml-4">رسائل الطلبات (<span class="orders_under_work_count">{{ $orders_under_work->count() }}</span>)</h5>
                                <div class="simplebar-content orders_under_work">
                                    @foreach ($orders_under_work as $order_under_work)
                                        <a href="{{ route('orders_under_work.show', $order_under_work) }}" class="text-reset notification-item">
                                            <div class="media">
                                                <div class="avatar-xs mr-3">
                                                    <span class="avatar-title border-secondary rounded-circle ">
                                                        <i class="mdi mdi-wechat"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">الشركة : {{ $order_under_work->customer->name }}</h6>
                                                    <h6 class="mt-0 mb-1">أسم المركب : {{ $order_under_work->name }}</h6>
                                                    <h6 class="mt-0 mb-1">القسم الرئيسى : {{ $order_under_work->category->name }}</h6>
                                                    @if($order_under_work->sub_category)
                                                        <h6 class="mt-0 mb-1">القسم الفرعى : {{ $order_under_work->sub_category->name }}</h6>
                                                    @endif
                                                    <h6 class="mt-0 mb-1">الحالة : <span class="badge badge-secondary p-1">{{ $order_under_work->status->name }}</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {{-- News --}}
                        @if(Auth::user()->can('news.show') || Auth::user()->type == 'user')
                            <div class="pt-2" data-simplebar style="max-height: 230px;">
                                <h5 class="heading ml-4">الأخبار (<span class="news_count">{{ $news->count() }}</span>)</h5>
                                <div class="simplebar-content news">
                                    @foreach ($news as $new)
                                        <a href="{{ route('news.show', $new) }}" class="text-reset notification-item">
                                            <div class="media">
                                                <div class="avatar-xs mr-3">
                                                    <span class="avatar-title border-info rounded-circle ">
                                                        <i class="mdi mdi-newspaper"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">أسم الخبر : {{ $new->name }}</h6>
                                                    <div class="text-muted">
                                                        <p style="word-break: break-word" class="mb-1">تفاصيل الخبر : {{ $new->details }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {{-- Inquires --}}
                        @if(Auth::user()->can('inquires.show') || Auth::user()->type == 'user')
                            <div class="pt-2" data-simplebar style="max-height: 230px;">
                                <h5 class="heading ml-4">الأستفسارات (<span class="inquires_count">{{ $inquires->count() }}</span>)</h5>
                                <div class="simplebar-content inquires">
                                    @foreach ($inquires as $inquire)
                                        <a href="{{ route('inquires.show', $inquire) }}" class="text-reset notification-item">
                                            <div class="media">
                                                <div class="avatar-xs mr-3">
                                                    <span class="avatar-title border-primary rounded-circle ">
                                                        <i class="mdi mdi-chat"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">الشركة : {{ $inquire->customer->name }}</h6>
                                                    <h6 class="mt-0 mb-1">الأستفسار : {{ $inquire->details }}</h6>
                                                    <h6 class="mt-0 mb-1">القسم الرئيسى : {{ $inquire->category->name }}</h6>
                                                    @if($inquire->sub_category)
                                                        <h6 class="mt-0 mb-1">القسم الفرعى : {{ $inquire->sub_category->name }}</h6>
                                                    @endif
                                                    <h6 class="mt-0 mb-1">الحالة : <span class="badge badge-primary p-1">{{ $inquire->status->name }}</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            {{-- End Notification --}}


            @if(Auth::user()->type == 'user')
                @php
                    $balance = App\Models\CustomerBalance::where('user_id', Auth::id())->first();
                @endphp
                <div class="dropdown">
                    <button type="button" class=" header-item  waves-effect">
                        <span>الرصيد الحالى :</span>
                        <div class="badge badge-primary">
                            @if($balance)
                                {{ $balance->balance }}
                            @else
                            0
                            @endif
                        </div>
                    </button>
                </div>
            @endif
            {{-- Profile --}}
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::check())
                        @if (Auth::user()->avatar)
                            <img class="rounded-circle header-profile-user" src="{{ asset(Auth::user()->avatar) }}">
                        @else
                            <img class="rounded-circle header-profile-user" src="{{ asset('images/avatar.jpg') }}">
                        @endif
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('users.profile',  Auth::user()) }}"><i
                            class="mdi mdi-account-circle font-size-17 text-muted align-middle mr-1"></i>الملف الشخصى</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-power font-size-17 text-muted align-middle mr-1 text-danger"></i>
                            تسجيل الخروج
                        </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-spin mdi-settings"></i>
                </button>
            </div>

        </div>
    </div>
</header>
