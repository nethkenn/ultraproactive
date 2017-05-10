@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> Refill Logs</h2>
			</div>
		</div>
		<div class="filters "></div>
	</div>

	<form method="POST" form action="admin/maintenance/accounts" target="_blank">
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>ID</th>
						<th>Transaction Desription</th>
						<th>Issued To</th>
						<th>Order Form Number</th>
						<th>Transaction Remark</th>
						<th>Date</th> 
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>
	</form>
@endsection

@section('script')
<script type="text/javascript">
$(function() {
   $accountTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/reports/refill_logs/get',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},
        columns: [
       		{data: 'transaction_id', name: 'transaction_id'},
            {data: 'transaction_description', name: 'transaction_description'},
            {data: 'stockist_name', name: 'stockist_name'},
            {data: 'order_form_number', name: 'order_form_number'},
            {data: 'transaction_remark', name: 'transaction_remark'},
            {data: 'created_at', name: 'created_at'},
            {data: 'view', name: 'view'},
        ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
        	{
        		"sSearch": "",
        		"sProcessing": ""
         	},
        stateSave: true,
    });
});
</script>

@endsection