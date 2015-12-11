@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i>Slot #{{Request::input('id')}}</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
          @if($slot->slot_type == "CD")
          <button type="button" class="btn btn-primary change_info" slot_id="{{Request::input('id')}}">Convert To PS</button>
          @endif
	        <button onclick="location.href='admin/maintenance/slots'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
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

<div class="remodal" data-remodal-id="add" data-remodal-options="hashTracking: false, closeOnOutsideClick: true , closeOnConfirm : false">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h3>CONVERT THIS ACCOUNT TO PS</h3>
  <form class="form-horizontal" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">     
    <input type="hidden" name="slot_id" value="{{$slot->slot_id}}">
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button type="submit" class="remodal-confirm submit-amount">OK</button>
</form>
</div>

@endsection
@section('script')
    <script type="text/javascript" src="resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="resources/assets/chosen_v1.4.2/chosen.css">
    <script type="text/javascript">
        $(".chosen-select").chosen();
        $(document).ready(function()
        {
          $('.remodal-confirm').prop('disabled',false);
          var AddWallet = $('[data-remodal-id=add]').remodal();
          $('.change_info').on('click', function(event)
          {
            event.preventDefault();
            AddWallet.open();
          });
        });
    </script>
@endsection