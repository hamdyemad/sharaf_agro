<!DOCTYPE html>
<html lang="ar">

<head>

    <meta charset="utf-8" />
    <title> @yield('title', get_setting('project_name'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta content="Lexa Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
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
    <link href="{{ URL::asset('/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Responsive Table css -->
    <link href="{{ URL::asset('/libs/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ URL::asset('/libs/owl/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts/partials/header')

        @include('layouts/partials/sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- content -->
                    @yield('content')


                    @include('layouts/partials/footer')

                </div>
                <!-- end main content-->
            </div>
        </div>
    </div>
    <!-- END layout-wrapper -->
    <!-- Start preloader_all-->
    <div class="d-none" id="preloader_all">
        <div id="loader"></div>
    </div>
    <!-- END preloader_all-->

    @include('layouts/partials/rightbar')

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
    <!-- App js -->

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

        var orderChannel = pusher.subscribe('newOrder');
        orderChannel.bind('App\\Events\\newOrder', function(data) {
            if(data) {
                if(data.order.branch_id == "{{ Auth::user()->branch_id }}" || "{{Auth::user()->type}}" == 'admin') {
                    let orders_count = parseInt($('.navbar-header .dropdown .badge-pill').text());
                    $('.navbar-header .dropdown .badge-pill').text(orders_count + 1);
                    $('.vertical-menu .orders .badge-pill').text(orders_count + 1);
                    $(".navbar-header .dropdown .simplebar-content").prepend(`
                        <a href="{{ asset('/') }}admin/orders/${data.order.id}" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title border-primary rounded-circle ">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">رقم الطلب : (${data.order.id})</h6>
                                    <h6 class="mt-0 mb-1">طلب جديد</h6>
                                    <h6 class="mt-0 mb-1">الحالة : (${data.status.name})</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">عدد الأكلات : (${data.products_count})</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    `);
                }
            }
        });
    </script>

    <!-- footerScript -->
    @yield('footerScript')
</body>

</html>
