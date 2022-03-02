@extends('layouts.master')


@section('title')
{{ $business->name }}
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h2>{{ $business->name . ' - ' . $business->branch->name}}</h2>
                @can('expenses.create')
                    <a href="{{ route('expenses.create', ['type' => request('type')]) }}" class="btn btn-primary mb-2">انشاء
                        {{ $business->name }}</a>
                @endcan
            </div>
            <form action="{{ route('expenses.index') }}" method="GET">
                <input type="text" name="type" hidden value="{{ request('type') }}">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            @if ($business->type == 'income')
                                <label for="name">أسم الأيراد</label>
                            @else
                                <label for="name">أسم المصروف</label>
                            @endif
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            @if ($business->type == 'income')
                                <label for="name">أسم صاحب الأيراد</label>
                            @else
                                <label for="name">أسم صاحب المصروف</label>
                            @endif
                            <input class="form-control" name="expense_for" type="text"
                                value="{{ request('expense_for') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">الهاتف</label>
                            <input class="form-control" name="phone" type="text" value="{{ request('phone') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">المبلغ</label>
                            <input class="form-control" name="price" type="text" value="{{ request('price') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name"></label>
                            <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            @if ($business->type == 'income')
                                <th>أسم الأيراد</th>
                                <th>أسم صاحب الأيراد</th>
                            @else
                                <th>أسم المصروف</th>
                                <th>أسم صاحب المصروف</th>
                            @endif
                            <th>الهاتف</th>
                            <th>المبلغ</th>
                            <th>الملاحظات</th>
                            <th>وقت الأنشاء</th>
                            <th>وقت أخر تعديل</th>
                            <th>الأعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <th scope="row">{{ $expense->id }}</th>
                                <td>{{ $expense->name }}</td>
                                <td>{{ $expense->expense_for }}</td>
                                <td>{{ $expense->phone }}</td>
                                <td>{{ $expense->price }}</td>
                                <td>{{ $expense->notes }}</td>
                                <td>
                                    {{ $expense->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $expense->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('expenses.edit')
                                            <a class="btn btn-info mr-1"
                                                href="{{ route('expenses.edit', $expense) . '?type=' . request('type') }}">
                                                <span>تعديل</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('expenses.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $expense->id }}">
                                                <span>ازالة</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $expense->id,
                                            'route' => route('expenses.destroy', $expense->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $expenses->links() }}
            </div>
        </div>
    </div>
@endsection
