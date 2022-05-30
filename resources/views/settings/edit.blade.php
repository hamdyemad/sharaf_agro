@extends('layouts.master')

@section('title')
الأعدادات العامة
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأعدادات العامة @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') الأعدادات العامة @endslot
    @endcomponent
    <div class="edit_settings">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    الأعدادات العامة
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">أسم المشروع</label>
                                    <input type="text" class="form-control" value="{{ get_setting('project_name') }}"
                                        name="type[project_name]">
                                    @error('project_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">عدد أيام ارسال التنبيه بالتوقيت المتوقع</label>
                                    <input type="text" class="form-control" value="{{ get_setting('expected_date') }}"
                                        name="type[expected_date]">
                                    @error('expected_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">اللوجو</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden name="logo">
                                    <button type="button" class="btn btn-primary form-control files">
                                        @if (!get_setting('logo'))
                                            <span class="mdi mdi-plus btn-lg"></span>
                                        @else
                                            {{ get_setting('logo') }}
                                        @endif
                                    </button>
                                    <div class="imgs mt-2 d-flex">
                                        @if(get_setting('logo'))
                                        <img src="{{ asset(get_setting('logo')) }}" alt="">
                                        @else
                                        <img src="{{ asset('/images/default.jpg') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">توقيت الحضور</label>
                                    <input type="time" class="form-control" value="{{ get_setting('entry') }}"
                                        name="type[entry]">
                                    @error('entry')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">توقيت الأنصراف</label>
                                    <input type="time" class="form-control" value="{{ get_setting('exit') }}"
                                        name="type[exit]">
                                    @error('exit')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">توقيت السماح للتأخيرات</label>
                                    <input type="time" class="form-control" value="{{ get_setting('delay_allowed') }}"
                                        name="type[delay_allowed]">
                                    @error('delay_allowed')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
