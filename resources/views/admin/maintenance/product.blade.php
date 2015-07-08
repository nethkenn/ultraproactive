@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i>PRODUCT</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/product/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD PRODUCT</button>
			</div>
		</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/maintenance/product/">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/maintenance/product/?archived=1">ARCHIVED</a>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="product-table" class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>SKU</th>
					<th>Name</th>
					<th>Category</th>
					<th>Unilevel PTS</th>
					<th>Binary PTS</th>
					<th>Price</th>
					<th>Image</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
@endsection

@section('script')
	<script type="text/javascript">



		var $productTable = $('#product-table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/maintenance/product/get_product',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},

	        columns: [
	            {data: 'product_id', name: 'product_id'},
	            {data: 'sku', name: 'sku'},
	            {data: 'product_name', name: 'product_name'},
	            {data: 'product_category_name', name: 'product_category_name'},
	            {data: 'unilevel_pts', name: 'unilevel_pts'},
	            {data: 'binary_pts' ,name: 'binary_pts'},
	            {data: 'price' ,name: 'price'},
	            {data: 'image_file' ,name: 'image_file'},
	           	{data: 'edit' ,name: 'product_id'},
	            {data: 'archive' ,name: 'product_id'},
	            
	           	
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

	<script type="text/javascript" src="resources/assets/admin/product_ultra.js"></script>
@endsection
