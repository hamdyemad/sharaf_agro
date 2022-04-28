<table>
    <thead>
        <tr>
            <th>أسم الشركة</th>
            <th>رصيد الشركة</th>
            <th>وقت الأنشاء</th>
            <th>وقت أخر تعديل</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($balances as $balance)
            <tr>
                <td>{{ $balance->user->name }}</td>
                <td>{{ $balance->balance }}</td>
                <td>
                    {{ $balance->created_at }}
                </td>
                <td>
                    {{ $balance->updated_at }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
