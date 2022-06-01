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
                        @if(Auth::user()->type !== 'user')
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
                        @endif
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
                    <table class="table d-block overflow-auto table-hover mb-0">
                        <thead>
                            <tr>
                                <th><span class="max">#</span></th>
                                <th><span class="max">الأعدادات</span></th>
                                <th><span class="max">الشركة</span></th>
                                <th><span class="max">أسم المركب</span></th>
                                <th><span class="max">الحالة</span></th>
                                @if(Auth::user()->type == 'admin')
                                <th><span class="max">انشاء بواسطة</span></th>
                                @endif
                                <th><span class="max">القسم</span></th>
                                <th><span class="max">تفاصيل المركب</span></th>
                                <th><span class="max">التواريخ المضافة</span></th>
                                @if (Auth::user()->type == 'admin' || Auth::user()->can('orders.show_histories'))
                                    <th><span class="max">تاريخ التعديلات</span></th>
                                @endif
                                <th><span class="max">وقت الأنشاء</span></th>
                                <th><span class="max">وقت أخر تعديل</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr class="table-tr" id="{{ $order->id }}" data-value="{{ $order }}">
                                <td scope="row">{{ $order->id }}</td>
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
                                    </div>
                                </td>
                                <th>
                                    <span class="max">{{ $order->customer->name }}</span>
                                </th>
                                <td><span class="max">{{ $order->name }}</span></td>
                                <td><span class="max badge badge-primary">{{ $order->status->name }}</span></td>
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
                                <td>
                                    @if(Auth::user()->type == 'user')
                                        @if ($order->show_details)
                                            @if(strlen($order->details) > 30)
                                                <p class="m-0">{{ mb_substr($order->details, 0, 30) . '...' }}</p>
                                            @else
                                                <p class="m-0">{{ $order->details }}</p>
                                            @endif
                                        @endif
                                    @endif
                                    @if (Auth::user()->type !== 'user')
                                        @if(strlen($order->details) > 30)
                                            <p class="m-0">{{ mb_substr($order->details, 0, 30) . '...' }}</p>
                                        @else
                                            <p class="m-0">{{ $order->details }}</p>
                                        @endif
                                    @endif
                                </td>
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
                                @if (Auth::user()->can('orders.show_histories'))
                                    <td scope="row">
                                        @if (count($order->histories) > 0)
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <td><span class="max font-weight-bold">من عدل على الطلب</span></td>
                                                        <td><span class="max font-weight-bold">الحالة</span></td>
                                                        <td><span class="max font-weight-bold">التوقيت</span></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->histories()->latest()->get() as $history)
                                                        <tr>
                                                            <td><span class="max">{{ $history->user->name }}</span></td>
                                                            <td><span class="max">{{ $history->status->name }}</span></td>
                                                            <td><span class="max">{{ $history->created_at }}</span></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <span class="max">لا يوجد تعديلات بعد</span>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <span class="max">{{ $order->created_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <span class="max">{{ $order->updated_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="10">
                                    {{ $orders->appends(request()->all())->links() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">لا يوجد طلبات حاليا</div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>

        $(".table-tr").on('dblclick', function() {
            location.href = '/orders/show/' + $(this).attr('id');
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
    </script>
@endsection
