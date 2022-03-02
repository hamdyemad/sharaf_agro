@extends('layouts.master')

@section('title')
الأكلات
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأكلات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الأكلات @endslot
    @endcomponent
    <div class="all_products">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الأكلات</h2>
                    @can('products.create')
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary mb-2">أنشاء أكلة جديدة</a>
                        </div>

                    @endcan
                </div>
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="name">أسم الأكلة</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="name">الوصف</label>
                                <input class="form-control" name="description" type="text"
                                    value="{{ request('description') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="category">أسم الصنف</label>
                                <select class="form-control select2" name="category_id">
                                    <option value="">أختر الصنف</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id == request('category_id')) selected @endif>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="discount">السعر</label>
                                <input class="form-control" name="price" type="text" value="{{ request('price') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="discount">الخصم</label>
                                <input class="form-control" name="discount" type="text"
                                    value="{{ request('discount') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="price_after_discount">السعر بعد الخصم</label>
                                <input class="form-control" name="price_after_discount" type="text"
                                    value="{{ request('price_after_discount') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="viewed_number">رقم الظهور</label>
                                <input class="form-control" name="viewed_number" type="number"
                                    value="{{ request('viewed_number') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="category">مرئى</label>
                                <select class="form-control select2" name="active">
                                    <option value="">أختار</option>
                                    <option @if(request('active') == 'true') selected @endif value="true">مرئى</option>
                                    <option @if(request('active') == 'false') selected @endif value="false">غير مرئى</option>
                                </select>
                                @error('active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                <label for="date_range">الوقت</label>
                                <div class="input-daterange input-group" id="date-range">
                                    <input type="text" class="form-control" placeholder="من" name="start"
                                        value="{{ request('start') }}" />
                                    <input type="text" class="form-control" placeholder="الى" name="end"
                                        value="{{ request('end') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <label for=""></label>
                            <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>أسم الأكلة</th>
                                <th>الصنف</th>
                                <th>الفرع</th>
                                <th>الوصف</th>
                                <th>السعر</th>
                                <th>الخصم</th>
                                <th>السعر بعد الخصم</th>
                                <th>مرئى</th>
                                <th>رقم الظهور</th>
                                <th>وقت الأنشاء</th>
                                <th>وقت أخر تعديل</th>
                                <th>الأعدادات</th>
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
                                    {{ $product->price }}
                                </td>
                                <td>
                                    {{ $product->discount }}
                                </td>
                                <td>
                                    {{ $product->price - $product->discount }}
                                </td>
                                <td>
                                    @if ($product->active)
                                        <div class="badge badge-success w-100 p-2">نعم</div>
                                    @else
                                        <div class="badge badge-secondary w-100">لا</div>
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
                                                <span>اظهار</span>
                                                <span class="mdi mdi-eye"></span>
                                            </a>
                                        @endcan
                                        @can('products.edit')
                                            <a class="btn btn-info mr-1" href="{{ route('products.edit', $product) }}">
                                                <span>تعديل</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('products.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $product->id }}">
                                                <span>ازالة</span>
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
                            @if($product->variants)
                                @if(isset($product->variants->groupBy('type')['size']))
                                    <tr>
                                        <td>الحجم</td>
                                        <td>السعر</td>
                                        <td>الخصم</td>
                                        <td>السعر بعد الخصم</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($product->variants->groupBy('type')['size'] as $variant)
                                        <tr>
                                            <td>{{ $variant->variant }}</td>
                                            <td>{{ $variant->price }}</td>
                                            <td>{{ $variant->discount }}</td>
                                            <td>{{ $variant->price_after_discount }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if(isset($product->variants->groupBy('type')['extra']))
                                    <tr>
                                        <td>الأضافة</td>
                                        <td>السعر</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($product->variants->groupBy('type')['extra'] as $variant)
                                        <tr>
                                            <td>{{ $variant->variant }}</td>
                                            <td>{{ $variant->price_after_discount }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
