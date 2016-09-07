@extends('member.layout')
@section('content')

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
          <div class="max col-xs-6 text-right">Personal UPcoins : {{$total_personal_upcoins}}</div>
          <div class="max col-xs-6 text-right">Redeemed UPcoins : {{-1 * $reedemed_upcoins}}</div>
         
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