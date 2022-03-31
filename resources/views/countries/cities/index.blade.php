@extends('layouts.master')

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $country->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('cities') }} @endslot
    @endcomponent
    <div class="card cities">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>{{ translate('cities') }}</h2>
                <div>
                    <a href="{{ route('countries.cities.create', $country) }}" class="btn btn-primary mb-2">{{ translate('create new city') }}</a>
                    <a href="{{ route('countries.index') }}" class="btn btn-info mb-2">{{ translate('back to countries') }}</a>
                </div>
            </div>
            <form action="{{ route('countries.cities.index', $country) }}" method="GET">
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="name">{{ translate('city name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
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
                            <th><div class="full_width">{{ translate('city name') }}</div></th>
                            <th><div class="full_width">{{ translate('creation date') }}</div></th>
                            <th><div class="full_width">{{ translate('last update date') }}</div></th>
                            <th><div class="full_width">{{ translate('settings') }}</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cities as $city)
                            <tr>
                                <th scope="row">{{ $city->id }}</th>
                                <td>
                                    {{ $city->name }}
                                </td>
                                <td>
                                    <div class="full_width">{{ $city->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="full_width">{{ $city->updated_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        <a class="btn btn-info mr-1"
                                            href="{{ route('countries.cities.edit', ['country' => $country->id, 'city' => $city->id]) }}">
                                            <span>{{ translate('edit') }}</span>
                                            <span class="mdi mdi-circle-edit-outline"></span>
                                        </a>
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal_{{ $city->id }}">
                                            <span>{{ translate('delete') }}</span>
                                            <span class="mdi mdi-delete-outline"></span>
                                        </button>
                                        <!-- Modal -->
                                        @include('layouts.partials.modal', [
                                        'id' => $city->id,
                                        'route' => route('countries.cities.destroy', ['country' => $country->id, 'city' =>
                                        $city->id])
                                        ])
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <ul>
                                        @foreach ($city->prices as $price)
                                            <li>
                                                <span class="code">{{ $price->currency->code }}</span>
                                                <span>{{ $price->price }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $cities->links() }}
            </div>
        </div>
    </div>
@endsection
