@extends('stockist.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> ISSUE STOCKS</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="$('#product-package-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Issue</button>
	    </div>
    </div>
    <form id="product-package-add-form" method="post">
    <div class="col-md-12 form-group-container">
        	        @if($error)
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($error as $errors)
                                    <li>{{$errors}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            	<div class="form-group col-md-12">
				    <table id="product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stockist Quantity</th>
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
								<th>Stockist Quantity</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
            	</div>
    </div>


	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> ISSUE STOCKS PACKAGE</h2>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="product-package-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            	<div class="form-group col-md-12">
				    <table id="product-package-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stockist Quantity</th>
								<th></th>
							</tr>
						</thead>
					</table>
				</div>

            	<div class="form-group col-md-12">
            		<table id="added-product-table-pack" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stockist Quantity</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
            	</div>
        </form>
    </div>

    </form>


	<div class="remodal" data-remodal-id="add_prod_pack_modal" id="">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  <h1>Add to stocks quantity</h1>
	  <div class="form-group">
	    <label for="Quantity">Quantity</label>
	    <input id="pop-up-input2" name="" type="number" class="form-control" id="" placeholder="">
	  </div>	  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
	  <button data-remodal-action="confirm" class="remodal-confirm pack">OK</button>
	</div>

	<div class="remodal" data-remodal-id="add_prod_modal" id="">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  <h1>Add to stocks quantity</h1>
	  <div class="form-group">
	    <label for="Quantity">Quantity</label>
	    <input id="pop-up-input" name="" type="number" class="form-control" id="" placeholder="">
	  </div>
	  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
	  <button data-remodal-action="confirm" class="remodal-confirm nopack">OK</button>
	</div>

@endsection
@section('script')
	<script type="text/javascript">

	   	var $add_product_pop_up = $('[data-remodal-id=add_prod_modal]').remodal();

		var $productTable = $('#product-table').DataTable({

	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'stockist/issue_stocks/issue/product?id='+{{$id}},
	    	},

	        columns: [
	            {data: 'product_id', name: 'product_id'},
	            {data: 'product_name', name: 'product_name'},
	            {data: 'stockist_quantity', name: 'stockist_quantity'},
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
				$('#pop-up-input').focus();
			});


			$('.nopack').on('click', function(event)
			{
				event.preventDefault();
				var $new_td = [];
				$td = $selected_product.closest('tr').find('td');
				$($td).each (function(index,element) {

					$new_td[index] = $(element).html();

				});

				var $append = '<tr>'+
					'<td>'+$new_td[0]+'</td>'+
					'<td>'+$new_td[1]+'</td>'+
					'<td>'+$new_td[2]+'</td>'+
					'<td>'+'<input product-id = "'+$new_td[0]+'" style="width:100%;" type="number" name="quantity['+$new_td[0]+']" value="'+$('#pop-up-input').val()+'"></td>'+
					'<td><a style="cursor: pointer;" class="remove-added-prod" product-id = "'+$new_td[0]+'">REMOVE</a></td>'+
				'</tr>';

				// console.log($append);
				var $checktd = $('#added-product-table tbody td a[product-id='+$new_td[0]+']').length;
				console.log($checktd);
				if($checktd > 0)
				{
					var $input =  $('input[product-id='+$new_td[0]+']').val();

					$final_input = parseInt($input) + parseInt($('#pop-up-input').val());


					
					$('input[product-id='+$new_td[0]+']').val($final_input);

				}
				else
				{
					$('#added-product-table tbody').append($append);
				}
								
			});


			$( "#added-product-table" ).delegate( ".remove-added-prod", "click", function()
			{

				var $prod_id = $(this).attr('product-id');


				$(this).closest('tr').remove();
			});



			



			
		})

	</script>


	<script type="text/javascript">

	   	var $add_product_pop_up_pack = $('[data-remodal-id=add_prod_pack_modal]').remodal();

		var $productTable = $('#product-package-table').DataTable({

	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'stockist/issue_stocks/issue/product/package?id='+{{$id}},
	    	},

	        columns: [
	            {data: 'product_package_id', name: 'product_package_id'},
	            {data: 'product_package_name', name: 'product_package_name'},
	            {data: 'package_quantity', name: 'package_quantity'},
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

			$('.add-to-package-pack').on('click', function(event)
			{
				$selected_product = $(this);
				var $prod_id = $selected_product.attr('product-id');
				event.preventDefault();
				$('#pop-up-input2').val("");
				$('#pop-up-input2').attr('name', 'product['+$prod_id+'][quantity]');
				$add_product_pop_up_pack.open();
				$('#pop-up-input2').focus();
			});


			$('.pack').on('click', function(event)
			{
				event.preventDefault();
				var $new_td = [];
				$td = $selected_product.closest('tr').find('td');
				$($td).each (function(index,element) {

					$new_td[index] = $(element).html();

				});

				var $append = '<tr>'+
					'<td>'+$new_td[0]+'</td>'+
					'<td>'+$new_td[1]+'</td>'+
					'<td>'+$new_td[2]+'</td>'+
					'<td>'+'<input product-id = "'+$new_td[0]+'" style="width:100%;" type="number" name="quantitypack['+$new_td[0]+']" value="'+$('#pop-up-input2').val()+'"></td>'+
					'<td><a style="cursor: pointer;" class="remove-added-prod-pack" product-id = "'+$new_td[0]+'">REMOVE</a></td>'+
				'</tr>';

				// console.log($append);
				var $checktd = $('#added-product-table-pack tbody td a[product-id='+$new_td[0]+']').length;
				console.log($checktd);
				if($checktd > 0)
				{
					var $input =  $('input[product-id='+$new_td[0]+']').val();

					$final_input = parseInt($input) + parseInt($('#pop-up-input2').val());


					
					$('input[product-id='+$new_td[0]+']').val($final_input);

				}
				else
				{
					$('#added-product-table-pack tbody').append($append);
				}
								
			});


			$( "#added-product-table-pack" ).delegate( ".remove-added-prod-pack", "click", function()
			{

				var $prod_id = $(this).attr('product-id');


				$(this).closest('tr').remove();
			});



			



			
		})

	</script>
@endsection












