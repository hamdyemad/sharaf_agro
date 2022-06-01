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
                                <label for="name">أسم الراسل</label>
                                <input class="form-control" name="sender_name" type="text" value="{{ request('sender_name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">رقم موبيل الراسل</label>
                                <input class="form-control" name="sender_phone" type="text" value="{{ request('sender_phone') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الأستفسار</label>
                                <input class="form-control" name="details" type="text" value="{{ request('details') }}">
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
                        <div class="col-12 col-md-6">
                            <a class="btn btn-info mt-1" href="{{ route('inquires.export', request()->all()) }}">تصدير ملف اكسل</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-hover d-block overflow-auto mb-0">
                    <thead>
                        <tr>
                            <th><span class="max">#</span></th>
                            @if (Auth::user()->type == 'admin' || Auth::user()->can('inquires.show_histories'))
                                <th><span class="max">تاريخ التعديلات</span></th>
                            @endif
                            <th><span class="max">الشركة</span></th>
                            <th><span class="max">أسم الراسل</span></th>
                            <th><span class="max">رقم موبيل الراسل</span></th>
                            <th><span class="max">الأستفسار</span></th>
                            <th><span class="max">القسم</span></th>
                            <th><span class="max">رد على الأستفسار</span></th>
                            <th><span class="max">وقت الأنشاء</span></th>
                            <th><span class="max">وقت أخر تعديل</span></th>
                            <th><span class="max">الأعدادات</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquires as $inquire)
                            <tr id="{{ $inquire->id }}" data-value="{{ $inquire }}">
                                <td scope="row">{{ $inquire->id }}</td>
                                @if (Auth::user()->type == 'admin' || Auth::user()->can('inquires.show_histories'))
                                    <td scope="row">
                                        @if (count($inquire->histories) > 0)
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <td><span class="max font-weight-bold">من عدل على الطلب</span></td>
                                                        <td><span class="max font-weight-bold">التوقيت</span></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($inquire->histories()->latest()->get() as $history)
                                                        <tr>
                                                            <td><span class="max">{{ $history->user->name }}</span></td>
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
                                <th><span class="max">{{ $inquire->customer->name }}</span></th>
                                <th><span class="max">{{ $inquire->sender_name }}</span></th>
                                <th><span class="max">{{ $inquire->sender_phone }}</span></th>
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
                                    @if($inquire->reply)
                                        <span class="badge badge-secondary d-block">{{ $inquire->reply }}</span>
                                    @elseif(Auth::user()->type == 'admin' || Auth::user()->can('inquires.update_reply'))
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_change_{{ $inquire->id }}">
                                            أضافة رد
                                        </button>
                                        {{-- Status Change Modal --}}
                                        <div class="modal fade" id="modal_change_{{ $inquire->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                            اضافة رد
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('inquires.update', $inquire) }}" method="POST">
                                                            <input type="hidden" name="page" value="{{ request('page') }}">
                                                            <input type="hidden" name="add_reply" value="add_reply">
                                                            @method("PATCH")
                                                            @csrf
                                                            <div class="modal-body">
                                                                <textarea class="form-control" name="reply" cols="30" rows="10" placeholder="السبب"></textarea>
                                                                @error('reply')
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
                                    @else
                                    <span class="max">لا يوجد رد حتى الأن</span>
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
                {{ $inquires->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>

        @if(Session::has('error'))
            $(`#modal_change_${"{{ request('inquire_id') }}"}`).modal();
        @endif

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


        @if(Session::has('error'))
            $(`#modal_change_${"{{ request('order_id') }}"} form`).append(`<input type="hidden" name="status_id" value="${"{{ Session::get('status_id') }}"}">`);
            $(`#modal_change_${"{{ request('order_id') }}"}`).modal();
        @endif
    </script>
@endsection
