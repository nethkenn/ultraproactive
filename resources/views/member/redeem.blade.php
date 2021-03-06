@extends('member.layout')
@section('content')

    <style>
        .encashment .header {
            background-color: #0000D3;
            color: #fff;
            font-size: 14.58px;
            padding: 15px 35px;
            border-bottom: 10px solid #0000A7;
            text-align: left;
        }
        .encashment .body .header-button a button, .encashment .body .ui-sliders a button {
            background-color: #0000A7;
            border-color: #0000A7;
        }
    </style>

@if(isset($error))
<div class="alert alert-danger">
    <ul>
        <li>{{ $error }}</li>
    </ul>
</div>
@endif
@if(isset($success))
<div class="alert alert-success">
    <ul>
        <li>{{ $success }}</li>
    </ul>
</div>
@endif
<div class="encashment">
  @if($slotnow)
    <form method="POST">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <div class="header">Redeem ( Slot #{{$slotnow->slot_id}} )</div>
    <div class="body">
        <div class="col-md-12 header-button">

            <a style="cursor: pointer;" class="forhistory">
                <button type="button">View Redeem Codes</button>
            </a>
        </div>
        <div class="title">
            Choose amount for Redeeming Personal UPcoins.
        </div>
        <div class="ui-sliders">
          <div class="col-md-12">
              <div class="col-md-6 text-right"><b>Personal UPcoins</b> : {{$total_personal_upcoins}}</div>
              <div class="col-md-6 text-right"><b>Redeemed UPcoins</b> : {{-1 * $reedemed_upcoins}}</div>
          </div>
          
          <div class="col-md-12">
              <div class="col-md-6 text-right"><b>Remaining UPcoins</b> : {{$total_personal_upcoins - (-1 * $reedemed_upcoins)}}</div>
          </div>
         
          <select id="typeencashment" name="requested_amount">
            <option>250</option>
            <option>500</option>
            <option>1000</option>
            <option>10000</option>
            <option>20000</option>
            <option>30000</option>
          </select>

          <a style="cursor: pointer;">
            <button type="submit" id="clickencash" >Redeem</button>
          </a>
        </div>
    </div>
    </form>
    @else
        <div class="header">No Slot</div>
    @endif
</div>


<div class="remodal create-slot" data-remodal-id="encashment_history">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-encashment.png">
        Redeem Codes
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-12 para">
        <table class="footable">
            <thead>
                <tr>
                    <th>Request Code</th>
                    <th data-hide="phone">Amount</th>
                    <th data-hide="phone">Status</th>
                </tr>
            </thead>
            <tbody>
                @if($request)
                    @foreach($request as $h)
                        <tr class="tibolru">
                            <td>{{$h->request_code}}</td>
                            <td>{{$h->amount}}</td>
                            <td>{{$h->status}}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('script')

  <script type="text/javascript" src="/resources/assets/frontend/js/redeem.js"></script>


@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/encashment.css">
@endsection