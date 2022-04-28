@extends('layouts.master')

@section('title')
تعديل القسم الرئيسى
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $category->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأقسام الرئيسية @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('categories.index') }} @endslot
        @slot('li3') {{ $category->name }} @endslot
    @endcomponent
    <div class="edit_category">
        <div class="card">
            <div class="card-header">
                تعديل القسم الرئيسى
            </div>
            <div class="card-body">
                <form action="{{ route('categories.update', $category) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم القسم</label>
                                <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="submit" value="تعديل" class="btn btn-success">
                                <a href="{{ route('categories.index') }}" class="btn btn-info">الرجوع الى الأقسام الرئيسية</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
