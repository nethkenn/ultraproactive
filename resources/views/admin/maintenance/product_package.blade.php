@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i>PRODUCT PACKAGE</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/product_package/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD PRODUCT PACKAGE</button>
			</div>
		</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/maintenance/product_package/">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/maintenance/product_package/?archived=1">ARCHIVED</a>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="product-table" class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th></th>
					<th></th>
					
					
					
					

				</tr>
			</thead>
		</table>
	</div>
@endsection

@section('script')
	<script type="text/javascript">



		var $product_packageTable = $('#product-table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/maintenance/product_package/get',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},

	        columns: [
	            {data: 'product_package_id', name: 'product_package_id'},
	            {data: 'product_package_name', name: 'product_package_name'},
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
@endsection
