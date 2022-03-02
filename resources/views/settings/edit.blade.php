@extends('layouts.master')

@section('title')
الأعدادات العامة
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأعدادات العامة @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') تعديل الاعدادات @endslot
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
                            <div class="col-6">
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
                                        <img src="{{ asset(get_setting('logo')) }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">الهيدر</label>
                                    <input type="text" class="form-control" value="{{ get_setting('header') }}"
                                        name="type[header]">
                                    @error('header')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">لينك فيسبوك</label>
                                    <input type="text" class="form-control" value="{{ get_setting('facebook') }}"
                                        name="type[facebook]">
                                    @error('facebook')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">لينك الأنستاجرام</label>
                                    <input type="text" class="form-control" value="{{ get_setting('instagram') }}"
                                        name="type[instagram]">
                                    @error('instagram')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">لينك قناه اليوتيوب</label>
                                    <input type="text" class="form-control" value="{{ get_setting('youtube') }}"
                                        name="type[youtube]">
                                    @error('youtube')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">الوصف</label>
                                    <textarea id="textarea" class="form-control" name="type[description]" maxlength="225"
                                    rows="3">{{ get_setting('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">مفاتيح عمليات بحث جوجل</label>
                                    <textarea id="textarea" class="form-control" name="type[keywords]" maxlength="225"
                                        rows="3">{{ get_setting('keywords') }}</textarea>
                                        @error('keywords')
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
