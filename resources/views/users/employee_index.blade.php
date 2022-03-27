@extends('layouts.master')

@section('title')
{{ translate('employees') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('employees') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('employees') }} @endslot
    @endcomponent
    <div class="all_users">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('employees') }}</h2>
                    @can('users.create')
                        <div class="d-flex justify-content-between create_links">
                            <a href="{{ route('users.create') . '?type=sub-admin' }}" class="btn btn-primary mb-2">{{ translate('create employee') }}</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">{{ translate('employee name') }}</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">{{ translate('email') }}</label>
                                <input class="form-control" name="email" type="text" value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">{{ translate('phone') }}</label>
                                <input class="form-control" name="phone" type="text" value="{{ request('phone') }}">
                            </div>
                        </div>
                        @if(Auth::user()->type == 'admin')
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="branch_id">{{ translate('the branch') }}</label>
                                    <select class="form-control" name="branch_id">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" @if (request('branch_id') ==  $branch->id) selected @endif>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="banned">{{ translate('banned') }}</label>
                                <select class="form-control" name="banned">
                                    <option value="">{{ translate('choose') }}</option>
                                    <option value="1" @if (request('banned') == 1) selected @endif>{{ translate('banned') }}</option>
                                    <option value="2" @if (request('banned') == 2) selected @endif>{{ translate('not banned') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
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
                                <th>{{ translate('branch') }}</th>
                                <th>{{ translate('employee name') }}</th>
                                <th>{{ translate('email') }}</th>
                                <th>{{ translate('permessions') }}</th>
                                <th>{{ translate('phone') }}</th>
                                <th>{{ translate('address') }}</th>
                                <th>{{ translate('banned') }}</th>
                                <th>{{ translate('creation date') }}</th>
                                <th>{{ translate('last update date') }}</th>
                                <th>{{ translate('settings') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    @if($user->branch)
                                        <td>
                                            <div class="badge badge-primary p-2">{{ translate('employee in') }} : ({{ $user->branch->name }})</div>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="d-flex">
                                            @if ($user->avatar)
                                                <img src="{{ asset($user->avatar) }}" alt="">
                                            @else
                                                <img src="{{ asset('images/avatar.jpg') }}" alt="">
                                            @endif
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @forelse ($user->roles as $role)
                                            <div class="badge badge-primary">{{ $role->name }}</div>
                                        @empty
                                            <div class="badge badge-danger w-100">{{ translate('there is no permessions') }}</div>
                                        @endforelse
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>
                                        <form action="{{ route('users.banned', $user) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="checkbox" onchange="this.form.submit()" name="active" id="switch-{{ $loop->index }}" switch="bool"
                                                @if($user->banned)
                                                checked
                                                @endif />
                                                <label for="switch4" data-on-label="{{ translate('yes') }}" data-off-label="{{ translate('no') }}"></label>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $user->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('users.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('users.edit', $user) . '?type=' . $user->type }}">
                                                    <span>{{ translate('edit') }}</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>
                                            @endcan
                                            @can('users.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $user->id }}">
                                                    <span>{{ translate('delete') }}</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $user->id,
                                                'route' => route('users.destroy', $user->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
