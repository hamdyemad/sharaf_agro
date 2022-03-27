<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('/images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ URL::asset('/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    {{-- Toastr --}}
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
    <!-- headerCss -->
    @yield('headerCss')

</head>

<body>

    @yield('content')

    <!-- JAVASCRIPT -->
    <script src="{{ URL::asset('/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/libs/toastr/toastr.min.js') }}"></script>

    <script src="{{ URL::asset('/libs/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/metismenu/metismenu.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/node-waves/node-waves.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/jquery-sparkline/jquery-sparkline.min.js') }}"></script>
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
</body>

</html>
