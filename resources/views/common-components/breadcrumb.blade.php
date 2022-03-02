<div class="col-sm-6">
    <div class="page-title-box">
        @if (isset($title))
            <h4>{{ $title }}</h4>
        @endif
        <ol class="breadcrumb m-0">
            @if (isset($li1))
                <li class="breadcrumb-item"><a href="@if (isset($route1)){{ $route1 }} @endif">{{ $li1 }}</a></li>
            @endif
            @if (isset($li2))
                <li class="breadcrumb-item"><a href="@if (isset($route2)){{ $route2 }} @endif">{{ $li2 }}</a></li>
            @endif
            @if (isset($li3))
                <li class="breadcrumb-item active">{{ $li3 }}</li>
            @endif
        </ol>
    </div>
</div>
