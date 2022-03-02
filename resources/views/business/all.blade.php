@extends('layouts.master')


@section('title')
الأيرادات والمصروفات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأيرادات والمصروفات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') المعاملات المالية @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('business.index') }} @endslot
        @slot('li3') الأيرادات والمصروفات @endslot
    @endcomponent
    <div class="all_expenses">
        @if(Auth::user()->type == 'admin')
        @endif
        @foreach ($branches as $branch)
            <div class="card">
                <div class="card-header">
                    {{ $branch->name }}
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <h2>الأيرادات</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($branch->bussinesses->where('type', 'income') as $income)
                                    <div class="col-12 col-md-3">
                                        @component('common-components.widget')
                                            @slot('route') {{ route('expenses.index', ['type' => $income->id]) }} @endslot
                                            @slot('bg') bg-success @endslot
                                            @slot('icons') mdi mdi-arrow-up-bold-circle-outline float-right @endslot
                                            @slot('title') {{ $income->name }} @endslot
                                            @slot('price') {{ $income->expenses->count() }} @endslot
                                            @slot('badgeClass') badge-info @endslot
                                        @endcomponent
                                    </div>
                                @empty
                                    <div class="alert alert-primary w-100">لا يوجد ايرادات حاليا</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2>المصروفات</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($branch->bussinesses->where('type', 'expense') as $expense)
                                    <div class="col-12 col-md-3">
                                        @component('common-components.widget')
                                            @slot('route') {{ route('expenses.index', ['type' => $expense->id]) }} @endslot
                                            @slot('bg') bg-danger @endslot
                                            @slot('icons') mdi mdi-arrow-down-bold-circle-outline float-right @endslot
                                            @slot('title') {{ $expense->name }} @endslot
                                            @slot('price') {{ $expense->expenses->count() }} @endslot
                                            @slot('badgeClass') badge-info @endslot
                                        @endcomponent
                                    </div>
                                @empty
                                    <div class="alert alert-primary w-100">لا يوجد مصروفات حاليا</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
