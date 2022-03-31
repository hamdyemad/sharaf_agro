<div class="invoice">
    <div class="row">
        <div class="col-12">
            <div class="invoice-title d-flex justify-content-between">
                <h4 class="font-size-16">
                    <strong>{{ translate('order number') }} ({{ $order->id }})</strong>
                    <strong class="d-block mt-1 font-size-16">{{ translate('order status') }} ({{ $order->status->name }})</strong>
                    @if($order->paid)
                        <div class="badge badge-success d-block mt-1 p-2 font-size-16">{{ translate('paid') }}</div>
                    @endif
                </h4>
                <h4 class="font-size-16">
                    <strong>({{ $order->created_at }})</strong>
                    <strong class="d-block text-center mt-1">({{ $order->created_at->diffForHumans() }})</strong>
                </h4>
            </div>
            <hr>
            <div class="row">
                @if($order->customer_name)
                    <div class="col first">
                        <strong class="d-block mb-2">{{ translate('order details') }}</strong>
                        <div class="d-flex align-items-center mt-2">
                            <strong class="d-block mr-2">{{ translate('customer name') }} : </strong>
                            <span class="badge badge-primary">{{ $order->customer_name }}</span>
                        </div>
                        @if($order->customer_phone)
                            <div class="d-flex align-items-center mt-2">
                                <strong class="d-block mr-2">{{ translate('customer phone') }} : </strong>
                                <span class="badge badge-primary">{{ $order->customer_phone }}</span>
                            </div>
                        @endif
                        @if($order->customer_address)
                            <div class="d-flex align-items-center mt-2">
                                <strong class="d-block mr-2">{{ translate('customer address') }} : </strong>
                                <span class="badge badge-primary">{{ $order->customer_address }}</span>
                            </div>
                        @endif
                        @if($order->city)
                            <div class="d-flex align-items-center mt-2">
                                <strong class="d-block mr-2">{{ translate('city') }} : </strong>
                                <span class="badge badge-primary">{{ $order->city->name }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <strong class="d-block mr-2">{{ translate('country') }} : </strong>
                                <span class="badge badge-primary">{{ $order->city->country->name }}</span>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="col last">
                    @if (get_setting('logo'))
                        <img src="{{ asset(get_setting('logo')) }}" alt="">
                    @else
                        <img src="{{ asset('/images/default.jpg') }}" alt="">
                    @endif
                    <div class="d-flex align-items-center">
                        <strong class="d-block mr-2">{{ translate('order branch') }} : </strong>
                        <span class="badge badge-primary">{{ $order->branch->name }}</span>
                    </div>
                    @if($order->notes)
                        <div class="d-flex align-items-center mt-2">
                            <strong class="d-block mr-2">{{ translate('notes') }} : </strong>
                            <span class="badge badge-primary">{{ $order->notes }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div>
                <div class="p-2">
                    <h3 class="font-size-16"><strong>{{ translate('order summary') }}</strong></h3>
                </div>
                <div class="">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td><strong>{{ translate('food name') }}</strong></td>
                                    <td><strong>{{ translate('price') }}</strong></td>
                                    <td><strong>{{ translate('count') }}</strong></td>
                                    <td><strong>{{ translate('total price') }} </strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($order->order_details->groupBy('variant_type')['']))
                                    @foreach ($order->order_details->groupBy('variant_type')[''] as $variant)
                                        <tr>
                                            <td><strong>{{ $variant->product->name }}</strong></td>
                                            <td>
                                                <strong>{{ $variant->price }}</strong>
                                                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                                    @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                                        @if($variant->product->id == $product_id_from_extra)
                                                            @foreach ($val as $extra)
                                                                <div class="mb-2 d-flex align-items-center">
                                                                    <div class="line">
                                                                        <strong>{{ translate('extra') }} :</strong>
                                                                        <span class="badge badge-secondary">{{ $extra->variant  }}</span>
                                                                    </div>
                                                                    <div class="line">
                                                                        <strong>{{ translate('price') }} :</strong>
                                                                        <span class="badge badge-secondary">{{ $extra->price  }}</span>
                                                                    </div>
                                                                    <div class="line">
                                                                        <strong>{{ translate('order quantity') }} :</strong>
                                                                        <span class="badge badge-secondary">{{ $extra->qty  }}</span>
                                                                    </div>
                                                                    @if($extra->qty > 1)
                                                                        <div class="line">
                                                                            <strong>{{ translate('total price') }} :</strong>
                                                                            <span class="badge badge-secondary">{{ $extra->total_price  }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td><strong>{{ $variant->qty }}</strong></td>
                                            <td><strong>{{ $variant->total_price }}</strong></td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if(isset($order->order_details->groupBy('variant_type')['size']))
                                    @foreach ($order->order_details->groupBy('variant_type')['size']->groupBy('product_id') as $product_id_from_size => $value)
                                        <tr>
                                            <td>
                                                <h6><strong>{{ App\Models\Product::find($product_id_from_size)->name }}</strong></h6>
                                            </td>
                                            <td>
                                                @foreach ($value as $variant)
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <div class="line">
                                                            <strong>{{ translate('size') }} :</strong>
                                                            <span class="badge badge-secondary">{{ $variant->variant  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <strong>{{ translate('price') }} :</strong>
                                                            <span class="badge badge-secondary">{{ $order->currency->code . $variant->price  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <strong>{{ translate('quantity') }} :</strong>
                                                            <span class="badge badge-secondary">{{ $variant->qty  }}</span>
                                                        </div>
                                                        @if($variant->qty > 1)
                                                            <div class="line">
                                                                <strong>{{ translate('total price') }} :</strong>
                                                                <span class="badge badge-secondary">{{ $order->currency->code . $variant->total_price  }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                                    @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                                        @if($product_id_from_extra == $product_id_from_size)
                                                            @foreach ($val as $variant)
                                                                <div class="mb-2 d-flex align-items-center">
                                                                    <div class="line">
                                                                        <strong>{{ translate('extra') }} :</strong>
                                                                        <span class="badge badge-secondary">{{ $variant->variant  }}</span>
                                                                    </div>
                                                                    <div class="line">
                                                                        <strong>{{ translate('price') }} :</strong>
                                                                        <span class="badge badge-secondary">{{ $order->currency->code . $variant->price  }}</span>
                                                                    </div>
                                                                    <div class="line">
                                                                        <strong>{{ translate('quantity') }} :</strong>
                                                                        <span class="badge badge-secondary">{{ $variant->qty  }}</span>
                                                                    </div>
                                                                    @if($variant->qty > 1)
                                                                        <div class="line">
                                                                            <strong>{{ translate('total price') }} :</strong>
                                                                            <span class="badge badge-secondary">{{ $order->currency->code . $variant->total_price  }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td><strong>{{ $value->pluck('qty')->sum() }}</strong></td>
                                            <td><strong>{{ $order->currency->code . $value->pluck('total_price')->sum() }}</strong></td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center">
                                        <strong>{{ translate('total price withoud extras') }}</strong></td>
                                    @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                    <td class="thick-line"><strong>{{  $order->currency->code . (($order->grand_total  - $order->shipping -  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum()) + $order->total_discount) }}</strong></td>
                                    @else
                                    <td class="thick-line"><strong>{{ $order->currency->code . (( $order->grand_total - $order->shipping) + $order->total_discount)  }}</strong></td>
                                    @endif
                                </tr>
                                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-center"> <strong>{{ translate('total price of extras') }}</strong></td>
                                        <td class="thick-line"><strong>{{ $order->currency->code . $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum() }}</strong></td>
                                    </tr>
                                @endif
                                @if($order->shipping)
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center">
                                            <strong>{{ translate('shipping') }}</strong></td>
                                        <td class="no-line"><strong>{{ $order->currency->code . $order->shipping }}</strong></td>
                                    </tr>
                                @endif
                                @if($order->total_discount)
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center">
                                            <strong>{{ translate('discount') }}</strong></td>
                                        <td class="no-line"><strong>{{ $order->currency->code . $order->total_discount }}</strong></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center">
                                        <strong>{{ translate('final price') }}</strong></td>
                                    <td class="no-line">
                                        <h4 class="m-0"><strong>{{ $order->currency->code . $order->grand_total }}</strong></h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
