@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> Voucher Claims</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/transaction/claims/check'" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Process Claims</button>
			</div>
		</div>
		<div class="filters "></div>
	</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="" href="">Today's Claims</a>
				<a class="active" href="">All Claims</a>
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr class="text-center">

						<th>Voucher ID</th>
						<th>Voucher Code</th>
						<th>Total Amount</th>
						<th>Status</th>
						<th>Date</th>
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>
@endsection

@section('script')
<script type="text/javascript">
$(function() {
   $table = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/transaction/claims/data'
	    	},
        columns: [
            {data: 'voucher_id', name: 'voucher_id'},
            {data: 'voucher_code', name: 'voucher_code'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'status', name: 'claimed'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'cancel_or_view_voucher', name: 'account_id'},        ],
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