@extends('layouts.master')

@section('title')
الفروع
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الفروع @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') الفروع @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>الفروع</h2>
                @can('branches.create')
                    <div>
                        <a href="{{ route('branches.create') }}" class="btn btn-primary mb-2">أنشاء فرع جديد</a>
                    </div>
                @endcan
            </div>
            <form action="{{ route('branches.index') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">أسم الفرع</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">رقم الفرع</label>
                            <input class="form-control" name="phone" type="text" value="{{ request('phone') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">عنوان الفرع</label>
                            <input class="form-control" name="address" type="text" value="{{ request('address') }}">
                        </div>
                    </div>
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
                            <th>أسم الفرع</th>
                            <th>عنوان الفرع</th>
                            <th>رقم الفرع</th>
                            <th>وقت الأنشاء</th>
                            <th>وقت أخر تعديل</th>
                            <th>الأعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $branch)
                            <tr>
                                <th scope="row">{{ $branch->id }}</th>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->address }}</td>
                                <td>{{ $branch->phone }}</td>
                                <td>
                                    {{ $branch->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $branch->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('branches.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('branches.edit', $branch) }}">
                                                <span>تعديل</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>

                                        @endcan
                                        @can('branches.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $branch->id }}">
                                                <span>ازالة</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $branch->id,
                                            'route' => route('branches.destroy', $branch->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $branches->links() }}
            </div>
        </div>
    </div>
@endsection
