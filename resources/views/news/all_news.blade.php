@extends('layouts.master')


@section('title')
الأخبار
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأخبار @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل الأخبار @endslot
    @endcomponent
    <div class="all_news">
        <div class="card">
            <div class="card-header">
                <form action="{{ route('news.all_news') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم الخبر</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mt-4">
                                <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($news->count() > 0)
                    <div class="row justify-content-center">
                        @foreach ($news as $new)
                            <div class="col-12 col-md-4 mb-3">
                                <a href="{{ route('news.show', $new) }}">
                                    <div class="item">
                                        @if($new->images && is_array($new->images))
                                            <img src="{{ asset(json_decode($new->images)[0]) }}" alt="">
                                        @else
                                            <img src="{{ asset('/images/default.jpg') }}" alt="">
                                        @endif
                                        <h2>
                                            @if(strlen($new->name) > 30)
                                            {{ mb_substr($new->name, 0, 30) . '...' }}
                                            @else
                                            {{ $new->name }}
                                            @endif
                                        </h2>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">لا يوجد أخبار</div>
                @endif
                {{ $news->appends(request()->all())->links() }}
            </div>
        </div>
    </div>

@endsection
