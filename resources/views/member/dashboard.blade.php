@extends('member.layout')
@section('content')
<div class="col-md-7 left">
    <div class="profile para">
        <div class="profile-pic">
            <img src="/resources/assets/frontend/img/pix.png">
            <div class="borders"></div>
        </div>
        <div class="profile-info">
            <div class="name">{{$member->account_name}}</div>
            <div class="email">{{$member->account_email}}</div>
        </div>
    </div>
    <div class="info para">
        <div class="box col-md-4 inbox">
            <div class="img"><img src="/resources/assets/frontend/img/icon-inbox.png"></div>
            <div class="text"><span>5</span>Inbox</div>
        </div>
        <a href="/member#referral">
            <div class="box col-md-4 referral">
                <div class="img"><img src="/resources/assets/frontend/img/icon-referral.png"></div>
                <div class="text"><span>5</span>Referrals</div>
            </div>
        </a>
        <div class="box col-md-4 leads">
            <div class="img"><img src="/resources/assets/frontend/img/icon-lead.png"></div>
            <div class="text"><span>5</span>Leads</div>
        </div>
    </div>

    <div class="detail para">
        <div class="header">Account Summary</div>
        <div class="holder para">
            <div class="input form-horizontal para">
                <div class="form-group">
                    <label for="1" class="col-sm-6 control-label">Total Wallet</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control highlight" id="1" readonly value="{{ number_format($total_wallet, 2) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="2" class="col-sm-6 control-label">Total Number of Slots</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="2" readonly value="{{$total_count}} SLOT(S)">
                    </div>
                </div>
                <div class="form-group">
                    <label for="3" class="col-sm-6 control-label">Email</label>
                    <div class="col-sm-6">
                        <a href="mailto:{{ $member->account_email }}">{{ $member->account_email }}</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="4" class="col-sm-6 control-label">Date Joined</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="4" readonly value="{{ date('F d, Y',strtotime($member->account_date_created)) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($slotnow)
    <div class="detail para">
        <div class="header">Details For Slot #{{$slotnow->slot_id}}</div>
        <div class="holder para">
            <div class="title blue tinde">Overview</div>
            <div class="input form-horizontal para">
                <div class="form-group">
                    <label for="1" class="col-sm-6 control-label">Wallet</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control highlight" id="1" readonly value="{{ number_format($slotnow->slot_wallet, 2) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="2" class="col-sm-6 control-label">Membership</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="2" readonly value="{{$slotnow->membership_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="3" class="col-sm-6 control-label">Ranking</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="3" readonly value="{{$slotnow->rank_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="4" class="col-sm-6 control-label">Total Income</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="4" readonly value="{{$slotnow->slot_total_earning}}">
                    </div>
                </div>
            </div>
            <div class="title sblue">Unilevel</div>
            <div class="input form-horizontal para">
                <div class="form-group">
                    <label for="11" class="col-sm-6 control-label">Group PV</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="11" readonly value="1,200.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="22" class="col-sm-6 control-label">Personal PV</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="22" readonly value="500.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="33" class="col-sm-6 control-label">Required Personal PV</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="33" readonly value="800.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="44" class="col-sm-6 control-label">Status</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="44" readonly value="Not Yet Qualified">
                    </div>
                </div>
            </div>
            <div class="title blue tinde">Binary</div>
            <div class="input form-horizontal para">
                <div class="form-group">
                    <label for="111" class="col-sm-6 control-label">Points on Left</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="111" readonly value="1,200.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="222" class="col-sm-6 control-label">Points on Right</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="222" readonly value="0.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="333" class="col-sm-6 control-label">Total Left</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="333" readonly value="1,200.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="444" class="col-sm-6 control-label">Total Right</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="444" readonly value="1,200.00">
                    </div>
                </div>
            </div>
            <div class="title sblue">Total Bonuses</div>
            <div class="input form-horizontal para">
                <div class="form-group">
                    <label for="1111" class="col-sm-6 control-label">Binary Pairing</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="1111" readonly value="2,500.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="2222" class="col-sm-6 control-label">Unilevel Purchase</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="2222" readonly value="8,500.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="3333" class="col-sm-6 control-label">Direct Sponsorship Bonus</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="3333" readonly value="5,500.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="4444" class="col-sm-6 control-label">Indirect Bonus</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="4444" readonly value="8,500.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="5555" class="col-sm-6 control-label">Matching Bonus</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="5555" readonly value="8,500.00">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="col-md-5 right">
    <div class="holder">
        <div class="header">
            <img src="/resources/assets/frontend/img/icon-notification.png">
            Latest Notification
        </div>
        @foreach($_notification as $log)
        <div class="holders para">
            <div class="linyanglinya"></div>
            <div class="liness para">
                <div class="date col-md-12">{{ $log->date }}</div>
                <div class="text col-md-11">{!! $log->account_log_details !!}</div>
            </div>
        </div>
        @endforeach
        <a href="javascript:">
            <button type="button">View More Notifications</button>
        </a>
    </div>
    <div class="holder">
        <div class="header">
            <img src="/resources/assets/frontend/img/icon-earner.png">
            Top Earner's of the Month
        </div>
        <div class="holders para">
            <div class="liness para">
                <div class="pix">
                    <img src="/resources/assets/frontend/img/pix.png">
                </div>
                <div class="text">
                    <div class="name">John Doe</div>
                    <div class="email">sample@gmail.com</div>
                </div>
                <a href="/member#message" class="para pindutan">
                    <div class="message">
                        <img src="/resources/assets/frontend/img/icon-message.png">
                        <span>send message</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="holders para">
            <div class="liness para">
                <div class="pix">
                    <img src="/resources/assets/frontend/img/pix.png">
                </div>
                <div class="text">
                    <div class="name">John Doe</div>
                    <div class="email">sample@gmail.com</div>
                </div>
                <a href="/member#message" class="para pindutan">
                    <div class="message">
                        <img src="/resources/assets/frontend/img/icon-message.png">
                        <span>send message</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="holders para">
            <div class="liness para">
                <div class="pix">
                    <img src="/resources/assets/frontend/img/pix.png">
                </div>
                <div class="text">
                    <div class="name">John Doe</div>
                    <div class="email">sample@gmail.com</div>
                </div>
                <a href="/member#message" class="para pindutan">
                    <div class="message">
                        <img src="/resources/assets/frontend/img/icon-message.png">
                        <span>send message</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/dashboard.css">
@endsection