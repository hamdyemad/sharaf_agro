@extends('layouts.master')

@section('title')
{{ translate('orders') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('orders') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('orders') }} @endslot
    @endcomponent
    <div class="all_orders">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('orders') }}</h2>
                    @can('orders.create')
                        <div>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary mb-2">{{ translate('create') }}</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_name">{{ translate('customer name') }}</label>
                                <input class="form-control" name="customer_name" type="text" value="{{ request('customer_name') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_phone">{{ translate('customer phone') }}</label>
                                <input class="form-control" name="customer_phone" type="text" value="{{ request('customer_phone') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_address">{{ translate('customer address') }}</label>
                                <input class="form-control" name="customer_address" type="text" value="{{ request('customer_address') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">{{ translate('order status') }}</label>
                                <select class="form-control select2" name="status_id">
                                    <option value="">{{ translate('choose') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" @if ($status->id == request('status_id')) selected @endif>
                                            {{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(Auth::user()->type == 'admin')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('order type') }}</label>
                                    <select class="form-control select2" name="type">
                                        <option value="">{{ translate('choose') }}</option>
                                        <option value="inhouse" @if ('inhouse' == request('type')) selected @endif>{{ translate('receipt request from the branch') }}</option>
                                        <option value="online" @if ('online' == request('type')) selected @endif>{{ translate('online order') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('the branch') }}</label>
                                    <select class="form-control select2" name="branch_id">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if ($branch->id == request('branch_id')) selected @endif>
                                                {{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name"></label>
                                <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
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
                                <th><span>{{ translate('order number') }}</span></th>
                                <th><span>{{ translate('currency') }}</span></th>
                                <th><span>{{ translate('customer name') }}</span></th>
                                <th><span>{{ translate('customer address') }}</span></th>
                                <th><span>{{ translate('city') }}</span></th>
                                <th><span>{{ translate('customer phone') }}</span></th>
                                <th><span>{{ translate('order status') }}</span></th>
                                <th><span>{{ translate('paid') }}</span></th>
                                <th><span>{{ translate('order branch') }}</span></th>
                                <th><span>{{ translate('creation date') }}</span></th>
                                <th><span>{{ translate('last update date') }}</span></th>
                                <th><span>{{ translate('settings') }}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr id="{{ $order->id }}" data-value="{{ $order }}">
                                    <th scope="row">{{ $order->id }}</th>
                                    <th>{{ $order->currency->code }}</th>
                                    @if($order->customer_name)
                                        <td>{{ $order->customer_name }}</td>
                                    @else
                                        <td><div class="badge badge-secondary">{{ translate('there is no name') }}</div></td>
                                    @endif
                                    @if($order->customer_address)
                                        <td>{{ $order->customer_address }}</td>
                                    @else
                                        <td><div class="badge badge-secondary">{{ translate('there is no address') }}</div></td>
                                    @endif
                                    @if($order->city)
                                        <td>
                                            {{ $order->city->name }}
                                        </td>
                                    @else
                                    <td><div class="badge badge-secondary">{{ translate('there is no city') }}</div></td>
                                    @endif
                                    @if($order->customer_phone)
                                        <td>{{ $order->customer_phone }}</td>
                                    @else
                                        <td><div class="badge badge-secondary">ل{{ translate('there is no phone') }}</div></td>
                                    @endif
                                    <td>
                                        <select class="form-control status select2">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}" @if($order->status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        @if($order->paid)
                                        <span class="badge badge-success">{{ translate('yes') }}</span>
                                        @else
                                        <span class="badge badge-danger">{{ translate('no') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="badge badge-primary p-2">({{ $order->branch->name }})</div>
                                        @if($order->type == 'online')
                                            <div class="badge badge-primary mt-2">{{ translate('online order') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{ $order->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $order->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('orders.show')
                                                <a class="btn btn-success mr-1" href="{{ route('orders.show', $order) }}">
                                                    <span>{{ translate('show') }}</span>
                                                    <span class="mdi mdi-eye"></span>
                                                </a>
                                            @endcan
                                            @can('orders.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('orders.edit', $order) }}">
                                                    <span>{{ translate('edit') }}</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>

                                            @endcan
                                            @can('orders.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $order->id }}">
                                                    <span>{{ translate('delete') }}</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $order->id,
                                                'route' => route('orders.destroy', $order->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8">
                                        <div class="products d-flex">
                                            <div class="product-variants d-flex">
                                                @foreach ($order->order_details->groupBy('product_id') as $key => $orderProduct)
                                                    @if(isset($orderProduct->groupBy('variant_type')['']))
                                                        @foreach ($orderProduct->groupBy('variant_type')[''] as $variant)
                                                            <ul class="variants">
                                                                <li><h6>{{ translate('name') }} : </h6><div class="badge badge-info rounded">{{ $variant->product->name }}</div></li>
                                                                <li><h6>{{ translate('price') }} :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                <li><h6>{{ translate('quantity') }} : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                <li><h6>{{ translate('total price') }} : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                            </ul>
                                                        @endforeach
                                                    @else
                                                        <ul class="variants">
                                                            <li><h6>{{ translate('name') }} : </h6><div class="badge badge-info rounded">{{ \App\Models\Product::find($key)->name }}</div></li>
                                                        </ul>
                                                    @endif
                                                    @if(isset($orderProduct->groupBy('variant_type')['size']))
                                                        @foreach ($orderProduct->groupBy('variant_type')['size'] as $variant)
                                                            <ul class="variants">
                                                                <li><h6>{{ translate('size') }} : </h6><div class="badge badge-info rounded">{{ $variant->variant }}</div></li>
                                                                <li><h6>{{ translate('price') }} :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                <li><h6>{{ translate('quantity') }} : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                <li><h6>{{ translate('total price') }} : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                            </ul>
                                                        @endforeach
                                                    @endif
                                                    @if(isset($orderProduct->groupBy('variant_type')['extra']))
                                                        @foreach ($orderProduct->groupBy('variant_type')['extra'] as $variant)
                                                            <ul class="variants">
                                                                <li><h6>{{ translate('extra') }} : </h6><div class="badge badge-info rounded">{{ $variant->variant }}</div></li>
                                                                <li><h6>{{ translate('price') }} :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                <li><h6>{{ translate('quantity') }} : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                <li><h6>{{ translate('total price') }} : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                            </ul>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="product-variants d-flex">
                                                <ul class="variants">
                                                        <li><h6>{{ translate('total price') }} : </h6><div class="badge badge-info rounded">{{ ($order->grand_total - $order->shipping )+ $order->total_discount }}</div></li>
                                                        @if($order->shipping)
                                                            <li><h6>{{ translate('shipping') }}: </h6><div class="badge badge-info rounded">{{ $order->shipping }}</div></li>
                                                        @endif
                                                        @if($order->total_discount)
                                                            <li><h6>{{ translate('discount') }}: </h6><div class="badge badge-info rounded">{{ $order->total_discount }}</div></li>
                                                        @endif
                                                        <li><h6>{{ translate('final price') }} : </h6><div class="badge badge-info rounded">{{ $order->grand_total }}</div></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>
        orderChannel.bind('App\\Events\\newOrder', function(data) {
            if(data) {
                if(data.order.branch_id == "{{ Auth::user()->branch_id }}" || "{{Auth::user()->type}}" == 'admin') {
                    window.location.reload();
                }
            }
        });

        let statusChannel = pusher.subscribe('changeOrderStatus');
        statusChannel.bind('App\\Events\\changeOrderStatus', function(data) {
            if(data) {
                if(data.order.branch_id == "{{ Auth::user()->branch_id }}") {
                    window.location.reload();
                }
                // $(`#${data.order.id} .status`).select2("val", data.status_id);
            }
        });

        $(".status").on('change', function () {
            $("#preloader_all").removeClass('d-none');
            let token = $("meta[name=_token]").attr('content'),
            order_id = $(this).parent().parent().attr('id'),
            user_id = "{{ Auth::id() }}",
            status_id = $(this).val();
            $.ajax({
                "method": "POST",
                "data": {
                    "_token": token,
                    "order_id" : order_id,
                    "user_id" : user_id,
                    "status_id": status_id
                },
                "url": "{{ route('orders.status_update') }}",
                "success": function(data) {
                    if(data.status) {
                        toastr.success(data.msg);
                    }
                    $("#preloader_all").addClass('d-none');
                },
                "error": function(err) {
                    console.log(err);
                }
            })
        })
    </script>
@endsection
