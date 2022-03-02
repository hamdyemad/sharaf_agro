@extends('frontend.layout')

@section('content')
    <div class="profile pt-4 pb-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 d-none d-md-block">
                            @include('frontend.inc.user_computer_nav')
                        </div>
                        <div class="col-12 col-md-10">
                            @include('inc.invoice', ['order' => $order])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
@endsection
