@extends('layouts.master')

@section('title')
كل الرسائل
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') كل الرسائل @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الرسائل @endslot
    @endcomponent
    <div class="all_orders">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>كل الرسائل</h2>
                    @if(Auth::user()->type == 'user')
                        <div>
                            <a href="{{ route('orders_under_work.create') }}" class="btn btn-primary mb-2">انشاء رسالة</a>
                        </div>
                    @endif
                </div>
                <form action="{{ route('orders_under_work.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم المركب</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
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
                                <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th><span class="max">#</span></th>
                                <th><span class="max">الشركة</span></th>
                                <th><span class="max">أسم المركب</span></th>
                                <th><span class="max">تفاصيل المركب</span></th>
                                <th><span class="max">القسم</span></th>
                                <th><span class="max">الحالة</span></th>
                                <th><span class="max">السبب</span></th>
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
                                        @if(Auth::user()->type !== 'user' && Auth::user()->can('orders_under_work.update_status'))
                                            <select class="form-control change_status select2">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" @if($order->status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                        <div class="badge badge-primary">{{ $order->status->name }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <p>{{ $order->reason }}</p>
                                    </td>
                                    <td>
                                        <span class="max">{{ $order->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <span class="max">{{ $order->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            {{-- Status Change Modal --}}
                                            <div class="modal fade" id="modal_change_{{ $order->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                   تغيير الحالة
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('orders_under_work.update_status') }}" method="POST">
                                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                                <input type="hidden" name="page" value="{{ request('page') }}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <textarea class="form-control" name="reason" cols="30" rows="10" placeholder="السبب"></textarea>
                                                                    @error('reason')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
                                                                        <input type="submit" class="btn btn-danger" value="نعم">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(Auth::user()->can('orders_under_work.show') || Auth::user()->type == 'user')
                                                <a class="btn btn-success mr-1" href="{{ route('orders_under_work.show', $order) }}">
                                                    <span>اظهار</span>
                                                    <span class="mdi mdi-eye ml-1"></span>
                                                </a>
                                            @endif
                                            @can('orders_under_work.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('orders_under_work.edit', $order) }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline ml-1"></span>
                                                </a>
                                            @endcan
                                            @can('orders_under_work.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $order->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline ml-1"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $order->id,
                                                'route' => route('orders_under_work.destroy', $order->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
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

        @if(Session::has('error'))
            $(`#modal_change_${"{{ request('order_id') }}"} form`).append(`<input type="hidden" name="status_id" value="${"{{ Session::get('status_id') }}"}">`);
            $(`#modal_change_${"{{ request('order_id') }}"}`).modal();
        @endif

        $(".change_status").on('change', function () {
            let token = $("meta[name=_token]").attr('content'),
            order_id = $(this).parent().parent().attr('id'),
            user_id = "{{ Auth::id() }}",
            status_id = $(this).val();
            if(status_id == '5') {
                $(`#modal_change_${order_id} form`).append(`<input type="hidden" name="status_id" value="${status_id}">`);
                $(`#modal_change_${order_id}`).modal();
            } else {
                $("#preloader_all").removeClass('d-none');
                $.ajax({
                    "method": "POST",
                    "data": {
                        "_token": token,
                        "order_id" : order_id,
                        "ajax" : true,
                        "status_id": status_id
                    },
                    "url": "{{ route('orders_under_work.update_status') }}",
                    "success": function(res) {
                        console.log(res);
                        if(res.status) {
                            toastr.success(res.message);
                        }
                        $("#preloader_all").addClass('d-none');
                    },
                    "error": function(err) {
                        console.log(err);
                    }
                });
            }


        })
    </script>
@endsection
