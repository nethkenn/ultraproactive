@extends('member.layout')
@section('content')
<div class="encashment">
    <div class="header">Encashment ( Slot #5 )</div>
    <div class="body">
        <div class="col-md-12 header-button">
            <a href="member/encashment#encashment_history">
                <button type="button" onclick="location.href='member/encashment#encashment_history'">Encashment History ( 2 )</button>
            </a>
        </div>
        <div class="title">
            Enter the amount you'd like to encash.
        </div>
        <div class="ui-sliders">
          <div id="slider-range-min"></div>
          <div class="col-xs-6 slider-info text-left">0.00</div>
          <div class="col-xs-6 slider-info text-right">1200.00</div>
          <input type="text" id="amount" readonly>
          <select>
            <option>Bank Deposit</option>
          </select>
          <a href="member/encashment#encashment">
            <button type="button" onclick="location.href='member/encashment#encashment'">Submit Encashment</button>
          </a>
        </div>
    </div>
</div>
@endsection
@section('script')
  <script>
  $(function() {
    $( "#slider-range-min" ).slider({
      range: "min",
      value: 37,
      min: 1,
      max: 700,
      slide: function( event, ui ) {
        // $( "#amount" ).val( "$" + ui.value );
        $( "#amount" ).val( ui.value );
      }
    });
    // $( "#amount" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
    $( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ) );
  });
  </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/encashment.css">
@endsection