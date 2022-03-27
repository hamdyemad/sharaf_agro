@extends('frontend.layout')

@section('content')
    <div class="order_confirmed">
        <div class="container">
            @include('frontend.partials.order_tracker', ['cartTrack' => 'active','revieveTrack' => 'active','payTrack' => 'active','doneTrack' => 'active'])
            <div class="card">
                <div class="card-header text-center">
                    <h1>تم انشاء الطلب بنجاح</h1>
                    <span class="mdi mdi-check-decagram"></span>
                </div>
                <div class="card-body">
                    @include('frontend.partials.invoice')
                    <a href="{{ route('frontend.home') }}" class="btn btn-primary btn-block">
                        الرجوع الى القائمة الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
<script>
        if("{{ request('session_id') }}" == 'success_payment') {
            toastr.success('تم الدفع بنجاح');
        }
</script>
@endsection
