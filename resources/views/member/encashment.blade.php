@extends('member.layout')
@section('content')
<div class="encashment">
  @if($slotnow)
    <div class="header">Encashment ( Slot #{{$slotnow->slot_id}} )</div>
    <div class="body">
        <div class="col-md-12 header-button">

            <a style="cursor: pointer;" class="forhistory">
                <button type="button">Encashment History ( {{$counth}} )</button>
            </a>
        </div>
        <input type="hidden" class="forhidden" value="{{$json}}">
        <div class="title">
            Enter the amount you'd like to encash.
        </div>
        <div class="ui-sliders">
          <div id="slider-range-min"></div>
          <div class="col-xs-6 slider-info text-left">1</div>
          <div class="max col-xs-6 slider-info text-right" val="{{$slotnow->slot_wallet}}">{{$slotnow->slot_wallet}}</div>
          <input type="text" id="amount" value="1" name="val" onkeydown="return ( event.ctrlKey || event.altKey || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) || (95<event.keyCode && event.keyCode<106) || (event.keyCode==8) || (event.keyCode==9) || (event.keyCode>34 && event.keyCode<40) || (event.keyCode==46) )">
          <select id="typeencashment">
            <option value"Bank Deposit">Bank Deposit</option>
            <option value="Cheque">Cheque</option>
          </select>

          <a style="cursor: pointer;">
            <button type="button" id="clickencash" >Submit Encashment</button>
          </a>

        </div>
    </div>
    @else
        <div class="header">No Slot</div>
    @endif
</div>



<div class="remodal create-slot" data-remodal-id="encashment" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-encashments.png">
        Encashment
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="one" class="col-sm-3 control-label">Wallet</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="one" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="two" class="col-sm-3 control-label">Encashment Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="two" name="amount" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="three" class="col-sm-3 control-label">Remaining</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="three" disabled name="subtotal">
                </div>
            </div>

            @foreach($deduction['forjson'] as $j)
            <div class="form-group para">
                <label for="four" class="col-sm-3 control-label">{{$j->deduction_label}}</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="{{$j->deduction_id}}" disabled>
                </div>
            </div>
            @endforeach


            <div class="form-group para">
                <label for="six" class="col-sm-3 control-label">Receivables</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="six" disabled name="total">
                </div>
            </div>
            <input type="hidden" name="typeofencashment" id="enc" value="">
    </div>
             <br>
             <button  type="submit" name="confirmencash" class="orange-btn button">Confirm Encashment</button>
        </form>
</div>


<div class="remodal create-slot" data-remodal-id="encashment_history">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-encashment.png">
        Encashment History
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-12 para">
        <table class="footable">
            <thead>
                <tr>
                    <th>#</th>
                    <th data-hide="phone">Deduction</th>
                    <th data-hide="phone">Status</th>
                    <th data-hide="phone">Type</th>
                    <th data-hide="phone">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if($history)
                    @foreach($history as $h)
                        <tr class="tibolru">
                            <td>{{$h->request_id}}</td>
                            <td>{{$h->deduction}}</td>
                            <td>{{$h->status}}</td>
                            <td>{{$h->type}}</td>
                            <td>{{$h->amount}}</td>
                        </tr>
                    @endforeach
                @endif
              <!--  <tr class="tibolru">
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
                <tr class="tibolru">
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
                <tr class="tibolru">
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
                <tr class="tibolru">
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr> !-->
            </tbody>
        </table>
    </div>
</div>


@endsection
@section('script')
  <script>
  $(function() {
    var max = $(".max").attr('val');
  
    $( "#slider-range-min" ).slider({
      range: "min",
      value: 1,
      min: 1,
      max: max,
      slide: function( event, ui ) {
        // $( "#amount" ).val( "$" + ui.value );
        $( "#amount" ).val( ui.value );
      }
    });
    // $( "#amount" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
    $( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ) );
  });
  </script>
  <script type="text/javascript" src="/resources/assets/frontend/js/encashment.js"></script>


@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/encashment.css">
@endsection