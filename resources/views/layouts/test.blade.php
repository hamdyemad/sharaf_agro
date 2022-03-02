<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title> @yield('title') | Lexa - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Lexa Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link href="{{ URL::asset('/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/libs/owl/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">
    adasd
    hello dear

    <div class="owl-carousel owl-theme">
        <div class="item">
            <h4>1</h4>
        </div>
        <div class="item">
            <h4>2</h4>
        </div>
    </div>
    <script src="{{ URL::asset('/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/owl/owl.carousel.min.js') }}"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
</body>

</html>
