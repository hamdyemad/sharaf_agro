@extends('layouts.master')

@section('title')
انشاء قسم فرعى
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأقسام الفرعية @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأقسام الفرعية @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('sub_categories.index') }} @endslot
        @slot('li3') انشاء قسم فرعى @endslot
    @endcomponent
    <div class="create_category">
        <div class="card">
            <div class="card-header">
                انشاء قسم فرعى
            </div>
            <div class="card-body">
                <form action="{{ route('sub_categories.store') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">القسم الرئيسى</label>
                                <select name="category_id" class="form-control select2" id="">
                                    <option value="">أختر القسم</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="submit" value="انشاء" class="btn btn-success">
                                <a href="{{ route('sub_categories.index') }}" class="btn btn-info">الرجوع الى الأقسام الفرعية</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
