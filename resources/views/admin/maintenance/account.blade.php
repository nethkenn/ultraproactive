@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> ACCOUNT</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/accounts/field'" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> MANAGE FIELDS</button>
				<button onclick="location.href='admin/maintenance/accounts/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD ACCOUNT</button>
			</div>
		</div>
		<div class="filters ">
		</div>
	</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/maintenance/accounts/">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/maintenance/accounts/?archived=1">ARCHIVED</a>
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Full Name</th>
						<th>Email</th>
						<th>Contact Number</th>
						<th>Country Name</th>
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
   $accountTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/maintenance/accounts/data',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},
        columns: [
            {data: 'account_name', name: 'account_name'},
            {data: 'account_email', name: 'account_email'},
            {data: 'account_contact_number', name: 'account_contact_number'},
            {data: 'country_name', name: 'country_name'},
            {data: 'edit', name: 'account_id'},
            {data: 'archive', name: 'account_id'},
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

<script type="text/javascript" src="resources/assets/admin/account.js"></script>
@endsection