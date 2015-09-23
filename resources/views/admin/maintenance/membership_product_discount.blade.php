@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i>SET DISCOUNT PRODUCT</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/membership'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#product-package-edit-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i>Update</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="product-package-edit-form" method="post">
        	        	        @if($errors->all())
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" class="token" name="membership_id" value="{{ $membership->membership_id }}">
                <div class="form-group col-md-12">
                    <label for="membership_name">Membership Name</label>
            		<input name="membership_name" value="{{$membership->membership_name}}" type="text" disabled>
            	</div>

            	<div class="form-group col-md-12">
				    <table id="product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>SKU</th>
								<th>Name</th>
								<th>Unilevel PTS</th>
								<th>Binary PTS</th>
								<th>Price</th>
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
								<th>SKU</th>
								<th>Name</th>
								<th>Unilevel PTS</th>
								<th>Binary PTS</th>
								<th>Price</th>
								<th>Discounted Price</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@if($product_discount)
								@foreach($product_discount as $product)
									<tr>
										<td>{{$product->product_id}}</td>
										<td>{{$product->sku}}</td>
										<td>{{$product->product_name}}</td>
										<td>{{$product->unilevel_pts}}</td>
										<td>{{$product->binary_pts}}</td>
										<td>{{$product->price}}</td>
										<td class="option-col text-center"><input product-id = "{{$product->product_id}}" style="width:80%;" type="hidden" name="product[{{$product->product_id}}][quantity]" value="{{$product->discount}}">{{$product->price - (($product->discount/100)*$product->price)}}({{$product->discount}}%)</td>
										<td class="option-col"><a style="cursor: pointer;" class="remove-added-prod" product-id = "{{$product->product_id}}">REMOVE</a></td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
            	</div>
        </form>
    </div>
<div class="remodal" data-remodal-id="add_prod_modal" id="">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Set Discount</h1>
  	<form>
  <div class="form-group">
    <label for="Quantity">Discount Percentage</label>
    <input id="pop-up-input" name="" type="number" class="form-control" id="" placeholder="">
  </div>
</form>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>
@endsection
@section('script')
	<script type="text/javascript">

	   	var $edit_product_pop_up = $('[data-remodal-id=add_prod_modal]').remodal();

		var $productTable = $('#product-table').DataTable({

	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/maintenance/product_package/get_product',
	    	},

	        columns: [
	            {data: 'product_id', name: 'product_id'},
	            {data: 'sku', name: 'sku'},
	            {data: 'product_name', name: 'product_name'},
	            {data: 'unilevel_pts', name: 'unilevel_pts'},
	            {data: 'binary_pts' ,name: 'binary_pts'},
	            {data: 'price' ,name: 'price'},
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
				$edit_product_pop_up.open();
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
				var str = parseInt($new_td[5]) - ((parseInt($('#pop-up-input').val())/100)*parseInt($new_td[5]));
				var $append = '<tr>'+
					'<td>'+$new_td[0]+'</td>'+
					'<td>'+$new_td[1]+'</td>'+
					'<td>'+$new_td[2]+'</td>'+
					'<td>'+$new_td[3]+'</td>'+
					'<td>'+$new_td[4]+'</td>'+
					'<td>'+$new_td[5]+'</td>'+
					'<td class="option-col text-center">'+'<input  product-id = "'+$new_td[0]+'" style="width:80%;" type="hidden" name="'+$('#pop-up-input').attr('name')+'" value="'+$('#pop-up-input').val()+'">'+str+'('+$('#pop-up-input').val()+'%)</td>'+
					'<td><a style="cursor: pointer;" class="remove-added-prod" product-id = "'+$new_td[0]+'">REMOVE</a></td>'+
				'</tr>';

				// console.log($append);
				var $checktd = $('#added-product-table tbody td a[product-id='+$new_td[0]+']').length;
				console.log($checktd);
				if($checktd > 0)
				{
					var $prod_id = $new_td[0];
					$('#added-product-table tbody td a[product-id='+$new_td[0]+']').closest('tr').remove();
					$('#added-product-table tbody').prepend($append);

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