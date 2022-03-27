@extends('layouts.master')

@section('title')
{{ translate('languages') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('languages') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('languages') }} @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>{{ translate('languages') }}</h2>
                @can('languages.create')
                    <div>
                        <a href="{{ route('languages.create') }}" class="btn btn-primary mb-2">{{ translate('create new language') }}</a>
                    </div>
                @endcan
            </div>
            <form action="{{ route('languages.index') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('language name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
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
                            <th>{{ translate('translations link') }}</th>
                            <th>{{ translate('translation name') }}</th>
                            <th>{{ translate('translation code') }}</th>
                            <th>{{ translate('translation region') }}</th>
                            <th>{{ translate('creation date') }}</th>
                            <th>{{ translate('last update date') }}</th>
                            <th>{{ translate('settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($languages as $language)
                            <tr>
                                <th scope="row">{{ $language->id }}</th>
                                <td>
                                    <a href="{{ route('languages.translations.index', $language) }}">{{ translate('translations link') }}</a>
                                </td>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->code }}</td>
                                <td>{{ $language->regional }}</td>
                                <td>
                                    {{ $language->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $language->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('languages.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $language->id }}">
                                                <span>{{ translate('delete') }}</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $language->id,
                                            'route' => route('languages.destroy', $language->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $languages->links() }}
            </div>
        </div>
    </div>
@endsection
