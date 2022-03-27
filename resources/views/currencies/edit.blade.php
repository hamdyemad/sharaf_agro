@extends('layouts.master')


@section('title')
{{ translate('edit branches') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('branches') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('branches') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('branches.index') }} @endslot
        @slot('li3') {{ translate('edit branches') }} @endslot
    @endcomponent
    <div class="edit">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit branches') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('branches.update', $branch) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('branch name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $branch->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone">{{ translate('branch phone') }}</label>
                                    <input type="number" class="form-control" name="phone" value="{{ $branch->phone }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">{{ translate('branch address') }}</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ $branch->address }}">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                                    <a href="{{ route('branches.index') }}" class="btn btn-info">{{ translate('back to branches') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
