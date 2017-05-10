@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> STOCKIST REQUEST PRODUCT</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	       	 <button onclick="location.href='admin/stockist_request'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button type="button" class="btn btn-primary save_btn"><i class="fa fa-save"></i> TRANSFER</button>
	    </div>
    </div>
    @if($error)
    <div class="col-md-12 alert alert-danger form-errors">
        <ul>
            @foreach($error as $errors)
                <li>{{$errors}}</li>
            @endforeach
        </ul>
    </div>
	@endif
	<?php $totality = 0; ?>
    <form id="product-package-add-form" method="post">
    <div class="col-md-12 form-group-container">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" class="transaction_remarks" name="transaction_remarks" value="">
                <input type="hidden" class="transaction_sales_order" name="sales_order" value="">
            	<div class="form-group col-md-12">
				    <table id="product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Discount</th>
								<th>Discounted Price</th>
								<th>Subtotal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($product as $prod)
								<tr>
									<td>{{$prod->product_id}}</td>
									<td>{{$prod->product_name}}</td>
									<td>{{$prod->quantity}}</td>
									<td>{{$prod->price}}</td>
									<td>{{$prod->discounted}}%</td>
									<td>{{$prod->price - (($prod->discounted/100) * $prod->price) }}</td>
									<td>{{($prod->price - (($prod->discounted/100) * $prod->price) * $prod->quantity)}}</td>
									<?php $totality = ($prod->price - (($prod->discounted/100) * $prod->price) * $prod->quantity) + $totality ?>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>

            	<div class="form-group col-md-12">
            		<table id="added-product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Discount</th>
								<th>Discounted Price</th>
								<th>Subtotal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($package as $pack)
								<tr>
									<td>{{$pack->product_package_id}}</td>
									<td>{{$pack->product_package_name}}</td>
									<td>{{$pack->quantity}}</td>
									<td>{{$pack->price}}</td>
									<td>{{$pack->discounted}}%</td>
									<td>{{$pack->price - (($pack->discounted/100) * $pack->price) }}</td>
									<td>{{($pack->price - (($pack->discounted/100) * $pack->price) * $pack->quantity)}}</td>
									<?php $totality = ($pack->price - (($pack->discounted/100) * $pack->price) * $pack->quantity) + $totality ?>
								</tr>
							@endforeach
						</tbody>
					</table>            		
					
					<table id="added-product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th>Total: PHP {{$totality}}</th>
							</tr>
						</thead>
					</table>
            	</div>
    </div>


    </form>

<div class="remodal" data-remodal-id="before_confirmation" id="">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Confirmation</h1>
  	<form>
  <div class="form-group">
    <label for="Remarks">Sales Order</label>
    <input id="sales_order_container" type="text" class="form-control" id="" placeholder="">
  </div>
  <div class="form-group">
    <label for="Remarks">Remarks</label>
    <input id="remark_container" type="text" class="form-control" id="" placeholder="">
  </div>
</form>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button data-remodal-action="confirm" class="remodal-confirm confirm_remark">Confirm</button>
</div>
@endsection
@section('script')
	<script type="text/javascript">
	   	var before_confirmation = $('[data-remodal-id=before_confirmation]').remodal();
		$(".save_btn").click(function()
		{
			before_confirmation.open();
		});
		
		$(".confirm_remark").click(function(){
			$(".transaction_remarks").val($("#remark_container").val());
			$(".transaction_sales_order").val($("#sales_order_container").val());
			$('#product-package-add-form').submit();
		});
	</script>
@endsection












