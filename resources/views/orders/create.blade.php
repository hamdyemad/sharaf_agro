@extends('layouts.master')

@section('title')
انشاء طلب جديد
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الطلبات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الطلبات @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('orders.index') }} @endslot
        @slot('li3') انشاء طلب جديد @endslot
    @endcomponent
    <div class="create_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء طلب جديد
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            @if(Auth::user()->type == 'admin')
                                <div class="col-12 col-md-6 branch_col">
                                    <div class="form-group">
                                        <label for="name">فرع انشاء الطلب</label>
                                        <select class="form-control select2 branch_select" name="branch_id">
                                            @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if(old('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">نوع الطلب</label>
                                    <select class="form-control order_type select2" name="type">
                                        <option value="inhouse" @if(old('type') == 'inhouse') selected @endif>أستلام من الفرع</option>
                                        <option value="online" @if(old('type') == 'online') selected @endif>توصيل الى المنزل</option>
                                    </select>
                                </div>
                            </div>
                            @if(old('type') == 'online')
                                <div class="col-12 col-md-6 country_col">
                                    <div class="form-group">
                                        <label for="country">البلد</label>
                                        <select class="form-control select2 select_country" name="country_id">
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 address_col">
                                    <div class="form-group">
                                        <label for="customer_address">عنوان العميل</label>
                                        <input type="text" class="form-control" name="customer_address" value="{{ old('customer_address') }}">
                                        @error('customer_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">أسم العميل</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
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
                                    <label for="name">المنتجات</label>
                                    <select class="form-control select_products select2 select2-multiple"data-placeholder="أختر المنتجات" name="products_search[]" multiple>
                                        {{-- @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @if(is_array(old('products_search')) && in_array($product->id, old('products_search'))) selected @endif>{{ $product->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    @error("products_search")
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
                                <div class="responsive-table products_table"></div>
                            </div>
                            <div class="w-100 cart-of-total-container d-none">
                                <div class="cart-of-total">
                                    <h5>الملخص</h5>
                                    <div class="responsive-table">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>السعر الأجمالى</td>
                                                    <td>
                                                        <div class="total_prices"></div>
                                                    </td>
                                                </tr>
                                                <tr class="shipping_tr d-none">
                                                    <td>الشحن</td>
                                                    <td><div class="shipping">0</div></td>
                                                </tr>
                                                <tr>
                                                    <td>الخصم</td>
                                                    <td><input class="form-control total_discount" name="total_discount" type="number" placeholder="الخصم" value="{{ old('total_discount') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>السعر بعد الخصم</td>
                                                    <td>
                                                        <div class="grand_total"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="أنشاء" class="btn btn-success">
                                    <a href="{{ route('orders.index') }}" class="btn btn-info">رجوع الى الطلبات</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script>
        let address_col = `
            <div class="col-12 col-md-6 address_col">
                <div class="form-group">
                    <label for="customer_address">عنوان العميل</label>
                    <input type="text" class="form-control" name="customer_address" value="{{ old('customer_address') }}">
                    @error('customer_address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            `,
            country_col = `
            <div class="col-12 col-md-6 country_col">
                <div class="form-group">
                    <label for="country">البلد</label>
                    <select class="form-control select_country" name="country_id"></select>
                </div>
            </div>
            `,
            city_col = `
            <div class="col-12 col-md-6 city_col">
                <div class="form-group">
                    <label for="country">المدينة</label>
                    <select class="form-control select_city" name="city_id"></select>
                    @error('city_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            `;
    $(".order_type").on('change', function() {
        arrayOfValues = $(this).val();
        if (arrayOfValues.includes('online')) {
            $(this).parent().parent().after(address_col);
            $(this).parent().parent().after(country_col);
            $(".select_country").select2();
            @foreach ($countries as $country)
                $(".select_country").append(`<option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>`);
            @endforeach
            getCitiesByCountryId();
        } else {
            $('.shipping_tr').addClass('d-none');
            $(".address_col").remove();
            $(".country_col").remove();
            $(".city_col").remove();
            if($('.shipping_tr').hasClass('d-none')) {
                $(".shipping_tr .shipping").text(0);
            }
        }
        getFullPrice();
    })


    $(".branch_select").on('change', function() {
        getProductsByBranchId($(this).val());
        $(".products_table").empty();
        $(".select_products").empty();
    });
    function getProductsByBranchId(branch_id) {
        let token = $("meta[name=_token]").attr('content');
        $.ajax({
            'method': 'POST',
            'data': {
                '_token': token,
                'branch_id': branch_id
            },
            'url': "{{ route('products.all') }}",
            'success': function(res) {
                if(res.status) {
                    $(".select_products").select2().html('');
                    res.data.forEach((obj) => {
                        $(".select_products").append(`
                        <option value="${obj.id}" @if(is_array(old('products_search')) && in_array(${obj.id}, old('products_search'))) selected @endif>${obj.name}</option>
                        `);
                    })
                } else {
                    toastr.error(res.message);
                }
            },
            'erorr' : function(err) {
                console.log(err);
            }
        });
    }
    getProductsByBranchId($("[name=branch_id]").val());

    function getCitiesByCountryIdAjax(country_id) {
        let token = $("meta[name=_token]").attr('content');
        $.ajax({
            'method': 'POST',
            'data': {
                '_token': token,
                country_id: country_id
            },
            'url' : `{{ route('countries.cities.all') }}`,
            'success': function(res) {
                if(res.status) {
                    $(".select_city").select2().html('');
                    res.data.forEach((obj) => {
                        $(".select_city").append(`<option value="${obj.id}" data-shipping="${obj.price}">${obj.name}</option>`);
                    })
                    $('.shipping_tr').removeClass('d-none');
                    $(".shipping_tr .shipping").text($(".select_city option:selected").data('shipping'))
                    $(".select_city").on('change', function() {
                        $(".shipping_tr .shipping").text($(".select_city option:selected").data('shipping'))
                    })
                    getFullPrice();
                }
            },
            'erorr' : function(err) {
                console.log(err);
            }
        });
    }


    // Get Cities By Country id
    function getCitiesByCountryId() {
        let country_id = $('.select_country option:selected').val();
        if(country_id) {
            $('.select_country').parent().parent().after(city_col);
            getCitiesByCountryIdAjax(country_id);
        }
        $(".select_country").on('change', function() {
            country_id = $(this).val();
            getCitiesByCountryIdAjax(country_id);
        });
    }
    getCitiesByCountryId();

    function getTrOfProductVariantTable(product,obj) {
        let photo = '';
        if(product.photos) {
            photo = ` <img src="{{ asset('${JSON.parse(product.photos)[0]}') }}" alt="">`;
        } else {
            photo = `<img src="{{ asset('/images/product_avatar.png') }}" alt="">`;
        }
        return `<tr id="${obj.id}">
                <td>
                    <div class="d-flex align-items-center">
                        ${photo}
                        <span> ${product.name}</span>
                    </div>
                </td>
                <td>
                    ${obj.variant }
                </td>
                <td>
                    <div class="price">${obj.price_after_discount }</div>
                </td>
                <td>
                    <input class="form-control amount" name="products[${product.id}][variants][${obj.id}][amount]"  min="1"  type="number" placeholder="الكمية" value="1">
                    @error("products.*.variants.*.amount")
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>

                <td>
                    <div class="total_price">${obj.price_after_discount }</div>
                </td>
            </tr>
        `;
    }

    function getProductVariantTable(variant) {
        if(variant == 'size')  {
            return `
            <table class="table size-table">
                <thead>
                    <th>أسم المنتج</th>
                    <th>الأحجام</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>السعر الكلى</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
            </table>
            `;
        } else if(variant == 'extra') {
            return `
            <table class="table extra-table">
                <thead>
                    <th>أسم المنتج</th>
                    <th>الأضافات</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>السعر الكلى</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
            </table>
            `;
        }
    }

    function getProductVariantHeadingTr(product) {
        let photo = '';
        if(product.photos) {
            photo = ` <img src="{{ asset('${JSON.parse(product.photos)[0]}') }}" alt="">`;
        } else {
            photo = `<img src="{{ asset('/images/product_avatar.png') }}" alt="">`;
        }

        return `
            <tr class="${product.id}">
                <input type="hidden" value="products[${product.id}]">
                <td>
                    <div class="d-flex align-items-center">
                        ${photo}
                        <span>${product.name}</span>
                    </div>
                </td>
            </tr>
        `;
    }

    function getProductVariantHeadingTable() {
        return `
        <div class="table-responsive">
            <table class="table variant_table">
                <thead>
                    <th>أسم المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>السعر الكلى</th>
                    <th>الحجم</th>
                    <th>الأضافات</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        `;
    }


    if($(".select_products").val().length !== 0) {
        $('.cart-of-total-container').removeClass('d-none');
        $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse ');
        getProductsWithAjax($(".select_products").val());
    }

    function getProductsWithAjax(productsIds) {
        $.ajax({
            'method': 'GET',
            'data': {
                ids: productsIds
            },
            'url' : "{{ route('products.all_by_ids') }}",
            'success': function(products) {
                if(products.length !== 0) {
                    $(".products_table").empty();
                    products.forEach(product => {
                        if(product.variants.length !==0) {
                            if($(".products_table").find('.variant_table').length == 0) {
                                $(".products_table").append(getProductVariantHeadingTable());
                            }
                            $(".products_table .variant_table tbody").append(getProductVariantHeadingTr(product))
                            let extraTypeArray = product.variants.filter((obj) => {
                                return obj.type == 'extra';
                            });
                            let sizeTypeArray = product.variants.filter((obj) => {
                                return obj.type == 'size';
                            });
                            if(sizeTypeArray.length !==0) {
                                $(`.${product.id}`).append(`<td>لا يوجد سعر</td>`);
                                $(`.${product.id}`).append(`<td>لا يوجد كمية</td>`);
                                $(`.${product.id}`).append(`<td>لا يوجد سعر كلى</td>`);
                                $(`.${product.id}`).append(`
                                    <td><ul class="select_variant size_select"></ul></td>
                                `);
                                sizeTypeArray.forEach((size) => {
                                    $(`.${product.id} .size_select`).append(`
                                        <li class="variant" data-variant="${size.type}" data-variant_value='${JSON.stringify(size)}' data-product_value='${JSON.stringify(product)}'>
                                            ${size.variant}
                                        </li>
                                    `);
                                });
                            } else {
                                $(`.${product.id}`).append(`<td><div class="price">${product.price_after_discount}</div></td>`);
                                $(`.${product.id}`).append(`<td><input class="form-control amount" value="1" min="1" type="number" name="products[${product.id}][amount]"></td>`);
                                $(`.${product.id}`).append(`<td><div class="total_price">${product.price_after_discount}</div></td>`);
                                $(`.${product.id}`).append(`<td>لا يوجد احجام</td>`);
                            }
                            if(extraTypeArray.length !==0) {
                                $(`.${product.id}`).append(`
                                    <td><ul class="select_variant extra_select"></ul></td>
                                `);
                                extraTypeArray.forEach((extra) => {
                                    $(`.${product.id} .extra_select`).append(`
                                        <li class="variant" data-variant="${extra.type}" data-variant_value='${JSON.stringify(extra)}' data-product_value='${JSON.stringify(product)}'>
                                            ${extra.variant}
                                        </li>
                                    `);
                                });
                            } else {
                                $(`.${product.id}`).append(`<td>لا يوجد اضافات</td>`);
                            }

                        } else {
                            if($(".products_table").find('.variant_table').length == 0) {
                                $(".products_table").append(getProductVariantHeadingTable());
                            }
                            $(".products_table .variant_table tbody").append(getProductVariantHeadingTr(product))
                            $(`.${product.id}`).append(`<td><div class="price">${product.price_after_discount}</div></td>`);
                            $(`.${product.id}`).append(`<td><input class="form-control amount" value="1" min="1" type="number" name="products[${product.id}][amount]"></td>`);
                            $(`.${product.id}`).append(`<td><div class="total_price">${product.price_after_discount}</div></td>`);
                            $(`.${product.id}`).append(`<td>لا يوجد احجام</td>`);
                            $(`.${product.id}`).append(`<td>لا يوجد اضافات</td>`);
                            getFullPrice();
                        }
                    });
                    $(".variant").click('click', function() {
                        let product = $(this).data('product_value');
                        $(this).toggleClass("active");
                        let variant = $(this).data('variant');
                        if($(".products_table").find(`.${variant}-table`).length == 0) {
                            $(".products_table").append(getProductVariantTable(variant))
                        }
                        if($(this).hasClass("active")) {
                            $(`.products_table .${variant}-table tbody`).append(getTrOfProductVariantTable(product,$(this).data('variant_value')));
                        } else {
                            $(`.products_table .${variant}-table tbody #${$(this).data('variant_value').id}`).remove();
                        }
                        if($(".products_table").find(`.${variant}-table tbody`).children().length == 0) {
                            $(`.products_table .${variant}-table`).remove();
                        }
                        amountChange();
                        getFullPrice();
                    })
                    getFullPrice();
                    amountChange();
                }
            },
            'error': function(error) {
                console.log(error)
            }
        });

    }

    $(".select_products").on('change', function() {
        arrayOfValues = $(this).val();
        if(arrayOfValues.length !== 0) {
            $('.cart-of-total-container').removeClass('d-none');
            $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse ');
            getProductsWithAjax(arrayOfValues);
        } else {
            $(".products_table").empty();
            $('.cart-of-total-container').removeClass('d-block d-md-flex flex-row-reverse ');
            $('.cart-of-total-container').addClass('d-none');
        }
    });
    function getFullPrice() {
        let prices = [],
            total_prices = $(".total_prices"),
            grandTotal = $(".grand_total"),
            shippping = parseFloat($(".shipping").text()),
            total_discount = $('.total_discount');
        if(isNaN(shippping)) {
            shippping = 0;
        }
        if($(".variant_table tbody").children().length !== 0) {
            $(".variant_table tbody").children().each((index, tr) => {
                if(!isNaN(parseFloat($(tr).find('.total_price').text()))) {
                    prices.push(parseFloat($(tr).find('.total_price').text()));
                }
            });
        }

        if($(".variant_table .select_variant").children().length !== 0) {
            $(".variant_table .select_variant").each((index, variant_ul) => {
                $(variant_ul).children().each((index, selected) => {
                    if($(selected).hasClass('active')) {
                        prices.push(parseFloat($(`#${$(selected).data('variant_value').id}`).find('.total_price').text()))
                    }
                });
            });
        }
        if(prices.length !== 0) {
            prices = prices.reduce((acc, current) => acc + current);
        }
        total_prices.text(prices);
        grandTotal.text(prices + shippping);
        total_discount.on('keyup', function() {
            let full_price = (prices +  shippping);
            full_price = full_price - $(this).val();
            grandTotal.text(full_price);
        });
    }
    getFullPrice();
    function amountChange() {
        $(".amount").on('keyup', function() {
            let priceVal = parseFloat($(this).parent().parent().find('.price').text()),
            amountVal = parseFloat($(this).val());
            $(this).parent().parent().find('.total_price').text(priceVal * amountVal);
            getFullPrice();
        });
    }

    </script>
@endsection
