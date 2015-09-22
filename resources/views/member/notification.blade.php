@extends('member.layout')
@section('content')
<div class="col-md-12 right">
    <!-- NOTIFICATIONS -->
    @if($_notification)
    <div class="holder">
        <div class="header">
            <img src="/resources/assets/frontend/img/icon-notification.png">
            Account Notifications
        </div>
        @foreach($_notification as $log)
        <div class="holders para">
            <div class="linyanglinya"></div>
            <div class="liness para">
                <div class="date col-md-12">{{ $log->date }}</div>
                <div class="text col-md-11">{!! $log->logs !!}</div>
            </div>
        </div>
        @endforeach

    </div>
    @endif
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/dashboard.css">
@endsection