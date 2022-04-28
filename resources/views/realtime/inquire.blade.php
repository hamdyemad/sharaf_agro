<script>
var orderChannel = pusher.subscribe("RealInquire");
orderChannel.bind("App\\Events\\RealInquire", function(data) {
    if (data) {
        let notify_count = parseInt(
                $(".navbar-header .dropdown .badge-pill").text()
            ),
            inquires_count = parseInt(
                $(".navbar-header .dropdown .inquires_count").text()
            );
        $(".navbar-header .dropdown .badge-pill").text(notify_count + 1);
        $(".navbar-header .dropdown .inquires_count").text(inquires_count + 1);
        $(".navbar-header .dropdown .inquires").prepend(`
            <a href="{{ asset('/') }}admin/inquires/show/${data.inquire.id}" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title border-secondary rounded-circle ">
                            <i class="mdi mdi-wechat"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">الشركة : ${data.customer_name}</h6>
                        <h6 class="mt-0 mb-1">الأستفسار : ${data.inquire.details}</h6>
                        <h6 class="mt-0 mb-1">القسم الرئيسى : ${data.main_category}</h6>
                        <h6 class="mt-0 mb-1">القسم الفرعى : ${data.sub_category}</h6>
                        <h6 class="mt-0 mb-1">الحالة : <span class="badge badge-primary p-1">${data.status}</span></h6>
                    </div>
                </div>
            </a>
        `);
    }
});

</script>
