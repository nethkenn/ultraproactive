@extends('member.layout')
@section('content')

        @if(Session::has('message'))
            <div class="alert alert-danger">
                <ul>
                        <li>{{ $error }}</li>
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

        
<div class="encashment slot">
<form method="POST">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <div class="header">My Slots ( {{$count}} )</div>
    <div class="body para">
        @if($slot2)
            @foreach($slot2 as $s)
                <div class="holder para">
                    <div class="col-md-3">
                        <div class="slot-box">
                            <div class="labels-slot">SLOT</div>
                            <div class="values-slot">#{{$s->slot_id}}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-xs-6 labels-container">
                            <div class="labels">Wallet</div>
                            <div class="labels">Membership</div>
                            <div class="labels">Rank</div>
                            <div class="labels">Downlines</div>
                        </div>
                        <div class="col-xs-6 labels-container">
                            <div class="values">{{number_format($s->slot_wallet, 2)}}</div>
                            <div class="values">{{$s->membership_name}}</div>
                            <div class="values">{{$s->rank_name}}</div>
                            <div class="values">7</div>
                        </div>
                    </div>
                    <div class="col-md-3 top-container">
                        <div class="btn-holder">
                            <a style="cursor: pointer;">
                                <button class="upbtn" type="button" tols="{{$s->slot_id}}" wallet="{{$s->slot_wallet}}" memship="{{$s->membership_price}}">Upgrade Membership</button>
                            </a>
                        </div>
                        <div class="btn-holder">           
                            <a href="javascript:">
                                <button type="submit" name="changeslot" value="{{$s->slot_id}}"{{$s->slot_id == $currentslot ? 'disabled' : ""}}>Use this Slot</button>
                            </a>
                        </div>
                        <div class="btn-holder">
                            <a style="cursor: pointer;">
                                <button type="button" class="trans_click" value="{{$s->slot_id}}">Transfer Slot</button>
                            </a>
                        </div>
                    </div>
                </div>
                <img src="/resources/assets/frontend/img/linyangmalupet.png" style="max-width: 100%;">
            @endforeach   
        @endif   
    </div>
</form>
    <!--  <div class="sample" value="asd"> !-->
      <!--  <div class="holder para">
            <div class="col-md-3">
                <img src="/resources/assets/frontend/img/boxbox.png">
            </div>
            <div class="col-md-6">
                <div class="col-xs-6">
                    <div class="labels">Wallet</div>
                    <div class="labels">Membership</div>
                    <div class="labels">Rank</div>
                    <div class="labels">Downlines</div>
                </div>
                <div class="col-xs-6">
                    <div class="values">1,200.00</div>
                    <div class="values">Associate</div>
                    <div class="values">Entry Level</div>
                    <div class="values">7</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="btn-holder">
                    <a href="#upgrade_member">
                        <button type="button" onClick="location.href='#upgrade_member'">Upgrade Membership</button>
                    </a>
                </div>
                <div class="btn-holder">
                    <a href="javascript:">
                        <button type="button">Use this Slot</button>
                    </a>
                </div>
                <div class="btn-holder">
                    <a href="#transfer_slot">
                        <button type="button" onClick="location.href='#transfer_slot'">Transfer Slot</button>
                    </a>
                </div>
            </div>
        </div> !-->
</div>

<div class="remodal create-slot" data-remodal-id="transfer_slot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-transfer.png">
        Transfer Slot
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="isa" class="col-sm-3 control-label">Slot Being Transferred</label>
                <div class="col-sm-9">
                    <input type="text" value="" class="form-control" id="isa" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="dalawa" class="col-sm-3 control-label">Transfer to the account of</label>
                <div class="col-sm-9">
                    <select class="form-control" id="dalawa" name="acct" required>
                        @if($getlead->count() != 0)
                            @foreach($getlead as $g)
                                <option value="{{$g->account_id}}">{{$g->account_email}} ({{$g->account_name}})</option>
                            @endforeach
                        @else
                            <option value="">You don't have any lead please add first.</option>
                        @endif
                    </select>
                    <input type="hidden" value="" class="form-control" id="hiddenisa" name="slot">
                </div>
            </div>
            <div class="form-group para">
                <label for="tatlo" class="col-sm-3 control-label">Enter Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="tatlo" name="pass">
                </div>
            </div>
    </div>
    <br>
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="button" type="submit" name="initsbmt">Initiate Transfer</button>
    </form>
</div>

<div class="remodal create-slot" data-remodal-id="upgrade_member" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-membership.png">
        Claim Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="get">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" class="token" name="tols" id="tols" value="">
            <div class="alerted alert alert-danger">
                You don't have enough balance in your wallet for upgrade.
            </div>
            <div class="form-group para">
                <label for="wan" class="col-sm-3 control-label">Choose Membership</label>
                <div class="col-sm-9">
                    <select class="form-control" id="wan" name="membership">
                        @if($membership2)
                            @foreach($membership2 as $m)
                              <option value="{{$m->membership_id}}" amount="{{$m->membership_price}}">{{$m->membership_name}}</option>
                            @endforeach
                        @endif    
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="tuu" class="col-sm-3 control-label">Choose product</label>
                <div class="col-sm-9">
                    <select class="form-control" id="tuu" name="product"> 
                        @if($slot2)
                            @foreach($slot2 as $s)
                                @foreach($s->productlist as $p)
                                  <option value="{{$p->product_id}}" slot="{{$s->slot_id}}">{{$p->product_name}}</option>
                                @endforeach
                            @endforeach
                        @endif   
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="tu" class="col-sm-3 control-label">Your Wallet</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tu" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="tri" class="col-sm-3 control-label">Upgrade Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tri" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="por" class="col-sm-3 control-label">Enter Your Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="por" name="pass">
                </div>
            </div>
            <br>
            <button class="button" data-remodal-action="cancel">Cancel</button>
            <button class="button" type="submit" id="subup" name="subup" value="1">Submit Upgrade</button>
        </form>
    </div>

</div>
    
@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/frontend/js/slot.js"></script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/slot.css">
@endsection