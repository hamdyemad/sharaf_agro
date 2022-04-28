@extends('layouts.master')


@section('title')
انشاء صلاحية
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') انشاء صلاحية @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') الصلاحيات @endslot
        @slot('route2') {{ route('roles.index') }} @endslot
        @slot('li3') انشاء صلاحية @endslot
    @endcomponent
    <div class="create_role">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء صلاحية
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">أسم الصلاحية</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <h2 class="alert alert-primary">الصلاحيات</h2>
                                    @error('permessions')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    @foreach ($permessions as $key => $value)
                                        <hr>
                                        <h2>{{ $key }}</h2>
                                        @foreach ($value as $permession)
                                            <div class="form-group d-flex">
                                                <label class="permession_label"
                                                    for="permession">{{ $permession->name }}</label>
                                                <div>
                                                    <input type="checkbox" name="permessions[]"
                                                        id="switch{{ $permession->id }}" switch="bool"
                                                        value="{{ $permession->id }}" />
                                                    <label for="switch{{ $permession->id }}" data-on-label="نعم"
                                                        data-off-label="لا"></label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="انشاء" class="btn btn-success">
                                    <a href="{{ route('roles.index') }}" class="btn btn-info">الرجوع الى الصلاحيات</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
