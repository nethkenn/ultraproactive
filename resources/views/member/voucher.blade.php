@extends('member.layout')
@section('content')
<div class="encashment voucher code-vault">
    <div class="table">
        <div class="table-head para">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-voucher.png">
                Vouchers
            </div>
        </div>
        <table class="footable">
            <thead>
                <tr>
                    <th>Voucher Reference No.</th>
                    <th data-hide="phone">Voucher Code.</th>
                    <th data-hide="phone,phonie">Claimed</th>
                    <th data-hide="phone">Total Amount</th>
                    <th data-hide="phone,phonie"></th>
                </tr>
            </thead>
            <tbody>
                @if($_voucher)
                    @foreach ($_voucher as $voucher)  
                        <tr class="tibolru">
                            <td>{{$voucher->voucher_id}}</td>
                            <td>{{$voucher->voucher_code}}</td>
                            <td><div class="check"><input disabled type="checkbox" {{$voucher->claimed == 1 ? 'checked' : '' }}><div class="bgs"></div></div></td>
                            <td>{{$voucher->total_amount}}</td>
                            <td><a href="#voucher" class="view-voucher" voucher-id="{{$voucher->voucher_id}}">View Voucher</a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<div id="section-to-print" class="remodal" data-remodal-id="view-voucher-product" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
    <img class="voucher_preloader" src="/resources/assets/img/preloader_cart.png" style="display:none;">
    <div id="view-voucher-product-container" class="">

    </div>
</div>
<style type="text/css">
    @media print {
      body * {
        visibility: hidden;
      }
      #section-to-print, #section-to-print * {
        visibility: visible;
      }
      #section-to-print {
        position: absolute;
        left: 0;
        top: 0;
      }
    }
    .voucher_preloader
    {
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        z-index: 99;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    div[data-remodal-id="view-voucher-product"]
    {
        min-height:  491px;
        position: relative;
    }
</style>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/voucher.css">
@endsection
@section('script')
    <script type="text/javascript" src="resources/assets/members/js/voucher.js"></script>
@endsection