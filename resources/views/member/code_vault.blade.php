@extends('member.layout')
@section('content')
<div class="code-vault">
    @if(Session::has('message'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ $_error }}</li>
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
        <div class="table-head para" style="background-color: #0000D3;">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-member.png">
                Unused Membership Codes ({{$count}})
            </div>
            <div class="col-md-6 ew">
                <a style="cursor: pointer;" class="{{$member->disable_membership == 1 ? 'hidden' : ''}}">
                    <div class="button" id="buymember" style="background-color: #0000A7; border-color: #0000A7;">Buy Membership Codes</div>
                </a>
                <a style="cursor: pointer;" class="claim_code">
                    <div class="button" style="background-color: #0000A7; border-color: #0000A7;">Claim Code</div>
                </a>
            </div>
        </div>
        @if($code)
        <table class="footable">
            <thead style="background-color: #0000A7;">
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
                    @if(isset($c->transferer))
                    <td>{{$c->transferer}}</td>
                    @else
                    <td>{{$c->description}}</td>
                    @endif
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
            </tbody>
        </table>
        {!! $code->appends(Request::input())->render() !!}
        @endif
    </div>

    <div class="table">
        <div class="table-head para" style="background-color: #0000D3;">
            <div class="col-md-6 aw">
                Used Membership Codes ({{$used_count}})
            </div>
            <div class="col-md-6 ew">
                <a style="cursor: pointer;">
                 
                </a>
                <a style="cursor: pointer;" class="claim_code">

                </a>
            </div>
        </div>
        @if($used_code)
        <table class="footable">
            <thead style="background-color: #0000A7;">
                <tr>
                    <th>Pin</th>
                    <th data-hide="phone">Code</th>
                    <th data-hide="phone">Type</th>
                    <th data-hide="phone">Obtained From</th>
                    <th data-hide="phone,phonie">Membership</th>
                    <th data-hide="phone,phonie">Product Set</th>
                    <th data-hide="phone,phonie">Status</th>
                    <th data-hide="phone,phonie,tablet"></th>
                    <th data-hide="phone,phonie,tablet"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($used_code as $c)
                <tr class="tibolru" loading="{{$c->code_pin}}">
                    <td>{{$c->code_pin}}</td>
                    <td>{{$c->code_activation}}</td>
                    <td>{{$c->code_type_name}}</td>
                    @if(isset($c->transferer))
                    <td>{{$c->transferer}}</td>
                    @else
                    <td>{{$c->description}}</td>
                    @endif
                    <td>{{$c->membership_name}}</td>
                    <td>{{$c->product_package_name}}</td>
                    <td>{{$c->used == 0 ? "Available" : "Used"}}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $used_code->appends(Request::input())->render() !!}
        @endif
    </div>


    <!-- PRODUCT CODE TABLE -->
    <div class="table">
        <div class="table-head para" style="background-color: #0000D3;">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-product.png">
                Available Product Codes ( {{$count2}} )
            </div>
        </div>
        @if($prodcode)
        <table class="footable">
            <thead style="background-color: #0000A7;">
                <tr>
                    <th>Pin</th>
                    <th data-hide="phone">Code</th>
                    <th data-hide="phone">Product</th>
                    <th data-hide="phone,phonie">UPcoins</th>
                    <th data-hide="phone,phonie">Binary Points</th>
                    <th data-hide="phone,phonie,tablet"></th>
                    <!--<th data-hide="phone,phonie,tablet"></th>-->
                </tr>
            </thead>
            <tbody>
                @foreach($prodcode as $prod)
                <tr class="tibolru" loading="{{$prod->product_pin}}">
                    <td>{{$prod->product_pin}}</td>
                    <td>{{$prod->code_activation}}</td>
                    <td>{{$prod->product_name}}</td>
                    <td>{{number_format($prod->unilevel_pts, 2)}}</td>
                    <td>{{number_format($prod->binary_pts, 2)}}</td>
                    <td><a style="cursor: pointer;" class="use-p" binary_pts="{{ $prod->binary_pts }}" unilevel_pts="{{ $prod->unilevel_pts }}" code_id="{{ $prod->product_pin }}">Use Code</a></td>
                    <!--<td><a style="cursor: pointer;" class="transferer-p" vals="{{$prod->voucher_id}}" value="{{$prod->product_pin}} @ {{$prod->code_activation}}" val="{{$prod->product_pin}}">Transfer Code</a></td>-->
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {!! $prodcode->appends(Request::input())->render() !!}
        @endif
    </div>
</div>

<!-- POPUP FOR PRODUCT CODE / USE CODE -->
<div class="remodal create-slot" data-remodal-id="use_code">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-use.png">
        Use Product Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" action="member/code_vault/use_product_code">
            <div class="form-group para">
                <label for="111" class="col-sm-3 control-label">Points Recipient</label>
                <input name="product_pin" class="product-code-id-reference" type="hidden" id="product_code_id" value="">
                <div class="col-sm-9">
                    <select class="form-control" id="111" name="slot">
                        @if($getallslot)
                            @foreach($getallslot as $get)
                                <option {{ $slotnow->slot_id == $get->slot_id ? 'selected' : '' }}  value="{{$get->slot_id}}"> Slot #{{$get->slot_id}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="222" class="col-sm-3 control-label">UPcoins</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control unilevel_pts_container" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="333" class="col-sm-3 control-label">Binary Points</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control binary_pts_container" disabled>
                </div>
            </div>
        </div>
        <br>
        <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
        <button class="usingprodcode button" type="submit" name="usingcode">Use Code</button>
        <span class='loadingprodicon' style="margin-left: 50px;"><img class='loadingprodicon' src='/resources/assets/img/small-loading.GIF'></span>
    </form>
