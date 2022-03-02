@extends('layouts.auth-master')

@section('title', 'Email Confirmation')

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
                                <p class="text-muted text-center">اعادة تهيئة كلمة السر</p>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="form-horizontal mt-4" method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">البريد الألكترونى</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus
                                            placeholder="البريد الألكترونى">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" id="register"
                                            type="submit">ارسال رابط اعادة تهيئة الرقم السرى</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p>ليس لديك حساب ؟<a href="/register" class="text-primary"> تسجيل حساب جديد </a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
