<table>
    <thead>
        <tr>
            <th>#</th>
            <th>الشركة</th>
            <th>أسم الراسل</th>
            <th>رقم موبيل الراسل</th>
            <th>الأستفسار</th>
            <th>القسم الرئيسى</th>
            <th>القسم الفرعى</th>
            <th>الحالة</th>
            <th>وقت الأنشاء/th>
            <th>وقت أخر تعديل</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inquires as $inquire)
            <tr>
                <td>{{ $inquire->id }}</td>
                <th>{{ $inquire->customer->name }}</th>
                <th>{{ $inquire->sender_name }}</th>
                <th>{{ $inquire->sender_phone }}</th>
                <td>
                    {{ $inquire->details }}
                </td>
                <td>
                    {{ $inquire->category->name }}
                </td>
                @if($inquire->sub_category)
                    <td>
                        {{ $inquire->sub_category->name }}
                    </td>
                @endif
                <td>
                    {{ $inquire->status->name }}
                </td>
                <td>
                    {{ $inquire->created_at }}
                </td>
                <td>
                    {{ $inquire->updated_at }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
