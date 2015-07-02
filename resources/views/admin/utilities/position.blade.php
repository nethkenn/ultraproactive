@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-user-secret"></i> POSITION</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/country/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD POSITION</button>
			</div>
		</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="/admin/maintenance/country">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="/admin/maintenance/country?archived=1">ARCHIVED</a>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="country-table" class="table table-bordered">
			<thead>
				<tr>
					<th>Position ID</th>
					<th>Position Name</th>
					<th>Position Level</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		var $coutryTable = $('#country-table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/utilities/position/data',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},

	        columns: [
	            { data: 'admin_position_id', name: 'admin_position_id'},
	            { data: 'admin_position_name', name: 'admin_position_name'},
	            { data: 'admin_position_level', name: 'admin_position_level'},
	            { data: 'edit' ,name: 'admin_position_id'},
	            { data: 'archive' ,name: 'admin_position_id'}
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
	<script type="text/javascript" src="resources/assets/admin/country.js"></script>
@endsection
