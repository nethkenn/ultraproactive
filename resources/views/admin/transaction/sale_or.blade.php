
	<div>Date: {{$voucher->formatted_date_created}}</div>
	<div>Voucher # {{$voucher->voucher_id}}</div>
	<div>Voucher Code : {{$voucher->voucher_code}}</div>
	<div>Sold to : {{$voucher->account_name}} ({{$voucher->account_name}})</div>
	<div>Payment : {{$voucher->payment_option == 1 ? "Credit" : ""}} {{$voucher->payment_option == 0 ? "Cash" : ""}} {{$voucher->payment_option == 2 ? "Cheque" : ""}} {{$voucher->payment_option == 3 ? "Ewallet" : ""}}</div>
	<div>Status : {{$voucher->status}}</div>
	<div>Generated by : {{$voucher->processed_by_name}}</div>
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
	                <td>{{$voucher_product->price}}</td>
	                <td>{{$voucher_product->unilevel_pts}}</td>
	                <td>{{$voucher_product->binary_pts}}</td>
	                <td>{{$voucher_product->qty}}</td>
	                <td>{{$voucher_product->price * $voucher_product->qty}}</td>
	            </tr>
	        @endforeach
	        <tr><td class="text-right" colspan="7"><strong>Item total Price : {{number_format($product_total)}}</strong></td></tr>
	         <tr><td class="text-right" colspan="7"><strong>Discount :  {{number_format($discount_pts,2)}}</strong></td></tr>
	          <tr><td class="text-right" colspan="7"><strong>Additional : {{number_format($voucher->other_charge,2)}} ({{(($voucher->other_charge/100)*$product_total)}})</strong></td></tr>
	        <tr><td class="text-right" colspan="7"><strong>Grand Total : {{$voucher->total_amount}}</strong></td></tr>
	    @endif
	</tbody>
</table>
