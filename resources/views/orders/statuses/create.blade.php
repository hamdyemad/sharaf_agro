@extends('layouts.master')

@section('title')
انشاء حالة جديدة
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') انشاء حالة جديدة @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') البلاد @endslot
        @slot('route2') {{ route('statuses.index') }} @endslot
        @slot('li3') انشاء حالة جديدة @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء حالة جديدة
                </div>
                <div class="card-body">
                    <form action="{{ route('statuses.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">أسم الحالة</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="الحالة الأفتراضية">الحالة الأفتراضية</label>
                                <div class="form-group">
                                    <input type="checkbox" name="default_val" id="switch4" switch="bool" />
                                    <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="أنشاء" class="btn btn-success">
                                    <a href="{{ route('statuses.index') }}" class="btn btn-info">رجوع الى الحالات</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
