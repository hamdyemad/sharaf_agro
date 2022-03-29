@extends('layouts.master')

@section('title')
{{ translate('foods') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('foods') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('foods') }} @endslot
    @endcomponent
    <div class="all_products">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('foods') }}</h2>
                    @can('products.create')
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary mb-2">{{ translate('create new food') }}</a>
                        </div>

                    @endcan
                </div>
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="name">{{ translate('food name') }}</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="name">{{ translate('description') }}</label>
                                <input class="form-control" name="description" type="text"
                                    value="{{ request('description') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="category">{{ translate('choose category') }}</label>
                                <select class="form-control select2" name="category_id">
                                    <option value="">{{ translate('choose') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id == request('category_id')) selected @endif>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="discount">{{ translate('price') }}</label>
                                <input class="form-control" name="price" type="text" value="{{ request('price') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="discount">{{ translate('discount') }}</label>
                                <input class="form-control" name="discount" type="text"
                                    value="{{ request('discount') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="price_after_discount">{{ translate('price after discount') }}</label>
                                <input class="form-control" name="price_after_discount" type="text"
                                    value="{{ request('price_after_discount') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="viewed_number">{{ translate('appearance number') }}</label>
                                <input class="form-control" name="viewed_number" type="number"
                                    value="{{ request('viewed_number') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="category">{{ translate('available') }}</label>
                                <select class="form-control select2" name="active">
                                    <option value="">{{ translate('choose') }}</option>
                                    <option @if(request('active') == 'true') selected @endif value="true">{{ translate('available') }}</option>
                                    <option @if(request('active') == 'false') selected @endif value="false">{{ translate('not available') }}</option>
                                </select>
                                @error('active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="date_range">{{ translate('creation date') }}</label>
                                <div class="input-daterange input-group" id="date-range">
                                    <input type="text" class="form-control" placeholder="{{ translate('from') }}" name="start"
                                        value="{{ request('start') }}" />
                                    <input type="text" class="form-control" placeholder="{{ translate('to') }}" name="end"
                                        value="{{ request('end') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <label for=""></label>
                            <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
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
                                <th><span>{{ translate('food name') }}</span></th>
                                <th><span>{{ translate('category') }}</span></th>
                                <th><span>{{ translate('branch') }}</span></th>
                                <th><span>{{ translate('description') }}</span></th>
                                <th><span>{{ translate('available') }}</span></th>
                                <th><span>{{ translate('appearance number') }}</span></th>
                                <th><span>{{ translate('creation date') }}</span></th>
                                <th><span>{{ translate('last update date') }}</span></th>
                                <th><span>{{ translate('settings') }}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>
                                    <div>
                                        <h4 class="mr-2">
                                            {{ $product->name }}
                                        </h4>
                                        @if ($product->photos !== null)
                                            <img class="mt-2"
                                                src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                        @else
                                            <img class="mt-2"
                                                src="{{ asset('/images/product_avatar.png') }}" alt="">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a class="h4 d-block"
                                        href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->name }}</a>
                                        @if ($product->category->photo !== null)
                                            <img class="mt-2" src="{{ asset($product->category->photo) }}"
                                                alt="">
                                        @else
                                            <img class="mt-2" src="{{ asset('/images/product_avatar.png') }}"
                                                alt="">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $product->category->branch->name }}
                                </td>
                                <td>
                                    @if (strlen($product->description) > 20)
                                        {{ substr($product->description, 0, 20) . '...' }}
                                    @else
                                        {{ $product->description }}
                                    @endif
                                </td>
                                <td>
                                    @if ($product->active)
                                        <div class="badge badge-success w-100 p-2">{{ translate('yes') }}</div>
                                    @else
                                        <div class="badge badge-secondary w-100">{{ translate('no') }}</div>
                                    @endif
                                </td>
                                <td>
                                    {{ $product->viewed_number }}
                                </td>
                                <td>
                                    {{ $product->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $product->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('products.show')
                                            <a class="btn btn-success mr-1"
                                                href="{{ route('products.show', $product) }}">
                                                <span>{{ translate('show') }}</span>
                                                <span class="mdi mdi-eye"></span>
                                            </a>
                                        @endcan
                                        @can('products.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('products.edit', $product) }}">
                                                <span>{{ translate('edit') }}</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('products.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $product->id }}">
                                                <span>{{ translate('delete') }}</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $product->id,
                                            'route' => route('products.destroy', $product->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                            @if(count($product->prices) > 0)
                                <tr>
                                    <td>{{ translate('currency') }}</td>
                                    <td>{{ translate('price') }}</td>
                                    <td>{{ translate('discount') }}</td>
                                    <td>{{ translate('price after discount') }}</td>
                                    </td>
                                </tr>
                                @foreach ($product->prices as $price)
                                    <tr>
                                        <td>{{ $price->currency->code }}</td>
                                        <td>{{ $price->price }}</td>
                                        <td>{{ $price->discount }}</td>
                                        <td>{{ $price->price_after_discount }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            @if($product->variants)
                                @if(isset($product->variants->groupBy('type')['size']))

                                    <tr>
                                        <td>{{ translate('size') }}</td>
                                        @foreach($currencies as $currency)
                                            <th>{{ $currency['code'] }}</th>
                                        @endforeach
                                    </tr>
                                    @foreach ($product->variants->groupBy('type')['size'] as $variant)
                                        <tr>
                                            <td>{{ $variant->variant }}</td>
                                            @foreach ($variant->prices as $price)
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span>{{ translate('price') . ':' }}</span> <span class="badge badge-primary">{{ $price->price }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <span>{{ translate('discount') . ':' }}</span><span class="badge badge-primary">{{ $price->discount }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <span>{{ translate('price after discount') . ':' }}</span><span class="badge badge-primary">{{ $price->price_after_discount }}</span>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endif
                                @if(isset($product->variants->groupBy('type')['extra']))
                                    <tr>
                                        <td>{{ translate('extra') }}</td>
                                        @foreach($currencies as $currency)
                                            <th>{{ $currency['code'] }}</th>
                                        @endforeach
                                    </tr>
                                    @foreach ($product->variants->groupBy('type')['extra'] as $variant)
                                        <tr>
                                            <td>{{ $variant->variant }}</td>
                                            @foreach ($variant->prices as $price)
                                                <td>{{ $price->price_after_discount }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
