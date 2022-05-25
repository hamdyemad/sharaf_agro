@extends('layouts.master')

@section('title')
رصيد الشركات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') رصيد الشركات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') رصيد الشركات @endslot
    @endcomponent
    <div class="all_users">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>رصيد الشركات</h2>
                    @can('balances.create')
                        <div>
                            <a href="{{ route('balances.create') }}" class="btn btn-primary d-block d-md-flex mb-2">اضافة رصيد</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('balances.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="user_id">أسم الشركة</label>
                                <select class="form-control select2" name="user_id">
                                    <option value="">أختر</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @if(request('user_id') == $customer->id) selected @endif>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الرصيد</label>
                                <input class="form-control" name="balance" type="text" value="{{ request('balance') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                        <a class="btn btn-info mt-1" href="{{ route('balances.export', request()->all()) }}">تصدير ملف اكسل</a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($balances->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th><span class="max">أسم الشركة</span></th>
                                    <th><span class="max">رصيد الشركة</span></th>
                                    <th><span class="max">وقت أخر تعديل</span></th>
                                    <th><span class="max">الأعدادات</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($balances as $balance)
                                    <tr>
                                        <td><span class="max">{{ $balance->user->name }}</span></td>
                                        <td>{{ $balance->balance }}</td>
                                        <td>
                                            {{ $balance->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            {{ $balance->updated_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <div class="options d-flex">
                                                @can('balances.edit')
                                                    <a class="btn btn-info mr-1" href="{{ route('balances.edit', $balance) }}">
                                                        <span>تعديل</span>
                                                        <span class="mdi mdi-circle-edit-outline"></span>
                                                    </a>
                                                @endcan
                                                @can('balances.destroy')
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal_{{ $balance->id }}">
                                                        <span>ازالة</span>
                                                        <span class="mdi mdi-delete-outline"></span>
                                                    </button>
                                                    <!-- Modal -->
                                                    @include('layouts.partials.modal', [
                                                    'id' => $balance->id,
                                                    'route' => route('balances.destroy', $balance->id)
                                                    ])
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $balances->appends(request()->all())->links() }}
                    </div>
                @else
                <div class="alert alert-info">لا يوجد شركات</div>
                @endif
            </div>
        </div>
    </div>
@endsection
