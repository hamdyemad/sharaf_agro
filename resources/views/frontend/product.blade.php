@extends('frontend.layout')

@section('content')
    <div class="product">
        <div class="container">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="images">
                                @if($product->photos)
                                    <div class="selected">
                                        <img class="rounded" src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                    </div>
                                    <div class="owl-carousel product-carousel owl-theme mt-2">
                                        @foreach (json_decode($product->photos) as $photo)
                                            <div class="item">
                                                <img class="rounded" src="{{ asset($photo) }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="selected">
                                        <img class="rounded" src="{{ asset('/images/product_avatar.png') }}" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="product_info">
                                <h1>{{ $product->name }}</h1>
                                <h2>الصنف :  <span>{{ $product->category->name }}</span></h2>
                                <p>{{ $product->description }}</p>
                                <form id="cart" method="POST" action="{{ route('frontend.addToCart') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="info">
                                        @if(isset($product->variants->groupBy('type')['size']))
                                            <input type="hidden" name="size_id" value="">
                                            <input type="hidden" name="size_name" value="">
                                            <input type="hidden" name="size_amount" value="">
                                            <div class="card">
                                                <div class="card-header">
                                                    الأحجام
                                                </div>
                                                <div class="card-body">
                                                    <ul class="select_variant size_select">
                                                        @foreach ($product->variants->groupBy('type')['size'] as $size)
                                                            <li class="variant" data-id="{{ $size->id }}" data-value="{{ $size }}">
                                                                {{ $size->variant . ' ( ' . price($size->price_after_discount) . ' ) ' }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <h4 class="prices mt-2 mb-3">
                                                <del class="d-block mb-2"><span>السعر قبل الخصم : </span> <span>{{ price($product->price) }}</span></del>
                                                <div><span>السعر بعد الخصم : </span> <span class="price_after_discount"> {{ price($product->price_after_discount) }}</span></div>
                                            </h4>
                                            <div class="not_variant">
                                                <input class="form-control amount" type="number" name="amount" min="0" value="1">
                                            </div>
                                        @endif
                                        @if(isset($product->variants->groupBy('type')['extra']))
                                            <input type="hidden" name="extra_id" value="">
                                            <input type="hidden" name="extra_name" value="">
                                            <input type="hidden" name="extra_amount" value="">
                                            <div class="card mt-2">
                                                <div class="card-header">
                                                    الأضافات
                                                </div>
                                                <div class="card-body">
                                                    <ul class="select_variant extra_select">
                                                        @foreach ($product->variants->groupBy('type')['extra'] as $extra)
                                                            <li class="variant" data-id="{{ $extra->id }}" data-value="{{ $extra }}">
                                                                {{ $extra->variant . ' ( ' . price($extra->price_after_discount) . ' ) ' }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="h4">
                                            <span>السعر الكلى : </span>
                                            <span class="grand_total">
                                                @if($product->price_after_discount)
                                                    {{ price($product->price_after_discount) }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary add_to_cart">
                                                <span>أضف الى عربة التسوق</span>
                                                <span class="mdi mdi-cart-outline"></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
    <script>
        $('.product-carousel').owlCarousel({
            loop: true,
            margin:10,
            rtl: true,
            responsive:{
                0:{
                    items:3
                },
                600:{
                    items:4
                },
                1000:{
                    items:4
                }
            }
        })


        $(".variant").click('click', function() {
            let variantObj = $(this).data('value'),
                variantId = $(this).data('id');
            if($(this).hasClass('active')) {
                if(variantObj.type == 'extra') {
                    $(`input[name=extra_id]`).val('');
                    $(`input[name=extra_name]`).val('');
                    $(`input[name=extra_amount]`).val('');
                }
                if(variantObj.type == 'size') {
                    $(`input[name=size_id]`).val('');
                    $(`input[name=size_name]`).val('');
                    $(`input[name=size_amount]`).val('');
                }

                $(this).removeClass('active');
            } else {
                $(this).parent().children().each((index, child) => {
                    $(child).removeClass('active');
                });
                $(this).toggleClass("active");
                if(variantObj.type == 'extra') {
                    $(`input[name=extra_id]`).val(variantId);
                    $(`input[name=extra_name]`).val(variantObj.variant);
                    $(`input[name=extra_amount]`).val(1);
                }
                if(variantObj.type == 'size') {
                    $(`input[name=size_id]`).val(variantId);
                    $(`input[name=size_name]`).val(variantObj.variant);
                    $(`input[name=size_amount]`).val(1);
                }

            }
            getFullPrice();
        })
        function getFullPrice() {
            let prices = [],
                grandTotal = $(".grand_total"),
                not_variant_amount = $(".not_variant .amount").val(),
                price_after_discount = parseFloat($(".price_after_discount").text());

            $(".select_variant").children().each((index, child) => {
                if($(child).hasClass('active')) {
                    prices.push($(child).data('value').price_after_discount);
                }
            });
            if(!isNaN(price_after_discount)) {
                prices.push(price_after_discount * not_variant_amount);
            }
            if(prices.length !== 0) {
                prices = prices.reduce((acc, current) => acc + current);
            }
            grandTotal.text(prices);
        }

        function amountChange() {
            $(".not_variant .amount").on('keyup', function() {
                let price = parseFloat($(".price_after_discount").text()),
                    grand_total = $(".grand_total"),
                    amount = parseFloat($(this).val());
                    if(!isNaN(amount)) {
                        grand_total.text(amount * price);
                    }
                getFullPrice();
            });
        }
        amountChange();


        // $(".add_to_cart").on('click', function() {
        //     let token = $("meta[name=_token]").attr('content');
        //     $.ajax({
        //         method: "POST",
        //         url: "{{ route('frontend.addToCart') }}",
        //         data: {
        //             _token: token,
        //             carts: $('#cart').serializeArray()
        //         },
        //         success: function(res) {
        //             console.log(res)
        //             if(res.status) {
        //                 toastr.success(res.message);
        //             } else {
        //                 toastr.error(res.message);
        //             }
        //         },
        //         error: function(err) {
        //             console.log(err)
        //         }
        //     })
        // });

    </script>
@endsection
