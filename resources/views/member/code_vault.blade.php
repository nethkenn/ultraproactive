@extends('member.layout')
@section('content')
<div class="code-vault">
    <div class="table">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                <ul>
                        <li>{{ $error }}</li>
                </ul>
            </div>
        @endif
        <div class="table-head para">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-member.png">
                Membership Codes ({{$count}})
            </div>
            <div class="col-md-6 ew">

                <a href="member/code_vault#buy_code">
                    <div class="button" id="buymember">Buy Membership Codes</div>
                </a>
                <a style="cursor: pointer;" class="claim_code">
                    <div class="button">Claim Code</div>
                </a>
            </div>
        </div>



        <table class="footable">
            @if($code)
            <thead>
                <tr>
                    <th>Pin</th>
                    <th data-hide="phone">Code</th>
                    <th data-hide="phone">Type</th>
                    <th data-hide="phone">Obtained From</th>
                    <th data-hide="phone,phonie">Membership</th>
                    <th data-hide="phone,phonie">Locked</th>
                    <th data-hide="phone,phonie">Product Set</th>
                    <th data-hide="phone,phonie">Status</th>
                    <th data-hide="phone,phonie,tablet"></th>
                    <th data-hide="phone,phonie,tablet"></th>
                </tr>
            </thead>
            <tbody>
                    @foreach($code as $c)
                    <tr class="tibolru" loading="{{$c->encrypt}}">
                        <td>{{$c->code_pin}}</td>
                        <td>{{$c->code_activation}}</td>
                        <td>{{$c->code_type_name}}</td>
                        <td>{{$c->transferer}}</td>
                        <td>{{$c->membership_name}}</td>
                        <td>
                            <div class="check">
                                <input type="checkbox" class="checklock" {{$c->lock == 1 ? "checked" : ""}}>
                            <div class="bgs">
                            </div>
                            </div>
                        </td>
                        <td>{{$c->product_package_name}}</td>
                        <td>{{$c->used == 0 ? "Available" : "Used"}}</td>

                        <td><a style="cursor: pointer;" class="createslot">Create Slot</a></td>
                        <td><a style="cursor: pointer;" class="transferer" value="{{$c->code_pin}} @ {{$c->code_activation}}" val="{{$c->code_pin}}">Transfer Code</a></td>
<!--                        <td><a href="member/code_vault#create_slot">Create Slot</a></td>
                        <td><a href="member/code_vault#transfer_code">Transfer Code</a></td>
!-->
                    </tr>
                    @endforeach
                @endif 

                <!-- <tr class="tibolru">
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
                <tr class="tibolru">
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
                <tr class="tibolru">
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
                </tr> !-->
            </tbody>
        </table>
    </div>
    <div class="table">
    <div class="table-head para">
        <div class="col-md-6 aw">
            <img src="/resources/assets/frontend/img/icon-product.png">
            Product Codes ( 2 )
        </div>
    </div>
    <table class="footable">
        <thead>
            <tr>
                <th>Pin</th>
                <th data-hide="phone">Code</th>
                <th data-hide="phone">Obtained From</th>
                <th data-hide="phone,phonie">Locked</th>
                <th data-hide="phone">Product</th>
                <th data-hide="phone,phonie">Price</th>
                <th data-hide="phone,phonie">Unilevel Points</th>
                <th data-hide="phone,phonie">Binary Points</th>
                <th data-hide="phone,phonie">Status</th>
                <th data-hide="phone,phonie,tablet"></th>
                <th data-hide="phone,phonie,tablet"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="tibolru">
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="member/code_vault#use_code">Use Code</a></td>
                <td><a href="member/code_vault#transfer_code">Transfer Code</a></td>
            </tr>
            <tr class="tibolru">
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="member/code_vault#use_code">Use Code</a></td>
                <td><a href="member/code_vault#transfer_code">Transfer Code</a></td>
            </tr>
            <tr class="tibolru">
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="member/code_vault#use_code">Use Code</a></td>
                <td><a href="member/code_vault#transfer_code">Transfer Code</a></td>
            </tr>
            <tr class="tibolru">
                <td>516</td>
                <td>K65N4</td>
                <td>Guillermo Tabligan (Admin)</td>
                <td><div class="check"><input type="checkbox"><div class="bgs"></div></div></td>
                <td>Candy</td>
                <td>1,200.00</td>
                <td>30.00</td>
                <td>40.00</td>
                <td>Available</td>
                <td><a href="member/code_vault#use_code">Use Code</a></td>
                <td><a href="member/code_vault#transfer_code">Transfer Code</a></td>
            </tr>
        </tbody>
    </table>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/frontend/js/code_vault.js"></script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/codevault.css">
@endsection