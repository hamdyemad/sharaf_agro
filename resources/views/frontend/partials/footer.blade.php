<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="logo">
                    @if (get_setting('logo'))
                        <img src="{{ asset(get_setting('logo')) }}">
                    @else
                        <img src="{{ URL::asset('/images/default.jpg') }}">
                    @endif
                </div>
                @if(get_setting('description'))
                <p class="mt-2">{{ get_setting('description') }}</p>
                @endif
                <ul class="social-links d-flex align-items-center">
                    <li><a href="{{ get_setting('facebook') }}"><span class="mdi mdi-facebook"></span></a></li>
                    <li><a href="{{ get_setting('instagram') }}"><span class="mdi mdi-instagram"></span></a></li>
                    <li><a href="{{ get_setting('youtube') }}"><span class="mdi mdi-youtube"></span></a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                @php
                    $branches = \App\Models\Branch::all();
                @endphp
                <div class="row">
                    <div class="col">
                        @if(count($branches) > 0)
                            <ul>
                                <li><a>الفروع</a></li>
                                @foreach (\App\Models\Branch::all() as $branch)
                                    <li><a href="{{ $branch->id }}">{{ $branch->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="col">
                    <ul>
                        <li><a>الصفحات</a></li>
                        <li><a href="{{ route('frontend.login') }}">تسجيل الدخول</a></li>
                        <li><a href="{{ route('frontend.register') }}">تسجيل حساب</a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="down-footer text-center">
        كل الحقوق محفوظة لدى {{ get_setting('project_name') }}
    </div>
</footer>
