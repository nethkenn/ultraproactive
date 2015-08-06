@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i>STOCKIST TYPE</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/stockist_type/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD STOCKIST TYPE </button>
			</div>
		</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/stockist_type">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/stockist_type?archived=1">ARCHIVED</a>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="datatable" class="table table-bordered">
			<thead>
				<tr>
					<th class="option-col">ID</th>
					<th>Name</th>
					<th>Product Discount</th>
					<th>Package Discount</th>
					<th>Minimum order</th>
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
	        	url:'admin/stockist_type/get_data',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},

	        columns: [
	            {data: 'stockist_type_id', name: 'stockist_type_id'},
	            {data: 'stockist_type_name', name: 'stockist_type_name'},
	            {data: 'stockist_type_discount', name: 'stockist_type_discount'},
	            {data: 'stockist_type_package_discount', name: 'stockist_type_package_discount'},
	            {data: 'stockist_type_minimum_order' ,name: 'stockist_type_minimum_order'},
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
	<script type="text/javascript" src="resources/assets/admin/stockist_type.js"></script>
@endsection
