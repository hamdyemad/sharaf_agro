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
                            <div class="all_orders">
                                <form action="{{ route('frontend.orders') }}" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="customer_name">أسم العميل</label>
                                                <input class="form-control" name="customer_name" type="text" value="{{ request('customer_name') }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="customer_phone">رقم العميل</label>
                                                <input class="form-control" name="customer_phone" type="text" value="{{ request('customer_phone') }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="customer_address">عنوان العميل</label>
                                                <input class="form-control" name="customer_address" type="text" value="{{ request('customer_address') }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">حالة الطلب</label>
                                                <select class="form-control select2" name="status_id">
                                                    <option value="">أختر الحالة</option>
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
                                                    <label for="name">نوع الطلب</label>
                                                    <select class="form-control select2" name="type">
                                                        <option value="">أختر النوع</option>
                                                        <option value="inhouse" @if ('inhouse' == request('type')) selected @endif>طلب أستلام من الفرع</option>
                                                        <option value="online" @if ('online' == request('type')) selected @endif>طلب أونلاين</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name">الفرع</label>
                                                    <select class="form-control select2" name="branch_id">
                                                        <option value="">أختر الفرع</option>
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
                                                <th><span>أسم العميل</span></th>
                                                <th><span>عنوان العميل</span></th>
                                                <th><span>المدينة</span></th>
                                                <th><span>رقم العميل</span></th>
                                                <th><span>حالة الطلب</span></th>
                                                <th><span>دفع مقدما</span></th>
                                                <th><span>فرع الطلب</span></th>
                                                <th><span>وقت الأنشاء</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr id="{{ $order->id }}">
                                                    <th scope="row">{{ $order->id }}</th>
                                                    @if($order->customer_name)
                                                        <td>{{ $order->customer_name }}</td>
                                                    @else
                                                        <td><div class="badge badge-secondary">لا يوجد أسم</div></td>
                                                    @endif
                                                    @if($order->customer_address)
                                                        <td>{{ $order->customer_address }}</td>
                                                    @else
                                                        <td><div class="badge badge-secondary">لا يوجد عنوان</div></td>
                                                    @endif
                                                    @if($order->city)
                                                        <td>
                                                            {{ $order->city->name }}
                                                        </td>
                                                    @else
                                                    <td><div class="badge badge-secondary">لا يوجد مدينة</div></td>
                                                    @endif
                                                    @if($order->customer_phone)
                                                        <td>{{ $order->customer_phone }}</td>
                                                    @else
                                                        <td><div class="badge badge-secondary">لا يوجد هاتف</div></td>
                                                    @endif
                                                    <td>
                                                        <span>{{ $order->status->name }}</span>
                                                    </td>
                                                    <td>
                                                        @if($order->paid)
                                                        <span class="badge badge-success">نعم</span>
                                                        @else
                                                        <span class="badge badge-secondary">لا</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-primary p-2">({{ $order->branch->name }})</div>
                                                        @if($order->type == 'online')
                                                            <div class="badge badge-primary mt-2">طلب أونلاين</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span>{{ $order->created_at->diffForHumans() }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="options d-flex">
                                                            <a class="btn btn-success mr-1" href="{{ route('frontend.orders.show', $order) }}">
                                                                <span>اظهار</span>
                                                                <span class="mdi mdi-eye"></span>
                                                            </a>
                                                        </div>
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
                                                                                <li><h6>الأسم : </h6><div class="badge badge-info rounded">{{ $variant->product->name }}</div></li>
                                                                                <li><h6>السعر :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                                <li><h6>الكمية : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                                <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                                            </ul>
                                                                        @endforeach
                                                                    @else
                                                                        <ul class="variants">
                                                                            <li><h6>الأسم : </h6><div class="badge badge-info rounded">{{ \App\Models\Product::find($key)->name }}</div></li>
                                                                        </ul>
                                                                    @endif
                                                                    @if(isset($orderProduct->groupBy('variant_type')['size']))
                                                                        @foreach ($orderProduct->groupBy('variant_type')['size'] as $variant)
                                                                            <ul class="variants">
                                                                                <li><h6>الحجم : </h6><div class="badge badge-info rounded">{{ $variant->variant }}</div></li>
                                                                                <li><h6>السعر :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                                <li><h6>الكمية : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                                <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                                            </ul>
                                                                        @endforeach
                                                                    @endif
                                                                    @if(isset($orderProduct->groupBy('variant_type')['extra']))
                                                                        @foreach ($orderProduct->groupBy('variant_type')['extra'] as $variant)
                                                                            <ul class="variants">
                                                                                <li><h6>الأضافة : </h6><div class="badge badge-info rounded">{{ $variant->variant }}</div></li>
                                                                                <li><h6>السعر :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                                <li><h6>الكمية : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                                <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                                            </ul>
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="product-variants d-flex">
                                                                <ul class="variants">
                                                                        <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ ($order->grand_total - $order->shipping )+ $order->total_discount }}</div></li>
                                                                        @if($order->shipping)
                                                                            <li><h6>الشحن: </h6><div class="badge badge-info rounded">{{ $order->shipping }}</div></li>
                                                                        @endif
                                                                        @if($order->total_discount)
                                                                            <li><h6>الخصم: </h6><div class="badge badge-info rounded">{{ $order->total_discount }}</div></li>
                                                                        @endif
                                                                        <li><h6>السعر النهائى : </h6><div class="badge badge-info rounded">{{ $order->grand_total }}</div></li>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
@endsection
