@extends('frontend.layout')

@section('content')
    <div class="home">
        <section class="header">
            <div class="overlay">
                <div class="container">
                    <div class="content">
                        <h1>{{ get_setting('header') }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="all_branches">
            <div class="container">
                <div class="heading text-center pt-4 pb-4">
                    <h2>الفروع</h2>
                </div>
                <div class="branches">
                    @foreach ($branches as $branch)
                        <div class="branch">
                            <a href="{{ route('frontend.branch', $branch) }}">
                                <img src="{{ asset('/images/agency.png') }}" alt="">
                                <h2>{{ $branch->name }}</h2>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="branches_with_categories mt-3">
                    @foreach ($branches as $branch)
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $branch->name . ' (' . $branch->categories->count() . ')' }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="owl-carousel branch-carousel owl-theme">
                                    @foreach ($branch->categories as $category)
                                        <div class="item">
                                            <img src="{{ asset($category->photo) }}" alt="">
                                            <h4>{{ $category->name }}</h4>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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
                    items:4
                },
                1000:{
                    items:4
                }
            }
        })
    </script>
@endsection
