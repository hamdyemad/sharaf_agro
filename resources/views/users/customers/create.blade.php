@extends('layouts.master')

@section('title')
انشاء شركة
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') انشاء شركة @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') كل الشركات @endslot
        @slot('route2') {{ route('customers.index') }} @endslot
        @slot('li3') انشاء شركة @endslot
    @endcomponent
    <div class="create_user">
        <div class="card">
            <div class="card-header">
                انشاء شركة
            </div>
            <div class="card-body">
                <form class="form-horizontal mt-4" method="POST" action="{{ route('customers.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">أسم الشركة</label>
                                <input type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                    class="form-control" autofocus id="name">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="username">أسم المستخدم</label>
                                <input type="text" name="username" value="{{ old('username') }}" autocomplete="username"
                                    class="form-control" autofocus id="username">
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">البريد الألكترونى</label>
                                <input type="email" name="email" class="form-control" name="email"
                                    value="{{ old('email') }}" id="email"
                                    autocomplete="email">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">الصورة الشخصية</label>
                                <input type="file" class="form-control input_files" accept="image/*" hidden
                                    name="avatar" value="{{ old('avatar') }}">
                                <button type="button" class="btn btn-primary form-control files">
                                    <span class="mdi mdi-plus btn-lg"></span>
                                </button>
                                <div class="imgs mt-2 d-flex"></div>
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4>الأشخاص المسئولة</h4>
                                    <button type="button" class="btn btn-success add_responsible">أضافة</button>
                                </div>
                                <div class="card-body @if(old('responsible')) @else d-none @endif">
                                    <table class="table responsible_table">
                                        <thead>
                                            <th>#</th>
                                            <th>الأسم</th>
                                            <th>
                                                رقم الموبيل
                                            </th>
                                            <th>الأعدادات</th>
                                        </thead>
                                        <tbody>
                                            @if(old('responsible'))
                                                @foreach (old('responsible') as $responsible)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>
                                                            <input class="form-control" type="text" value="{{ $responsible['name'] }}" name="responsible[{{ $loop->index }}][name]">
                                                            @error("responsible.*.name")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td class="phones_td">
                                                            @foreach ($responsible['phones'] as $phone)
                                                                <div class="mb-1">
                                                                    <input class="form-control" type="text" value="{{ $phone }}" name="responsible[{{ $loop->index }}][phones][]">
                                                                    @error("responsible.*.phones.*")
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success add_phone ml-2">اضافة رقم جديد</button>
                                                            <button type="button" class="btn btn-danger remove_responsible">ازالة</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="username">رقم التليفون</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="form-control">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="username">العنوان (أختيارى)</label>
                                <input type="text" name="address" value="{{ old('address') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="userpassword">الرقم السرى</label>
                                <input type="password" class="form-control" name="password"
                                    autocomplete="new-password" value="{{ old('password') }}" id="userpassword">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="userpassword">تأكيد الرقم السرى</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="userconfirmpassword" value="{{ old('password_confirmation') }}">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">تسجيل الحساب</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-info">الرجوع الى الشركات</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
<script>

    let index = 0;

    function phone_div(index) {
        return `
        <div class="mb-1">
            <input class="form-control" type="text" name="responsible[${index}][phones][]">
            @error("responsible.*.phones.*")
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    `;
    }
    function tr(index) {
        return `
            <tr>
                <td>${index}</td>
                <td>
                    <input class="form-control" type="text" name="responsible[${index}][name]">
                    @error("responsible.*.name")
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
                <td class="phones_td">
                    <div class="mt-1">
                        <input class="form-control" type="text" name="responsible[${index}][phones][]">
                        @error("responsible.*.phones.*")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-success add_phone ml-2">اضافة رقم جديد</button>
                    <button type="button" class="btn btn-danger remove_responsible">ازالة</button>
                </td>
            </tr>
        `;
    }
    $(".add_responsible").on('click', function() {
        index++
        $(".responsible_table").parent().removeClass('d-none');
        $(".responsible_table tbody").append(tr(index));
        add_phone(index);
        remove_tr();
    });

    function add_phone(index) {
        $(".add_phone").on('click', function() {
            $(this).parent().parent().find('.phones_td').prepend(phone_div(index));
        });
    }
    add_phone();


    function remove_tr() {
        $(".remove_responsible").on('click', function() {
            $(this).parent().parent().remove();
            if($(".responsible_table tbody").children().length == 0) {
                $(".responsible_table").parent().addClass('d-none');
            }
        });
    }
    remove_tr();

</script>
@endsection
