@extends('layouts.master')

@section('title')
كل الأستفسارات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') كل الأستفسارات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الأستفسارات @endslot
    @endcomponent
    <div class="all_orders">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>كل الأستفسارات</h2>
                    @if(Auth::user()->type == 'user')
                        <div>
                            <a href="{{ route('inquires.create') }}" class="btn btn-primary mb-2">انشاء أستفسار</a>
                        </div>
                    @endif
                </div>
                <form action="{{ route('inquires.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الأستفسار</label>
                                <input class="form-control" name="details" type="text" value="{{ request('details') }}">
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
                                <th><span class="max">الأستفسار</span></th>
                                <th><span class="max">القسم</span></th>
                                <th><span class="max">الحالة</span></th>
                                <th><span class="max">وقت الأنشاء</span></th>
                                <th><span class="max">وقت أخر تعديل</span></th>
                                <th><span class="max">الأعدادات</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquires as $inquire)
                                <tr id="{{ $inquire->id }}" data-value="{{ $inquire }}">
                                    <td scope="row">{{ $inquire->id }}</td>
                                    <th><span class="max">{{ $inquire->customer->name }}</span></th>
                                    <td>
                                        @if(strlen($inquire->details) > 30)
                                            <p class="m-0">{{ mb_substr($inquire->details, 0, 30) . '...' }}</p>
                                        @else
                                        <p class="m-0">{{ $inquire->details }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <span>القسم الرئيسى: </span>
                                                <p>{{ $inquire->category->name }}</p>
                                            </li>
                                            @if($inquire->sub_category)
                                                <li>
                                                    <span>القسم الفرعى: </span>
                                                    <p>{{ $inquire->sub_category->name }}</p>
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                    <td>
                                        @if(Auth::user()->type !== 'user' && Auth::user()->can('inquires.update_status'))
                                            <select class="form-control change_status select2">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" @if($inquire->status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                        <div class="badge badge-primary">{{ $inquire->status->name }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="max">{{ $inquire->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <span class="max">{{ $inquire->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @if(Auth::user()->can('inquires.show') || Auth::user()->type == 'user')
                                                <a class="btn btn-success mr-1" href="{{ route('inquires.show', $inquire) . '?page=' . request('page') }}">
                                                    <span>اظهار</span>
                                                    <span class="mdi mdi-eye ml-1"></span>
                                                </a>
                                            @endif
                                            @can('inquires.show')
                                                <a class="btn btn-info mr-1" href="{{ route('inquires.edit', $inquire) . '?page=' . request('page') }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline ml-1"></span>
                                                </a>
                                            @endcan
                                            @can('inquires.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $inquire->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline ml-1"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $inquire->id,
                                                'route' => route('inquires.destroy', $inquire->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $inquires->links() }}
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
            order_id = $(this).parent().parent().attr('id'),
            user_id = "{{ Auth::id() }}",
            status_id = $(this).val();
            $("#preloader_all").removeClass('d-none');
            $.ajax({
                "method": "POST",
                "data": {
                    "_token": token,
                    "order_id" : order_id,
                    "status_id": status_id
                },
                "url": "{{ route('inquires.update_status') }}",
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


        })
    </script>
@endsection
