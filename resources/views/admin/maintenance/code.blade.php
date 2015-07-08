@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> MEMBERSHIP CODES</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button type="button" class="btn btn-default" id="check-code-btn"><i class="fa fa-pencil"></i> CHECK CODE</button>
				<button onclick="location.href='admin/maintenance/codes/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> GENERATE CODES</button>
			</div>
		</div>
		<div class="filters ">
		</div>
	</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('status') == null ? 'active' : ''}}" href="admin/maintenance/codes/">Company Codes</a>
				<a class="{{$active = Request::input('status') == 'unused' ? 'active' : ''}}" href="admin/maintenance/codes?status=unused">Unused Member Codes</a>
				<a class="{{$active = Request::input('status') == 'used' ? 'active' : ''}}" href="admin/maintenance/codes?status=used">Used Member Codes</a>
				<a class="{{$active = Request::input('status') == 'blocked' ? 'active' : ''}}" href="admin/maintenance/codes?status=blocked">Block</a>
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Pin</th>
						<th>Activation</th>
						<th>Membership</th>
						<th>Code Type</th>
						<th>Product</th>
						<th>Owner</th>
						<th>Voucher</th>
						<th>Date</th>
						<th class="option-col"></th>
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>





	<div class="remodal" data-remodal-id="transfer_code_modal" id="">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Transfer Code</h1>
 <form id="transfer-code-form">
 	<input type="hidden" name="_token" value="{{ csrf_token() }}">
 	<input class="form-control text-center" type="hidden" value="" name="code_pin">
 	<div class="form-group">
	  	<label>Code Pin # </label>
	  	<input class="form-control text-center" type="text" value="" name="code_pin" disabled>
        </select>
	  </div>
	  <div class="form-group">
	  	<label>Select Member</label>
        <select data-placeholder="Select member" name="account_id" class="form-control chosen-select" placeholder="Select Members">    
           <option value=""></option>
            @if($_account)
	            @foreach($_account as $account)
	                <option value="{{$account->account_id}}">{{$account->account_name}}</option>
	            @endforeach
            @endif
        </select>
	  </div>
</form>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button data-remodal-action="confirm" class="remodal-confirm" id="transfer-code-submit">OK</button>
</div>

<div class="remodal" data-remodal-id="check_code_modal" >
	 {{-- <button data-remodal-action="close" class="remodal-close"></button> --}}
 <form id="check-code-form">
 	<input type="hidden" name="_token" value="{{ csrf_token() }}">
 		<div class="form-group">
 		<div id="check-code-error" style="display: none;" class="col-md-12 alert alert-warning">
	  		No results found.
	  	</div>
	  	<label>Enter Code Pin</label>
	  	<input class="form-control text-center" type="text" value="" name="code_pin">
        </select>
	  </div>
	   <div class="form-group">
	  	<label>Code Status</label>
	  	<input class="form-control text-center" type="text" value="" name="code_status" disabled>
        </select>
	  </div>
	  <div class="form-group">
	  	<label>Used by/ Own By</label>
	  	<input class="form-control text-center" type="text" value="" name="used_by" disabled>
        </select>
	  </div>
	 <div class="form-group">
	  	<label>Slot# Generated</label>
	  	<input class="form-control text-center" type="text" value="" name="slot_generated" disabled>
        </select>
	  </div>
	  <div class="form-group">
	  	<label>Code Issued By</label>
	  	<input class="form-control text-center" type="text" value="" name="code_issued_by" disabled>
        </select>
	  </div>
	  <div class="form-group">
	  	<label>Claimable Voucher</label>
	  	<input class="form-control text-center" type="text" value="" name="claimable_voucher" disabled>
        </select>
	  </div>
</form>
  {{-- <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button> --}}
  <button class="" id="check-code-submit">OK</button>
  <img id="check-code-loading" style="display: none;" src="../../resources/assets/img/small-loading.GIF" alt="">
</div>

{{-- <div data-remodal-id="modal">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Remodal</h1>
  <p>
    Responsive, lightweight, fast, synchronized with CSS animations, fully customizable modal window plugin with declarative configuration and hash tracking.
  </p>
</div> --}}
@endsection

