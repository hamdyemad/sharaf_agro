@extends('layouts.master')

@section('title')
الحالات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الحالات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') الحالات @endslot
    @endcomponent
    <div class="all_statuses">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الحالات</h2>
                    @can('statuses.create')
                        <div>
                            <a href="{{ route('statuses.create') }}" class="btn btn-primary mb-2">أنشاء حالة جديد</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('statuses.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">أسم الحالة</label>
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
                                <th>أسم الحالة</th>
                                <th>الحالة الأفتراضية</th>
                                <th>وقت الأنشاء</th>
                                <th>وقت أخر تعديل</th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuses as $status)
                                <tr>
                                    <th scope="row">{{ $status->id }}</th>
                                    <td>{{ $status->name }}</td>
                                    <td>
                                        @if($status->default_val)
                                            <div class="badge badge-success">افتراضي</div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $status->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $status->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('statuses.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('statuses.edit', $status) }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>

                                            @endcan
                                            @can('statuses.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $status->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $status->id,
                                                'route' => route('statuses.destroy', $status->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $statuses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
