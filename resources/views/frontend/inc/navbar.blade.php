<nav class="navbar navbar-expand-lg p-0">
    <div class="container">
        <a class="navbar-brand" href="{{ route('frontend.home') }}">
            @if (get_setting('logo'))
                <img src="{{ asset(get_setting('logo')) }}">
            @else
                <img src="{{ URL::asset('/images/default.jpg') }}">
            @endif
        </a>
        <div class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item @if(activeRoute('frontend.home')) active_link @endif">
                <a class="nav-link" href="{{ route('frontend.home') }}">الرئيسية</a>
            </li>
            @auth
                <li class="nav-item @if(activeRoute('frontend.profile')) active_link @endif">
                    <a class="nav-link" href="{{ route('frontend.profile', Auth::id()) }}">
                        <span>حسابى</span>
                        <span class="mdi mdi-account-outline"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#search_modal">
                        <span>البحث</span>
                        <span class="mdi mdi-file-document-box-search-outline"></span>
                    </a>
                </li>
                @php
                    $orders = App\Models\Order::where('client_viewed', 0)
                    ->where('user_id', Auth::id())
                    ->orWhere('client_status_viewed', 0)
                    ->where('user_id', Auth::id())->latest()->get();
                @endphp
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link bell" href="#" data-toggle="modal" data-target="#notify_modal">
                        <span class="mdi mdi-bell-outline">
                            <span class="badge badge-danger badge-pill notify">{{ count($orders) }}</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.logout') }}">
                        <span>تسجيل الخروج</span>
                        <span class="mdi mdi-account-arrow-left-outline"></span>
                    </a>
                </li>
            @else
                <li class="nav-item @if(activeRoute('frontend.login')) active_link @endif">
                    <a class="nav-link" href="{{ route('frontend.login') }}">
                        <span>تسجيل الدخول</span>
                        <span class="mdi mdi-account-outline"></span>
                    </a>
                </li>
                <li class="nav-item @if(activeRoute('frontend.register')) active_link @endif">
                    <a class="nav-link" href="{{ route('frontend.register') }}">
                        <span>تسجيل حساب</span>
                        <span class="mdi mdi-account-plus-outline"></span>
                    </a>
                </li>
            @endauth

            <li class="nav-item dropdown cart">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    <span>السلة</span>
                    @if(Session::has('carts'))
                    <span class="cart_count">{{ count(Session::get('carts')) }}</span>
                    @endif
                    <span class="mdi mdi-cart-outline"></span>
                </a>
            <div class="dropdown-menu cart_items" aria-labelledby="navbarDropdown">
                {{-- {{ Session::forget('carts') }} --}}
                @if(Session::has('carts') && count(Session::get('carts')) > 0)
                    <div class="carts">
                        <div class="carts-info">
                            @foreach (Session::get('carts') as $index => $cart)
                                @php
                                    $product = \App\Models\Product::find($cart['product_id']);
                                @endphp
                                @if($product)
                                    <a class="dropdown-item cart-{{ $index }}">
                                        <div>
                                            <div class="first d-flex align-items-center">
                                                @if($product->photos)
                                                    <img class="rounded" src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                                @else
                                                    <img class="rounded" src="{{ asset('/images/product_avatar.png') }}" alt="">
                                                @endif
                                                <h5 class="ml-1">
                                                    @if(strlen($product->name) > 13)
                                                    {{ mb_substr($product->name, 0, 13) . '...' }}
                                                    @else
                                                    {{ $product->name }}
                                                    @endif
                                                </h5>
                                            </div>
                                            <div class="about">
                                                @if(isset($cart['amount']))
                                                    <div class="d-flex align-items-center  mt-2">
                                                        <span class="h4">السعر : </span>
                                                        <span class="badge badge-primary d-block ml-1">{{ price($product->price_after_discount) }}</span>
                                                    </div>
                                                    <div class="amount d-flex align-items-center  mt-2">
                                                        <span class="h4">الكمية : </span>
                                                        <span class="badge badge-primary d-block ml-1">{{ $cart['amount'] }}</span>
                                                    </div>
                                                @endif
                                                @if(isset($cart['sizes']))
                                                    <div class="sizes mt-2">
                                                        <span class="h4">الأحجام</span>
                                                        <table class="table mt-2">
                                                            <thead>
                                                                <th>الحجم</th>
                                                                <th>الكمية</th>
                                                                <th>السعر</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($cart['sizes'] as $size)
                                                                    <tr>
                                                                        <td>{{ $size['size_name'] }}</td>
                                                                        <td>{{$size['size_amount'] }}</td>
                                                                        <td class="total_size">{{ price($product->variants->find($size['size_id'])->price_after_discount * $size['size_amount']) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                                @if(isset($cart['extras']))
                                                    <div class="extras mt-2">
                                                        <span class="h4">الأضافات</span>
                                                        <table class="table mt-2">
                                                            <thead>
                                                                <th>الأضافة</th>
                                                                <th>الكمية</th>
                                                                <th>السعر</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($cart['extras'] as $extra)
                                                                    <tr>
                                                                        <td>{{ $extra['extra_name'] }}</td>
                                                                        <td>{{$extra['extra_amount'] }}</td>
                                                                        <td class="total_extra">{{ price($product->variants->find($extra['extra_id'])->price_after_discount * $extra['extra_amount']) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <ul>
                                                <li class=" d-flex align-items-center justify-content-between">
                                                    <span>السعر الكلى</span>
                                                    <span class="total_price">{{ price($cart['total_price']) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <button class="trash" onclick="removeCartNav({{ $index }})">
                                            <span class="mdi mdi-alpha-x-circle-outline"></span>
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        <div class="dropdown-divider"></div>
                        <ul class="last_price_ul">
                            <li class="d-flex align-items-center justify-content-between">
                                <span>السعر النهائى</span>
                                <span class="total_prices">{{ price(array_reduce(array_map(function($obj) {
                                    return $obj['total_price'];
                                }, Session::get('carts')), function($acc, $curr) {return $acc + $curr;})) }}</span>
                            </li>
                        </ul>
                        <div class="buttons mt-2 justify-content-center d-flex align-items-center">
                            <a class="btn btn-primary" href="{{ route('frontend.cart') }}">أكمل عملية الشراء</a>
                        </div>
                    </div>
                @else
                <div class="alert alert-info m-0 p-1">لا يوجد شئ فى السلة</div>
                @endif
            </div>
            </li>
        </ul>
        </div>
    </div>
  </nav>

