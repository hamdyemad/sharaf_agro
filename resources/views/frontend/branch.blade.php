@extends('frontend.layout')

@section('content')
    <div class="branch_content">
        <div class="container">
            <div class="branch">
                <div class="heading text-center pt-4 pb-4">
                    <h1>{{ $branch->name  . ' (' . $branch->categories->count() . ')' }}</h1>
                </div>
            </div>
            @foreach ($branch->categories()->where('active', 1)->orderBy('viewed_number')->get() as $category)
                <div class="card category text-center text-md-left">
                    <div class="card-header">
                        <h2>{{ $category->name }}</h2>
                        @if($category->photo)
                            <img class="rounded" src="{{ asset($category->photo ) }}" alt="">
                        @else
                            <img class="rounded" src="{{ asset('/images/default.jpg') }}" alt="">
                        @endif
                    </div>
                    <div class="card-body products">

                        <div class="owl-carousel branch-carousel owl-theme">
                            @foreach ($category->products()->where('active', 1)->orderBy('viewed_number')->get() as $product)
                                <div class="item">
                                    <a href="{{ route('frontend.product', $product) }}" class="d-block">
                                        @if($product->photos)
                                            <img class="rounded" src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                        @else
                                            <img class="rounded"  src="{{ asset('/images/product_avatar.png') }}" alt="">
                                        @endif
                                        <h4>{{ $product->name }}</h4>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
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
        })
    </script>
@endsection
