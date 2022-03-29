@extends('layouts.master')

@section('title')
{{ translate('translations') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('translations') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('translations') }} @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>{{ $language->name . ' - ' . translate('translations') }}</h2>
            </div>
            <form action="{{ route('languages.translations.index', $language) }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('translation key') }}</label>
                            <input class="form-control" name="lang_key" type="text" value="{{ request('lang_key') }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('languages.translations.update', $language) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ translate('translation key') }}</th>
                                <th>{{ translate('translation value') }}</th>
                                <th>{{ translate('creation date') }}</th>
                                <th>{{ translate('last update date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($translations as $translation)
                            <input class="form-control" type="hidden" value="{{ $translation->lang_key }}" name="translations[{{ $loop->index }}][lang_key]">
                            <input class="form-control" type="hidden" value="{{ $language->id }}" name="language">
                                <tr>
                                    <td>
                                        {{ $translation->lang_key }}
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ $translation->lang_value }}" name="translations[{{ $loop->index }}][lang_value]" type="text">
                                    </td>
                                    <td>
                                        {{ $translation->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $translation->updated_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                            <button hidden>hello</button>
                        </tbody>
                    </table>
                    {{ $translations->appends(['lang_key' => request('lang_key')])->links() }}
                </form>
            </div>
        </div>
    </div>
@endsection
