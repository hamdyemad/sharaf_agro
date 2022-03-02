@extends('frontend.layout')

@section('content')
    <div class="receive">
        <div class="container">
            @include('frontend.partials.order_tracker', ['cartTrack' => 'active','revieveTrack' => 'active','payTrack' => '','doneTrack' => ''])
            <div class="card">
                <div class="card-header">
                    تفاصيل الأستلام
                </div>
                <div class="card-body">
                    <form action="{{ route('frontend.receive') }}" method="GET">
                        <select class="form-control select2" name="type" onchange="this.form.submit()">
                            <option value="">طريقة الأستلام</option>
                            <option value="inhouse" @if(request('type') == 'inhouse') selected @endif>أستلام من الفرع</option>
                            <option value="online" @if(request('type') == 'online') selected @endif>توصيل الى المنزل</option>
                        </select>
                    </form>
                    <div class="d-flex justify-content-end mt-2">
                        <a href="{{ route('frontend.payment') }}" class="btn btn-primary">
                            الذهاب الى عملية الدفع
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
    <script>
    </script>
@endsection
