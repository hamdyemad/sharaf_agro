@extends('layouts.master')

@section('title') لوحةالتحكم  @endsection

@section('content')
    <!-- start page title -->
    <div class="row">

        @component('common-components.breadcrumb')
            @slot('title') لوحةالتحكم @endslot
        @endcomponent
    </div>
    <!-- end page title -->
    @if(Auth::user()->type == 'admin')
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                @component('common-components.widget')
                    @slot('route') {{ route('news.index') }} @endslot
                    @slot('icons') mdi mdi-newspaper float-right @endslot
                    @slot('title') الأخبار @endslot
                    @slot('price') {{ $newsCount }} @endslot
                    @slot('badgeClass') badge-danger @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6">
                @component('common-components.widget')
                    @slot('route') {{ route('orders.index') }} @endslot
                    @slot('icons') mdi mdi-cart-outline float-right @endslot
                    @slot('title') الطلبات @endslot
                    @slot('price') {{ $ordersCount }} @endslot
                    @slot('badgeClass') badge-danger @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6">
                @component('common-components.widget')
                    @slot('route') {{ route('categories.index') }} @endslot
                    @slot('icons') mdi mdi-inbox-multiple float-right @endslot
                    @slot('title') الأقسام الرئيسية @endslot
                    @slot('price') {{ $categoriesCount }} @endslot
                    @slot('badgeClass') badge-danger @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6">
                @component('common-components.widget')
                    @slot('route') {{ route('sub_categories.index') }} @endslot
                    @slot('icons') mdi mdi-inbox-multiple float-right @endslot
                    @slot('title') الأقسام الفرعية @endslot
                    @slot('price') {{ $subCategoriesCount }} @endslot
                    @slot('badgeClass') badge-danger @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6">
                @component('common-components.widget')
                    @slot('route') {{ route('users.index') }} @endslot
                    @slot('icons') mdi mdi-account-multiple-outline float-right @endslot
                    @slot('title') الموظفين @endslot
                    @slot('price') {{ $employeesCount }} @endslot
                    @slot('badgeClass') badge-danger @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-6">
                @component('common-components.widget')
                    @slot('route') {{ route('customers.index') }} @endslot
                    @slot('icons') mdi mdi-account-multiple-outline float-right @endslot
                    @slot('title') الشركات @endslot
                    @slot('price') {{ $customersCount }} @endslot
                    @slot('badgeClass') badge-danger @endslot
                @endcomponent
            </div>
        </div>
        <!-- end row -->
    @else
    <div class="alert alert-primary">أهلا بك عزيزى {{ Auth::user()->name }}</div>
    @endif

@endsection

@section('footerScript')
    <!--Morris Chart-->
    <script src="{{ URL::asset('/libs/morris.js/morris.js.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/raphael/raphael.min.js') }}"></script>
@endsection
