@extends('layouts.master')


@section('title')
{{ translate('create new language') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('create new language') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('languages') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('languages.index') }} @endslot
        @slot('li3') {{ translate('create new language') }} @endslot
    @endcomponent
    <div class="create_language">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new language') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('languages.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('language') }}</label>
                                    <select class="form-control select2" name="language">
                                        @foreach ($languages as $code => $obj)
                                        <option value="{{ $code }}">{{ $obj['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="rtl">rtl</label>
                                <div class="form-group">
                                    <input type="checkbox" name="rtl" id="switch" switch="bool" />
                                    <label for="switch" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('create') }}" class="btn btn-success">
                                    <a href="{{ route('languages.index') }}" class="btn btn-info">{{ translate('back to languages') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
    <script>
    </script>
@endsection
