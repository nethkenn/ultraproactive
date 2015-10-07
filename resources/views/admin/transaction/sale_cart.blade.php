@if($cart)
	@foreach ($cart as $product)
		<tr>
			<td>{{$product['product_id']}}</td>
			<td>{{$product['sku']}}</td>
			<td>{{$product['product_name']}}</td>
			<td>{{number_format($product['price'],2)}}</td>
			<td><a href="" class="edit-qty" product-id="{{$product['product_id']}}">{{$product['qty']}}</a></td>
			<td>{{number_format($product['sub_total'],2)}}</td>
			<td><a href="" class="remove-to-cart" product-id="{{$product['product_id']}}">X</a></td>
			</tr>
	@endforeach
		<tr>
			<td class="text-right" colspan="6">Cart Total :  {{number_format($cart_total,2)}}</td>
		</tr>
		<tr>
			<td class="text-right" colspan="6">Discount : {{number_format($discount,2)}} </td>
		</tr>
		<tr>
			<td class="text-right" colspan="6">Other Charges : {{number_format($other,2)}}% ( {{number_format($other_pts,2)}} )</td>
		</tr>
		<tr>
			<td class="text-right" colspan="6">Final Total :  {{number_format($final_total,2)}}</td>
		</tr>
@endif