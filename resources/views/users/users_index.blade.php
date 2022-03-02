@extends('layouts.master')

@section('title')
المستخدمين
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') المستخدمين @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') المستخدمين @endslot
    @endcomponent
    <div class="all_users">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>المستخدمين</h2>
                </div>
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم المستخدم</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">البريد الألكترونى</label>
                                <input class="form-control" name="email" type="text" value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الهاتف</label>
                                <input class="form-control" name="phone" type="text" value="{{ request('phone') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="banned">الحذر</label>
                                <select class="form-control" name="banned">
                                    <option value="">أختر</option>
                                    <option value="1" @if (request('banned') == 1) selected @endif>محذور</option>
                                    <option value="2" @if (request('banned') == 2) selected @endif>غير محذور</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
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
                                <th>أسم المستخدم</th>
                                <th>البريد الألكترونى</th>
                                <th>الهاتف</th>
                                <th>العنوان</th>
                                <th>الحذر</th>
                                <th>وقت الأنشاء</th>
                                <th>وقت أخر تعديل</th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>
                                        <div class="d-flex">
                                            @if ($user->avatar)
                                                <img src="{{ asset($user->avatar) }}" alt="">
                                            @else
                                                <img src="{{ asset('images/avatar.jpg') }}" alt="">
                                            @endif
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>
                                        <form action="{{ route('users.banned', $user) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="checkbox" onchange="this.form.submit()" name="active" id="switch4" switch="bool"
                                                @if($user->banned)
                                                checked
                                                @endif />
                                                <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $user->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('users.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $user->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $user->id,
                                                'route' => route('users.destroy', $user->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
