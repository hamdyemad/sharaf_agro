@extends('frontend.layout')

@section('content')
    @include('frontend.inc.branch_content', ['branch' => $branch])
@endsection

@section('footerScript')
    <script>
        $('.branch-carousel').owlCarousel({
            margin:10,
            rtl: true,
            nav:true,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:2
                },
                1000:{
                    items:4
                }
            }
        });
    </script>
@endsection
