@extends('layouts.master')

@section('title')
تنبيهات الطلبات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') تنبيهات الطلبات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') تنبيهات الطلبات @endslot
    @endcomponent
    <div class="all_orders">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>تنبيهات الطلبات</h2>
                </div>
            </div>
            <div class="card-body">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th><span class="max">#</span></th>
                                    <th><span class="max">الحالة</span></th>
                                    <th><span class="max">التواريخ المضافة</span></th>
                                    <th><span class="max">الشركة</span></th>
                                    @if(Auth::user()->type == 'admin')
                                        <th><span class="max">الموظف المختص</span></th>
                                    @endif
                                    <th><span class="max">أسم المركب</span></th>
                                    <th><span class="max">القسم</span></th>
                                    <th><span class="max">وقت الأنشاء</span></th>
                                    <th><span class="max">وقت أخر تعديل</span></th>
                                    <th><span class="max">الأعدادات</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr id="{{ $order->id }}" data-value="{{ $order }}">
                                        <td scope="row">{{ $order->id }}</td>
                                        <td><span class="max badge badge-primary">{{ $order->status->name }}</span></td>
                                        <td>
                                            <ul>
                                                @if($order->submission_date)
                                                    <li>
                                                        <span>تاريخ التقديم: </span>
                                                        <p>{{ $order->submission_date }}</p>
                                                    </li>
                                                @endif
                                                @if($order->expected_date && Auth::user()->type !== 'user')
                                                    <li>
                                                        <span>تاريخ متوقع: </span>
                                                        <p>{{ $order->expected_date }}</p>
                                                    </li>
                                                @endif
                                                @if($order->expiry_date)
                                                    <li>
                                                        <span>تاريخ الأنتهاء: </span>
                                                        <p>{{ $order->expiry_date }}</p>
                                                    </li>
                                                @endif
                                                @if(Auth::user()->type !== 'user' && $order->expected_notify)
                                                    <li>
                                                        <span class="badge badge-success">تم ارسال تنبيه للموظف المختص</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td><span class="max">{{ $order->customer->name }}</span></td>
                                        @if(Auth::user()->type == 'admin')
                                            <td>
                                                <span class="max">{{ $order->employee->name }}</span>
                                            </td>
                                        @endif
                                        <td><span class="max">{{ $order->name }}</span></td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <span>القسم الرئيسى: </span>
                                                    <p>{{ $order->category->name }}</p>
                                                </li>
                                                @if($order->sub_category)
                                                    <li>
                                                        <span>القسم الفرعى: </span>
                                                        <p>{{ $order->sub_category->name }}</p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="max">{{ $order->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            <span class="max">{{ $order->updated_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            <div class="options d-flex">
                                                @if(Auth::user()->type == 'user' || Auth::user()->can('orders.show'))
                                                    <a class="btn btn-success mr-1" href="{{ route('orders.show', $order) }}">
                                                        <span>عرض</span>
                                                        <span class="mdi mdi-eye ml-1"></span>
                                                    </a>
                                                @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->appends(request()->all())->links() }}
                    </div>
                @else
                    <div class="alert alert-info">لا يوجد تنبيهات حاليا</div>
                @endif
            </div>
        </div>
    </div>
@endsection
