@extends('layouts.master')

@section('title')
الصلاحيات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الصلاحيات  @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') الصلاحيات  @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>الصلاحيات </h2>
                @can('roles.create')
                    <div>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">انشاء صلاحية</a>
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
            @if($roles->count() > 0)
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><span class="max">أسم الصلاحية</span></th>
                            <th><span class="max">عدد الصلاحيات</span></th>
                            <th><span class="max">الموظفين المضاف لهم الصلاحية</span></th>
                            <th><span class="max">وقت الأنشاء</span></th>
                            <th><span class="max">وقت أخر تعديل</span></th>
                            <th><span class="max">الأعدادات</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $role->id }}</th>
                                <td><span class="max">{{ $role->name }}</span></td>
                                <td>{{ $role->permessions->count() }}</td>
                                <td>
                                    @forelse ($role->users->pluck('name') as $name)
                                        <span class="badge badge-primary d-block mb-1 p-2 font-size-14">{{ $name }}</span>
                                    @empty
                                        <div class="alert alert-info">لا يوجد موظفين مضافين</div>
                                    @endforelse
                                </td>
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
                {{ $roles->appends(request()->all())->links() }}
            @else
            <div class="alert alert-info">لا يوجد صلاحيات</div>
            @endif
        </div>
    </div>
@endsection
