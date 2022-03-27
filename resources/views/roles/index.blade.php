@extends('layouts.master')

@section('title')
{{ translate('permessions') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('permessions') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('permessions') }} @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>{{ translate('permessions') }}</h2>
                @can('roles.create')
                    <div>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">{{ translate('create new permession') }}</a>
                    </div>
                @endcan
            </div>
            <form action="{{ route('roles.index') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('permession name') }}</label>
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
                            <th>{{ translate('permession name') }}</th>
                            <th>{{ translate('permessions count') }}</th>
                            <th>{{ translate('creation date') }}</th>
                            <th>{{ translate('last update date') }}</th>
                            <th>{{ translate('settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->permessions->count() }}</td>
                                <td>
                                    {{ $role->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $role->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('roles.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('roles.edit', $role) }}">
                                                <span>{{ translate('edit') }}</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('roles.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $role->id }}">
                                                <span>{{ translate('delete') }}</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $role->id,
                                            'route' => route('roles.destroy', $role->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection
