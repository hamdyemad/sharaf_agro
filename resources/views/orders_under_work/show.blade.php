@extends('layouts.master')

@section('title')
اظهار الرسالة
@endsection

@section('content')
    <div class="show_order_under_work">
        @component('common-components.breadcrumb')
            @slot('title') اظهار الرسالة @endslot
            @slot('li1') لوحة التحكم @endslot
            @slot('li2') الرسائل @endslot
            @slot('route1') {{ route('dashboard') }} @endslot
            @slot('route2') {{ route('orders_under_work.index') }} @endslot
            @slot('li3') اظهار الرسالة  @endslot
        @endcomponent
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1>أسم الشركة : {{ $order->customer->name }}</h1>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center">
                                <h3>أسم المركب: </h4>
                                <h4 class="ml-2 bg-primary p-2 rounded">{{ $order->name }}</h4>
                            </li>
                            <li class="d-flex align-items-center">
                                <h3>القسم الرئيسى: </h4>
                                <h4 class="ml-2 bg-primary p-2 rounded">{{ $order->category->name }}</h4>
                            </li>
                            @if($order->sub_category)
                                <li class="d-flex align-items-center">
                                    <h3>القسم الفرعى: </h4>
                                    <h4 class="ml-2 bg-primary p-2 rounded">{{ $order->sub_category->name }}</h4>
                                </li>
                            @endif
                            <li class="d-flex align-items-center">
                                <h3>الحالة: </h4>
                                <h4 class="ml-2 bg-primary p-2 rounded">{{ $order->status->name }}</h4>
                            </li>
                            @if($order->reason)
                                <li class="d-flex align-items-center">
                                    <h3>السبب: </h4>
                                    <h4 class="ml-2 bg-primary p-2 rounded">{{ $order->reason }}</h4>
                                </li>
                            @endif
                        </ul>
                        @if(count($images) > 0)
                            <div class="images_carousel owl-carousel owl-theme">
                                @foreach ($images as $image)
                                    <div class="item">
                                            <a href="{{ asset($image) }}">
                                                <img src="{{ asset($image) }}" alt="صورة">
                                            </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header"><h2>الملاحظات</h2></div>
                            <div class="card-body">
                                {{ $order->details }}
                            </div>
                        </div>
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
                        <a class="btn btn-info" href="{{ route('orders_under_work.index') }}">الرجوع الى رسائل الطلبات</a>
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
