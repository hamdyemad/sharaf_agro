@extends('layouts.master')

@section('title')
تعديل الحالة
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') تعديل الحالة @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') الحالات @endslot
        @slot('route2') {{ route('statuses.index') }} @endslot
        @slot('li3') تعديل الحالة @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل الحالة
                </div>
                <div class="card-body">
                    <form action="{{ route('statuses.update', $status) }}" method="POST">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">أسم الحالة</label>
                                    <input type="text" class="form-control" name="name" value="{{ $status->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="الحالة الأفتراضية">الحالة الأفتراضية</label>
                                <div class="form-group">
                                    <input type="checkbox" name="default_val" id="switch4" switch="bool"
                                        @if($status->default_val)
                                            checked
                                        @endif
                                    />
                                    <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
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
