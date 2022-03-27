@extends('layouts.master')

@section('title')
{{ $business->name }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $business->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('financial transactions') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('business.index') }} @endslot
        @slot('li3') {{ translate('edit') }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('expenses.update', $expense) }}" method="POST">
                        <input type="text" name="type" hidden value="{{ request('type') }}">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    @if ($business->type == 'income')
                                        <label for="name">{{ translate('income name') }}</label>
                                    @else
                                        <label for="name">{{ translate('expenses name') }}</label>
                                    @endif
                                    <input type="text" class="form-control" name="name" value="{{ $expense->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    @if ($business->type == 'income')
                                        <label for="name">{{ translate("incomes owner's name") }}</label>
                                    @else
                                        <label for="name">{{ translate("expenses owner's name") }}</label>
                                    @endif
                                    <input type="text" class="form-control" name="expense_for"
                                        value="{{ $expense->expense_for }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone">{{ translate("the phone") }}</label>
                                    <input type="number" class="form-control" name="phone"
                                        value="{{ $expense->phone }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="price">{{ translate("the amount") }}</label>
                                    <input type="text" class="form-control" name="price" value="{{ $expense->price }}">
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="notes">{{ translate("the notes") }}</label>
                                    <textarea id="textarea" class="form-control" name="notes" maxlength="225"
                                        rows="3">{{ $expense->notes }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate("edit") }}" class="btn btn-success">
                                    <a href="{{ route('expenses.index', ['type' => request('type')]) }}"
                                        class="btn btn-info">
                                        {{ translate("back to") }} {{ $business->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
