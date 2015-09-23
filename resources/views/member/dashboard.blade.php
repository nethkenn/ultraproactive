@extends('member.layout')
@section('content')
<div class="info para col-md-12">
    <a href="javascript:">
        <div class="col-md-3" style="padding-left: 0 !important;">
            <div class="box wallet para">
                <div class="img col-md-6">
                    <img src="/resources/assets/frontend/img/wallet.png">
                </div>
                <div class="text col-md-6">
                    <div class="middle">
                        <div class="total">CURRENT</div>
                        <div>WALLET</div>
                    </div>
                </div>
                <div class="valuez para">{{ number_format($total_wallet, 2) }}</div>
            </div>
        </div>
    </a>
    <a href="javascript:">
        <div class="col-md-3">
            <div class="box slot para">
                <div class="img col-md-6">
                    <img src="/resources/assets/frontend/img/slot.png">
                </div>
                <div class="text col-md-6">
                    <div class="middle">
                        <div class="total">TOTAL</div>
                        <div>SLOT(S)</div>
                    </div>
                </div>
                <div class="valuez para">{{$total_count}} SLOT(S)</div>
            </div>
        </div>
    </a>
    @if($slotnow)
    <a href="javascript:">
        <div class="col-md-3">
            <div class="box income para">
                <div class="img col-md-6">
                    <img src="/resources/assets/frontend/img/income.png">
                </div>
                <div class="text col-md-6">
                    <div class="middle">
                        <div class="total">TOTAL</div>
                        <div>INCOME</div>
                    </div>
                </div>
                <div class="valuez para">{{ number_format($earnings['total_income'],2)}}</div>
            </div>
        </div>
    </a>
    @endif
    <a href="javascript:">
        <div class="col-md-3" style="padding-right: 0 !important;">
            <div class="box money para">
                <div class="img col-md-6">
                    <img src="/resources/assets/frontend/img/money.png">
                </div>
                <div class="text col-md-6">
                    <div class="middle">
                        <div class="total">TOTAL</div>
                        <div>SPENT</div>
                    </div>
                </div>
                <div class="valuez para">{{$earnings['total_withdrawal']}}</div>
            </div>
        </div>
    </a>
</div>
<div class="col-md-9 left">
    <div class="profile para">
        <div class="profile-pic">
            @if($member->image != "")
            <img src="{{$member->image}}">
            @else
            <img src="/resources/assets/img/default-image.jpg">
            @endif
        </div>
        <div class="profile-info">
            <div class="name">{{$member->account_name}}</div>
            <div class="email">{{$member->account_email}}</div>
            <div style="margin: 15px 0; display: table; width: 100%;">
                <div class="p">
                    <div class="p-label">MEMBER SINCE</div>
                    <div class="p-value">{{$joined_date}}</div>
                </div>
                <div class="p">
                    <div class="p-label">NOTIFICATIONS</div>
                    <div class="p-value">{{$count_log}} Notifications</div>
                </div>
                <div class="p">
                    <div class="p-label">AVAILABLE CODE</div>
                    <div class="p-value">{{$code}} Membership</br>{{$prod}} Product</div>
                </div>
            </div>
        </div>
        <div class="profile-button">
            <button type="button" onClick="location.href='/member/settings'">EDIT PROFILE</button>
            <button type="button" onClick="location.href='/member/settings#cpass'">CHANGE PASSWORD</button>
            <!-- <button type="button">MESSAGES (5)</button> -->
            <button type="button" onClick="location.href='/member/leads'">LEADS ({{$leadc}})</button>
        </div>
    </div>
    <div class="detail para">
        @if($slotnow)
        <div class="holder">
            <div class="title">
                <span>SLOT</span></br> OVERVIEW
            </div>
            <div class="info">
                <div class="holders">
                    <div class="leybel">MEMBERSHIP</div>
                    <div class="balyu">{{$slotnow->membership_name}}</div>
                </div>
                <div class="holders">
                    <div class="leybel">TOTAL INCOME</div>
                    <div class="balyu">{{ number_format($earnings['total_income'],2)}}</div>
                </div>
                <div class="holders">
                    <div class="leybel">TOTAL WITHDRAWAL</div>
                    <div class="balyu">{{number_format($earnings['total_withdrawal'],2)}}</div>
                </div>
                <!-- <div class="holders">
                    <div class="leybel">MAX INCOME PER DAY</div>
                    <div class="balyu">{{$slotnow->slot_today_income}}/{{$slotnow->max_income}}</div>
                </div> -->
                <div class="holders">
                    <div class="leybel">MAX PAIRS PER DAY</div>
                    <div class="balyu">{{$slotnow->pairs_today}}/{{$slotnow->max_pairs_per_day}}</div>
                </div>
            </div>
        </div>
        <div class="holder">
            <div class="title">
                <span>UNILEVEL</span></br> INFORMATION
            </div>
            <div class="info">
                <div class="holders">
                    <div class="leybel">GROUP PV</div>
                    <div class="balyu">{{ number_format($slotnow->slot_group_points, 2) }} PV</div>
                </div>
                <div class="holders">
                    <div class="leybel">PERSONAL PV</div>
                    <div class="balyu">{{ number_format($slotnow->slot_personal_points, 2) }} PV</div>
                </div>
                <div class="holders">
                    <div class="leybel">REQUIRED PV</div>
                    <div class="balyu">{{ number_format($slotnow->membership_required_pv, 2) }} PV</div>
                </div>
                <div class="holders">
                    <div class="leybel">UNILEVEL STATUS</div>
                    <div class="balyu">{{ $slotnow->slot_personal_points >= $slotnow->membership_required_pv ? 'Qualified for Unilevel' : 'Not Yet Qualified' }}</div>
                </div>
            </div>
        </div>
        @endif
        @if(isset($next_membership))
        <div class="holder">
            <div class="title">
                <span>PROMOTION</span></br> QUALIFICATION
            </div>
            <div class="info">
                <div class="holders">
                    <div class="leybel">CURRENT MEMBERSHIP</div>
                    <div class="balyu">{{ $slotnow->membership_name }}</div>
                </div>
                <div class="holders">
                    <div class="leybel">NEXT MEMBERSHIP</div>
                    <div class="balyu">{{ $next_membership->membership_name }}</div>
                </div>
                <div class="holders">
                    <div class="leybel">PROMOTION POINTS</div>
                    <div class="balyu">{{ number_format($slotnow->slot_upgrade_points, 2) }} PP</div>
                </div>
                <div class="holders">
                    <div class="leybel">REQUIRED PROMOTION POINTS</div>
                    <div class="balyu">{{ number_format($next_membership->membership_required_upgrade, 2) }} PP</div>
                </div>
            </div>
        </div>
        @endif
        @if($slotnow)
        <div class="holder">
            <div class="title">
                <span>BINARY</span></br> INFORMATION
            </div>
            <div class="info">

                <div class="holders">
                    <div class="leybel">POINTS ON LEFT</div>
                    <div class="balyu">{{ number_format($slotnow->slot_binary_left, 2) }} POINTS</div>
                </div>

                <div class="holders">
                    <div class="leybel">POINTS ON RIGHT</div>
                    <div class="balyu">{{ number_format($slotnow->slot_binary_right, 2) }} POINTS</div>
                </div>

                <div class="holders">
                    <div class="leybel">SLOTS ON LEFT</div>
                    <div class="balyu">{{ number_format($left_side) }} SLOTS</div>
                </div>

                <div class="holders">
                    <div class="leybel">SLOTS ON RIGHT</div>
                    <div class="balyu">{{ number_format($right_side) }} SLOTS</div>
                </div>

            </div>
        </div>
        <div class="holder">
            <div class="title">
                <span>INCOME</span></br> SUMMARY
            </div>
            <div class="info">
                <div class="holders">
                    <div class="leybel">BINARY PAIRING BONUS</div>
                    <div class="balyu">{{ number_format($earnings['binary'], 2) }}</div>
                </div>
                <div class="holders">
                    <div class="leybel">MENTOR BONUS</div>
                    <div class="balyu">{{ number_format($earnings['mentor'], 2) }}</div>
                </div>
                <div class="holders">
                    <div class="leybel">DIRECT SPONSORSHIP BONUS</div>
                    <div class="balyu">{{ number_format($earnings['direct'], 2) }}</div>
                </div>
                <div class="holders">
                    <div class="leybel">INDIRECT LEVEL BONUS</div>
                    <div class="balyu">{{ number_format($earnings['indirect'], 2) }}</div>
                </div>
            </div>
        </div>
         @endif
    </div>
    <!-- <div class="detail para">
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
    </div> -->


