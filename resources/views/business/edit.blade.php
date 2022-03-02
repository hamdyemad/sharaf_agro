@extends('layouts.master')

@section('title')
تعديل المعاملة المالية
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $business->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') المعاملات المالية @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('business.index') }} @endslot
        @slot('li3') {{ $business->name }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل المعاملة المالية
                </div>
                <div class="card-body">
                    <form action="{{ route('business.update', $business) }}" method="POST">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">أسم المعاملة المالية</label>
                                    <input type="text" class="form-control" name="name" value="{{ $business->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="category">نوع المعاملة المالية</label>
                                    <select class="form-control select2" name="type">
                                        <option value="">أختر الصنف</option>
                                        <option value="income" @if ($business->type == 'income') selected @endif>ايراد</option>
                                        <option value="expense" @if ($business->type == 'expense') selected @endif>مصروف</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->type == 'admin')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="category">الفرع</label>
                                        <select class="form-control select2" name="branch_id">
                                            <option value="">أختر الفرع</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if ($business->branch_id == $branch->id) selected @endif>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                            <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                            @endif
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                    <a href="{{ route('business.index') }}" class="btn btn-info">رجوع الى المعاملات
                                        المالية</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
