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
					<th>Membership</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="remodal" data-remodal-id="view_content">
	  <h2 style="margin-bottom: 30px;">PRODUCT PACKAGE INFO</h2>
	  <table id="product-table" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Unilevel PTS</th>
				<th>Binary PTS</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody class="view_body">

		</tbody>
	</table>
	  <button data-remodal-action="confirm" class="remodal-confirm" id="view_oks">OK</button>
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
	            {data: 'linked', name: 'product_package_name'},
	            {data: 'membership', name: 'membership_id'},
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
	<script type="text/javascript">
	$(document).ready(function(){
   	   $('#product-table').on('click', '#view_content', function(e)
       {
	   	$.get("/admin/maintenance/product_package/view_content", { id: $(e.currentTarget).attr("package-id") }, function(data, status){
	   		$x = jQuery.parseJSON( data );
	   		var opt = "";
	   		$(".view_body").empty();
	   		$.each($x, function( key, value ) 
            {
            	opt = opt + "<tr>"+
            	'<td>'+value.product_id+'</td>'+
            	'<td>'+value.product_name+'</td>'+
            	'<td>'+value.unilevel_pts+'</td>'+
            	'<td>'+value.binary_pts+'</td>'+
            	'<td>'+value.price+'</td>';
            });
            $(".view_body").append(opt);
        });//CALL MODAL
       }); 
       $('#view_oks').click(function(){
       	$(".view_body").empty();
       });
	});
	</script>
	<script type="text/javascript" src="resources/assets/admin/product_package.js"></script>
@endsection
