@extends('layouts.master')


@section('title')
الأقسام الفرعية
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأقسام الفرعية @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الأقسام الفرعية @endslot
    @endcomponent
    <div class="all_sub_categories">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الأقسام الفرعية</h2>
                    @can('categories.create')
                        <div>
                            <a href="{{ route('sub_categories.create') }}" class="btn btn-primary mb-2">انشاء قسم فرعى</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('sub_categories.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم القسم</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">القسم الرئيسى</label>
                                <select name="category_id" class="form-control select2" id="">
                                    <option value="">أختر القسم</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
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
                @if($sub_categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span class="max">أسم القسم</span></th>
                                    <th><span class="max">القسم الرئيسى</span></th>
                                    <th><span class="max">وقت الأنشاء</span></th>
                                    <th><span class="max">وقت أخر تعديل</span></th>
                                    <th><span class="max">الأعدادات</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub_categories as $sub_category)
                                    <tr>
                                        <th scope="row">{{ $sub_category->id }}</th>
                                        <td><span class="max">{{ $sub_category->name }}</span></td>
                                        <td><span class="max">{{ $sub_category->category->name }}</span></td>
                                        <td>{{ $sub_category->created_at->diffForHumans() }}</td>
                                        <td>{{ $sub_category->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="options d-flex">
                                                @can('categories.edit')
                                                    <a class="btn btn-info mr-1"
                                                        href="{{ route('sub_categories.edit', $sub_category) }}">
                                                        <span>تعديل</span>
                                                        <span class="mdi mdi-circle-edit-outline"></span>
                                                    </a>
                                                @endcan
                                                @can('categories.destroy')
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal_{{ $sub_category->id }}">
                                                        <span>ازالة</span>
                                                        <span class="mdi mdi-delete-outline"></span>
                                                    </button>
                                                    <!-- Modal -->
                                                    @include('layouts.partials.modal', [
                                                    'id' => $sub_category->id,
                                                    'route' => route('sub_categories.destroy', $sub_category->id)
                                                    ])
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $sub_categories->appends(request()->all())->links() }}
                    </div>
                @else
                    <div class="alert alert-info">لا يوجد أقسام</div>
                @endif
            </div>
        </div>
    </div>

@endsection
