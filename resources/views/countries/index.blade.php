@extends('layouts.master')

@section('title')
البلاد
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') البلاد @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') البلاد @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>البلاد</h2>
                @can('countries.create')
                    <div>
                        <a href="{{ route('countries.create') }}" class="btn btn-primary mb-2">أنشاء بلد جديدة</a>
                    </div>
                @endcan
            </div>
            <form action="{{ route('countries.index') }}" method="GET">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label for="name">أسم البلد</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label for="name">كود البلد</label>
                            <input class="form-control" name="code" type="text" value="{{ request('code') }}">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label for="category">مرئى ام لا</label>
                            <select class="form-control select2" name="active">
                                <option value="">أختر</option>
                                <option @if(request('active') == 'true') selected @endif value="true">مرئى</option>
                                <option @if(request('active') == 'false') selected @endif value="false">غير مرئى</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
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
                            <th>أسم البلد</th>
                            <th>كود البلد</th>
                            <th>عدد المدن</th>
                            <th>مرئى</th>
                            <th>وقت الأنشاء</th>
                            <th>وقت أخر تعديل</th>
                            <th>الأعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <th scope="row">{{ $country->id }}</th>
                                <td>
                                    <a
                                        href="{{ route('countries.cities.index', $country->id) }}">{{ $country->name }}</a>
                                </td>
                                <td>{{ $country->code }}</td>
                                <td>{{ $country->cities->count() }}</td>
                                <td>
                                    @if ($country->active)
                                        <span class="badge badge-success">مرئى</span>
                                    @else
                                        <span class="badge badge-danger">غير مرئى</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $country->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $country->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('countries.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('countries.edit', $country) }}">
                                                <span>تعديل</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('countries.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $country->id }}">
                                                <span>ازالة</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $country->id,
                                            'route' => route('countries.destroy', $country->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $countries->links() }}
            </div>
        </div>
    </div>
@endsection
