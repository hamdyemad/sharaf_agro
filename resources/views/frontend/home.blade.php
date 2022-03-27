@extends('frontend.layout')

@section('content')
    <div class="home">
        <section class="header">
            <img src="{{ asset('/images/background.jpg') }}" alt="">
            <div class="overlay">
                <div class="container">
                    <div class="content">
                        <h1>{{ get_setting('header') }}</h1>
                    </div>
                </div>
            </div>
        </section>
        @if(!Auth::check() || Auth::user()->type == 'user'|| Auth::user()->type == 'admin')
            <div class="all_branches">
                <div class="container">
                    <div class="heading text-center pt-4 pb-4">
                        <h2>الفروع</h2>
                    </div>
                    <div class="branches">
                        <div class="branches owl-carousel owl-theme branch-carousel">
                            @foreach ($branches as $branch)
                                <div class="branch item">
                                    <a href="{{ route('frontend.branch', $branch) }}">
                                        <img src="{{ asset('/images/agency.png') }}" alt="">
                                        <h2>
                                            @if(strlen($branch->name) > 15)
                                            {{ mb_substr($branch->name, 0, 15) . '...' }}
                                            @else
                                            {{ $branch->name }}
                                            @endif
                                        </h2>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="branches_with_categories mt-3">
                        @foreach ($branches as $branch)
                            @if( $branch->categories->count() > 0)
                                <div class="card">
                                    <div class="card-header">
                                        <h3>{{ $branch->name . ' (' . $branch->categories->count() . ')' }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="owl-carousel branch-carousel owl-theme">
                                            @foreach ($branch->categories as $category)
                                                <div class="item">
                                                    <img src="{{ asset($category->photo) }}" alt="">

                                                    <h4>
                                                        @if(strlen($category->name) > 15)
                                                        {{ mb_substr($category->name, 0, 15) . '...' }}
                                                        @else
                                                        {{ $category->name }}
                                                        @endif
                                                    </h4>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            @include('frontend.inc.branch_content', ['branch' => Auth::user()->branch])
        @endif
    </div>
@endsection

@section('footerScript')
    <script>

        // Search With Ajax
        $(".products_search input").on('keyup', function() {
            let branch_id = '';
            @if(Auth::check())
                branch_id = "{{ Auth::user()->branch_id }}";
            @endif
            console.log(branch_id);
            if($(this).val() !== '') {
                $.ajax({
                    method: "POST",
                    url: "{{ route('frontend.productsByName') }}",
                    data: {
                        _token: token,
                        branch_id: branch_id,
                        name: $(this).val()
                    },
                    success: function(res) {
                        if(res.status) {
                            console.log(res.data);
                            $(".products_search .products").empty();
                            res.data.forEach((obj) => {
                                let img = '';
                                if(obj.photos) {
                                    img = `<img src="${JSON.parse(obj.photos)[0]}" alt="">`;
                                } else {
                                    img = `<img src="{{ asset('/images/product_avatar.png') }}" alt="">`;
                                }
                                $(".products_search .products").prepend(`
                                    <li>
                                        <a href="{{ asset('/') }}product/${obj.id}">
                                            ${img}
                                            <h5>${obj.name}</h5>
                                        </a>
                                    </li>
                                `);
                            });
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            } else {
                $(".products_search .products").empty();
            }
        });
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
