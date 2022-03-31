@extends('layouts.master')

@section('title')
{{ translate('order show') }}
@endsection

@section('content')

    <div class="show_order">
        @component('common-components.breadcrumb')
            @slot('title') {{ translate('order show') }} @endslot
            @slot('li1') {{ translate('dashboard') }} @endslot
            @slot('li2') {{ translate('orders') }} @endslot
            @slot('route1') {{ route('dashboard') }} @endslot
            @slot('route2') {{ route('orders.index') }} @endslot
            @slot('li3') {{ translate('order show') }}  @endslot
        @endcomponent
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-print-none">
                            <div class="float-right">
                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mr-2"><i class="fa fa-print"></i></a>
                                <a href="{{ route('orders.pdf', $order) }}" class="btn btn-info waves-effect waves-light mr-2"><i class="fa fa-file"></i></a>
                            </div>
                        </div>
                        @include('inc.invoice')
                        <div class="statuses_history">
                            <strong class="mb-2 d-block">{{ translate('order status history') }}</strong>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>{{ translate('name of the user who changed the status') }}</th>
                                        <th>{{ translate('status') }}</th>
                                        <th>{{ translate('creation date') }}</th>
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
