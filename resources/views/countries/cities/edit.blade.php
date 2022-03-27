@extends('layouts.master')

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $country->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('cities') }} @endslot
        @slot('route2') {{ route('countries.cities.index', $country) }} @endslot
        @slot('li3') {{ $country->name }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $country->name }}</h2>
                    {{ translate('edit city') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('countries.cities.update', ['country' => $country, 'city' => $city]) }}"
                        method="POST">
                        <input type="hidden" name="country_id" value="{{ $country->id }}">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('city name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $city->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('shipping price') }}</label>
                                    <input type="text" class="form-control" name="price" value="{{ $city->price }}">
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                                    <a href="{{ route('countries.cities.index', $country) }}" class="btn btn-info">{{ translate('back to cities') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
