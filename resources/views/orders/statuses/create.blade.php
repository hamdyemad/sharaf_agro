@extends('layouts.master')

@section('title')
{{ translate('create new status') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('create new status') }} @endslot
        @slot('li1') {{ translate('dashboard') }}@endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('statuses') }} @endslot
        @slot('route2') {{ route('statuses.index') }} @endslot
        @slot('li3') {{ translate('create new status') }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new status') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('statuses.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ translate('status name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="{{ translate('default status') }}">{{ translate('default status') }}</label>
                                <div class="form-group">
                                    <input type="checkbox" name="default_val" id="switch4" switch="bool" />
                                    <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('create') }}" class="btn btn-success">
                                    <a href="{{ route('statuses.index') }}" class="btn btn-info">{{ translate('back to statuses') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
