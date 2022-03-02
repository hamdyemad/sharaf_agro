@extends('layouts.master')
@section('title')
المعاملات المالية
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') المعاملات المالية @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل المعاملات المالية @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column-reverse flex-md-row justify-content-between">
                <h2>المعاملات المالية</h2>
                @can('business.create')
                    <a href="{{ route('business.create') }}" class="btn btn-primary mb-2">انشاء معاملة مالية جديدة</a>
                @endcan
            </div>
            <form action="{{ route('business.index') }}" method="GET">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">أسم المعاملة</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="category">نوع المعاملة المالية</label>
                            <select class="form-control select2" name="type">
                                <option value="">أختر نوع المعاملة</option>
                                <option value="income" @if (request('type') == 'income') selected @endif>ايراد</option>
                                <option value="expense" @if (request('type') == 'expense') selected @endif>مصروف</option>
                            </select>
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
            <div class="table-responsive">
                <table class="table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>أسم المعاملة المالية</th>
                            <th>نوع المعاملة المالية</th>
                            <th>الفرع</th>
                            <th>وقت الأنشاء</th>
                            <th>وقت أخر تعديل</th>
                            <th>الأعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($businesses as $business)
                            <tr>
                                <th scope="row">{{ $business->id }}</th>
                                <td>{{ $business->name }}</td>
                                <td>
                                    @if ($business->type == 'expense')
                                        مصروف
                                    @elseif($business->type == 'income')
                                        ايراد
                                    @endif
                                </td>
                                <td>
                                    {{ $business->branch->name }}
                                </td>
                                <td>
                                    {{ $business->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $business->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('business.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('business.edit', $business) }}">
                                                <span>تعديل</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('business.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $business->id }}">
                                                <span>ازالة</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $business->id,
                                            'route' => route('business.destroy', $business->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $businesses->links() }}
            </div>
        </div>
    </div>
@endsection
