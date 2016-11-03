@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> ACCOUNT BLOCK</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/accounts/field'" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> MANAGE FIELDS</button>
				<button onclick="location.href='admin/maintenance/accounts/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD ACCOUNT</button>
			</div>
		</div>
		<div class="filters "></div>
	</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('blocked') ? '' : 'active' }}" href="admin/maintenance/account_block/">UNBLOCKED</a>
				<a class="{{$active = Request::input('blocked') ? 'active' : '' }}" href="admin/maintenance/account_block/blocked?blocked=1">BLOCKED</a>
			</div>
		</div>
	<form method="POST" form action="admin/maintenance/accounts" target="_blank">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-md-12">
		<table id="table" class="table table-bordered">
			<thead>
				<tr class="text-center">
					<th>ID</th>
					<th>Full Name</th>
					<th>Username</th>
					<th></th>
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
	        	url:'admin/maintenance/account_block/data',
	        	data:{
	        	   	blocked : "{{Request::input('blocked') == 1 ? 1 : 0 }}"
	        	   }
	    	},
        columns: [
       		{data: 'account_id', name: 'account_id'},
            {data: 'account_name', name: 'account_name'},
            {data: 'account_username', name: 'account_username'},
            {data: 'block', name: 'account_id'},
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