<table>
    <thead>
        <tr>
            <th>#</th>
            <th>نوع العملية</th>
            <th>أسم الموظف</th>
            <th>وقت الدخول</th>
            <th>وقت الأنصراف</th>
            <th>تاريخ العملية</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entriesAndExits as $entryAndExit)
            <tr>
                <td scope="row">{{ $entryAndExit['id'] }}</td>
                <td scope="row">
                    @if ($entryAndExit['is_enter'])
                        حضور
                    @endif
                    @if ($entryAndExit['is_exit'])
                        أنصراف
                    @endif
                </td>
                <td scope="row">
                    @if(request('extras'))
                        {{ \App\User::find($entryAndExit['user_id'])->name }}
                    @else
                        {{ $entryAndExit->user->name }}
                    @endif
                </td>
                <td scope="row">
                    @if($entryAndExit['entry'])
                        {{ Carbon\Carbon::createFromDate($entryAndExit['entry'])->format('g:i A') }}
                    @endif
                </td>
                <td scope="row">
                    @if($entryAndExit['exit'])
                        {{ Carbon\Carbon::createFromDate($entryAndExit['exit'])->format('g:i A') }}
                    @endif
                </td>
                <td>
                    {{ $entryAndExit['current_date'] }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
