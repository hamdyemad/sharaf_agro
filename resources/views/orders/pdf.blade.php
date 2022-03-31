<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>{{ $order->id }}</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box @if($rtl) rtl @endif">
			<table class="table" cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="6">
						<table class="table">
							<tr>
								<td class="title">
                                    @if (get_setting('logo'))
                                        <img src="{{ asset(get_setting('logo')) }}" style="width: 100px; height: 100px" alt="">
                                    @else
                                        <img src="{{ asset('/images/default.jpg') }}" alt="">
                                    @endif
								</td>

								<td>
                                    {{ translate('order number') . ' : ' . $order->id }}<br>
                                    @if($order->paid)
                                    {{ translate('paid') }}
                                    @endif
                                    ({{ $order->created_at }})<br>
                                    ({{ $order->created_at->diffForHumans() }})
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="6">
						<table>
							<tr>
								<td>
                                    {{ translate('order branch') . ': ' }} {{ $order->branch->name }}<br>
                                    @if($order->notes)
									    {{ translate('notes') . ': ' }} {{ $order->notes }}<br>
                                    @endif
								</td>

								<td>
									{{ translate('order summary') }}<br>
									{{ translate('customer name') . ': ' }} {{ $order->customer_name }}<br>
                                    @if($order->customer_phone)
									    {{ translate('customer phone') . ': ' }} {{ $order->customer_phone }}<br>
                                    @endif
                                    @if($order->customer_address)
									    {{ translate('customer address') . ': ' }} {{ $order->customer_address }}<br>
                                    @endif
                                    @if($order->city)
									    {{ translate('city') . ': ' }} {{ $order->city->name }}<br>
									    {{ translate('country') . ': ' }} {{ $order->city->country->name }}<br>
                                    @endif
								</td>
							</tr>
						</table>
					</td>
				</tr>
                <tr class="heading">
                    <td>{{ translate('food name') }}</td>
                    <td>{{ translate('price') }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ translate('count') }}</td>
                    <td>{{ translate('total price') }} </td>
                </tr>
                @if(isset($order->order_details->groupBy('variant_type')['']))
                    @foreach ($order->order_details->groupBy('variant_type')[''] as $variant)
                        <tr class="item">
                            <td>
                                <strong>{{ $variant->product->name }}</strong>
                                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                    <table>
                                        @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                            @if($variant->product->id == $product_id_from_extra)
                                                @foreach ($val as $extra)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ translate('extra') }} :</strong>
                                                            <span>{{ $extra->variant  }}</span>
                                                        </td>
                                                        <td>
                                                            <strong>{{ translate('price') }} :</strong>
                                                            <span>{{ $extra->price  }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong>{{ translate('order quantity') }} :</strong>
                                                            <span>{{ $extra->qty  }}</span>
                                                        </td>
                                                        @if($extra->qty > 1)
                                                            <td>
                                                                <strong>{{ translate('total price') }} :</strong>
                                                                <span>{{ $extra->total_price  }}</span>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </table>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $variant->price }}</strong>
                            </td>
                            <td></td>
                            <td></td>
                            <td><strong>{{ $variant->qty }}</strong></td>
                            <td><strong>{{ $variant->total_price }}</strong></td>
                        </tr>
                    @endforeach
                @endif
                @if(isset($order->order_details->groupBy('variant_type')['size']))
                    @foreach ($order->order_details->groupBy('variant_type')['size']->groupBy('product_id') as $product_id_from_size => $value)
                        <tr class="item">
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
                            <td></td>
                            <td></td>
                            <td><strong>{{ $value->pluck('qty')->sum() }}</strong></td>
                            <td><strong>{{ $order->currency->code . $value->pluck('total_price')->sum() }}</strong></td>
                        </tr>
                    @endforeach
                @endif
                <tr class="item">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="thick-line text-center">
                        <strong>{{ translate('total price withoud extras') }}</strong>
                    </td>
                    @if(isset($order->order_details->groupBy('variant_type')['extra']))
                        <td><strong>{{  $order->currency->code . (($order->grand_total  - $order->shipping -  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum()) + $order->total_discount) }}</strong></td>
                    @else
                        <td><strong>{{ $order->currency->code . (( $order->grand_total - $order->shipping) + $order->total_discount)  }}</strong></td>
                    @endif
                </tr>
                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                    <tr class="item">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"> <strong>{{ translate('total price of extras') }}</strong></td>
                        <td><strong>{{ $order->currency->code . $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum() }}</strong></td>
                    </tr>
                @endif
                @if($order->shipping)
                    <tr class="item">
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line text-center">
                            <strong>{{ translate('shipping') }}</strong></td>
                        <td class="no-line"><strong>{{ $order->currency->code . $order->shipping }}</strong></td>
                    </tr>
                @endif
                @if($order->total_discount)
                    <tr class="item">
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line text-center">
                            <strong>{{ translate('discount') }}</strong></td>
                        <td class="no-line"><strong>{{ $order->currency->code . $order->total_discount }}</strong></td>
                    </tr>
                @endif
                <tr class="item">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="no-line text-center">
                        <strong>{{ translate('final price') }}</strong></td>
                    <td>
                        <strong>{{ $order->currency->code . $order->grand_total }}</strong>
                    </td>
                </tr>
			</table>
            <table>
            </table>
		</div>
	</body>
</html>
