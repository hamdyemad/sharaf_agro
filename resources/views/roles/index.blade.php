@extends('layouts.master')

@section('title')
الصلاحيات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الصلاحيات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') الصلاحيات @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>الصلاحيات</h2>
                @can('roles.create')
                    <div>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">أنشاء صلاحية</a>
                    </div>
                @endcan
            </div>
            <form action="{{ route('roles.index') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">أسم الصلاحية</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
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
                            <th>أسم الصلاحية</th>
                            <th>عدد الصلاحيات</th>
                            <th>وقت الأنشاء</th>
                            <th>وقت أخر تعديل</th>
                            <th>الأعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->permessions->count() }}</td>
                                <td>
                                    {{ $role->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $role->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('roles.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('roles.edit', $role) }}">
                                                <span>تعديل</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('roles.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $role->id }}">
                                                <span>ازالة</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $role->id,
                                            'route' => route('roles.destroy', $role->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection
