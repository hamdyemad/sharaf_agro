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
    <div class="news">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الأخبار</h2>
                    @can('news.create')
                        <div>
                            <a href="{{ route('news.create') }}" class="btn btn-primary mb-2">انشاء خبر</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('news.index') }}" method="GET">
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
                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th><span class="max">أسم الخبر</span></th>
                                <th><span class="max">تفاصيل الخبر</span></th>
                                <th><span class="max">وقت الأنشاء</span></th>
                                <th><span class="max">وقت أخر تعديل</span></th>
                                <th><span class="max">الأعدادات</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $new)
                                <tr>
                                    <th scope="row">{{ $new->id }}</th>
                                    <td>
                                        <div class="d-flex">
                                            @if ($new->images && is_array($new->images))
                                                <img src="{{ asset(json_decode($new->images)[0]) }}" alt="">
                                            @else
                                                <img src="{{ asset('images/default.jpg') }}" alt="">
                                            @endif
                                            <h3 class="max ml-3">
                                                @if(strlen($new->name) > 30)
                                                {{ mb_substr($new->name, 0, 30) . '...' }}
                                                @else
                                                {{ $new->name }}
                                                @endif
                                            </h3>
                                        </div>
                                    </td>
                                    <td>
                                        <p>
                                            @if(strlen($new->details) > 60)
                                            {{ mb_substr(strip_tags($new->details), 0, 60) . '...' }}
                                            @else
                                            {{ strip_tags($new->details) }}
                                            @endif
                                        </p>
                                    </td>
                                    <td>{{ $new->created_at->diffForHumans() }}</td>
                                    <td>{{ $new->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('news.show')
                                                <a class="btn btn-success mr-1" href="{{ route('news.show', $new) }}">
                                                    <span>اظهار</span>
                                                    <span class="mdi mdi-eye ml-1"></span>
                                                </a>
                                            @endcan
                                            @can('news.edit')
                                                <a class="btn btn-info mr-1"
                                                    href="{{ route('news.edit', $new) }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>
                                            @endcan
                                            @can('news.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $new->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $new->id,
                                                'route' => route('news.destroy', $new->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $news->appends(request()->all())->links() }}
                @else
                    <div class="alert alert-info">لا يوجد أخبار</div>
                @endif
            </div>
        </div>
    </div>

@endsection
