@extends('layouts.master')

@section('title')
تعديل الأستفسار
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأستفسارات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأستفسارات @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('orders.index') }} @endslot
        @slot('li3') تعديل الأستفسار @endslot
    @endcomponent
    <div class="create_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل الأستفسار
                </div>
                <div class="card-body">
                    <form action="{{ route('inquires.update', $inquire) }}" method="POST" enctype="multipart/form-data">
                        @method("PATCH")
                        @csrf
                        <input type="hidden" name="page" value="{{ request('page') }}">
                        <div class="row">
                            <div class="col-12 col-md-6 categories_col">
                                <div class="form-group">
                                    <label for="country">الأقسام الرئيسية</label>
                                    <select class="form-control select2 select_main_category" name="category_id">
                                        <option value="">أختر</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if($inquire->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 sub_categories_col">
                                <div class="form-group">
                                    <label for="country">الأقسام الفرعية</label>
                                    <select class="form-control select2 select_sub_categories" name="sub_category_id"></select>
                                    @error('sub_category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">أسم الراسل</label>
                                    <input class="form-control" name="sender_name" value="{{ $inquire->sender_name }}" type="text">
                                    @error('sender_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">رقم الموبيل</label>
                                    <input class="form-control" name="sender_phone" value="{{ $inquire->sender_phone }}" type="text">
                                    @error('sender_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                    <a href="{{ route('inquires.index') }}" class="btn btn-info">كل الأستفسارت</a>
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
        let categories_ids = [];
        function getSubCategoryById() {
            $(".select_main_category").on('change', function() {
                $(".select_sub_categories").select2().html('');
                categories_ids.push($(this).val());
                if(categories_ids.length !== 0) {
                    getSubByCategoryIdAjax(categories_ids);
                }
                categories_ids = [];
            });
        }
        getSubCategoryById();

        // if the select has value without change
        if($(".select_main_category").val()) {
            categories_ids.push($(".select_main_category").val());
            if(categories_ids.length !== 0) {
                getSubByCategoryIdAjax(categories_ids);
            }
            categories_ids = [];
        }

        function getSubByCategoryIdAjax(categories_ids) {
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    categories_ids: categories_ids,
                    all: true
                },
                'url' : `{{ route('sub_categories.all') }}`,
                'success': function(res) {
                    if(res.status) {
                        res.data.forEach((obj) => {
                            $(".select_sub_categories").append(`<option value="${obj.id}">${obj.name}</option>`);
                            $(`.select_sub_categories option[value="{{ $inquire->sub_category_id }}"]`).attr('selected', '');
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
