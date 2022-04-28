@extends('layouts.master')

@section('title')
انشاء قسم رئيسى
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأقسام الرئيسية @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأقسام الرئيسية @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('categories.index') }} @endslot
        @slot('li3') انشاء قسم رئيسى @endslot
    @endcomponent
    <div class="create_category">
        <div class="card">
            <div class="card-header">
                انشاء قسم رئيسى
            </div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم القسم</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="submit" value="انشاء" class="btn btn-success">
                                <a href="{{ route('categories.index') }}" class="btn btn-info">الرجوع الى الأقسام الرئيسية</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
