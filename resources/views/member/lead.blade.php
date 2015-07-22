@extends('member.layout')
@section('content')
<div class="encashment voucher code-vault">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                <ul>
                        <li>{{ $error }}</li>
                </ul>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success">
                <ul>
                        <li>{{ $success }}</li>
                </ul>
            </div>
        @endif
    <div class="table">
        <div class="table-head para">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-lead.png">
                Leads ( {{$leadcount}} )
            </div>
            <div class="col-md-6 ew">
                <a style="cursor: pointer;" class="genlead">
                    <div class="button">How to Generate Leads?</div>
                </a>
                <a style="cursor: pointer;" class="a_lead">
                    <div class="button">Add Leads ( Manually )</div>
                </a>
            </div>
        </div>
        <table class="footable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th data-hide="phone">Email</th>
                    <th data-hide="phone">Join Date</th>
                    <th data-hide="phone"></th>
                </tr>
            </thead>
            <tbody>
                @if($lead)
                    @foreach($lead as $l)
                    <tr class="tibolru">
                        <td>{{$l->account_name}}</td>
                        <td>{{$l->account_email}}</td>
                        <td>{{$l->join_date}}</td>
                        <td><a href="javascript:">Account Link</a></td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="remodal create-slot" data-remodal-id="generate_lead" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-how.png">
        How to Generate Leads
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div style="color: #77818e; font-size: 12p.5x;">You might invite people using this link. </br>People who gives their information using your link become your Leads</div>
    <div>
        @if($acc->account_email)
             <input style="color: #f47265; font-size: 12.5px; width: 80%; margin: 20px auto; padding: 10px; text-align: center; border: 1px solid #eeeeee;" type="text" value="{{$_SERVER['SERVER_NAME']}}/member/leads/{{$acc->account_email}}"></div>
        @else
             <input style="color: #f47265; font-size: 12.5px; width: 80%; margin: 20px auto; padding: 10px; text-align: center; border: 1px solid #eeeeee;" type="text" value="Please add your email first in your account settings."></div>
        @endif
    <br>
    <button class="button" data-remodal-action="confirm">Close</button>
</div>

@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/frontend/js/lead.js"></script>
@endsection
@section('css')

@endsection