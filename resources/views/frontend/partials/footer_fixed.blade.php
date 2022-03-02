@if(Auth::check())
  <!-- Modal -->
  <div class="modal fade side_nav" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @include('frontend.inc.user_computer_nav')
        </div>
      </div>
    </div>
  </div>
    <div class="footer_fixed d-block d-lg-none">
        <div class="row">
            <div class="col-4">
                <a href="{{ route('frontend.home') }}">
                    <span class="mdi mdi-home"></span>
                </a>
            </div>
            <div class="col-4">
                <a href="#" data-toggle="modal" data-target="#exampleModal">
                    <span class="mdi mdi-account-outline"></span>
                </a>
            </div>
            <div class="col-4">
                @php
                    $orders = App\Models\Order::where('client_viewed', 0)
                    ->where('user_id', Auth::id())
                    ->orWhere('client_status_viewed', 0)
                    ->where('user_id', Auth::id())->latest()->get();
                @endphp
                <a class="bell" href="#" data-toggle="modal" data-target="#notify_modal">
                    <span class="mdi mdi-bell-outline">
                        <span class="badge badge-danger badge-pill notify">{{ count($orders) }}</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
    {{-- Notification Modal --}}
    <div class="modal fade" id="notify_modal" tabindex="-1" aria-labelledby="notify_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notify_modal"> الطلبات (<span class="order_notify">{{ count($orders) }}</span>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="notifications" style="max-height: 230px; overflow-y: scroll">
                    @foreach ($orders as $order)
                        <a href="{{ route('frontend.orders.show', $order) }}" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title border-primary rounded-circle ">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">رقم الطلب : ({{ $order->id }})</h6>
                                    <h6 class="mt-0 mb-1">حالة الطلب : ({{ $order->status->name }})</h6>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="p-2 border-top">
                    <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ route('frontend.orders') }}">
                        عرض الطلبات
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
@endif
