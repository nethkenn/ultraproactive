@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-star"></i> MEMBERSHIP</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/membership/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD MEMBERSHIP</button>
			</div>
		</div>
		<div class="filters ">
		</div>
	</div>
	<div class="filters ">
		<div class="col-md-8">
			<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/maintenance/membership/">ACTIVE</a>
			<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/maintenance/membership/?archived=1">ARCHIVED</a>
		</div>
	</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th class="option-col">ID</th>
						<th>Membership Name</th>
						<th>Membership Price</th>
						<th>Discount(%)</th>
						<th>Max income per day</th>
						<th class="option-col">Entry</th>
						<th class="option-col">Upgrade</th>
						<th class="option-col">Discounted Product</th>
						<th class="option-col"></th>
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>
@endsection

@section('script')
<script type="text/javascript">
$(function() {
    $membershipTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
       	ajax:{
	        	url:'{{url("admin/maintenance/membership/data")}}',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},
        columns: [
            {data: 'membership_id', name: 'membership_id'},
            {data: 'membership_name', name: 'membership_name'},
            {data: 'membership_price', name: 'membership_price'},
            {data: 'discount', name: 'discount'},
            {data: 'max_income', name: 'max_income'},            
            {data: 'entry', name: 'membership_id'},
            {data: 'upgrade', name: 'membership_id'},
            {data: 'product_discount', name: 'product_discount'},
            {data: 'edit', name: 'membership_id'},
            {data: 'archive', name: 'membership_id'},
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
<script type="text/javascript" src="resources/assets/admin/membership.js"></script>
@endsection