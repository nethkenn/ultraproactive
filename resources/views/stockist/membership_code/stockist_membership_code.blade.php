@extends('stockist.layout')
@section('content')
<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> MEMBERSHIP CODES</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<!--<button type="button" class="btn btn-default" id="check-code-btn"><i class="fa fa-pencil"></i> CHECK CODE</button>-->
				<button onclick="location.href='stockist/membership_code/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> GENERATE CODES</button>
			</div>
		</div>

		<!--<div class="filters ">-->
		<!--	<div class="col-md-8">-->
		<!--		<a class="{{$active = Request::input('status') == null ? 'active' : ''}}" href="stockist/membership_code?status=unused">Unused Member Codes</a>-->
		<!--		<a class="{{$active = Request::input('status') == 'used' ? 'active' : ''}}" href="stockist/membership_code?status=used">Used Member Codes</a>-->
		<!--		<a class="{{$active = Request::input('status') == 'blocked' ? 'active' : ''}}" href="stockist/membership_code?status=blocked">Block</a>-->
		<!--	</div>-->
		<!--</div>-->
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>OR Number</th>
						<th>OR Code</th>
						<th>Form Number</th>
						<th>Owner</th>
						<th>Date</th>
						<th class="option-col">View Voucher</th>
					</tr>
				</thead>
			</table>
	</div>
</div>

<div class="remodal" data-remodal-id="view_prod_modal"
  data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
  <button data-remodal-action="close" class="remodal-close"></button>
  <div id="voucher-prod-container">

  </div>
  <div style="display:none;" id="email-message"></div>
  <button  data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
 <!-- <button  class="email-voucher remodal-confirm">Email</button> -->
  <img class="loading" style="display: none;" src="/resources/assets/img/small-loading.GIF" alt="">
</div>
@endsection
@section('script')
	<script type="text/javascript">
		var $membershipCodeTable = $('#table').DataTable(
		{
			processing: true,
			serverSide: true,
			 ajax:{
			    	url:'stockist/membership_code/get_data',
			    	data:{
			    	   	status : '{{Request::input("status")}}',
			    	   }
				},
			columns: [
				 // {data: 'code_pin', name: 'code_pin'},
			    {data: 'membershipcode_or_num', name: 'membershipcode_or_num'},
			    {data: 'membershipcode_or_code', name: 'membershipcode_or_code'},
			    {data: 'order_form_number', name: 'order_form_number'},
			    {data: 'account_name', name: 'account_name'},
			    {data: 'created_at', name: 'created_at'},
			    {data: 'view_voucher', name: 'view_voucher'},

			],
			"lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
			"oLanguage": 
				{
					"sSearch": "",
					"sProcessing": ""
			 	},
			stateSave: true,
		});
		
	   $('#table').on('click', '.view-voucher', function(event) {
	   		event.preventDefault();
	   		var v_id = $(this).attr('voucher-id');
	   		$('.email-voucher').attr('voucher-id', v_id);
	   		$('#voucher-prod-container').load('stockist/process_sales/sales/sale_or?voucher_id='+v_id);
	   		modal.open();
	   });

	</script>
@endsection