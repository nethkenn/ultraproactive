@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> Redeem </h2>
			</div>
		</div> 
		<div class="filters ">

		</div>
	</div>
		<div class="filters col-md-12">
			@if(Session::get('success_message'))
				<div class="col-md-12 alert alert-success success-message">
					{{Session::get('success_message')}}
				</div>
			@endif
			@if(Session::get('error_message'))
				<div class="col-md-12 alert alert-warning warning-message">
					{{Session::get('error_message')}}
				</div>
			@endif
			<div class="col-md-8">
			    <!--
				<a class="{{Request::input('filter') == 'today' ? 'active' : '' }}" href="admin/transaction/sales?filter=today">Today's Sale</a>
				<a class="{{Request::input('filter') == null ? 'active' : '' }}" href="admin/transaction/sales">All Sale</a> -->
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr class="text-center">

						<th>Request ID</th>
						<th>Request Code</th>
						<th>Requested by</th>
						<th>Slot #</th>
						<th>Amount </th>
						<th>Status </th>
						<th>Date Request </th>
						<th></th>
					</tr>
				</thead>
			</table>
	</div><div class="col-md-12">
</div>
@endsection

@section('script')

<script type="text/javascript">
$(function() {

   $table = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/transaction/redeem/data',
	    	},
        columns: [
            {data: 'request_id', name: 'request_id'},
            {data: 'request_code', name: 'request_code'},
            {data: 'account_name', name: 'account_name'},
            {data: 'slot_id', name: 'slot_id'},
            {data: 'amount', name: 'amount'},
            {data: 'status', name: 'status'},
            {data: 'request_date', name: 'request_date'},
            {data: 'view', name: 'view'},

		 ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
        	{

         	},
        stateSave: true,
    });

   var modal = $('[data-remodal-id="view_prod_modal"]').remodal();
   
});
</script>
@endsection