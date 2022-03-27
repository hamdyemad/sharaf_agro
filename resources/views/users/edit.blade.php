@extends('layouts.master')

@section('title')
{{ translate('edit employee') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $user->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('all employees') }} @endslot
        @slot('route2') {{ route('users.index') }} @endslot
        @slot('li3') {{ $user->name }} @endslot
    @endcomponent
    <div class="create_user">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit employee') }}
                </div>
                <div class="card-body">
                    <form class="form-horizontal mt-4" method="POST" action="{{ route('users.update', $user) }}"
                        enctype="multipart/form-data">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            @if(Auth::user()->type == 'admin')
                                <div class="col-12 col-md-6 branch_col">
                                    <div class="form-group">
                                        <label for="branch_id">{{ translate('the branch') }}</label>
                                        <select class="form-control select2" name="branch_id">
                                            @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if ($user->branch_id ==  $branch->id) selected @endif>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('name') }}</label>
                                    <input type="text" name="name" value="{{ $user->name }}"
                                        class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(request('type') == 'sub-admin')
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="category">{{ translate('permessions') }}</label>
                                        <select class="form-control select2 select2-multiple" name="roles[]"
                                            data-placeholder="{{ translate('choose') }}" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @if ($user->roles->contains($role->id)) selected @endif>
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="useremail">{{ translate('email') }}</label>
                                    <input type="email" name="email" class="form-control" name="email"
                                        value="{{ $user->email }}" id="useremail"
                                        autocomplete="email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('profile picture') }}</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden
                                        name="avatar" value="{{ old('avatar') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="imgs mt-2 d-flex">
                                        @if ($user->avatar)
                                            <img class="rounded" src="{{ asset($user->avatar) }}" alt="">
                                        @else
                                            <img class="rounded" src="{{ asset('images/avatar.jpg') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">{{ translate('phone') }}</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" autocomplete="phone"
                                        class="form-control" autofocus id="phone">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">{{ translate('address') }}</label>
                                    <input type="text" name="address" value="{{ $user->address }}" autocomplete="address"
                                        class="form-control" autofocus id="address">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">{{ translate('password') }}</label>
                                    <input type="password" class="form-control" name="password"
                                        autocomplete="new-password" id="userpassword">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ translate('edit') }}</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-info">{{ translate('back to employees') }}</a>
                                </div>
                            </div>
                        </div>




                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script>
        let branch_col = `
            <div class="col-12 col-md-6 branch_col">
                <div class="form-group">
                    <label for="name">فرع انشاء الطلب</label>
                    <select class="form-control select2" name="branch_id">
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @if(old('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        `;
        $(".order_type").on('change', function() {
            arrayOfValues = $(this).val();
            if (arrayOfValues.includes('online')) {
                $(".branch_col").remove();
            } else {
                $(this).parent().parent().after(branch_col);
            }
        })
    </script>
@endsection
