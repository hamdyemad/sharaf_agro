@extends('layouts.master')

@section('title')
انشاء خبر
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأخبار @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأخبار @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('news.index') }} @endslot
        @slot('li3') انشاء خبر @endslot
    @endcomponent
    <div class="create_category">
        <div class="card">
            <div class="card-header">
                انشاء خبر
            </div>
            <div class="card-body">
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">أسم الخبر</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">تفاصيل الخبر</label>
                                <textarea id="myeditorinstance" name="details">{{ old('details') }}</textarea>
                                @error('details')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">صور الخبر</label>
                                <input type="file" class="form-control input_files" multiple accept="image/*" hidden
                                    name="images[]" data-img="5" data-pdf="1">
                                <button type="button" class="btn btn-primary form-control files">
                                    <span class="mdi mdi-plus btn-lg"></span>
                                </button>
                                <div class="text-danger file_error img-error" hidden>يجب أختيار أقل من 5 من الصور</div>
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="d-block" for="">ارسال تنبيه بالخبر</label>
                                <input type="checkbox" name="send_notify" id="switch6" switch="success" checked />
                                <label for="switch6" data-on-label="نعم" data-off-label="لا"></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="submit" value="انشاء" class="btn btn-success">
                                <a href="{{ route('news.index') }}" class="btn btn-info">الرجوع الى الأخبار</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
