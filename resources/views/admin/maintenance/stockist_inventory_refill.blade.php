@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> STOCKIST REFILL  ({{$stockist->stockist_full_name}})</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/stockist_inventory'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#product-package-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="product-package-add-form" method="post">

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
								<th>Your Quantity</th>
								<th>Price</th>
								<th>Percent</th>
								<th>Total</th>
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
								<th>Your Quantity</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
						<div class="pricenopack text-right">Total Price: 0</div>
            	</div>
        </form>
    </div>
<div class="remodal" data-remodal-id="add_prod_modal" id="">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Add to stocks quantity</h1>
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
	   	var total = 0;
		var $productTable = $('#product-table').DataTable({

	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/stockist_inventory/get_product/product?id='+{{Request::input('id')}}+"&discount="+{{$discount}},
	    	},

	        columns: [
	            {data: 'product_id', name: 'product_id'},
	            {data: 'product_name', name: 'product_name'},
	            {data: 'stock_qty', name: 'stock_qty'},
	            {data: 'price', name: 'price'},
	            {data: 'percent', name: 'percent'},
	            {data: 'total', name: 'total'},
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


			$('.remodal-confirm').on('click', function(event)
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
					'<td>'+'<input readonly product-id = "'+$new_td[0]+'" style="width:100%; text-align: center; border:0 none;" type="text" name="quantity['+$new_td[0]+']" value="'+$('#pop-up-input').val()+'" readonly></td>'+
					'<td><a style="cursor: pointer;" class="remove-added-prod" product-id = "'+$new_td[0]+'" price="'+$new_td[5]+'" qty="'+$('#pop-up-input').val()+'">REMOVE</a></td>'+
				'</tr>';

 				total = total + (parseFloat($new_td[5]) * parseInt($('#pop-up-input').val()));

				$(".pricenopack").text("Total Price: "+total.toFixed(2));
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
@endsection