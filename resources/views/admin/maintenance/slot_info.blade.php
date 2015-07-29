@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i>Slot #{{Request::input('id')}}</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/codes'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	    </div>
    </div>


    <div class="col-md-12 form-group-container">
        <div class="form-group col-md-12">
            @if($slot)
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-4"><h4>Wallet:</h4></div>
                  <div class="col-xs-6 col-md-4"><h4>{{$slot->slot_wallet}}</h4></div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-4"><h4>Account Name:</h4></div>
                  <div class="col-xs-6 col-md-4"><h4>{{$slot->account_name}}</h4></div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-4"><h4>Membership:</h4></div>
                  <div class="col-xs-6 col-md-4"><h4>{{$slot->membership_name}}</h4></div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-4"><h4>Rank:</h4></div>
                  <div class="col-xs-6 col-md-4"><h4>{{$slot->rank_name}}</h4></div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-4"><h4>Rank:</h4></div>
                  <div class="col-xs-6 col-md-4"><h4>{{$slot->rank_name}}</h4></div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-4"><h4>Slot Sponsor:</h4></div>
                  <div class="col-xs-6 col-md-4"><h4>{{$slot->slot_sponsor}}</h4></div>
                </div>
            @endif
        </div>         
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="resources/assets/chosen_v1.4.2/chosen.css">
    <script type="text/javascript">
        $(".chosen-select").chosen();
    </script>
@endsection