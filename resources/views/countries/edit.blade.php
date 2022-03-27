@extends('layouts.master')

@section('title')
{{ translate('edit country') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $country->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('countries') }} @endslot
        @slot('route2') {{ route('countries.index') }} @endslot
        @slot('li3') {{ $country->name }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit country') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('countries.update', $country) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('country name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $country->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="code">{{ translate('country code') }}</label>
                                    <input type="text" class="form-control" name="code" value="{{ $country->code }}">
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="{{ translate('available') }}">{{ translate('available') }}</label>
                                <div class="form-group">
                                    <input type="checkbox" name="active" id="switch4" switch="bool" @if ($country->active)
                                    checked
                                    @endif
                                    />
                                    <label for="switch4" data-on-label="{{ translate('yes') }}" data-off-label="{{ translate('no') }}"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                                    <a href="{{ route('countries.index') }}" class="btn btn-info">{{ translate('back to countries') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
