@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Add New Product Package</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/Product Package'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#product-package-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="product-package-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
                    <label for="product-package_name">Product Package Name</label>
{{--                     @if($_error['Product Package_name'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['Product Package_name'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
            		<input name="product_package_name" value="" required="required" class="form-control" id="" placeholder="" type="text">
            	</div>

            	<div class="form-group col-md-12">
				    <table id="product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Category</th>
								<th>Unilevel Points</th>
								<th>Binary Points</th>
								<th>Price</th>
								<th>Image</th>
								<th></th>
							</tr>
						</thead>
					</table>
				</div>

            	<div class="form-group col-md-12">
            		<table id="added-product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Category</th>
								<th>Unilevel Points</th>
								<th>Binary Points</th>
								<th>Price</th>
								<th>Image</th>
								<th>Qty</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
            	</div>




        </form>
    </div>
<div class="remodal" data-remodal-id="add_prod_modal" id="">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Add Product</h1>
  	<form>
  <div class="form-group">
    <label for="Quantity">Quantity</label>
    <input id="pop-up-input" name="" type="number" class="form-control" id="" placeholder="">
  </div>
</form>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>
@endsection
@section('script')
	<script type="text/javascript">

	   	var $add_product_pop_up = $('[data-remodal-id=add_prod_modal]').remodal();

		var $productTable = $('#product-table').DataTable({

	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/maintenance/product_package/get_product',
	    	},

	        columns: [
	            {data: 'product_id', name: 'product_id'},
	            {data: 'product_name', name: 'product_name'},
	            {data: 'product_category_name', name: 'product_category_name'},
	            {data: 'unilevel_pts', name: 'unilevel_pts'},
	            {data: 'binary_pts' ,name: 'binary_pts'},
	            {data: 'price' ,name: 'price'},
	            {data: 'image_file' ,name: 'image_file'},
	           	{data: 'add' ,name: 'product_id'}
	            
	           	
	        ],
	        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
	        "oLanguage": 
	        	{
	        		"sSearch": "",
	        		"sProcessing": ""
	         	},
	        stateSave: true,
	    });

		$productTable.on( 'draw.dt', function ()
		{

			$('.add-to-package').on('click', function(event)
			{
				$selected_product = $(this);
				var $prod_id = $selected_product.attr('product-id');
				event.preventDefault();
				$('#pop-up-input').val("");
				$('#pop-up-input').attr('name', 'product['+$prod_id+'][quantity]');
				$add_product_pop_up.open();
			});


			$('.remodal-confirm').on('click', function(event)
			{
				event.preventDefault();
				var $new_td = [];
				$td = $selected_product.closest('tr').find('td');
				$($td).each (function(index,element) {
					$new_td[index] = $(element).html();
					// console.log(index+ ' = '+ $(element).html());
				  // do your cool stuff
				});

				// console.log($new_td);


				$append = '<tr>'+
					'<td>'+$new_td[0]+'</td>'+
					'<td>'+$new_td[1]+'</td>'+
					'<td>'+$new_td[2]+'</td>'+
					'<td>'+$new_td[3]+'</td>'+
					'<td>'+$new_td[4]+'</td>'+
					'<td>'+$new_td[5]+'</td>'+
					'<td>'+$new_td[6]+'</td>'+
					'<td>'+'<input style="width:100%;" type="number" name="'+$('#pop-up-input').attr('name')+'" value="'+$('#pop-up-input').val()+'"></td>'+
					'<td><a style="cursor: pointer;" class="remvoe-added-prod">REMOVE</a></td>'+
				'</tr>';

				// console.log($append);
				$('#added-product-table tbody').append($append);
								
			});


			$( "#added-product-table" ).delegate( ".remvoe-added-prod", "click", function()
			{
				$(this).closest('tr').remove();
			});







			
		})

	</script>
@endsection