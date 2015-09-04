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

		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('status') == null ? 'active' : ''}}" href="stockist/membership_code?status=unused">Unused Member Codes</a>
				<a class="{{$active = Request::input('status') == 'used' ? 'active' : ''}}" href="stockist/membership_code?status=used">Used Member Codes</a>
				<a class="{{$active = Request::input('status') == 'blocked' ? 'active' : ''}}" href="stockist/membership_code?status=blocked">Block</a>
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
	</script>
@endsection