@extends('layouts.master')

@section('title')
تعديل الطلب
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الطلبات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الطلبات @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('orders.index') }} @endslot
        @slot('li3') تعديل الطلب @endslot
    @endcomponent
    <div class="create_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل الطلب
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            @if(Auth::user()->type == 'admin')
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
                            @else
                                <div class="col-12 col-md-6 categories_col">
                                    <div class="form-group">
                                        <label for="country">الأقسام الرئيسية</label>
                                        <select class="form-control select2 select_main_category" name="category_id">
                                            <option value="">أختر</option>
                                            @foreach ($userCategories as $userCategory)
                                            <option value="{{ $userCategory->category_id }}" @if($order->category_id == $userCategory->category_id) selected @endif>{{ $userCategory->category->name }}</option>
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
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">الشركة</label>
                                    <select class="form-control select2" name="customer_id">
                                        <option value="">أختر</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" @if($order->customer_id == $customer->id) selected @endif>{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">حالة الطلب</label>
                                    <select class="form-control select2 status_select" name="status_id">
                                        <option value="">أختر</option>
                                        @foreach ($statuses as $status)
                                            <option data-name="{{ $status->name }}" value="{{ $status->id }}" @if(old('status_id')) @if(old('status_id') == $status->id) selected @endif @else @if($status->id == $order->status_id) selected  @endif @endif>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
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
                                    <label for="customer">تفاصيل المركب</label>
                                    <div>
                                        <input type="checkbox" name="show_details" id="switch1" switch="none" @if($order->show_details) checked @endif />
                                        <label for="switch1" data-on-label="ظهور" data-off-label="اخفاء"></label>
                                    </div>
                                    <textarea class="form-control" name="details" cols="30" rows="10">{{ $order->details }}</textarea>
                                    @error('details')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 addition_cols @if($order->status_id == 1) d-none @endif">
                                <div class="card card_status">
                                    <div class="card-header"></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">مرفقات</label>
                                                    <input type="file" class="form-control input_files" multiple accept="application/pdf,image/*" hidden
                                                        name="files[]" data-img="3" data-pdf="3">
                                                    <button type="button" class="btn btn-primary form-control files">
                                                        <span class="mdi mdi-plus btn-lg"></span>
                                                    </button>
                                                    <div class="alert alert-secondary mt-1">( يمكن إضافة 3 صور او3 ملفات PDF بحد اقصي 2 ميجا بايت/ملف)</div>
                                                    <div class="text-danger file_error pdf-error" hidden>يجب أختيار أقل من 3 من ملفات ال pdf</div>
                                                    <div class="text-danger file_error img-error" hidden>يجب أختيار أقل من 3 من الصور</div>
                                                    @error('files')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
                                            </div>
                                            {{-- Addition --}}
                                            <div class="row w-100 addition"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                    <a href="{{ route('orders.index') }}" class="btn btn-info">كل الطلبات</a>
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
        let submitted_cols = `
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="submission">تاريخ التقديم</label>
                    <input class="form-control" value="{{ $order->submission_date }}" type="date" name="submission_date">
                    @error('submission_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="submission">تاريخ متوقع</label>
                    <input class="form-control" type="date" value="{{ $order->expected_date }}" name="expected_date"  min="{{ date("Y-m-d") }}">
                    @error('expected_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        `,
        completed_cols = `
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="submission"> تاريخ ارسال التنبيه بالتجديدات (أختيارى)</label>
                    <input class="form-control" value="{{ $order->expiry_date_notify }}"  type="date" name="expiry_date_notify">
                    @error('expiry_date_notify')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="submission">تاريخ الأنتهاء (أختيارى)</label>
                    <input class="form-control" type="date" value="{{ $order->expiry_date }}" name="expiry_date">
                    @error('expiry_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        `;



        // Text it with current selected status
        $(".addition_cols .card-header").text($(".status_select option:selected").data('name'));

        $(".status_select").on('change', function() {
            $('.addition').empty();
            let statusName = $(this).find('option:selected').data('name');
            if(statusName == 'تحت الأنشاء') {
                $(".addition_cols").addClass('d-none');
            } else {
                $(".addition_cols").removeClass('d-none');
            }
            $(".card_status .card-header").text(statusName);
            if(statusName == 'تم التقديم') {
                $('.addition').append(submitted_cols);
            } else if(statusName == 'مكتمل') {
                $('.addition').append(completed_cols);
            }
        });

        if($(".status_select option:selected").data('name') == 'تحت الأنشاء') {
            $(".addition_cols").addClass('d-none');
        } else {
            $(".addition_cols").removeClass('d-none');
        }
        if($(".status_select option:selected").data('name') == 'تم التقديم') {
            $('.addition').append(submitted_cols);
        }
        if($(".status_select option:selected").data('name') == 'مكتمل') {
            $('.addition').append(completed_cols);
        }


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
                'url' : `/orders/remove_files/` + order_id,
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
