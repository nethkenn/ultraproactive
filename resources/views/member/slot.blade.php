@extends('member.layout')
@section('content')
<div class="encashment slot">
    <div class="header">My Slots ( 2 )</div>
    <div class="body para">
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
        </div>
        <img src="/resources/assets/frontend/img/linyangmalupet.png">
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
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/slot.css">
@endsection