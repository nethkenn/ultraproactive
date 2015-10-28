@extends('member.layout')
@section('content')
<div class="encashment">
    @if($error)
        <div class="alert alert-danger">
            <ul>
                    <li>{{$error}}</li>
            </ul>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('success') }}</li>
            </ul>
        </div>
    @endif
    @if($slotnow)
    <div class="header">Transfer Wallet ( Slot #{{$slotnow->slot_id}} )</div>
    <input type="hidden" class="slotcurrent" value="{{$currentwallet}}">
    <div class="body">
        <div class="col-md-12 header-button">
            @if($_accept->count() != 0)
                <a style="cursor: pointer;" class="forhistory">
                    <button type="button" class="accept">Someone transferred a wallet to you ({{$_accept->count()}})</button>
                </a>
            @endif
        </div>
        <div class="ui-sliders">
            <div class="col-md-12 form-group-container">
                <form method="post" autocomplete="off">
                        <div class="alerted form-group col-md-12" style="display:none;">
                            <div class="alert alert-danger">
                                Slot wallet is not enough to transfer this amount
                            </div>
                        </div>  
                        <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group col-md-12">
                            <label for="transfer_wallet">Amount to transfer</label>
                            <input type="number" class="form-control" name="transfer_wallet" step="any">
                        </div> 

                        <div class="form-group col-md-12">
                            <label for="username">Username of the recipient</label>
                            <input name="username" value="" required="required" class="form-control" id="username" placeholder="" type="text">
                        </div> 
                        <div class="form-group col-md-12">
                            <select class="tree form-control" id="slot_id" name="placement" required>
                                <option value="">Put a recipient first</option>
                            </select>
                        </div>
                        <br>
                        <a style="cursor: pointer;" class="forhistory">
                            <button type="button" class="view_pending">View Pending Request</button>
                        </a>
                        <a style="cursor: pointer;" class="forhistory">
                            <button type="submit" class="c_slot" name="sent">Send a transfer</button>
                        </a>
                </form>
            </div>
        </div>
    </div>
    @else
        <div class="header">No Slot</div>
    @endif
</div>


    <div class="remodal create-slot" data-remodal-id="pending" data-remodal-options="hashTracking: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="header">
            <img src="/resources/assets/frontend/img/icon-encashments.png">
            Pending Request
        </div>
        <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
            <div class="col-md-10 col-md-offset-1 para">
                <form class="form-horizontal" method="POST">
                    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                        <table id="table" class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Transfer ID</th>
                                    <th>Slot you used</th>
                                    <th>Amount</th>
                                    <th>Transferred to</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="break text-center">
                                @foreach($_pending as $pend)
                                <tr class="text-center">
                                    <td>{{$pend->transfer_id}}</td>
                                    <td>Slot #{{$pend->sent_slot_by}}</td>
                                    <td>{{$pend->amount}}</td>
                                    <td>{{$pend->account_name}} (Slot #{{$pend->slot_id}})</td>
                                    <td><button type="submit" value="{{$pend->transfer_id}}" name="cancel">Cancel</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </form>
            </div>  
     </div>



     <div class="remodal create-slot" data-remodal-id="accept" data-remodal-options="hashTracking: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="header">
            <img src="/resources/assets/frontend/img/icon-encashments.png">
            Accept Transfer
        </div>
        <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
            <div class="col-md-10 col-md-offset-1 para">
                <form class="form-horizontal" method="POST">
                    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                        <table id="table" class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Transfer ID</th>
                                    <th>Slot that will receive</th>
                                    <th>Amount</th>
                                    <th>Transferred by</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="break text-center">
                                @foreach($_accept as $pend)
                                <tr class="text-center">
                                    <td>{{$pend->transfer_id}}</td>
                                    <td>Slot #{{$pend->received_slot_by}}</td>
                                    <td>{{$pend->amount}}</td>
                                    <td>{{$pend->account_name}} (Slot #{{$pend->slot_id}})</td>
                                    <td><button type="submit" value="{{$pend->transfer_id}}" name="accept">Accept</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </form>
            </div>  
     </div>


@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/frontend/js/transfer_wallet.js"></script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/encashment.css">
@endsection