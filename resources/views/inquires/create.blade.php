@extends('layouts.master')

@section('title')
انشاء استفسار
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأستفسارات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأستفسارات @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('orders_under_work.index') }} @endslot
        @slot('li3') انشاء استفسار @endslot
    @endcomponent
    <div class="create_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h1>{{ auth()->user()->name }}</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('inquires.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6 categories_col">
                                <div class="form-group">
                                    <label for="country">الأقسام الرئيسية</label>
                                    <select class="form-control select2 select_main_category" name="category_id">
                                        <option value="">أختر</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
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
                                    <input class="form-control" name="sender_name" type="text">
                                    @error('sender_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer">رقم الموبيل</label>
                                    <input class="form-control" name="sender_phone" type="text">
                                    @error('sender_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="customer">الأستفسار</label>
                                    <textarea class="form-control" name="details" cols="30" rows="10">{{ old('details') }}</textarea>
                                    @error('details')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="انشاء" class="btn btn-success">
                                    <a href="{{ route('inquires.index') }}" class="btn btn-info">كل الأستفسارات</a>
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
                    <input class="form-control" type="date" name="submission_date">
                    @error('submission_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="submission">تاريخ متوقع</label>
                    <input class="form-control" type="date" name="expected_date"  min="{{ date("Y-m-d") }}">
                    @error('expected_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        `,
        completed_cols = `
            <div class="col-12">
                <div class="form-group">
                    <label for="submission">تاريخ الأنتهاء</label>
                    <input class="form-control" type="date" name="expiry_date">
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
