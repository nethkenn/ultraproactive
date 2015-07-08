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
        <table>
            <thead>
                <tr>
                    <td>Voucher Reference No.</td>
                    <td>Voucher Code.</td>
                    <td>Claimed</td>
                    <td>Total Amount</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12</td>
                    <td>QV67L</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>1,200.00</td>
                    <td><a href="#voucher">View Voucher</a></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>QV67L</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>1,200.00</td>
                    <td><a href="#voucher">View Voucher</a></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>QV67L</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>1,200.00</td>
                    <td><a href="#voucher">View Voucher</a></td>
                </tr>
                <tr>
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