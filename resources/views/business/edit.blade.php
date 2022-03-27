@extends('layouts.master')

@section('title')
{{ translate('edit financial transactions') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $business->name }} @endslot
        @slot('li1') {{ translate('dashboard') }}@endslot
        @slot('li2') {{ translate('financial transactions') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('business.index') }} @endslot
        @slot('li3') {{ $business->name }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit financial transactions') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('business.update', $business) }}" method="POST">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('financial name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $business->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="category">{{ translate('financial type') }}</label>
                                    <select class="form-control select2" name="type">
                                        <option value="">{{ translate('choose') }}</option>
                                        <option value="income" @if ($business->type == 'income') selected @endif>{{ translate('income') }}</option>
                                        <option value="expense" @if ($business->type == 'expense') selected @endif>{{ translate('expenses') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->type == 'admin')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="category">{{ translate('the branch') }}</label>
                                        <select class="form-control select2" name="branch_id">
                                            <option value="">{{ translate('choose') }}</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if ($business->branch_id == $branch->id) selected @endif>{{ $branch->name }}</option>
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
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                                    <a href="{{ route('business.index') }}" class="btn btn-info">{{ translate('back to financial transactions') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
