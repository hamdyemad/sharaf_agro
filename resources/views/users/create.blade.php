@extends('layouts.master')

@section('title')
{{ translate('create new employee') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('create new employee') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('all employees') }} @endslot
        @slot('route2') {{ route('users.index') }} @endslot
        @slot('li3') {{ translate('create new employee') }} @endslot
    @endcomponent
    <div class="create_user">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new employee') }}
                </div>
                <div class="card-body">
                    <form class="form-horizontal mt-4" method="POST" action="{{ route('users.store') }}"
                        enctype="multipart/form-data">
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        @csrf
                        <div class="row">
                            @if(Auth::user()->type == 'admin')
                                <div class="col-12 col-md-6 branch_col">
                                    <div class="form-group">
                                        <label for="branch_id">{{ translate('the branch') }}</label>
                                        <select class="form-control select2" name="branch_id">
                                            @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if (old('branch_id') ==  $branch->id) selected @endif>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                            @endif
                            <div class="col-12 col-md-6 roles_col">
                                <div class="form-group">
                                    <label for="category">{{ translate('permessions') }}</label>
                                    <select class="form-control select2 select2-multiple" name="roles[]"
                                        data-placeholder="{{ translate('choose') }}" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @if (is_array(old('roles')) && in_array($role->id, old('roles'))) selected @endif>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                        class="form-control" autofocus id="name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="useremail">{{ translate('email') }}</label>
                                    <input type="email" name="email" class="form-control" name="email"
                                        value="{{ old('email') }}" id="useremail"
                                        autocomplete="email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('profile picture') }}</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden
                                        name="avatar" value="{{ old('avatar') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="imgs mt-2 d-flex"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">{{ translate('phone') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">{{ translate('address') }}</label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">{{ translate('password') }}</label>
                                    <input type="password" class="form-control" name="password"
                                        autocomplete="new-password" id="userpassword">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userpassword">{{ translate('password confirmation') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="userconfirmpassword">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ translate('register') }}</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-info">{{ translate('back to employees') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
