@extends('layouts.master')


@section('title')
الأصناف
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأصناف @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الأصناف @endslot
    @endcomponent
    <div class="all_categories">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الأصناف</h2>
                    @can('categories.create')
                        <div>
                            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-2">أنشاء صنف جديد</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('categories.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">أسم الصنف</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        @if(Auth::user()->type == 'admin')
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="category">الفرع</label>
                                    <select class="form-control select2" name="branch_id">
                                        <option value="">أختر الفرع</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if (request('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name"></label>
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
                                <th>#</th>
                                <th>أسم الصنف</th>
                                <th>الفرع</th>
                                <th>عدد المنتجات</th>
                                <th>مرئى</th>
                                <th>رقم الظهور</th>
                                <th>وقت الأنشاء</th>
                                <th>وقت أخر تعديل</th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>
                                        <div>
                                            <span class="d-block">{{ $category->name }}</span>
                                            @if ($category->photo !== null)
                                                <img class="mt-2" src="{{ asset($category->photo) }}" alt="">
                                            @else
                                                <img class="mt-2" src="{{ asset('/images/product_avatar.png') }}"
                                                    alt="">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $category->branch->name }}</td>
                                    <td>
                                        <a
                                            href="{{ route('products.index', ['category_id' => $category->id]) }}">{{ $category->products->count() }}</a>
                                    </td>
                                    <td>
                                        @if($category->active)
                                            <div class="badge badge-success font-size-14 p-2">مرئى</div>
                                        @else
                                        <div class="badge badge-danger">غير مرئى</div>
                                        @endif
                                    </td>
                                    <td>{{ $category->viewed_number }}</td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                    <td>{{ $category->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('categories.show')
                                                <a class="btn btn-success mr-1"
                                                    href="{{ route('categories.show', $category) }}">
                                                    <span>اظهار</span>
                                                    <span class="mdi mdi-eye"></span>
                                                </a>
                                            @endcan
                                            @can('categories.edit')
                                                <a class="btn btn-info mr-1"
                                                    href="{{ route('categories.edit', $category) }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>
                                            @endcan
                                            @can('categories.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $category->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $category->id,
                                                'route' => route('categories.destroy', $category->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
