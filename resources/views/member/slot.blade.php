@extends('member.layout')
@section('content')
<div class="encashment slot">
<form method="POST">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <div class="header">My Slots ( {{$count}} )</div>
    <div class="body para">
        @if($slot2)
            @foreach($slot2 as $s)
                <div class="holder para">
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
                            <div class="values">{{$s->slot_wallet}}</div>
                            <div class="values">{{$s->membership_name}}</div>
                            <div class="values">{{$s->rank_name}}</div>
                            <div class="values">7</div>
                        </div>
                    </div>
                    <div class="col-md-3">
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
                            <a href="/member/slot#transfer_slot">
                                <button type="button" onClick="location.href='/member/slot#transfer_slot'">Transfer Slot</button>
                            </a>
                        </div>
                    </div>
                </div>
                <img src="/resources/assets/frontend/img/linyangmalupet.png">
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
@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/frontend/js/slot.js"></script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/slot.css">
@endsection