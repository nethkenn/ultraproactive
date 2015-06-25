@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i> COUNTRY</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/country/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD COUNTRY</button>
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
					<th>Coutry ID</th>
					<th>Coutry Name</th>
					<th>Currency</th>
					<th>Conversion Rate</th>
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
	        	url:'admin/maintenance/country/get_country',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},

	        columns: [
	            {data: 'country_id', name: 'country_id'},
	            {data: 'country_name', name: 'country_name'},
	            {data: 'currency', name: 'currency'},
	            {data: 'rate', name: 'account_contact_number'},
	            {data: 'edit' ,name: 'country_id'},
	            {data: 'archive' ,name: 'country_id'}
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
