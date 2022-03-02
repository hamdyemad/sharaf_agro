@extends('layouts.master')

@section('title')
اظهار الطلب
@endsection

@section('content')

    <div class="show_order">
        @component('common-components.breadcrumb')
            @slot('title') اظهار الطلب @endslot
            @slot('li1') لوحة التحكم @endslot
            @slot('li2') الطلبات @endslot
            @slot('route1') {{ route('dashboard') }} @endslot
            @slot('route2') {{ route('orders.index') }} @endslot
            @slot('li3') اظهار الطلب  @endslot
        @endcomponent
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-print-none">
                            <div class="float-right">
                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mr-2"><i class="fa fa-print"></i></a>
                            </div>
                        </div>
                        @include('inc.invoice')
                        <div class="statuses_history">
                            <strong class="mb-2 d-block">تاريخ حالات الطلب</strong>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>أسم المستخدم الذى غير الحالة</th>
                                        <th>الحالة</th>
                                        <th>وقت الأنشاء</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($statuses_history as $status_history)
                                            <tr>
                                                <td>{{ $status_history->user->name }}</td>
                                                <td>{{ $status_history->status->name }}</td>
                                                <td>{{ $status_history->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end row -->

                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection
