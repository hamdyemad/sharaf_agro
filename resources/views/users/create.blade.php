@extends('layouts.master')

@section('title')
انشاء موظف
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') انشاء موظف @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') كل الموظفين @endslot
        @slot('route2') {{ route('users.index') }} @endslot
        @slot('li3') انشاء موظف @endslot
    @endcomponent
    <div class="create_user">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء موظف
                </div>
                <div class="card-body">
                    <form class="form-horizontal mt-4" method="POST" action="{{ route('users.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="category">الصلاحيات</label>
                                    <select class="form-control select2 select2-multiple" name="roles[]"
                                        data-placeholder="أختر" multiple>
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
                            <div class="col-12 col-md-6 categories_col">
                                <div class="form-group">
                                    <label for="category">الأقسام</label>
                                    <select class="form-control select2 select2-multiple select_main_category" name="categories[]"
                                        data-placeholder="أختر" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if (is_array(old('categories')) && in_array($category->id, old('categories'))) selected @endif>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 sub_categories_col">
                                <div class="form-group">
                                    <label class="sub_categories_label" for="sub_categories">الأقسام الفرعية</label>
                                    <select class="form-control select2 select_sub_categories" name="sub_categories[]" multiple>
                                        @if(old('categories'))
                                            @php
                                                $sub_categories = App\Models\SubCategory::whereIn('category_id',old('categories'))->get();
                                            @endphp
                                            @foreach ($sub_categories as $sub_category)
                                                <option value="{{ $sub_category->id }}" @if(old('sub_categories')) @if(in_array($sub_category->id,old('sub_categories'))) selected @endif @endif>{{ $sub_category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('sub_categories')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الأسم</label>
                                    <input type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                        class="form-control" autofocus id="name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">أسم المستخدم</label>
                                    <input type="text" name="username" value="{{ old('username') }}" autocomplete="username"
                                        class="form-control" autofocus id="username">
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">البريد الألكترونى</label>
                                    <input type="email" name="email" class="form-control" name="email"
                                        value="{{ old('email') }}" id="email"
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
                                    @error('avatar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">رقم التليفون (أختيارى)</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">العنوان (أختيارى)</label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">الرقم السرى</label>
                                    <input type="password" class="form-control" name="password"
                                        autocomplete="new-password" value="{{ old('password') }}" id="userpassword">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="userpassword">تأكيد الرقم السرى</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="userconfirmpassword" value="{{ old('password_confirmation') }}">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">تسجيل الحساب</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-info">الرجوع الى الموظفين</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
<script>

    function getSubCategoryById() {
        $(".select_main_category").on('change', function() {
            $(".select_sub_categories").select2().html('');
            let categories_ids = $(this).val();
            if(categories_ids.length !== 0) {
                getSubByCategoryIdAjax(categories_ids);
            }
        });
    }
    getSubCategoryById();

    function getSubByCategoryIdAjax(categories_ids) {
        $.ajax({
            'method': 'POST',
            'data': {
                '_token': token,
                categories_ids: categories_ids,
            },
            'url' : `{{ route('sub_categories.all') }}`,
            'success': function(res) {
                if(res.status) {
                    res.data.forEach((obj) => {
                        $(".select_sub_categories").append(`<option value="${obj.id}">${obj.name}</option>`);
                    });
                }
            },
            'erorr' : function(err) {
                console.log(err);
            }
        });
    }
</script>
@endsection
