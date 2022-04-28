<table>
    <thead>
        <tr>
            <th>#</th>
            <th>الشركة</th>
            <th>أسم المركب</th>
            <th>تفاصيل المركب</th>
            @if(Auth::user()->type == 'admin')
                <th>الموظف المختص</th>
            @endif
            <th>القسم الرئيسى</th>
            <th>القسم الفرعى</th>
            <th>الحالة</th>
            <th>تاريخ التقديم</th>
            @if(Auth::user()->type !== 'user')
                <th>التاريخ المتوقع</th>
            @endif
            <th>تاريخ الأنتهاء</th>
            <th>وقت الأنشاء</th>
            <th>وقت أخر تعديل</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr id="{{ $order->id }}" data-value="{{ $order }}">
                <td scope="row">{{ $order->id }}</td>
                <th>{{ $order->customer->name }}</th>
                <td>{{ $order->name }}</td>
                <td>
                    {{ $order->details }}
                </td>
                @if(Auth::user()->type == 'admin')
                    <td>
                        {{ $order->employee->name }}
                    </td>
                @endif
                <td>
                    {{ $order->category->name }}
                </td>
                @if($order->sub_category)
                    <td>
                        {{ $order->sub_category->name }}
                    </td>
                @endif
                <td>{{ $order->status->name }}</td>
                <td>
                    @if($order->submission_date)
                        {{ $order->submission_date }}
                    @endif
                </td>
                @if(Auth::user()->type !== 'user')
                    <td>
                        @if($order->expected_date)
                            {{ $order->expected_date }}
                        @endif
                    </td>
                @endif
                <td>
                    @if($order->expiry_date)
                        {{ $order->expiry_date }}
                    @endif
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
