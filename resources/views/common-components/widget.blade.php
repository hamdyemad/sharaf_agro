<a href="@if (isset($route)) {{ $route }} @endif">
    <div class="card mini-stat @if (isset($bg)) {{ $bg }} @else bg-primary @endif">
        <div class="card-body mini-stat-img">
            <div class="mini-stat-icon">
                <i class="@if (isset($icons)) {{ $icons }} @else mdi mdi-arrow-up-bold-circle-outline float-right @endif"></i>
            </div>
            <div class="text-white">
                <h6 class="text-uppercase mb-3 font-size-16">@if (isset($title)) {{ $title }} @else title @endif</h6>
                <h2 class="mb-4">@if (isset($price)) {{ $price }} @else price @endif</h2>
                @if (isset($per))
                    <span class="badge {{ $badgeClass }}">
                        @if (isset($per)) {{ $per }}  @endif
                    </span>
                @endif
            </div>
        </div>
    </div>
</a>
