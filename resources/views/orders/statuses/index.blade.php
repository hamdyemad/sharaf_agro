@extends('layouts.master')

@section('title')
{{ translate('statuses') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('statuses') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('statuses') }} @endslot
    @endcomponent
    <div class="all_statuses">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('statuses') }}</h2>
                    @can('statuses.create')
                        <div>
                            <a href="{{ route('statuses.create') }}" class="btn btn-primary mb-2">{{ translate('create') }}</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('statuses.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">{{ translate('status name') }}</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
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
                                <th>{{ translate('status name') }}</th>
                                <th>{{ translate('default status') }}</th>
                                <th>{{ translate('creation date') }}</th>
                                <th>{{ translate('last update date') }}</th>
                                <th>{{ translate('settings') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuses as $status)
                                <tr>
                                    <th scope="row">{{ $status->id }}</th>
                                    <td>{{ $status->name }}</td>
                                    <td>
                                        @if($status->default_val)
                                            <div class="badge badge-success">{{ translate('default') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $status->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $status->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('statuses.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('statuses.edit', $status) }}">
                                                    <span>{{ translate('edit') }}</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>

                                            @endcan
                                            @can('statuses.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $status->id }}">
                                                    <span>{{ translate('delete') }}</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $status->id,
                                                'route' => route('statuses.destroy', $status->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $statuses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