</div>
<div class="col-md-3 right">
    <!-- NOTIFICATIONS -->
  <!--   @if($_notification)
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
            <button onclick="location.href='/member/notification'" type="button">View All Notification(s)</button>
        </a>
    </div>
    @endif -->

    <!-- REAL NOTIFICATION :: NOTIFICATION IN TOP IS FAKE I PROMISE-->
    @if($_notification)
    <div class="holder">
        <div class="header notif">LATEST NOTIFICATION</div>
        @foreach($_notification as $log)
            <div class="holders">
                <div class="text">{!! $log->logs !!}</div>
                <div class="date">{{ $log->date }}</div>
                <!-- <div class="time">{{ date("g:i a", strtotime("$log->date")) }}</div> -->
            </div>
        @endforeach
        <div class="link-holder">
            <a href="/member/notification" class="link">VIEW ALL NOTIFICATIONS</a>
        </div>
    </div>
    @endif
    <!-- REAL TOP EARNERS :: THIS IS REAL THIS REAL -->
    <!-- <div class="holder" style="padding-bottom: 0;">
        <div class="header earn">TOP EARNERS OF THE MONTH</div>
        <div class="holders holders-no">
            <div class="img">
                <img src="/resources/assets/frontend/img/man.jpg">
            </div>
            <div class="info">
                <div class="name">Edward Guevarra</div>
                <div class="email">primiaph@gmail.com</div>
                <div class="button">
                    <button>Profile</button>
                    <button>Message</button>
                </div>
            </div>
        </div>
        <div class="linya"></div>
        <div class="holders holders-no">
            <div class="img">
                <img src="/resources/assets/frontend/img/man.jpg">
            </div>
            <div class="info">
                <div class="name">Edward Guevarra</div>
                <div class="email">primiaph@gmail.com</div>
                <div class="button">
                    <button>Profile</button>
                    <button>Message</button>
                </div>
            </div>
        </div>
        <div class="linya"></div>
        <div class="holders holders-no">
            <div class="img">
                <img src="/resources/assets/frontend/img/man.jpg">
            </div>
            <div class="info">
                <div class="name">Edward Guevarra</div>
                <div class="email">primiaph@gmail.com</div>
                <div class="button">
                    <button>Profile</button>
                    <button>Message</button>
                </div>
            </div>
        </div>
        <div class="linya"></div>
        <div class="holders holders-no">
            <div class="img">
                <img src="/resources/assets/frontend/img/man.jpg">
            </div>
            <div class="info">
                <div class="name">Edward Guevarra</div>
                <div class="email">primiaph@gmail.com</div>
                <div class="button">
                    <button>Profile</button>
                    <button>Message</button>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/dashboard.css">
@endsection