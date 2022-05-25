<table>
    <thead>
        <tr>
            <th>#</th>
            <th>الشركة</th>
            <th>أسم الراسل</th>
            <th>رقم موبيل الراسل</th>
            <th>الشركة</th>
            <th>أسم المركب</th>
            <th>تفاصيل المركب</th>
            <th>القسم</th>
            <th>القسم الفرعى</th>
            <th>الحالة</th>
            <th>السبب</th>
            <th>وقت الأنشاء</th>
            <th>وقت أخر تعديل</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <th>{{ $order->customer->name }}</th>
                <th>{{ $order->sender_name }}</th>
                <th>{{ $order->sender_phone }}</th>
                <td>{{ $order->name }}</td>
                <td>
                    {{ $order->details }}
                </td>
                <td>
                    {{ $order->category->name }}
                </td>
                @if($order->sub_category)
                    <td>
                        {{ $order->sub_category->name }}
                    </td>
                @endif
                <td>
                    {{ $order->status->name }}
                </td>
                <td>
                    {{ $order->reason }}
                </td>
                <td>
                    {{ $order->created_at }}
                </td>
                <td>
                    {{ $order->updated_at }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
