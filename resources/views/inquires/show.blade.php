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
            @slot('route2') {{ route('inquires.index') }} @endslot
            @slot('li3') اظهار الرسالة  @endslot
        @endcomponent
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1>{{ $inquire->customer->name }}</h1>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center">
                                <h3>القسم الرئيسى: </h4>
                                <h4 class="ml-2 bg-primary p-2 rounded">{{ $inquire->category->name }}</h4>
                            </li>
                            @if($inquire->sub_category)
                                <li class="d-flex align-items-center">
                                    <h3>القسم الفرعى: </h4>
                                    <h4 class="ml-2 bg-primary p-2 rounded">{{ $inquire->sub_category->name }}</h4>
                                </li>
                            @endif
                            <li class="d-flex align-items-center">
                                <h3>أسم الراسل: </h4>
                                <h4 class="ml-2 bg-primary p-2 rounded">{{ $inquire->sender_name }}</h4>
                            </li>
                            <li class="d-flex align-items-center">
                                <h3>رقم موبيل الراسل: </h4>
                                <h4 class="ml-2 bg-primary p-2 rounded">{{ $inquire->sender_phone }}</h4>
                            </li>
                        </ul>
                        <div class="card">
                            <div class="card-header"><h2>الأستفسار</h2></div>
                            <div class="card-body">
                                {{ $inquire->details }}
                            </div>
                        </div>
                        @if($inquire->reply)
                            <div class="card">
                                <div class="card-header"><h2>رد على الأستفسار</h2></div>
                                <div class="card-body">
                                    {{ $inquire->reply }}
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->type == 'admin' || Auth::user()->can('inquires.show_histories'))
                            <td scope="row">
                                @if (count($inquire->histories) > 0)
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td><span class="max font-weight-bold">من عدل على الطلب</span></td>
                                                <td><span class="max font-weight-bold">التوقيت</span></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inquire->histories()->latest()->get() as $history)
                                                <tr>
                                                    <td><span class="max">{{ $history->user->name }}</span></td>
                                                    <td><span class="max">{{ $history->created_at }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                <span class="max">لا يوجد تعديلات بعد</span>
                                @endif
                            </td>
                        @endif
                        <a class="btn btn-info" href="{{ route('inquires.index', ['page' => request('page')]) }}">الرجوع الى الأستفسارات </a>
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
