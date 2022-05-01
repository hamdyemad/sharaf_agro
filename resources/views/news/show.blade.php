@extends('layouts.master')

@section('title')
اظهار الخبر
@endsection

@section('content')
    <div class="show_order_under_work">
        @component('common-components.breadcrumb')
            @slot('title') اظهار الخبر @endslot
            @slot('li1') لوحة التحكم @endslot
            @slot('li2') الأخبار @endslot
            @slot('route1') {{ route('dashboard') }} @endslot
            @slot('route2') {{ route('news.index') }} @endslot
            @slot('li3') اظهار الخبر  @endslot
        @endcomponent
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1>أسم الخبر : {{ $new->name }}</h1>
                    </div>
                    <div class="card-body">
                        @if(count(json_decode($new->images)) > 0)
                            <div class="images_carousel owl-carousel owl-theme">
                                @foreach (json_decode($new->images) as $image)
                                    <div class="item">
                                            <a href="{{ asset($image) }}">
                                                <img class="rounded" src="{{ asset($image) }}" alt="صورة">
                                            </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3>تفاصيل الخبر</h4>
                            </div>
                            <div class="card-body">
                                @php echo $new->details; @endphp
                            </div>
                        </div>
                        @if(Auth::user()->type == 'user')
                        <a class="btn btn-info" href="{{ route('news.all_news') }}">الرجوع الى الأخبار</a>
                        @else
                        <a class="btn btn-info" href="{{ route('news.index') }}">الرجوع الى الأخبار</a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection

@section('footerScript')
<script>
    $('.images_carousel').owlCarousel({
    rtl: true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
</script>
@endsection
