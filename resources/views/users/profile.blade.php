@extends('layouts.master')

@section('title')
تعديل الملف الشخصى
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $user->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ $user->name }} @endslot
    @endcomponent
    <div class="create_user">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل الملف الشخصى
                </div>
                <div class="card-body">
                    <form class="form-horizontal mt-4" method="POST" action="{{ route('users.update_profile', $user) }}"
                        enctype="multipart/form-data">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الأسم</label>
                                    <input type="text" name="name" value="{{ $user->name }}"
                                        class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="useremail">الأيميل</label>
                                    <input type="email" name="email" class="form-control" name="email"
                                        value="{{ $user->email }}" id="useremail"
                                        autocomplete="email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">الصورة الشخصية</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden
                                        name="avatar" value="{{ old('avatar') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="imgs mt-2 d-flex">
                                        @if ($user->avatar)
                                            <img class="rounded" src="{{ asset($user->avatar) }}" alt="">
                                        @else
                                            <img class="rounded" src="{{ asset('images/avatar.jpg') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">الرقم السرى القديم</label>
                                    <input type="password" class="form-control" value="{{ old('old_password') }}" name="old_password"
                                        autocomplete="new-password">
                                    @error('old_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if(Session::has('old_password.invalid'))
                                        <div class="text-danger">{{ Session::get('old_password.invalid') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">الرقم السرى الجديد</label>
                                    <input type="password" class="form-control" name="password"
                                        autocomplete="new-password">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">تعديل الملف الشخصى</button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-info mt-2 mt-md-0">الرجوع الى لوحة التحكم</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
