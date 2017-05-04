@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i>STOCKIST DISCOUNT</h2>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="datatable" class="table table-bordered">
			<thead>
				<tr>
					<th class="option-col">ID</th>
					<th>Name</th>
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
	        	url:'admin/admin_stockist/get_data',
	        	data:{
	        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
	        	   }
	    	},

	        columns: [
	            {data: 'stockist_id', name: 'stockist_id'},
	            {data: 'stockist_full_name', name: 'stockist_full_name'},
	            {data: 'set_discount_type', name: 'set_discount_type'},
	            
	           	
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
	<script type="text/javascript" src="resources/assets/admin/stockist.js"></script>
@endsection


