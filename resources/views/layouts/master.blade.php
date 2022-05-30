@php
    $orders = App\Models\Order::where('expected_notify', 0)->get();
    if($orders->count() > 0) {
        foreach ($orders as $order) {
            if($order->expected_date) {
                $expected_date =  new \Carbon\Carbon($order->expected_date);
                $now = \Carbon\Carbon::now();
                if($expected_date->subDays(get_setting('expected_date'))->lte($now)) {
                    $order->update([
                        'expected_notify' => 1
                    ]);
                    $main_category = App\Models\Category::find($order->category_id);
                    $data = [
                        'name' => $order->name,
                        'customer_name' => $order->customer->name,
                        'status_name' => $order->status->name,
                        'category_name' => $main_category->name,
                        'details' => $order->details,
                        'subject' => $order->name . ' (تنبيه خاص بالتوقيت المتوقع)'
                    ];
                    $order_view = App\Models\OrderView::
                    where('order_id', $order->id)
                    ->where('user_id', $order->employee->id)
                    ->first();
                    if($order_view) {
                        $order_view->update([
                            'viewed' => 0
                        ]);
                    }
                    if($order->sub_category_id) {
                        $data['sub_category_name'] = $main_category->sub_categories->find($order->sub_category_id)->name;
                    }
                    try {
                        Mail::to($order->employee->email)->send(new App\Mail\ExpectedOrderNotify($data));
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                    header("Refresh:0");
                }
            }
        }
    }
@endphp

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
    {{-- Include Tiny Configurations Component --}}
    <x-head.tinymce-config/>


    <!-- headerCss -->
    @yield('headerCss')

    <!-- Cairo Font -->

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
        <div class="main-content admin">
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
    <script src="{{ URL::asset('/libs/jquery.ddslick.min.js') }}"></script>
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

        var pusher = new Pusher('423c01a9accfc4e9cdb4', {
            cluster: 'eu'
        });

        var token = $("meta[name=_token]").attr('content');
        // Show Loading On Submit
        $("input[type=submit]").click(function() {
            $("#preloader_all").removeClass('d-none');
        })
    </script>
    {{-- RealTime --}}
    @include('realtime.order')
    @include('realtime.news')
    @include('realtime.order_under_work')
    @include('realtime.inquire')
    {{-- Firebase Push Notifications --}}
    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.11/firebase-app.js";
        import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/9.6.11/firebase-messaging.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyDp_thdB3kSn73uNrovqBIH0kmiKaP4RF4",
            authDomain: "sharaf-6a5a8.firebaseapp.com",
            projectId: "sharaf-6a5a8",
            storageBucket: "sharaf-6a5a8.appspot.com",
            messagingSenderId: "370503949424",
            appId: "1:370503949424:web:8c4f48ec25ba5b5adbe8b5",
            measurementId: "G-3PYF3M2CZY"
        };
        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);
        getToken(messaging, { vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}" }).then((currentToken) => {
        if (currentToken) {
            $.ajax({
                method: "POST",
                url: "/admin/firebase_tokens",
                data: {
                    currentToken: currentToken,
                    _token: token
                },
                success: function(res) {
                    // console.log(res);
                },
                error: function(err) {
                    // console.log(err);
                }
            })
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
            // ...
        }
        }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        // ...
        });
      </script>

    <!-- footerScript -->
    @yield('footerScript')
</body>

</html>
