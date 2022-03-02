@extends('layouts.master')

@section('title')
انشاء بلد جديدة
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') انشاء بلد جديدة @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') البلاد @endslot
        @slot('route2') {{ route('countries.index') }} @endslot
        @slot('li3') انشاء بلد جديدة @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء بلد جديدة
                </div>
                <div class="card-body">
                    <form action="{{ route('countries.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">أسم البلد</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">كود البلد</label>
                                    <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="ظهور">ظهور</label>
                                <div class="form-group">
                                    <input type="checkbox" name="active" id="switch4" switch="bool" checked
                                    />
                                    <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="انشاء" class="btn btn-success">
                                    <a href="{{ route('countries.index') }}" class="btn btn-info">رجوع الى البلاد</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
