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
                <tr class="tibolru">
                    <td>12</td>
                    <td>QV67L</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>1,200.00</td>
                    <td><a href="#voucher">View Voucher</a></td>
                </tr>
                <tr class="tibolru">
                    <td>12</td>
                    <td>QV67L</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>1,200.00</td>
                    <td><a href="#voucher">View Voucher</a></td>
                </tr>
                <tr class="tibolru">
                    <td>12</td>
                    <td>QV67L</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>1,200.00</td>
                    <td><a href="#voucher">View Voucher</a></td>
                </tr>
                <tr class="tibolru">
                    <td>12</td>
                    <td>QV67L</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>1,200.00</td>
                    <td><a href="#voucher">View Voucher</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/voucher.css">
@endsection