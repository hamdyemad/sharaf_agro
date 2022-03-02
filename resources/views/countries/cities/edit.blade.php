@extends('layouts.master')

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $country->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') البلاد @endslot
        @slot('route2') {{ route('countries.index') }} @endslot
        @slot('li3') {{ $country->name }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $country->name }}</h2>
                    تعديل المدينة
                </div>
                <div class="card-body">
                    <form action="{{ route('countries.cities.update', ['country' => $country, 'city' => $city]) }}"
                        method="POST">
                        <input type="hidden" name="country_id" value="{{ $country->id }}">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">أسم المدينة</label>
                                    <input type="text" class="form-control" name="name" value="{{ $city->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">سعر الشحن</label>
                                    <input type="text" class="form-control" name="price" value="{{ $city->price }}">
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                    <a href="{{ route('countries.cities.index', $country) }}" class="btn btn-info">رجوع
                                        الى المدن</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
