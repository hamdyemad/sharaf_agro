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
            @php
            $languages = App\Models\Language::all();
            @endphp
            <div class="dropdown d-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="mdi mdi-google-translate"></span>
                    <span>{{ app()->getLocale() }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                    <div data-simplebar style="max-height: 230px;">
                        @foreach($languages as $language)
                            <a href="{{ LaravelLocalization::getLocalizedURL($language->code, null, [], true) }}" class="text-reset notification-item">
                                <div class="media align-items-center">
                                    <div class="avatar-xs mr-3">
                                        <span class="avatar-title @if(app()->getLocale() == $language->code) border-success @else border-info @endif rounded-circle">
                                            <span class="mdi mdi-google-translate"></span>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        {{ $language->name }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Start Noteifications --}}
            @php
                $status = App\Models\Status::where('default_val', 1)->first();
                if(Auth::user()->type == 'admin') {
                    $orders = App\Models\Order::where('viewed', 0)->latest()->get();
                } else {
                    $orders = App\Models\Order::where('viewed', 0)->where('branch_id', Auth::user()->branch_id)->latest()->get();
                }
            @endphp
            <div class="dropdown d-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ti-bell"></i>
                    <span class="badge badge-danger badge-pill">{{ count($orders) }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0"> {{ translate('orders') }} ({{ count($orders) }}) </h5>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        {{-- <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title border-success rounded-circle ">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">Your order is placed</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title border-warning rounded-circle ">
                                        <i class="mdi mdi-message"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">New Message received</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">You have 87 unread messages</p>
                                    </div>
                                </div>
                            </div>
                        </a> --}}

                        {{-- <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title border-info rounded-circle ">
                                        <i class="mdi mdi-glass-cocktail"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">It is a long established fact that a reader will</p>
                                    </div>
                                </div>
                            </div>
                        </a> --}}
                        @foreach ($orders as $order)
                            <a href="{{ route('orders.show', $order) }}" class="text-reset notification-item">
                                <div class="media">
                                    <div class="avatar-xs mr-3">
                                        <span class="avatar-title border-primary rounded-circle ">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">{{ translate('order number') }} : ({{ $order->id }})</h6>
                                        <h6 class="mt-0 mb-1">{{ translate('new order') }}</h6>
                                        <h6 class="mt-0 mb-1">{{ translate('status') }} : ({{ $order->status->name }})</h6>
                                        <div class="text-muted">
                                            <p class="mb-1">{{ translate('foods count') }} : ({{ $order->order_details->groupBy('product_id')->count() }})</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        {{-- <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title border-warning rounded-circle ">
                                        <i class="mdi mdi-message"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">New Message received</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">You have 87 unread messages</p>
                                    </div>
                                </div>
                            </div>
                        </a> --}}
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ route('orders.index') . '?status_id='. $status->id }}">
                            {{ translate('show orders') }}
                        </a>
                    </div>
                </div>
            </div>
            {{-- End Noteifications --}}



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
                            class="mdi mdi-account-circle font-size-17 text-muted align-middle mr-1"></i>{{ translate('profile') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-power font-size-17 text-muted align-middle mr-1 text-danger"></i>
                            {{ translate('logout') }}</a>
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
