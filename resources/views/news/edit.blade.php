@extends('layouts.master')

@section('title')
تعديل الخبر
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأخبار @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأخبار @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('news.index') }} @endslot
        @slot('li3') تعديل الخبر @endslot
    @endcomponent
    <div class="edit_news">
        <div class="card">
            <div class="card-header">
                تعديل الخبر
            </div>
            <div class="card-body">
                <form action="{{ route('news.update', $new) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">أسم الخبر</label>
                                <input type="text" class="form-control" name="name" value="{{ $new->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">تفاصيل الخبر</label>
                                <textarea id="myeditorinstance" name="details">{{ $new->details }}</textarea>
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
                            @if ($new->images)
                                <div class="current_files">
                                    <ul class="list-unstyled">
                                        @foreach (json_decode($new->images) as $image)
                                            <li class="mb-2 d-flex align-items-center">
                                                <a class="mr-2" href="{{ asset($image) }}">{{ $image }}</a>
                                                <button type="button" data-new_id="{{ $new->id }}" data-index="{{ $loop->index }}" class="remove_files btn-{{ $loop->index }} btn btn-danger rounded">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="submit" value="تعديل" class="btn btn-success">
                                <a href="{{ route('news.index') }}" class="btn btn-info">الرجوع الى الأخبار</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
    <script>

        // Remove Files From Order
        $(".remove_files").on('click', function() {
            let index = $(this).data('index'),
            new_id = $(this).data('new_id');
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    index: index
                },
                'url' : `/news/remove_files/` + new_id,
                'success': function(res) {
                    if(res.status) {
                        toastr.success(res.message);
                        $(`.btn-${index}`).parent().fadeOut(500);
                        setTimeout(() => {
                            $(`.btn-${index}`).parent().remove()
                        }, 500);
                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
        });

    </script>
@endsection
