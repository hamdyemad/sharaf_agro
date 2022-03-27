@extends('layouts.master')

@section('title')
{{ translate('edit permession') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $role->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('permessions') }} @endslot
        @slot('route2') {{ route('roles.index') }} @endslot
        @slot('li3') {{ $role->name }} @endslot
    @endcomponent
    <div class="create_role">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit permession') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ translate('permession name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $role->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <h2 class="alert alert-primary">{{ translate('permessions') }}</h2>
                                    @error('permessions')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    @foreach ($permessions as $key => $value)
                                        <hr>
                                        <h2>{{ $key }}</h2>
                                        @foreach ($value as $permession)
                                            <div class="form-group d-flex">
                                                <label class="permession_label"
                                                    for="permession">{{ $permession->name }}</label>
                                                <div>
                                                    <input type="checkbox" name="permessions[]"
                                                        id="switch{{ $permession->id }}" switch="bool"
                                                        value="{{ $permession->id }}" @if ($role->permessions->contains('id', $permession->id))
                                                    checked
                                        @endif
                                        />
                                        <label for="switch{{ $permession->id }}" data-on-label="{{ translate('yes') }}"
                                            data-off-label="{{ translate('no') }}"></label>
                                </div>
                            </div>
                            @endforeach
                            @endforeach
                        </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                        <a href="{{ route('roles.index') }}" class="btn btn-info">{{ translate('back to permessions') }}</a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
