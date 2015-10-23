@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-share-alt"></i> SLOTS</h2>
			</div>
			<div class="buttons col-md-2 text-right">
				<button class="slot_limit btn btn-primary" type="button" style="width: 100%;"><i></i>Slot Limit ({{$slot_limit->value}})</button>
			</div>
			<div class="buttons col-md-2 text-right">
				<button onclick="location.href='admin/maintenance/slots/add'" style="width: 100%;" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> GENERATE SLOTS</button>
			</div>
		</div>
		<div class="filters ">
			 <div class="col-md-8">
 			</div>
		</div>
	</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Slot #</th>
						<th>Owner</th>
						<th>Membership</th>
						<th>Placement</th>
						<th>Position</th>
						<th>Sponsor</th>
						<th>Type</th>
						<th>Wallet</th>
						<th>Date</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
			</table>
	</div>

<div class="remodal create-slot" data-remodal-id="slot_limit" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Slot Limit per account:
    </div>
    <form class="form-horizontal" method="POST">
	    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
	    <input type="number" class="form-control" value="{{$slot_limit->value}}" name="slot_limit" style="text-align: center;">
		<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Change Limit</button>
    </form>
</div>
<div class="remodal" data-remodal-id="adjust-wallet"
  data-remodal-options="hashTracking: false, closeOnOutsideClick: false">

  <button data-remodal-action="close" class="remodal-close remodal-btn"></button>
  <h3>Adjust Wallet</h3>
  <form id="ajust-wallet-form">
  		<div class="form-group">
  			<div class="adjsut-wallet-message">
  				
  			</div>
  		</div>
	  <div class="form-group">
	    <label for="">Slot#</label>
	    <input name="slot_id" type="text" class="form-control" id="" placeholder="" readonly>
	  </div>
	  <div class="form-group">
	    <label for="">Wallet Amount</label>
	    <input name="wallet_amount" type="text" class="form-control" id="" placeholder="" readonly>
	  </div>
	  <div class="form-group">
	    <label for="">Select Adjustment</label>
	    <select class="form-control" name="wallet_adjustment">
	    	<option value="add">Add</option>
	    	<option value="deduct">Deduct</option>
	    </select>
	  </div>
	  <div class="form-group">
	    <label for="">Adjustment Amount</label>
	    <input name="wallet_adjustment_amount" type="number" class="form-control" id="" placeholder="">
	  </div>
	  <div class="form-group">
	  	<button data-remodal-action="cancel" class="remodal-cancel remodal-btn">Cancel</button>
  		<button class="remodal-confirm remodal-btn ajust-wallet-submit-btn">OK</button>
	  </div>
  </form>
</div>

<div class="remodal" data-remodal-id="adjust-wallet-success-modal">
  <button data-remodal-action="close" class="remodal-close"></button>
  <div class="col-md-12 adjust-wallet-success-msg-box">

  </div>
  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>




@endsection

@section('script')
<script type="text/javascript">

    var $slot_table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        	        ajax:{
	        	url:'{{ url("admin/maintenance/slots/data") }}',
	        	data:{
	        	   	memid : "{{$memid = Request::input('memid')}}"
	        	   }
	    	},
        columns: [
            {data: 'slot_id', name: 'slot_id'},
            {data: 'account_name', name: 'account_name'},
            {data: 'membership_name', name: 'membership_name'},
            {data: 'placement', name: 'placement'},
            {data: 'position', name: 'position'},
            {data: 'sponsor', name: 'sponsor'},
            {data: 'slot_type', name: 'slot_type'},
            {data: 'wallet', name: 'slot_wallet'},
            {data: 'created_at', name: 'created_at'},
            {data: 'gen', name: 'slot_id'},
            {data: 'info', name: 'slot_id'},
        ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
        	{
        		"sSearch": "",
        		"sProcessing": ""
         	},
        stateSave: true,
    });
$(function() {



    var mem  = '{!! Request::input("memid")  !!}';
  	var json = '{!! json_encode($membership) !!}';
  	json = $.parseJSON(json);
  	var str = '<select onchange="if (this.value) window.location.href=this.value" class="style form-control"><option value="/admin/maintenance/slots">All</option>';

  	$.each(json, function(key, val)
	{	
		if(mem == val.membership_id)
		{
			str = str + '<option value="/admin/maintenance/slots?memid='+val.membership_id+'" selected>'+val.membership_name+'</option>';			
		}
		else
		{
			str = str + '<option value="/admin/maintenance/slots?memid='+val.membership_id+'">'+val.membership_name+'</option>';
		}

	});

  	str = str + '</select>';
	$('#table_filter').prepend(str);
    $.fn.dataTableExt.sErrMode = 'throw';

    $(".slot_limit").click(function()
    {
			var inst = $('[data-remodal-id=slot_limit]').remodal();
          	inst.open(); 
    });

});
</script>
<script type="text/javascript" src="/resources/assets/admin/adjust_wallet.js"></script>
@endsection