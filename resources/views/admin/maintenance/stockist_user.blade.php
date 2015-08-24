@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i>STOCKIST USER</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/admin_stockist_user/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD STOCKIST USER</button>
			</div>
		</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/admin_stockist_user">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/admin_stockist_user?archived=1">ARCHIVED</a>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="datatable" class="table table-bordered">
			<thead>
				<tr>
					<th>Stokist</th>
					<th>ID</th>
					<th>Email</th>
					<th>Username</th>
					<th>Password</th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
@endsection
@section('script')

	<script type="text/javascript">

		var $Table = $('#datatable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/admin_stockist_user/get_data',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},

	        columns: [
	        	{data: 'stockist_full_name', name: 'stockist_full_name'},
	            {data: 'stockist_user_id', name: 'stockist_user_id'},
	            {data: 'stockist_email', name: 'stockist_email'},
	            {data: 'stockist_un', name: 'stockist_un'},
	            {data: 'stockist_pw', name: 'stockist_pw'},
	           	{data: 'edit_archive' ,name: 'stockist_type_id'},
	            
	           	
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
	<script type="text/javascript" src="resources/assets/admin/stockist_user.js"></script>
@endsection
