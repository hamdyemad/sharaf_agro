@extends('layouts.master')

@section('title')
انشاء شركة
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') انشاء رصيد @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') كل الأرصدة @endslot
        @slot('route2') {{ route('balances.index') }} @endslot
        @slot('li3') انشاء رصيد @endslot
    @endcomponent
    <div class="create_user">
        <div class="card">
            <div class="card-header">
                انشاء رصيد
            </div>
            <div class="card-body">
                <form class="form-horizontal mt-4" method="POST" action="{{ route('balances.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="user_id">أسم الشركة</label>
                                <select class="form-control select2" name="user_id">
                                    <option value="">أختر</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @if(old('user_id') == $customer->id) selected @endif>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">رصيد الشركة</label>
                                <input class="form-control" type="text" value="{{ old('balance') }}" name="balance">
                                @error('balance')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">انشاء الرصيد</button>
                                <a href="{{ route('balances.index') }}" class="btn btn-info">الرجوع الى الأرصدة</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
