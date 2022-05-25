@extends('layouts.master')

@section('title')
الموظفين
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الموظفين @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') الموظفين @endslot
    @endcomponent
    <div class="all_users">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الموظفين</h2>
                    @can('users.create')
                        <div>
                            <a href="{{ route('users.create') }}" class="btn btn-primary d-block d-md-flex mb-2">انشاء موظفين</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6 roles_col">
                            <div class="form-group">
                                <label for="category">الصلاحيات</label>
                                <select class="form-control select2" name="role_id">
                                    <option value="">أختر</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @if ($role->id == request('role_id')) selected @endif>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم الموظف</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم المستخدم</label>
                                <input class="form-control" name="username" type="text" value="{{ request('username') }}">
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
                                <label for="banned">الحظر</label>
                                <select class="form-control select2" name="banned">
                                    <option value="">أختر</option>
                                    <option value="1" @if (request('banned') == 1) selected @endif>محظور</option>
                                    <option value="2" @if (request('banned') == 2) selected @endif>غير محظور</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mt-md-4">
                                <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span class="max">الأسم</span></th>
                                    <th><span class="max">أسم المستخدم</span></th>
                                    <th><span class="max">البريد الألكترونى</span></th>
                                    <th><span class="max">الأقسام</span></th>
                                    <th><span class="max">الصلاحيات</span></th>
                                    <th><span class="max">العنوان</span></th>
                                    <th><span class="max">رقم التليفون</span></th>
                                    @if(Auth::user()->type == 'admin')
                                        <th><span class="max">الحظر</span></th>
                                    @endif
                                    <th><span class="max">وقت الأنشاء</span></th>
                                    <th><span class="max">وقت أخر تعديل</span></th>
                                    <th><span class="max">الأعدادات</span></th>
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
                                                <span class="max">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div>
                                                @foreach ($user->main_categories as $userCategory)
                                                    <span class="badge badge-primary d-block">{{ $userCategory->category->name}}</span>
                                                    @foreach ($userCategory->category->sub_categories->whereIn('id', $user->sub_categories->pluck('sub_category_id')->toArray()) as $userSubCategory)
                                                        <span class="badge badge-secondary d-block">{{ $userSubCategory->name}}</span>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                @forelse ($user->roles as $role)
                                                    <span class="badge badge-primary d-block">{{ $role->name }}</span>
                                                @empty
                                                <div class="alert alert-info max">لا يوجد صلاحيات</div>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td><p>{{ $user->address }}</p></td>
                                        <td>{{ $user->phone }}</td>
                                        @if(Auth::user()->type == 'admin')
                                            <td>
                                                <form action="{{ route('users.banned', $user) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="checkbox" onchange="this.form.submit()" name="active" id="switch-{{ $loop->index }}" switch="bool"
                                                        @if($user->banned)
                                                        checked
                                                        @endif />
                                                        <label for="switch-{{ $loop->index }}" data-on-label="نعم" data-off-label="لا"></label>
                                                    </div>
                                                </form>
                                            </td>
                                        @endif
                                        <td>
                                            {{ $user->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            {{ $user->updated_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <div class="options d-flex">
                                                @can('users.edit')
                                                    <a class="btn btn-info mr-1" href="{{ route('users.edit', $user) }}">
                                                        <span>تعديل</span>
                                                        <span class="mdi mdi-circle-edit-outline"></span>
                                                    </a>
                                                @endcan
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
                        {{ $users->appends(request()->all())->links() }}
                    </div>
                @else
                <div class="alert alert-info">لا يوجد موظفين</div>
                @endif
            </div>
        </div>
    </div>
@endsection
