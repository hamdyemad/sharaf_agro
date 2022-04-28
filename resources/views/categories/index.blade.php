@extends('layouts.master')


@section('title')
الأقسام الرئيسية
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأقسام الرئيسية @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الأقسام الرئيسية @endslot
    @endcomponent
    <div class="all_categories">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الأقسام الرئيسية</h2>
                    @can('categories.create')
                        <div>
                            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-2">انشاء قسم رئيسى</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('categories.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم القسم</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name"></label>
                                <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span class="max">أسم القسم</span></th>
                                    <th><span class="max">عدد الأقسام الفرعية</span></th>
                                    <th><span class="max">وقت الأنشاء</span></th>
                                    <th><span class="max">وقت أخر تعديل</span></th>
                                    <th><span class="max">الأعدادات</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <th scope="row">{{ $category->id }}</th>
                                        <td><span class="max">{{ $category->name }}</span></td>
                                        <td><a class="btn btn-primary" href="{{ route('sub_categories.index', ['category_id' => $category->id]) }}">{{ $category->sub_categories->count() }}</a></td>
                                        <td>{{ $category->created_at->diffForHumans() }}</td>
                                        <td>{{ $category->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="options d-flex">
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
                @else
                    <div class="alert alert-info">لا يوجد أقسام</div>
                @endif
            </div>
        </div>
    </div>

@endsection
