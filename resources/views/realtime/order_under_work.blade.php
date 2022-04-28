<script>
var orderChannel = pusher.subscribe("RealOrderUnderWork");
orderChannel.bind("App\\Events\\RealOrderUnderWork", function(data) {
    if (data) {
        console.log(data);
        if (
            "{{Auth::user()->type}}" == "admin"
        ) {
            let notify_count = parseInt(
                    $(".navbar-header .dropdown .badge-pill").text()
                ),
                orders_under_work_count = parseInt(
                    $(".navbar-header .dropdown .orders_under_work_count").text()
                );
            $(".navbar-header .dropdown .badge-pill").text(notify_count + 1);
            $(".navbar-header .dropdown .orders_under_work_count").text(orders_under_work_count + 1);
            $(".navbar-header .dropdown .orders_under_work").prepend(`
                <a href="{{ asset('/') }}admin/orders_under_work/show/${data.order.id}" class="text-reset notification-item">
                    <div class="media">
                        <div class="avatar-xs mr-3">
                            <span class="avatar-title border-secondary rounded-circle ">
                                <i class="mdi mdi-wechat"></i>
                            </span>
                        </div>
                        <div class="media-body">
                            <h6 class="mt-0 mb-1">الشركة : ${data.customer_name}</h6>
                            <h6 class="mt-0 mb-1">أسم المركب : ${data.order.name}</h6>
                            <h6 class="mt-0 mb-1">القسم الرئيسى : ${data.main_category}</h6>
                            <h6 class="mt-0 mb-1">القسم الفرعى : ${data.sub_category}</h6>
                            <h6 class="mt-0 mb-1">الحالة : <span class="badge badge-secondary p-1">${data.status}</span></h6>
                        </div>
                    </div>
                </a>
            `);
        }
    }
});

</script>
