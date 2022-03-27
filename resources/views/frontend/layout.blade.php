<!DOCTYPE html>
<html lang="ar">
    <head>

        <meta charset="utf-8" />
        <title> @yield('title', get_setting('project_name'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="_token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ get_setting('description') }}"/>
        <meta name="author" content="Hamdy Emad"/>
        <meta name="robots" content="index, follow">
        <meta name="keywords" content="{{ get_setting('keywords') }}">
        <!-- Schema.org markup for google -->
        <meta itemprop="name" content="{{ get_setting('project_name') }}">
        <meta itemprop="description" content="{{ get_setting('description') }}">
        <meta itemprop="image" content="{{ asset(get_setting('logo')) }}">
        <!-- twitter card data -->
        <meta name="twitter:card" content="product">
        <meta name="twitter:size" content="@publisher_handle">
        <meta name="twitter:title" content="{{ get_setting('project_name') }}">
        <meta name="twitter:description" content="description">
        <meta name="twitter:creator" content="@author_handle">
        <meta name="twitter:image" content="{{ asset(get_setting('logo')) }}">
        <!-- open graph data -->
        <meta property="og:title" content="{{ get_setting('project_name') }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ asset('/') }}">
        <meta property="og:image" content="{{ asset(get_setting('logo')) }}">
        <meta property="og:description" content="{{ get_setting('description') }}">
        <meta property="og:site_name" content="{{ get_setting('project_name') }}">
        <meta property="fb:app_id" content="">
        <!-- App favicon -->
        @if (get_setting('logo'))
            <link rel="shortcut icon" href="{{ asset(get_setting('logo')) }}">
        @else
            <link rel="shortcut icon" href="{{ URL::asset('/images/default.jpg') }}">
        @endif

        <!-- headerCss -->
        @yield('headerCss')

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

        <!-- Bootstrap Css -->
        <link href="{{ URL::asset('/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('/libs/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ URL::asset('/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ URL::asset('/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        {{-- RTL Bootstrap --}}
        @php
        $language = App\Models\Language::where('code', App::getLocale())->first();
        @endphp
        @if($language)
            @if($language->rtl)
                <link href="{{ URL::asset('/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
            @endif
        @endif
        <!-- Responsive Table css -->
        <link href="{{ URL::asset('/libs/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Css -->
        <link href="{{ URL::asset('/libs/owl/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />
    </head>
<body>


    <div class="frontend">
        @include('frontend.inc.navbar')
        <div class="front-page-content">
            @yield('content')
        </div>
        @include('frontend.partials.footer_fixed')
        @include('frontend.partials.footer')
    </div>

    <!-- Start preloader_all-->
    <div class="d-none" id="preloader_all">
        <div id="loader"></div>
    </div>
    <!-- END preloader_all-->

    <!-- JAVASCRIPT -->
    <script src="{{ URL::asset('/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/libs/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/metismenu/metismenu.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/node-waves/node-waves.min.js') }}"></script>

    <script src="{{ URL::asset('/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/bootstrap-filestyle2/bootstrap-filestyle2.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/jquery-sparkline/jquery-sparkline.min.js') }}"></script>
    <!-- Responsive Table js -->
    <script src="{{ URL::asset('/libs/rwd-table/rwd-table.min.js') }}"></script>
    <script src="{{ URL::asset('/js/pages/form-advanced.init.js') }}"></script>

    <script src="{{ URL::asset('/libs/owl/owl.carousel.min.js') }}"></script>

    <script src="{{ URL::asset('/js/app.min.js') }}"></script>
    @if (Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}");
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            toastr.info("{{ Session::get('info') }}");
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            toastr.error("{{ Session::get('error') }}");
        </script>
    @endif
    @if (Session::has('primary'))
        <script>
            toastr.primary("{{ Session::get('primary') }}");
        </script>
    @endif
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher('32b4313009ecadbd1560', {
        cluster: 'mt1'
        });

        let statusChannel = pusher.subscribe('changeOrderStatus');
        statusChannel.bind('App\\Events\\changeOrderStatus', function(data) {
            if(data) {
                let orders_count = parseInt($('.footer_fixed .bell .notify').text());
                    $('.bell .notify').text(orders_count + 1);
                    $('.frontend .order_notify').text(orders_count + 1);
                    $(".frontend .notifications").prepend(`
                    <a href="{{ asset('/') }}orders/${data.order.id}" class="text-reset notification-item d-block">
                        <div class="media">
                            <div class="avatar-xs mr-3">
                                <span class="avatar-title border-primary rounded-circle">
                                    <i class="mdi mdi-cart-outline"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <h6 class="mt-0 mb-1">رقم الطلب : (${data.order.id})</h6>
                                <h6 class="mt-0 mb-1">حالة الطلب : (${data.status_name})</h6>
                            </div>
                        </div>
                    </a>
                `);
            }
        });


    var token = $("meta[name=_token]").attr('content');

    function updateNav(index, remove = false) {
        if(remove) {
            $(`.navbar .carts .cart-${index}`).remove();
            $(".cart_count").text(parseFloat($(".cart_count").text()) - 1);
            if($(".navbar .carts .carts-info").children().length == 0) {
                $(".navbar .carts").addClass('d-none');
                $(".navbar .cart_items").append(`<div class="alert alert-info">السلة فارغة حاليا</div>`);
            } else {
                $(".navbar .carts").removeClass('d-none');
                $(".navbar .cart_items .alert").remove();
            }
        }
        prices = [];
        $(".navbar .carts .carts-info").children().each((i, child) => {
            prices.push(parseFloat($(child).find('.total_price').text()));
        });
        if(prices.length !== 0) {
            prices = prices.reduce((acc, curr) => acc + curr);
        }
        $(".total_prices").text(prices);
    }
    function removeCartNav(index) {
        $.ajax({
            method: "POST",
            url: "{{ route('frontend.removeCart') }}",
            data: {
                _token: token,
                index: index
            },
            success: function(res) {
                if(res.status) {
                    updateNav(index, true);
                    toastr.info(res.message);
                }
            },
            error: function(err) {

            }
        })
    }
    </script>

    <!-- footerScript -->
    @yield('footerScript')
    <!-- App js -->
</body>
</html>
