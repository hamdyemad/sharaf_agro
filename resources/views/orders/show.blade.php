@extends('layouts.master')

@section('title')
اظهار الطلب
@endsection

@section('content')
    <div class="show_order">
        @component('common-components.breadcrumb')
            @slot('title') اظهار الطلب @endslot
            @slot('li1') لوحة التحكم @endslot
            @slot('li2') الأخبار @endslot
            @slot('route1') {{ route('dashboard') }} @endslot
            @slot('route2') {{ route('news.index') }} @endslot
            @slot('li3') اظهار الطلب  @endslot
        @endcomponent
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1>أسم الشركة : {{ $order->customer->name }}</h1>
                    </div>
                    <div class="card-body">
                        <h2>أسم المركب : <span>{{ $order->name }}</span></h1>
                        <div class="card mt-4">
                            <div class="card-header">
                                <h3>تفاصيل المركب</h4>
                            </div>
                            <div class="card-body">
                                <p>{{ $order->details }}</p>
                            </div>
                        </div>
                        @if(count($images) > 0)
                            <div class="images_carousel owl-carousel owl-theme">
                                @foreach ($images as $image)
                                    <div class="item">
                                            <a href="{{ asset($image) }}">
                                                <img class="rounded" src="{{ asset($image) }}" alt="صورة">
                                            </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if(count($pdfs) > 0)
                            <h4>مرفقات ال ({{ count($pdfs) }}) pdf </h4>
                            <ul class="list-unstyled mt-2 files">
                                @foreach ($pdfs as $pdf)
                                    <li class="d-flex align-items-center">
                                        <span>{{ $loop->index + 1 }}</span>
                                        <a class="btn btn-primary ml-1" href="{{ asset($pdf) }}">{{ 'المرفق رقم' . ($loop->index + 1) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <a class="btn btn-info" href="{{ route('orders.index') }}">الرجوع الى الطلبات</a>
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
