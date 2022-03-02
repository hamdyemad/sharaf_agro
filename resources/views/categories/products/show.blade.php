@extends('layouts.master')

@section('title')
معلومات عن ({{ $product->name }})
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $product->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأكلات @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('products.index') }} @endslot
        @slot('li3') {{ $product->name }} @endslot
    @endcomponent
    <div class="show_product">
        <div class="card">
            <div class="card-header text-center text-md-left flex-column-reverse d-flex flex-md-row justify-content-between">
                <div class="text-left">
                    <h1>معلومات عن ({{ $product->name }})</h1>
                </div>
                <div class="text-left">
                    <a class="btn btn-info" href="{{ route('products.index') }}">
                        الرجوع الى الأكلات
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" style="direction: ltr">
                    @if($product->photos)
                        @foreach (json_decode($product->photos) as $photo)
                            <div class="item">
                                <img src="{{ asset($photo) }}" alt="">
                            </div>
                        @endforeach
                    @else
                    <img class="mt-2" src="{{ asset('/images/product_avatar.png') }}" alt="">
                    @endif
                </div>
                @if($product->variants)
                    @if(isset($product->variants->groupBy('type')['size']))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>الحجم</th>
                                <th>السعر</th>
                                <th>الخصم</th>
                                <th>السعر بعد الخصم</th>
                            </thead>
                            <tbody>
                                @foreach ($product->variants->groupBy('type')['size'] as $variant)
                                    <tr>
                                        <td>{{ $variant->variant }}</td>
                                        <td>{{ $variant->price }}</td>
                                        <td>{{ $variant->discount }}</td>
                                        <td>{{ $variant->price_after_discount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(isset($product->variants->groupBy('type')['extra']))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>الأضافة</th>
                                <th>السعر</th>
                            </thead>
                            <tbody>
                                @foreach ($product->variants->groupBy('type')['extra'] as $variant)
                                    <tr>
                                        <td>{{ $variant->variant }}</td>
                                        <td>{{ $variant->price_after_discount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

@endsection


@section('footerScript')
    <script>
        $('.owl-carousel').owlCarousel({
            // loop: true,
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
@endsection
