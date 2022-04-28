<script>
var orderChannel = pusher.subscribe("newNews");
orderChannel.bind("App\\Events\\newNews", function(data) {
    if (data) {
        console.log(data);
        let notify_count = parseInt(
                $(".navbar-header .dropdown .badge-pill").text()
            ),
            news_count = parseInt(
                $(".navbar-header .dropdown .news_count").text()
            );
        $(".navbar-header .dropdown .badge-pill").text(notify_count + 1);
        $(".navbar-header .dropdown .news_count").text(news_count + 1);
        $(".navbar-header .dropdown .news").prepend(`
            <a href="{{ asset('/') }}admin/news/${data.new.id}" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title border-info rounded-circle ">
                            <i class="mdi mdi-newspaper"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">أسم الخبر : ${data.new.name}</h6>
                        <div class="text-muted">
                            <p style="word-break: break-word" class="mb-1">تفاصيل الخبر : ${data.new.details}</p>
                        </div>
                    </div>
                </div>
            </a>
        `);
    }
});

</script>
