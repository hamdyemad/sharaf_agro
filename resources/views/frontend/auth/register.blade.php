@extends('frontend.layout')

@section('title')
تسجيل حساب جديد
@endsection

@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <h3 class="text-center mt-4">
                                @if (get_setting('logo'))
                                    <a href="/" class="logo logo-admin"><img src="{{ asset(get_setting('logo')) }}"
                                            height="30" alt="logo"></a>
                                @else
                                    <a href="/" class="logo logo-admin"><img src="{{ URL::asset('/images/default.jpg') }}"
                                            height="30" alt="logo"></a>
                                @endif
                            </h3>
                            <div class="p-3">
                                <form class="form-horizontal mt-4" method="POST" action="{{ route('frontend.signup') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="useremail">البريد الألكترونى</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" id="useremail" placeholder="أدخل الأيميل"
                                            autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="username">الأسم</label>
                                        <input type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                            class="form-control @error('name') is-invalid @enderror" autofocus id="name"
                                            placeholder="ادخل الأسم">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">الرقم السرى</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" autocomplete="new-password" id="userpassword"
                                            placeholder="ادخل الرقم السرى">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">اتمام الرقم السرى</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="userconfirmpassword" placeholder="اتمام الرقم السرى">
                                    </div>

                                    <div class="form-group row mt-4">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit">تسجيل الحساب</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p>لديك حساب بالفعل ؟<a href="/login" class="text-primary"> تسجيل الدخول </a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