</div>

<!-- POPUP FOR MEMBERSHIP CODE / USE CODE -->
<div class="remodal create-slot" data-remodal-id="create_slot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-plis.png">
        Create Slot
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="sponsornot"></div>
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST" id="createslot">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="1" class="col-sm-3 control-label">Sponsor</label>
                <div class="col-sm-9">
                    @if($exist_lead)
                    <input type="hidden" value="1" id="checkclass">
                    <select class="sponser form-control" id="1" name="sponsor">
                        @foreach($exist_lead as $exist)
                        <option value="{{$exist->slot_id}}">Slot #{{$exist->slot_id}}</option>
                        @endforeach
                    </select>
                    @else
                        <input type="hidden" value="0" id="checkclass">
                        <input class="sponse form-control" id="1" name="sponsor" value="">
                    @endif
                </div>
            </div>
            <div class="form-group para">
                <label for="2" class="col-sm-3 control-label">Placement</label>
                <div class="treecon col-sm-9">
                    <select class="tree form-control hidden" id="2" name="placement" required disabled>
                        <option value="">Input a slot sponsor</option>
                    </select>
                    <input type="number" class="form-control placement-input" name="placement">
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
        <button class="cancel button" type="button" data-remodal-action="cancel">Cancel</button>
        <button class="c_slot button"  type="button" name="c_slot">Create Slot</button>
        <span class='loadingicon' style="margin-left: 50px;"><img class='loadingicon' src='/resources/assets/img/small-loading.GIF'></span>
    </form>
</div>

<!-- POPUP FOR CONFIRMATION / USE CODE -->
<div class="remodal confirm_slot-slot" data-remodal-id="confirm_slot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-plis.png">
        Confirm Slot
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="sponsornot"></div>
    <div class="col-md-10 col-md-offset-1 para">
        <div class="form-group para">
            <label for="2" class="col-sm-3 control-label">Placement Owner</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="placement_owner" disabled>
            </div>
        </div>
        <div class="form-group para">
            <label for="2" class="col-sm-3 control-label">Sponsor Owner</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="sponsor_owner" disabled>
            </div>
        </div>
        <button class="canceler button" type="button">Back</button>
        <button class="confirmer button" type="button" name="c_slot">Create Slot</button>
        <span class='loadingiconer' style="margin-left: 50px;"><img class='loadingiconer' src='/resources/assets/img/small-loading.GIF'></span>
    </div>    

        <br>
</div>

<!-- POPUP FOR BUYING OF CODES -->
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
                        @if($membership2)
                        @foreach($membership2 as $m)
                        <option value="{{$m->membership_id}}" amount="{{$m->membership_price}}" included="{{$m->membership_id}}">{{$m->membership_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="3123" class="col-sm-3 control-label">Product Package</label>
                <div class="col-sm-9">
                    <select id="packageincluded" class="form-control" id="3123" name="package">
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
                    <input type="text" class="form-control" id="22222" name="wallet" value="{{$current_wallet}}" disabled>
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
        <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
        <button class="ifbuttoncode button" type="submit" id="ifbuttoncode" name="sbmitbuy" value="Buy Code" disabled>Buy Code</button>
    </form>
</div>

<!-- POPUP FOR TRANSFERRING OF PRODUCT CODE  -->
<div class="remodal create-slot" data-remodal-id="transfer_product" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-transfer.png">
        Transfer Code / Product?
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST">
            <div class="form-group para">
                <label for="11z" class="col-sm-3 control-label">Code</label>
                <div class="col-sm-9">
                    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" class="form-control" id="11sz" name="code">
                    <input type="hidden" class="form-control" id="11szz" name="voucher">
                    <input type="text" class="form-control" id="11z" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="22" class="col-sm-3 control-label">Recipient</label>
                <div class="col-sm-9">
                    <select class="form-control" id="22" name="account">
                        @if($accountlist)
                        @foreach($accountlist  as $a)
                        <option value="{{$a->account_id}}">{{$a->account_email}}({{$a->account_name}})</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="33" class="col-sm-3 control-label">Enter Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="33" name="pass">
                </div>
            </div>
        </div>
        <br>
        <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
        <button class="button" type="submit" name="prodsbmt">Initiate Transfer</button>
    </div>
</form>

<!-- POPUP FOR TRANSFERRING OF MEMBERSHIP CODE  -->
<div class="remodal create-slot" data-remodal-id="transfer_code" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-transfer.png">
        Transfer Code / Membership
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST">
            <div class="form-group para">
                <label for="11z" class="col-sm-3 control-label">Code</label>
                <div class="col-sm-9">
                    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" class="form-control" id="11s" name="code">
                    <input type="text" class="form-control" id="11" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="22" class="col-sm-3 control-label">Recipient</label>
                <div class="col-sm-9">
                    <select class="form-control" id="22" name="account">
                        @if($getlead->count() != 0)
                            @foreach($getlead as $g)
                                <option value="{{$g->account_id}}">{{$g->account_email}} ({{$g->account_name}})</option>
                            @endforeach
                        @else
                            <option value="">You don't have any lead please add first.</value>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="33" class="col-sm-3 control-label">Enter Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="33" name="pass">
                </div>
            </div>
        </div>
        <br>
        <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
         @if($getlead->count() != 0)
         <button class="button" type="submit" name="codesbmt">Initiate Transfer</button>
         @else
         <button class="button" type="submit" name="codesbmt" disabled>Initiate Transfer</button>
         @endif
    </div>
</form>
@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/frontend/js/code_vault.js"></script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/codevault.css">
@endsection