@extends('layouts.master')

@section('title')
تعديل الرصيد
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') تعديل الرصيد @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') كل الأرصدة @endslot
        @slot('route2') {{ route('balances.index') }} @endslot
        @slot('li3') تعديل الرصيد @endslot
    @endcomponent
    <div class="create_user">
        <div class="card">
            <div class="card-header">
                {{ $balance->user->name }}
            </div>
            <div class="card-body">
                <form class="form-horizontal mt-4" method="POST" action="{{ route('balances.update', $balance) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">رصيد الشركة</label>
                                <input class="form-control" type="text" value="{{ $balance->balance }}" name="balance">
                                @error('balance')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">تعديل الرصيد</button>
                                <a href="{{ route('balances.index') }}" class="btn btn-info">الرجوع الى الأرصدة</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
