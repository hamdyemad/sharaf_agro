@extends('frontend.layout')

@section('content')
    <div class="payment">
        <div class="container">
            @include('frontend.partials.order_tracker', ['cartTrack' => 'active','revieveTrack' => 'active','payTrack' => 'active','doneTrack' => ''])
            <div class="card">
                <div class="card-header">
                    أختيار عملية الدفع
                </div>
                <div class="card-body">
                    <ul class="payments row justify-content-center">
                        <li class="col-6 col-md-3 @if(old('payment_method') == 'cod') active @endif" data-value="cod">
                            <img src="{{ asset('/images/payments/cash_on_delivery.png') }}" alt="">
                        </li>
                        <li class="col-6 col-md-3 @if(old('payment_method') == 'paypal') active @endif" data-value="paypal">
                            <img src="{{ asset('/images/payments/paypal.png') }}" alt="">
                        </li>
                        <li class="col-6 col-md-3 @if(old('payment_method') == 'stripe') active @endif" data-value="stripe">
                            <img src="{{ asset('/images/payments/stripe.png') }}" alt="">
                        </li>
                        <li class="col-6 col-md-3 @if(old('payment_method') == 'paymob') active @endif" data-value="paymob">
                            <img src="{{ asset('/images/payments/paymob.png') }}" alt="">
                        </li>
                        <li class="col-6 col-md-3 @if(old('payment_method') == 'fawry') active @endif" data-value="fawry">
                            <img src="{{ asset('/images/payments/fawry.png') }}" alt="">
                        </li>
                    </ul>
                    @error('payment_method')
                        <div class="text-danger text-center">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    تفاصيل الطلب
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="cart_summary">
                                @if(Session::has('carts') && count(Session::get('carts')) > 0)
                                    <div class="carts">
                                        <div class="carts-info">
                                            @foreach (Session::get('carts') as $index => $cart)
                                                @php
                                                    $product = \App\Models\Product::find($cart['product_id']);
                                                @endphp
                                                @if($product)
                                                    <div class="cart-{{ $index }}">
                                                        <div>
                                                            <div class="first d-flex align-items-center">
                                                                @if($product->photos)
                                                                    <img class="rounded" src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                                                @else
                                                                    <img class="rounded" src="{{ asset('/images/product_avatar.png') }}" alt="">
                                                                @endif
                                                                <h5 class="ml-1">
                                                                    {{ $product->name }}
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
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <ul class="last_price_ul">
                                            <li class="d-flex align-items-center justify-content-between">
                                                <span>السعر النهائى</span>
                                                <span class="total_prices">{{  price(array_reduce(array_map(function($obj) {
                                                    return $obj['total_price'];
                                                }, Session::get('carts')), function($acc, $curr) {return $acc + $curr;})) }}</span>
                                            </li>
                                            @if(request()->session()->get('order_type') == 'online')
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>الشحن</span>
                                                    <span class="shipping"></span>
                                                </li>
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>السعر النهائى بالشحن</span>
                                                    <span class="total_prices_with_shipping"></span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @else
                                    <div class="alert alert-info m-0 p-1">لا يوجد شئ فى السلة</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <form action="{{ route('frontend.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" value="">
                                <input type="hidden" name="type" value="{{ request()->session()->get('order_type') }}">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="country">البلد</label>
                                            <select class="form-control select2 select_country" name="country_id">
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="country">المدينة</label>
                                            <select class="form-control select_city select2" name="city_id"></select>
                                            @error('city_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="customer_address">عنوان العميل</label>
                                            <input type="text" class="form-control" name="customer_address" value="{{ old('customer_address') }}">
                                            @error('customer_address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="customer_name">أسم العميل</label>
                                            <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}">
                                            @error('customer_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="customer_phone">رقم العميل</label>
                                            <input type="number" class="form-control" name="customer_phone" value="{{ old('customer_phone') }}">
                                            @error('customer_phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">الملاحظات</label>
                                            <textarea id="textarea" class="form-control" name="notes" maxlength="225"
                                                rows="3">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <input type="submit" value="أنشاء" class="btn btn-success btn-block">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}"></script>
    <script>
    $(".payments").children().each((index, child) => {
        $(child).on('click', function() {
            $(".payments").children().each((index, child) => {
                $(child).removeClass('active');
            })
            $(this).addClass('active');
            $("input[name='payment_method']").val($(this).data('value'))
        })
    });

    $(".select_city").on('change', function() {
        let shipping = $(".select_city option:selected").data('shipping');
        $(".shipping").text(shipping)
        $(".payment .total_prices_with_shipping")
        .text(shipping + parseFloat($(".payment .total_prices").text()))
    });
    function getCitiesByCountryIdAjax(country_id) {
        $.ajax({
            'method': 'POST',
            'data': {
                '_token': token,
                country_id: country_id
            },
            'url' : `{{ route('cities.all') }}`,
            'success': function(res) {
                if(res.status) {
                    $(".select_city").select2().html('');
                    res.data.forEach((obj) => {
                        $(".select_city").append(`<option value="${obj.id}" data-shipping="${obj.price}">${obj.name}</option>`);
                    })
                    let shipping = $(".select_city option:selected").data('shipping');
                    $(".shipping").text(shipping)
                    $(".payment .total_prices_with_shipping").text(parseFloat($(".payment .total_prices").text()) + parseFloat(shipping));
                }
            },
            'erorr' : function(err) {
                console.log(err);
            }
        });
    }
    getCitiesByCountryIdAjax($(".select_country").val());
    </script>
@endsection
