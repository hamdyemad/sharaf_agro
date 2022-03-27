<ul class="user_nav">
    <div class="heading text-center mt-2">
        @if (Auth::user()->avatar)
            <img class="rounded mb-1" src="{{ asset(Auth::user()->avatar) }}" alt="">
        @else
            <img class="rounded mb-1" src="{{ asset('images/avatar.jpg') }}" alt="">
        @endif
        <span class="badge badge-primary d-block m-auto">{{ Auth::user()->name }}</span>
    </div>
    <li class="@if(activeRoute('frontend.profile')) active_link @endif"><a href="{{ route('frontend.profile', Auth::user()) }}">حسابى</a></li>
    <li class="@if(activeRoute('frontend.orders')) active_link @endif"><a href="{{ route('frontend.orders') }}">الطلبات</a></li>
    <li class="@if(activeRoute('frontend.payments')) active_link @endif"><a href="{{ route('frontend.payments') }}">المدفوعات</a></li>
</ul>
