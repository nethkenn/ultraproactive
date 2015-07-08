@extends('member.layout')
@section('content')
<div class="code-vault">
    <div class="table">
        <div class="table-head para">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-member.png">
                Membership Codes ( 2 )
            </div>
            <div class="col-md-6 ew">
                <a href="#buy_code">
                    <div class="button">Buy Membership Codes</div>
                </a>
                <a href="#claim_code">
                    <div class="button">Claim Code</div>
                </a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Pin</td>
                    <td>Code</td>
                    <td>Type</td>
                    <td>Obtained Form</td>
                    <td>Membership</td>
                    <td>Locked</td>
                    <td>Product Set</td>
                    <td>Status</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>516</td>
                    <td>K65N4</td>
                    <td>PS</td>
                    <td>Guillermo Tabligan (Admin)</td>
                    <td>Associate</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>Set A</td>
                    <td>Available</td>
                    <td><a href="#create_slot">Create Slot</a></td>
                    <td><a href="#transfer_code">Transfer Code</a></td>
                </tr>
                <tr>
                    <td>516</td>
                    <td>K65N4</td>
                    <td>PS</td>
                    <td>Guillermo Tabligan (Admin)</td>
                    <td>Associate</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>Set A</td>
                    <td>Available</td>
                    <td><a href="#create_slot">Create Slot</a></td>
                    <td><a href="#transfer_code">Transfer Code</a></td>
                </tr>
                <tr>
                    <td>516</td>
                    <td>K65N4</td>
                    <td>PS</td>
                    <td>Guillermo Tabligan (Admin)</td>
                    <td>Associate</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>Set A</td>
                    <td>Available</td>
                    <td><a href="#create_slot">Create Slot</a></td>
                    <td><a href="#transfer_code">Transfer Code</a></td>
                </tr>
                <tr>
                    <td>516</td>
                    <td>K65N4</td>
                    <td>PS</td>
                    <td>Guillermo Tabligan (Admin)</td>
                    <td>Associate</td>
                    <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                    <td>Set A</td>
                    <td>Available</td>
                    <td><a href="#create_slot">Create Slot</a></td>
                    <td><a href="#transfer_code">Transfer Code</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table">
    <div class="table-head para">
        <div class="col-md-6 aw">
            <img src="/resources/assets/frontend/img/icon-product.png">
            Product Codes ( 2 )
        </div>
        <div class="col-md-6 ew">

        </div>
    </div>
    <table>
        <thead>
            <tr>
                <td>Pin</td>
                <td>Code</td>
                <td>Obtained Form</td>
                <td>Locked</td>
                <td>Product</td>
                <td>Price</td>
                <td>Unilevel Points</td>
                <td>Binary Points</td>
                <td>Status</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="#use_code">Use Code</a></td>
                <td><a href="#transfer_code">Transfer Code</a></td>
            </tr>
            <tr>
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="#use_code">Use Code</a></td>
                <td><a href="#transfer_code">Transfer Code</a></td>
            </tr>
            <tr>
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="#use_code">Use Code</a></td>
                <td><a href="#transfer_code">Transfer Code</a></td>
            </tr>
            <tr>
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="#use_code">Use Code</a></td>
                <td><a href="#transfer_code">Transfer Code</a></td>
            </tr>
        </tbody>
    </table>
</div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/codevault.css">
@endsection