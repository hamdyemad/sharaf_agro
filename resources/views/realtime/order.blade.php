<script>
var orderChannel = pusher.subscribe("newOrder");
orderChannel.bind("App\\Events\\newOrder", function(data) {
    if (data) {
        console.log(data);
        if (
            data.order.customer_id == "{{ Auth::id() }}" ||
            "{{Auth::user()->type}}" == "admin"
        ) {
            let notify_count = parseInt(
                    $(".navbar-header .dropdown .badge-pill").text()
                ),
                order_count = parseInt(
                    $(".navbar-header .dropdown .order_count").text()
                );
            $(".navbar-header .dropdown .badge-pill").text(notify_count + 1);
            $(".navbar-header .dropdown .order_count").text(order_count + 1);
            $(".navbar-header .dropdown .orders").prepend(`
                <a href="{{ asset('/') }}admin/orders/show/${data.order.id}" class="text-reset notification-item">
                    <div class="media">
                        <div class="avatar-xs mr-3">
                            <span class="avatar-title border-success rounded-circle ">
                                <i class="mdi mdi-cart-outline"></i>
                            </span>
                        </div>
                        <div class="media-body">
                            <h6 class="mt-0 mb-1">الشركة : ${data.customer_name}</h6>
                            <h6 class="mt-0 mb-1">أسم المركب : ${data.order.name}</h6>
                            <h6 class="mt-0 mb-1">القسم الرئيسى : ${data.main_category}</h6>
                            <h6 class="mt-0 mb-1">القسم الفرعى : ${data.sub_category}</h6>
                            <h6 class="mt-0 mb-1">الحالة : <span class="badge badge-success p-1">${data.status}</span></h6>
                        </div>
                    </div>
                </a>
            `);
        }
    }
});

</script>
