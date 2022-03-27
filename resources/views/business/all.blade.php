@extends('layouts.master')


@section('title')
{{ translate('revenues and expenses') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('revenues and expenses') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('financial transactions') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('business.index') }} @endslot
        @slot('li3') {{ translate('revenues and expenses') }} @endslot
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
                            <h2>{{ translate('incomes') }}</h2>
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
                                    <div class="alert alert-primary w-100">{{ translate('there is no incomes yet') }}</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ translate('expenses') }}</h2>
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
                                    <div class="alert alert-primary w-100">{{ translate('there is no expenses yet') }}</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
