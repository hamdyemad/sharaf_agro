@extends('layouts.master')

@section('title')
تعديل الرسالة
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الرسائل @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الرسائل @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('orders_under_work.index') }} @endslot
        @slot('li3') تعديل الرسالة @endslot
    @endcomponent
    <div class="create_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="{{ route('orders_under_work.update', $order) }}" method="POST" enctype="multipart/form-data">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6 categories_col">
                                <div class="form-group">
                                    <label for="country">الأقسام الرئيسية</label>
                                    <select class="form-control select2 select_main_category" name="category_id">
                                        <option value="">أختر</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if($order->category_id == $category->id) selected @endif>{{ $category->name }}</option>
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
                                    <input class="form-control" name="sender_name" value="{{ $order->sender_name }}" type="text">
                                    @error('sender_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">رقم الموبيل</label>
                                    <input class="form-control" name="sender_phone" value="{{ $order->sender_phone }}" type="text">
                                    @error('sender_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">أسم المركب</label>
                                    <input class="form-control" type="text" name="name" value="{{ $order->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">ملاحظات</label>
                                    <textarea class="form-control" name="details" cols="30" rows="10">{{ $order->details }}</textarea>
                                    @error('details')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">مرفقات</label>
                                    <input type="file" class="form-control input_files" multiple accept="application/pdf,image/*" hidden
                                        name="files[]" data-img="3" data-pdf="3">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="text-danger file_error pdf-error" hidden>يجب أختيار أقل من 3 من ملفات ال pdf</div>
                                    <div class="text-danger file_error img-error" hidden>يجب أختيار أقل من 3 من الصور</div>
                                    @error('files')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($order->files)
                                    <div class="current_files">
                                        <ul class="list-unstyled">
                                            @foreach (json_decode($order->files) as $file)
                                                <li class="mb-2 d-flex align-items-center">
                                                    <a class="mr-2" href="{{ asset($file) }}">{{ $file }}</a>
                                                    <button type="button" data-order_id="{{ $order->id }}" data-index="{{ $loop->index }}" class="remove_files btn-{{ $loop->index }} btn btn-danger rounded">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                    <a href="{{ route('orders_under_work.index') }}" class="btn btn-info">كل الرسائل</a>
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


        // Remove Files From Order
        $(".remove_files").on('click', function() {
            let index = $(this).data('index'),
            order_id = $(this).data('order_id');
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    index: index
                },
                'url' : `/orders_under_work/remove_files/` + order_id,
                'success': function(res) {
                    if(res.status) {
                        toastr.success(res.message);
                        $(`.btn-${index}`).parent().fadeOut(500);
                        setTimeout(() => {
                            $(`.btn-${index}`).parent().remove()
                        }, 500);
                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
        });

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
                            $(`.select_sub_categories option[value="{{ $order->sub_category_id }}"]`).attr('selected', '');
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
