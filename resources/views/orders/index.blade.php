@extends('layouts.master')

@section('title')
كل الطلبات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') كل الطلبات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الطلبات @endslot
    @endcomponent
    <div class="all_orders">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>كل الطلبات</h2>
                    @can('orders.create')
                        <div>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary mb-2">انشاء طلب</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم المركب</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الشركة</label>
                                <select class="form-control select2" name="customer_id">
                                    <option value="">أختر</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @if ($customer->id == request('customer_id')) selected @endif>
                                            {{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(Auth::user()->type == 'admin')
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الموظف المختص</label>
                                    <select class="form-control select2" name="employee_id">
                                        <option value="">أختر</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" @if ($employee->id == request('employee_id')) selected @endif>
                                                {{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الحالة</label>
                                <select class="form-control select2" name="status_id">
                                    <option value="">أختر</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" @if ($status->id == request('status_id')) selected @endif>
                                            {{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الأقسام الرئيسية</label>
                                <select class="form-control select2 select_main_category" name="category_id">
                                    <option value="">أختر</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id == request('category_id')) selected @endif>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الأقسام الفرعية</label>
                                <select class="form-control select2 select_sub_categories" name="sub_category_id"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="from">من</label>
                                <input class="form-control" name="from" value="{{ request('from') }}"  type="date">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="to">الى</label>
                                <input class="form-control" name="to" value="{{ request('to') }}" type="date">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                @if(Auth::user()->type == 'user')
                                    <label for=""></label>
                                @endif
                                <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <a class="btn btn-info mt-1" href="{{ route('orders.export', request()->all()) }}">تصدير ملف اكسل</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th><span class="max">#</span></th>
                                    <th><span class="max">الشركة</span></th>
                                    <th><span class="max">أسم المركب</span></th>
                                    <th><span class="max">تفاصيل المركب</span></th>
                                    @if(Auth::user()->type == 'admin')
                                        <th><span class="max">الموظف المختص</span></th>
                                    @endif
                                    <th><span class="max">القسم</span></th>
                                    <th><span class="max">الحالة</span></th>
                                    <th><span class="max">التواريخ المضافة</span></th>
                                    <th><span class="max">وقت الأنشاء</span></th>
                                    <th><span class="max">وقت أخر تعديل</span></th>
                                    <th><span class="max">الأعدادات</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr id="{{ $order->id }}" data-value="{{ $order }}">
                                        <td scope="row">{{ $order->id }}</td>
                                        <th><span class="max">{{ $order->customer->name }}</span></th>
                                        <td><span class="max">{{ $order->name }}</span></td>
                                        <td>
                                            @if(strlen($order->details) > 30)
                                                <p class="m-0">{{ mb_substr($order->details, 0, 30) . '...' }}</p>
                                            @else
                                            <p class="m-0">{{ $order->details }}</p>
                                            @endif
                                        </td>
                                        @if(Auth::user()->type == 'admin')
                                            <td>
                                                <span class="max">{{ $order->employee->name }}</span>
                                            </td>
                                        @endif
                                        <td>
                                            <ul>
                                                <li>
                                                    <span>القسم الرئيسى: </span>
                                                    <p>{{ $order->category->name }}</p>
                                                </li>
                                                @if($order->sub_category)
                                                    <li>
                                                        <span>القسم الفرعى: </span>
                                                        <p>{{ $order->sub_category->name }}</p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td><span class="max badge badge-primary">{{ $order->status->name }}</span></td>
                                        <td>
                                            <ul>
                                                @if($order->submission_date)
                                                    <li>
                                                        <span>تاريخ التقديم: </span>
                                                        <p>{{ $order->submission_date }}</p>
                                                    </li>
                                                @endif
                                                @if($order->expected_date && Auth::user()->type !== 'user')
                                                    <li>
                                                        <span>تاريخ متوقع: </span>
                                                        <p>{{ $order->expected_date }}</p>
                                                    </li>
                                                @endif
                                                @if($order->expiry_date)
                                                    <li>
                                                        <span>تاريخ الأنتهاء: </span>
                                                        <p>{{ $order->expiry_date }}</p>
                                                    </li>
                                                @endif
                                                @if(Auth::user()->type !== 'user' && $order->expected_notify)
                                                    <li>
                                                        <span class="badge badge-success">تم ارسال تنبيه للموظف المختص</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="max">{{ $order->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            <span class="max">{{ $order->updated_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            <div class="options d-flex">
                                                @if(Auth::user()->type == 'user' || Auth::user()->can('orders.show'))
                                                    <a class="btn btn-success mr-1" href="{{ route('orders.show', $order) }}">
                                                        <span>اظهار</span>
                                                        <span class="mdi mdi-eye ml-1"></span>
                                                    </a>
                                                @endif
                                                @can('orders.edit')
                                                    <a class="btn btn-info mr-1" href="{{ route('orders.edit', $order) }}">
                                                        <span>تعديل</span>
                                                        <span class="mdi mdi-circle-edit-outline ml-1"></span>
                                                    </a>
                                                @endcan
                                                @can('orders.destroy')
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal_{{ $order->id }}">
                                                        <span>ازالة</span>
                                                        <span class="mdi mdi-delete-outline ml-1"></span>
                                                    </button>
                                                    <!-- Modal -->
                                                    @include('layouts.partials.modal', [
                                                    'id' => $order->id,
                                                    'route' => route('orders.destroy', $order->id)
                                                    ])
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="alert alert-info">لا يوجد طلبات حاليا</div>
                @endif
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
                        $(".select_sub_categories").append(`<option value="">أختر</option>`);
                        res.data.forEach((obj) => {
                            $(".select_sub_categories").append(`<option data-val="${obj.id}" value="${obj.id}">${obj.name}</option>`);
                            $(`.select_sub_categories option[value="{{ request('sub_category_id') }}"]`).attr('selected', '');
                        });
                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
        }

        // orderChannel.bind('App\\Events\\newOrder', function(data) {
        //     if(data) {
        //         if(data.order.branch_id == "{{ Auth::user()->branch_id }}" || "{{Auth::user()->type}}" == 'admin') {
        //             window.location.reload();
        //         }
        //     }
        // });

        // let statusChannel = pusher.subscribe('changeOrderStatus');
        // statusChannel.bind('App\\Events\\changeOrderStatus', function(data) {
        //     if(data) {
        //         if(data.order.branch_id == "{{ Auth::user()->branch_id }}") {
        //             window.location.reload();
        //         }
        //         // $(`#${data.order.id} .status`).select2("val", data.status_id);
        //     }
        // });

        // $(".status").on('change', function () {
        //     $("#preloader_all").removeClass('d-none');
        //     let token = $("meta[name=_token]").attr('content'),
        //     order_id = $(this).parent().parent().attr('id'),
        //     user_id = "{{ Auth::id() }}",
        //     status_id = $(this).val();
        //     $.ajax({
        //         "method": "POST",
        //         "data": {
        //             "_token": token,
        //             "order_id" : order_id,
        //             "user_id" : user_id,
        //             "status_id": status_id
        //         },
        //         "url": "{{ route('orders.status_update') }}",
        //         "success": function(data) {
        //             if(data.status) {
        //                 toastr.success(data.msg);
        //             }
        //             $("#preloader_all").addClass('d-none');
        //         },
        //         "error": function(err) {
        //             console.log(err);
        //         }
        //     })
        // })
    </script>
@endsection
