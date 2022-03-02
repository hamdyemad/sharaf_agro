@extends('frontend.layout')

@section('content')
    <section class="cart">
        <div class="container">
            @include('frontend.partials.order_tracker', ['cartTrack' => 'active','revieveTrack' => '','payTrack' => '','doneTrack' => ''])
            <div class="cart_details">
                <div class="card">
                    <div class="card-header">
                        <h1>تفاصيل الطلب</h1>
                    </div>
                    <div class="card-body">
                        @if(Session::has('carts') && count(Session::get('carts')) > 0)
                            <table class="table  carts">
                                <thead>
                                    <th>الأكلة</th>
                                    <th>الأحجام والأضافات</th>
                                    <th>ازالة</th>
                                </thead>
                                <tbody>
                                    @foreach (Session::get('carts') as $index => $cart)
                                        @php
                                            $product = \App\Models\Product::find($cart['product_id']);
                                        @endphp
                                        @if($product)
                                            <tr class="cart-{{ $index }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($product->photos)
                                                            <img class="rounded" src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                                        @else
                                                            <img class="rounded" src="{{ asset('/images/product_avatar.png') }}" alt="">
                                                        @endif
                                                        <h5 class="ml-2">
                                                            {{ $product->name }}
                                                        </h5>
                                                    </div>
                                                    @if(isset($cart['amount']))
                                                        <div class="variant">
                                                            <div class="d-flex align-items-center mt-2">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="h4">الكمية : </span>
                                                                    <input type="number" min="1" class="form-control ml-1 amount" data-index="{{ $index }}" name="amount" value="{{ $cart['amount'] }}">
                                                                    <span class="d-none current_price">{{ $product->price_after_discount }}</span>
                                                                </div>
                                                                <div class="d-flex align-items-center ml-2">
                                                                    <span class="h4">السعر : </span>
                                                                    <span class="badge badge-primary d-block ml-1 price">{{ $product->price_after_discount * $cart['amount']  }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($cart['sizes']))
                                                        <div class="variant">
                                                            @foreach ($cart['sizes'] as $sizeIndex => $size)
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="h4">الحجم : </span>
                                                                        <span class="badge badge-primary d-block ml-1">{{ $size['size_name'] }}</span>
                                                                    </div>
                                                                    <div class="d-flex align-items-center ml-1">
                                                                        <span class="h4">الكمية : </span>
                                                                        <input type="number" min="1" class="form-control ml-1 amount" data-index="{{ $index }}" name="size-{{ $sizeIndex }}" value="{{ $size['size_amount']}}">
                                                                        <span class="d-none current_price">{{ $product->variants->find($size['size_id'])->price_after_discount }}</span>
                                                                    </div>
                                                                    <div class="d-flex align-items-center ml-1">
                                                                        <span class="h4">السعر : </span>
                                                                        <span class="badge badge-primary d-block ml-1 price">{{ $product->variants->find($size['size_id'])->price_after_discount * $size['size_amount'] }}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @if(isset($cart['sizes']) && isset($cart['extras']))
                                                        <hr>
                                                    @endif
                                                    @if(isset($cart['extras']))
                                                        <div class="variant">
                                                            @foreach ($cart['extras'] as $extraIndex => $extra)
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="h4">الأضافة : </span>
                                                                        <span class="badge badge-primary d-block ml-1">{{ $extra['extra_name'] }}</span>
                                                                    </div>
                                                                    <div class="d-flex align-items-center ml-1">
                                                                        <span class="h4">الكمية : </span>
                                                                        <input type="number" min="1" class="form-control ml-1 amount"  data-index="{{ $index }}" name="extra-{{ $extraIndex }}" value="{{ $extra['extra_amount']}}">
                                                                        <span class="d-none current_price">{{ $product->variants->find($extra['extra_id'])->price_after_discount }}</span>
                                                                    </div>
                                                                    <div class="d-flex align-items-center ml-1">
                                                                        <span class="h4">السعر : </span>
                                                                        <span class="badge badge-primary d-block ml-1 price">{{ $product->variants->find($extra['extra_id'])->price_after_discount * $extra['extra_amount'] }}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="trash" onclick="removeFromCart({{ $index }})">
                                                        <span class="mdi mdi-alpha-x-circle-outline"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="mr-1">السعر النهائى : </span>
                                                <span class="badge badge-primary d-block total_price">{{  array_reduce(array_map(function($obj) {
                                                    return $obj['total_price'];
                                                }, Session::get('carts')), function($acc, $curr) {return $acc + $curr;}) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                @if(Auth::check())
                                <a href="{{ route('frontend.receive') }}" class="btn btn-primary">
                                    أكمل عملية الشراء
                                </a>
                                @else
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        أكمل عملية الشراء
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">تسجيل الدخول</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card overflow-hidden">
                                                        <div class="card-body pt-0">
                                                            <form method="POST" class="form-horizontal mt-4" action="{{ route('login') }}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="username">البريد الألكترونى</label>
                                                                    <input id="email" type="text"
                                                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                                                        value="{{ old('email') }}" autocomplete="email" autofocus
                                                                        placeholder="البريد الألكترونى">
                                                                    @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userpassword">الرقم السرى</label>
                                                                    <input id="password" type="password"
                                                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                                                        autocomplete="current-password" placeholder="الرقم السرى">
                                                                    @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group row mt-4">
                                                                    <div class="col-6">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" name="remember"
                                                                                id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                                                                            <label class="custom-control-label" for="customControlInline">تذكرنى</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 text-right">
                                                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                                                            type="submit">تسجيل الدخول</button>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-0 row text-center">
                                                                    <div class="col">
                                                                        <a href="{{ route('frontend.register') }}">تسجيل حساب جديد</a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                        <div class="alert alert-info">لا يوجد أكلات مضافة حاليا</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footerScript')
    <script>

        if("{{ Session::has('errors') }}") {
            $(".modal").modal()
        }
        function removeFromCart(index) {
            $.ajax({
                method: "POST",
                url: "{{ route('frontend.removeCart') }}",
                data: {
                    _token: token,
                    index: index
                },
                success: function(res) {
                    console.log(res);
                    if(res.status) {
                        updateNav(index, true);
                        $(`.cart_details .cart-${index}`).remove();
                        getFullPrice();
                        if($(".cart_details .carts tbody").children().length == 1) {
                            $(".cart_details .card-body table").addClass('d-none');
                            $(".cart_details .card-body").append(`<div class="alert alert-info">السلة فارغة حاليا</div>`);
                            toastr.info(res.message);
                        } else {
                            $(".cart_details .card-body table").removeClass('d-none');
                            $(".cart_details .card-body .alert").remove();
                        }
                    }
                },
                error: function(err) {

                }
            })
        }

        function getFullPrice() {
            prices = [];
            $(".variant").children().each((index, child) => {
                prices.push(parseFloat($(child).find('.price').text()));
            });
            if(prices.length !== 0) {
                prices = prices.reduce((acc, curr) => acc + curr);
            }
            $(".total_price").text(prices);
        }
        function amountChange() {
            $(".amount").on('change', function() {
                let amount = parseFloat($(this).val());
                if(!isNaN(amount)) {
                    let current_price = parseFloat($(this).parent().find('.current_price').text())
                    $(this).parent().next().find('.price').text(current_price * amount);
                }
                getFullPrice();
                $.ajax({
                    method: "POST",
                    url: "{{ route('frontend.updateCart') }}",
                    data: {
                        _token: token,
                        data: {
                            index: $(this).data('index'),
                            name: $(this).attr('name'),
                            amount: amount
                        }
                    },
                    success: function(res) {
                        console.log(res);
                        if(res.status) {
                            updateNav($(this).data('index'));
                            toastr.info(res.message);
                        }
                    },
                    error: function(err) {

                    }
                })
            });
        }
        amountChange();
    </script>
@endsection
