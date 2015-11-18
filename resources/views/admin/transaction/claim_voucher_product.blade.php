<table class="table table-boreded table-striped">
	<thead>
	    <tr>
	        <th>Product ID</th>
	        <th>Name</th>
	        <th>Price</th>
	        <th>Unilevel Pts</th>
	        <th>Binary Pts</th>
	        <th>Qty </th>
	        <th>Amount</th>
	    </tr>
	</thead>
	<tbody>
	    @if($_voucher_product)
	        @foreach ($_voucher_product as $voucher_product)
	            <tr>
	                <td>{{$voucher_product->product_id}}</td>
	                <td>{{$voucher_product->product_name}}</td>
	                <td>{{$voucher_product->product_price}}</td>
	                <td>{{$voucher_product->unilevel_pts}}</td>
	                <td>{{$voucher_product->binary_pts}}</td>
	                <td>{{$voucher_product->qty}}</td>
	                <td>{{$voucher_product->sub_total}}</td>
	            </tr>
	        @endforeach

	        
	        <tr><td class="text-right" colspan="7"><strong>Item total Price : {{number_format($product_total,2)}}</strong></td></tr>
	         <tr><td class="text-right" colspan="7"><strong>Discount : {{number_format($discount_pts,2)}}</strong></td></tr>
	         <tr><td class="text-right" colspan="7"><strong>Additional : {{number_format($voucher->other_charge,2)}} ({{(($voucher->other_charge/100)*$product_total)}})</strong></td></tr>
	        <tr><td class="text-right" colspan="7"><strong>Grand Total : {{$voucher->total_amount}}</strong></td></tr>
	    @endif
	</tbody>
</table>