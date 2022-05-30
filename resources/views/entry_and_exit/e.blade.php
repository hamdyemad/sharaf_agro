@extends('layouts.master')


@section('title')
تاريخ الحضور والأنصراف
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') تاريخ الحضور والأنصراف @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل تاريخ الحضور والأنصراف @endslot
    @endcomponent
    <div class="all_entries_and_exits">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>تاريخ الحضور والأنصراف</h2>
                    @if(Auth::user()->type == 'admin')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#test">
                            test modal
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                ...
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endif
                </div>
                <form action="{{ route('entry_and_exit.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الموظف</label>
                                <select class="form-control select2" name="user_id">
                                    <option value="">أختر</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if ($user->id == request('user_id')) selected @endif>
                                            {{ $user->name }}
                                        </option>
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
                                <select class="form-control select2 select_sub_categories" value="{{ request('sub_category_id') }}" name="sub_category_id"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">بحث مخصص</label>
                                <select class="form-control select2" name="extras">
                                    <option value="">أختر</option>
                                    <option value="late" @if(request('extras') == 'late') selected @endif>التأخيرات</option>
                                    <option value="extra_time" @if(request('extras') == 'extra_time') selected @endif>الوقت الأضافى</option>
                                    <option value="delay_allowed" @if(request('extras') == 'delay_allowed') selected @endif>السماح</option>
                                </select>
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
                            <a class="btn btn-info mt-1" href="{{ route('entry_and_exit.export', request()->all()) }}">تصدير ملف اكسل</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($entriesAndExits->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span class="max">نوع العملية</span></th>
                                    <th><span class="max">أسم الموظف</span></th>
                                    <th><span class="max">وقت الدخول</span></th>
                                    <th><span class="max">وقت الأنصراف</span></th>
                                    <th><span class="max">موقع العملية</span></th>
                                    <th><span class="max">تاريخ العملية</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entriesAndExits as $entryAndExit)
                                    @php
                                        $entryTimeStamp = strtotime($entryAndExit['entry']);
                                        $exitTimeStamp = strtotime($entryAndExit['exit']);

                                        $enterSetting = strtotime(new Carbon\Carbon($entryAndExit['current_date'] . ' ' . get_setting('entry')));

                                        $exitSetting = strtotime(new Carbon\Carbon($entryAndExit['current_date'] . ' ' . get_setting('exit')));
                                        $delayAllowedSetting = strtotime(new Carbon\Carbon($entryAndExit['current_date'] . ' ' . get_setting('delay_allowed')));
                                    @endphp
                                    <tr class="
                                    @if($entryAndExit['is_enter'])
                                        @if($delayAllowedSetting)
                                            @if($entryTimeStamp <= $delayAllowedSetting && $entryTimeStamp > $enterSetting) bg-info @endif
                                            @if($entryTimeStamp > $delayAllowedSetting && $entryTimeStamp > $enterSetting) bg-danger @endif
                                        @else
                                            @if($entryTimeStamp > $enterSetting) bg-danger @endif
                                        @endif
                                    @endif
                                    @if($entryAndExit['is_exit'])
                                        @if($exitTimeStamp < $exitSetting) bg-danger @endif
                                        @if($exitTimeStamp > $exitSetting) bg-success @endif
                                    @endif
                                    ">
                                        <td scope="row">{{ $entryAndExit['id'] }}</td>
                                        <td scope="row">
                                            @if ($entryAndExit['is_enter'])
                                                حضور
                                            @endif
                                            @if ($entryAndExit['is_exit'])
                                                أنصراف
                                            @endif
                                        </td>
                                        <td scope="row">
                                            @if(request('extras'))
                                                {{ \App\User::find($entryAndExit['user_id'])->name }}
                                            @else
                                                {{ $entryAndExit->user->name }}
                                            @endif
                                        </td>
                                        <td scope="row">
                                            @if($entryAndExit['entry'])
                                                {{ Carbon\Carbon::createFromDate($entryAndExit['entry'])->format('g:i A') }}
                                            @endif
                                        </td>
                                        <td scope="row">
                                            @if($entryAndExit['exit'])
                                                {{ Carbon\Carbon::createFromDate($entryAndExit['exit'])->format('g:i A') }}
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ $entryAndExit['latitude'] }}%2C{{ $entryAndExit['longitude'] }}">الموقع</a>
                                        </td>
                                        <td>
                                            {{ $entryAndExit['current_date'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $entriesAndExits->appends(request()->all())->links() }}
                    </div>
                @else
                    <div class="alert alert-info">لا يوجد حضور او انصراف</div>
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
    </script>
@endsection
