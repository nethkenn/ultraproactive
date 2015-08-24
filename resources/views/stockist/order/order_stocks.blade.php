@extends('stockist.layout')
@section('content')
<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> Order Stocks</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<!--<button type="button" class="btn btn-default" id="check-code-btn"><i class="fa fa-pencil"></i> CHECK CODE</button>-->
				<button onclick="location.href='stockist/order_stocks/order'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Order</button>
			</div>
	        @if($success)
                <div class="col-md-12 alert alert-succ	ess form-errors">
                    <ul>
                            <li>{{$success}}</li>
                    </ul>
                </div>
            @endif
		</div>

		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('status') == '' ? 'active' : ''}}" href="/stockist/order_stocks">Pending</a>
				<a class="{{$active = Request::input('status') == 'confirmed' ? 'active' : ''}}" href="/stockist/order_stocks?status=confirmed">Confirmed</a>
				<a class="{{$active = Request::input('status') == 'canceled' ? 'active' : ''}}" href="stockist/order_stocks?status=canceled">Canceled</a>
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Order ID</th>
						<th>Status</th>
						<th>Ordered By</th>
						<th>Date Ordered</th>
						<th class="option-col"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($_order as $order)
					<tr>
						<td>{{$order->order_stocks_id}}</td>
						<td>{{$order->status}}</td>
						<td>{{$order->stockist_un}}</td>
						<td>{{$order->created_at}}</td>
						<td><a href="javascript:" class="order" order="{{$order->order_stocks_id}}">View Order</a></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
	</div>
</div>


<div class="remodal" data-remodal-id="view_prod_modal" data-remodal-options="hashTracking: false">
  <button data-remodal-action="close" class="remodal-close"></button>
  <div id="voucher-prod-container">

  			<div class="productcontainer">
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr class="text-center">
						<th>Product ID</th>
						<th>Product Name</th>
						<th>Quantity</th>
					</tr>
					<tbody class="tbody">

					</tbody>
				</thead>
			</table>
			</div>

			<div class="packagecontainer">
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr class="text-center">
						<th>Package ID</th>
						<th>Package Name</th>
						<th>Quantity</th>
					</tr>
					<tbody class="tbody-pack">

					</tbody>
				</thead>
			</table>
			</div>
  </div>
 <!-- <button  class="email-voucher remodal-confirm">Email</button> -->
  <img class="loading" style="display: none;" src="/resources/assets/img/small-loading.GIF" alt="">
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function()
{
	$(".order").click(function()	
	{

			$(".packagecontainer").hide();
			$(".productcontainer").hide();
		    var inst = $('[data-remodal-id=view_prod_modal]').remodal();
          	inst.open(); 
          	$(".tbody").empty();
          	$(".tbody-pack").empty();
          	$.ajax(
			{
				url: "stockist/order_stocks/get",
				dataType: "json",
				type:"get",
				data: {id: $(this).attr('order')},
				success: function(data)
				{
						$.each(data.product, function( key, value )
			            {
			            	var product = "<tr>";
							product = product + "<td>"+value.product_id+"</td>";
							product = product + "<td>"+value.product_name+"</td>";
							product = product + "<td>"+value.quantity+"</td>";
							product = product + "</tr>";
							$(".tbody").append(product);
							$(".productcontainer").show();
			            });

						$.each(data.package, function( key, value )
			            {
			            	var product = "<tr>";
							product = product + "<td>"+value.product_package_id+"</td>";
							product = product + "<td>"+value.product_package_name+"</td>";
							product = product + "<td>"+value.quantity+"</td>";
							product = product + "</tr>";
							$(".tbody-pack").append(product);
							$(".packagecontainer").show();
			            });
				}		
			});
	});
});


</script>
@endsection