@section('script')
<script type="text/javascript" src="resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="resources/assets/chosen_v1.4.2/chosen.css">
<script type="text/javascript">
$(function()
{

		// var options = {closeOnOutsideClick : 'false'};

  //  var  test2 = $('[data-remodal-id=modal]').remodal(options);
  //  test2.open();


   var $transfer_code_popup = $('[data-remodal-id=transfer_code_modal]').remodal();
   var $check_code_popup = $('[data-remodal-id=check_code_modal]').remodal();

   // $check_code_popup.open();
  // $check_code_popup.getState();


   var $membershipCodeTable = $('#table').DataTable(
   {
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/maintenance/codes/get',
	        	data:{
	        	   	status : '{{Request::input("status")}}',
	        	   }
	    	},
        columns: [
        	 // {data: 'code_pin', name: 'code_pin'},
            {data: 'code_pin', name: 'code_pin'},
            {data: 'code_activation', name: 'code_activation'},
            {data: 'membership_name', name: 'membership_name'},
            {data: 'code_type_name', name: 'code_type_name'},
            {data: 'product_package_name', name: 'product_package_name'},
            {data: 'account_name', name: 'account_name'},
            {data: 'inventory_update_type_id', name: 'inventory_update_type_id'},
            {data: 'created_at', name: 'created_at'},
            {data: 'delete', name: 'code_pin'},
            {data: 'transfer', name: 'code_pin'},
        
        ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
        	{
        		"sSearch": "",
        		"sProcessing": ""
         	},
        stateSave: true,
    });


	$membershipCodeTable.on( 'draw.dt', function ()
	{

				$('.block-membership-code').on('click', function(event)
				{
					event.preventDefault();

					var $code_pin = $(this).attr('membership-code-id');
					var $token = $('meta[name=_token]').attr('content');


					$.ajax(
					{
						url: 'admin/maintenance/codes/block',
						type: 'POST',
						dataType: 'json',
						data: {code_pin: $code_pin,
								_token: $token
							},
					})

					.done(function(data)
					{

						// console.log(data);
						if(data)
						{
							$membershipCodeTable.draw();
						}
					})
					.fail(function()
					{
						console.log("Error while blocking membership code.");
						alert("Error while blocking membership code.")
					})
					.always(function()
					{
						// console.log("complete");
					});
					
				});


				$('.transfer-membership-code').on('click',function(event)
				{
					event.preventDefault();
					/* Act on the event */
					
					var $code_id = $(this).attr('membership-code-id');
					var $account_id = $(this).attr('account-id');
					
					$('button.remodal-confirm').attr('membership-code-id', $code_id);

					$option = $('select.chosen-select option');


					$('select.chosen-select').val($account_id).trigger("chosen:updated");
					$('#transfer-code-form input[name="code_pin"]').val($code_id);
					$transfer_code_popup.open();

					$(".chosen-select").chosen(
				    {

				    });


					$.ajax({
						url: '/path/to/file',
						type: 'default GET (Other values: POST)',
						dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
						data: {param1: 'value1'},
					})
					.done(function() {
						console.log("success");
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						// console.log("complete");
					});
					
					
				});


				$('#transfer-code-submit').on('click',function(event) {
					/* Act on the event */
					event.preventDefault();

					// $('')
					var $code_pin = $(this).attr('membership-code-id');

					var $form = $('#transfer-code-form').serialize();
					
					// console.log($form);


					$.ajax({
						url: 'admin/maintenance/codes/transfer_code',
						type: 'POST',
						dataType: 'json',
						data: $form,
					})
					.done(function(data) {

						// console.log("success");
						// console.log(data);

						if(data)
						{
							$membershipCodeTable.draw();
						}

					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						// console.log("complete");
					});
					
					// console.log('code_pin : ' + $code_pin);
					// alert('final');




				});






				
	})


	$('#check-code-btn').on('click', function(event)
	{
		event.preventDefault();

		$check_code_popup.open();
		// alert(1241251254645678568);
		/* Act on the event */
	});


	$('#check-code-submit').on('click',function(event)
	{
		event.preventDefault();
		var $loading = $('#check-code-loading');
		var $check_error = $('#check-code-error');
		$loading.fadeIn();
		var $_input = $('#check-code-form').serialize();
		$.ajax({
			url: 'admin/maintenance/codes/verify_code',
			type: 'get',
			dataType: 'json',
			data:  $_input,
		})
		.done(function(data) {
			// console.log("success");
			
			setTimeout(function()
			{

				$('#check-code-form input:not(input[name="code_pin"])').val('');
				$check_error.fadeOut();
				if(data)
				{


					console.log(data);
					var $used_by = data['account_name'] ? data['account_name'] : 'No recipient';
					var $voucher = data['inventory_update_type_id'] <= 1 ?  'Yes': 'No';
					$('#check-code-form input[name="code_status"]').val(data['stat']);
					$('#check-code-form input[name="used_by"]').val($used_by);
					$('#check-code-form input[name="slot_generated"]').val();
					$('#check-code-form input[name="code_issued_by"]').val(data['admin_id']);
					$('#check-code-form input[name="claimable_voucher"]').val($voucher);
					// if(data['inventory_update_type_id']==1)
					// {
					// 	console.log('inventory_update_type_id :' + data['inventory_update_type_id']);
					// 	$('#check-code-form input[name="claimable_voucher"]').attr('checked','checked');
					// }
					// else
					// {
					// 	$('#check-code-form input[name="claimable_voucher"]').attr('checked','');
					// }
					// $('#check-code-form input[name="used_by"]').val(data['account_name']);

				}
				else
				{
					$('#check-code-form input:not(input[name="code_pin"])').val('');
					$check_error.fadeIn();
				}

				$loading.fadeOut();

			}, 1000);

		})
		.fail(function() {
			// console.log("error");
			alert('Opps! An error on checking code pin has occur.');
		})
		.always(function() {
			// console.log("complete");
		});

		function clear_check_input()
		{
			$('#check-code-form input').val('');
			// $('#check-code-form input[name="claimable_voucher"]').attr('checked','');
			$('#check-code-error').hide();

		}


		$(document).on('closed', '.remodal[data-remodal-id="check_code_modal"]', function (e)
		{
	  		clear_check_input();
			// console.log('Modal is closed' + (e.reason ? ', reason: ' + e.reason : ''));
		});
		
		

		/* Act on the event */
	});


	
});
</script>
@endsection