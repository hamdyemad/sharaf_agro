@extends('frontend.layout')

@section('content')
    <div class="profile pt-4 pb-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 d-none d-md-block">
                            @include('frontend.inc.user_computer_nav')
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="all_payments">
                                <form action="{{ route('frontend.orders') }}" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="order_id">رقم الطلب</label>
                                                <input class="form-control" name="order_id" type="text" value="{{ request('order_id') }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="transaction_id">رقم العملية</label>
                                                <input class="form-control" name="transaction_id" type="text" value="{{ request('transaction_id') }}">
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
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th><span>رقم الطلب</span></th>
                                                <th><span>رقم العملية</span></th>
                                                <th><span>المبلغ</span></th>
                                                <th><span>حالة الدفع</span></th>
                                                <th><span>وقت الأنشاء</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payments as $payment)
                                                <tr>
                                                    <th scope="row">{{ $payment->order->id }}</th>
                                                    <td>{{ $payment->transaction_id }}</td>
                                                    <td>{{ $payment->amount / 100}}</td>
                                                    <td>
                                                        @if($payment->order->paid)
                                                        <span class="badge badge-success">نعم</span>
                                                        @else
                                                        <span class="badge badge-secondary">لا</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span>{{ $payment->created_at->diffForHumans() }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $payments->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
@endsection
