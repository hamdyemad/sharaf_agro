@extends('layouts.master')

@section('title')
{{ translate('currencies') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('currencies') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('currencies') }} @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>{{ translate('currencies') }}</h2>
            </div>
            <form action="{{ route('currencies.index') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('currency name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('currency code') }}</label>
                            <input class="form-control" name="code" type="text" value="{{ request('code') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name"></label>
                            <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('name') }}</th>
                            <th>{{ translate('symbol') }}</th>
                            <th>{{ translate('code') }}</th>
                            <th>{{ translate('exchange to default currency') }}</th>
                            <th>{{ translate('default') }}</th>
                            <th>{{ translate('creation date') }}</th>
                            <th>{{ translate('last update date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currencies as $currency)
                            <tr>
                                <th scope="row">{{ $currency->id }}</th>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td>{{ $currency->code }}</td>
                                <td>{{ price($currency->exchange_rate) }}</td>
                                <td>
                                    <form action="{{ route('currencies.update', $currency) }}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <div class="form-group">
                                            <input type="checkbox" onchange="this.form.submit()" name="active" id="switch-{{ $loop->index }}" switch="bool"
                                            @if($currency->default)
                                            checked
                                            @endif />
                                            <label for="switch-{{ $loop->index }}" data-on-label="{{ translate('yes') }}" data-off-label="{{ translate('no') }}"></label>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    {{ $currency->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $currency->updated_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $currencies->links() }}
            </div>
        </div>
    </div>
@endsection
