@extends('layouts.master')

@section('title')
{{ translate('countries') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('countries') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('countries') }} @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>{{ translate('countries') }}</h2>
                @can('countries.create')
                    <div>
                        <a href="{{ route('countries.create') }}" class="btn btn-primary mb-2">{{ translate('create new country') }}</a>
                    </div>
                @endcan
            </div>
            <form action="{{ route('countries.index') }}" method="GET">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label for="name">{{ translate('country name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label for="name">{{ translate('country code') }}</label>
                            <input class="form-control" name="code" type="text" value="{{ request('code') }}">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label for="category">{{ translate('available') }}</label>
                            <select class="form-control select2" name="active">
                                <option value="">أختر</option>
                                <option @if(request('active') == 'true') selected @endif value="true">{{ translate('available') }}</option>
                                <option @if(request('active') == 'false') selected @endif value="false">{{ translate('not available') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
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
                            <th>{{ translate('country name') }}</th>
                            <th>{{ translate('country code') }}</th>
                            <th>{{ translate('country cities') }}</th>
                            <th>{{ translate('available') }}</th>
                            <th>{{ translate('creation date') }}</th>
                            <th>{{ translate('last update date') }}</th>
                            <th>{{ translate('settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <th scope="row">{{ $country->id }}</th>
                                <td>
                                    <a
                                        href="{{ route('countries.cities.index', $country->id) }}">{{ $country->name }}</a>
                                </td>
                                <td>{{ $country->code }}</td>
                                <td>{{ $country->cities->count() }}</td>
                                <td>
                                    @if ($country->active)
                                        <span class="badge badge-success">{{ translate('available') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ translate('not available') }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $country->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $country->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('countries.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('countries.edit', $country) }}">
                                                <span>{{ translate('edit') }}</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('countries.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $country->id }}">
                                                <span>{{ translate('delete') }}</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $country->id,
                                            'route' => route('countries.destroy', $country->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $countries->links() }}
            </div>
        </div>
    </div>
@endsection
