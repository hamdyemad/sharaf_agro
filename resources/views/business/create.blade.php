@extends('layouts.master')

@section('title')
انشاء معاملة مالية
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') المعاملات المالية @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') المعاملات المالية @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('business.index') }} @endslot
        @slot('li3') انشاء معاملة مالية @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء معاملة مالية
                </div>
                <div class="card-body">
                    <form action="{{ route('business.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">أسم المعاملة المالية</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
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
                                        <option value="{{ $branch->id }}" @if (old('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="category">نوع المعاملة المالية</label>
                                    <select class="form-control select2" name="type">
                                        <option value="">أختر نوع المعاملة</option>
                                        <option value="income" @if (old('type') == 'income') selected @endif>ايراد</option>
                                        <option value="expense" @if (old('type') == 'expense') selected @endif>مصروف</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="أنشاء" class="btn btn-success">
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
