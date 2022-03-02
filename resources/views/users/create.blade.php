@extends('layouts.master')

@section('title')
انشاء موظف جديد
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') انشاء موظف جديد @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') كل الموظفين @endslot
        @slot('route2') {{ route('users.index') }} @endslot
        @slot('li3') انشاء موظف جديد @endslot
    @endcomponent
    <div class="create_user">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء موظف جديد
                </div>
                <div class="card-body">
                    <form class="form-horizontal mt-4" method="POST" action="{{ route('users.store') }}"
                        enctype="multipart/form-data">
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        @csrf
                        <div class="row">
                            @if(Auth::user()->type == 'admin')
                                <div class="col-12 col-md-6 branch_col">
                                    <div class="form-group">
                                        <label for="branch_id">الفرع</label>
                                        <select class="form-control select2" name="branch_id">
                                            @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if (old('branch_id') ==  $branch->id) selected @endif>{{ $branch->name }}</option>
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
                            <div class="col-12 col-md-6 roles_col">
                                <div class="form-group">
                                    <label for="category">الصلاحيات</label>
                                    <select class="form-control select2 select2-multiple" name="roles[]"
                                        data-placeholder="أختر الصلاحيات" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @if (is_array(old('roles')) && in_array($role->id, old('roles'))) selected @endif>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الأسم</label>
                                    <input type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                        class="form-control" autofocus id="name" placeholder="ادخل الأسم">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="useremail">البريد الألكترونى</label>
                                    <input type="email" name="email" class="form-control" name="email"
                                        value="{{ old('email') }}" id="useremail" placeholder="أدخل البريد الألكترونى"
                                        autocomplete="email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الصورة الشخصية</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden
                                        name="avatar" value="{{ old('avatar') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="imgs mt-2 d-flex"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">الهاتف</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control" placeholder="أدخل الهاتف">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">العنوان</label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        class="form-control" placeholder="أدخل العنوان">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">الرقم السرى</label>
                                    <input type="password" class="form-control" name="password"
                                        autocomplete="new-password" id="userpassword" placeholder="ادخل الرقم السرى">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userpassword">اتمام الرقم السرى</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="userconfirmpassword" placeholder="اتمام الرقم السرى">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">تسجيل
                                        الحساب</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-info">الرجوع الى
                                        الموظفين</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
