@extends('member.layout')
@section('content')
<div class="code-vault">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                <ul>   
                       @foreach($_error as $error) 
                        <li>{{ $error }}</li>
                       @endforeach
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
                <img src="/resources/assets/frontend/img/icon-member.png">
                Membership Codes ({{$count}})
            </div>
            <div class="col-md-6 ew">

                <a style="cursor: pointer;">
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
                    <tr class="tibolru" loading="{{$c->code_pin}}">
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
                        @if($c->used == 0)
                        <td><a style="cursor: pointer;" class="createslot" value="{{$c->code_pin}}">Create Slot</a></td>
                        @else
                        <td><a style="cursor: pointer;" class="alertused">Already Used</a></td>
                        @endif
                        <td><a style="cursor: pointer;" class="transferer" value="{{$c->code_pin}} @ {{$c->code_activation}}" val="{{$c->code_pin}}">Transfer Code</a></td>
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


<div class="remodal create-slot" data-remodal-id="create_slot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-plis.png">
        Create Slot
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST" id="createslot">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="1" class="col-sm-3 control-label">Sponsor</label>
                <div class="col-sm-9">
                    <select class="form-control" id="1" name="sponsor">
                        @if($allslot)
                            @foreach($allslot as $a)
                            <option value="{{$a->slot_id}}">Slot #{{$a->slot_id}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="2" class="col-sm-3 control-label">Placement</label>
                <div class="col-sm-9">
                    <select class="form-control" id="2" name="placement">
                        @if($downline)
                            @foreach($downline as $d)
                            <option value="{{$d->placement_tree_child_id}}">Slot #{{$d->placement_tree_child_id}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <input type="hidden" id="code_number" value"" name="code_number">
            </div>
            <div class="form-group para">
                <label for="3" class="col-sm-3 control-label">Position</label>
                <div class="col-sm-9">
                    <select class="form-control" id="3" name="slot_position">
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                </div>
            </div>
    </div>
    <br>
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="c_slot button"  type="submit" name="c_slot">Create Slot</button>
    </form>
</div>


<div class="remodal create-slot" data-remodal-id="buy_code" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-buy.png">
        Buy Codes
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
     <form class="form-horizontal" method="POST">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="11111" class="col-sm-3 control-label">Membership</label>
                <div class="col-sm-9">
                    <select class="form-control" id="11111" name="memid">
                        @if($membership)
                            @foreach($membership as $m)    
                                <option value="{{$m->membership_id}}" amount="{{$m->membership_price}}" included="{{$m->membership_id}}">{{$m->membership_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="11111" class="col-sm-3 control-label">Product Package</label>
                <div class="col-sm-9">
                    <select id="packageincluded" class="form-control"  name="package">
                        @if($availprod)
                            @foreach($availprod as $a)    
                                <option value="{{$a->product_package_id}}" included="{{$a->membership_id}}" json="{{$a->productlist}}">{{$a->product_package_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="includer form-group para">

                <table>
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="productinclude">

                    </tbody>
                </table>

            </div>
            <div class="form-group para">
                <label for="22222" class="col-sm-3 control-label">Wallet</label>
                <div class="col-sm-9">
                    @if($slotnow)
                    <input type="text" class="form-control" id="22222" name="wallet" value="{{$slotnow->slot_wallet}}" disabled>
                    @else
                    <input type="text" class="form-control" id="22222" name="wallet" value="0" disabled>
                    @endif
                </div>
            </div>
            <div class="form-group para">
                <label for="33333" class="col-sm-3 control-label">Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="33333" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="44444" class="col-sm-3 control-label">Remaining</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="44444" readonly style="background-color: #f47265; border: 0; color: white; text-align: center;" value="">
                </div>
            </div>
    </div>
            <br>
                <button class="button" data-remodal-action="cancel">Cancel</button>
                <button class="button" type="submit" id="ifbuttoncode" name="sbmitbuy" value="Buy Code" disabled>Buy Code</button>
        </form>    
</div>

@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/frontend/js/code_vault.js"></script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/codevault.css">
@endsection