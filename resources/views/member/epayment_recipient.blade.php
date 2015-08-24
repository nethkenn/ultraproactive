@extends('member.layout')
@section('content')
		<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8 text-left">
				<h2><i class="glyphicon glyphicon-user"></i>E-PAYMENT RECIPIENT / PROFILE </h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='member/e-payment/recipient/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD RECIPIENT </button>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="datatable" class="table table-bordered table-hovered table-striped">
			<thead>
				<tr>
					<th class="option-col">ID</th>
					<th>PROFILE NAME</th>
					<th>TRANSACTION</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					
				</tr>
			</tbody>
		</table>
	</div>
@endsection
@section('css')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection
@section('script')
	
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script type="text/javascript" scr="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
	<script type="text/javascript">


			var $Table = $('#datatable').DataTable(
			{
		        processing: true,
		        serverSide: true,
		        ajax:{
		        	url:'member/e-payment/recipient/get_data',
		        	// data:{
		        	//    	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
		        	//    }
		    	},

		        columns: [
		            {data: 'id', name: 'id'},
		            {data: 'profile_name', name: 'profile_name'},
		            {data: 'transaction_code', name: 'transaction_code'},
		            {data: 'edit_delete', name: 'id'},
		           	
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
	<script type="text/javascript" src="resources/assets/members/js/epayment_transaction_recipient.js"></script>
@endsection