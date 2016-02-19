@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> MEMBERSHIP CODES (Total Codes:{{$total_code}})</h2>
			</div>
		</div>
		<div class="filters ">
		</div>
	</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>OR Number</th>
						<th>OR Code</th>
						<th>Form Number</th>
						<th>Owner</th>
						<th>Date</th>
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>
@endsection

@section('script')
<script type="text/javascript" src="resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="resources/assets/chosen_v1.4.2/chosen.css">
<script type="text/javascript">
$(function()
{




   var $transfer_code_popup = $('[data-remodal-id=transfer_code_modal]').remodal();
   var $check_code_popup = $('[data-remodal-id=check_code_modal]').remodal();

   var $membershipCodeTable = $('#table').DataTable(
   {
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/transaction/view_voucher_codes/get',
	        	data:{
	        	   }
	    	},
        columns: [
        	 // {data: 'code_pin', name: 'code_pin'},
            {data: 'membershipcode_or_num', name: 'membershipcode_or_num'},
            {data: 'membershipcode_or_code', name: 'membershipcode_or_code'},
            {data: 'order_form_number', name: 'order_form_number'},
            {data: 'account_name', name: 'account_name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'view_voucher', name: 'code_pin'},
        
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
				$('.block-membership-code').unbind("click");
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

				$('#transfer-code-submit').unbind("click");
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

	$(document).on('closed', $check_code_popup , function (e) {
		$('#check-code-result').empty();
	  // Reason: 'confirmation', 'cancellation'
	  // console.log('Modal is closing' + (e.reason ? ', reason: ' + e.reason : ''));
	});
	$('#check-code-btn').on('click', function(event)
	{
		event.preventDefault();
		$check_code_popup.open();
		// alert(1241251254645678568);
		/* Act on the event */
	});


	$('#check-code-submit').on('click',function(event)
	{	var $code_pin = $('#input_pin').val();
		$('#check-code-result').empty();
		event.preventDefault();
		console.log($code_pin);
		$.ajax({
			url: 'admin/maintenance/codes/verify_code',
			type: 'get',
			dataType: 'html',
			data: {code_pin: $code_pin},
		})
		.done(function($data) {
			// console.log("success");
			$('#check-code-result').append($data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		

	
		/* Act on the event */
	});


	
});
</script>
@endsection